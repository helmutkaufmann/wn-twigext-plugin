<?php

// Import necessary classes and facades
use Illuminate\Support\Facades\Cache;
use Mercator\TwigExt\Models\Settings;

/**
 * Retrieves the Telegram chat ID based on the provided bot token and chat title.
 *
 * This function attempts to fetch the chat ID either directly if a numeric ID is provided,
 * from the cache, or by making an API call to Telegram to retrieve updates and parse chat information.
 *
 * @param string $bot   The Telegram bot token.
 * @param string|null $title Optional. The title of the chat. If provided, the function searches for the corresponding chat ID.
 *
 * @return int|string|null The chat ID as an integer if found, or null if not found.
 */
function telegramGetChats($bot, $title = null)
{
    // If a numeric title is provided, assume it's the chat ID and return it directly
    if (is_numeric($title)) {
        return $title;
    }

    // Attempt to retrieve the chat ID from the cache using a unique key
    if ($chat = Cache::get("mer-port-chat-$bot-$title")) {
        return $chat;
    }

    // Initialize a cURL session to Telegram's getUpdates API endpoint
    $ch = curl_init("https://api.telegram.org/bot$bot/getUpdates");
    curl_setopt($ch, CURLOPT_HEADER, false);               // Exclude headers in the output
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);           // Return the transfer as a string
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);       // Disable SSL peer verification (not recommended for production)
    $result = curl_exec($ch);                              // Execute the cURL session
    curl_close($ch);                                        // Close the cURL session
    $result = json_decode($result, true);                  // Decode the JSON response into an associative array

    $chats = array();                                       // Initialize an array to store chat IDs and titles
    foreach ($result["result"] as $key => $ritem) {
        // Check if the update contains a message and a chat object
        if (array_key_exists("message", $ritem) && array_key_exists("chat", $ritem["message"])) {
            // Map chat ID to chat title
            $chats[$ritem["message"]["chat"]["id"]] = $ritem["message"]["chat"]["title"];
        }
    }

    if ($title) {
        // Search for the chat title in the chats array to find the corresponding chat ID
        $key = array_search($title, $chats);
        if ($key !== false) {
            // Cache the found chat ID for future requests (cache duration: 60 minutes)
            Cache::put("mer-port-chat-$bot-$title", $key, 60 * 60);
            return $key;
        } else {
            // Return null if the chat title is not found
            return null;
        }
    } else {
        // If no title is provided, return the entire chats array
        return $chats;
    }
}

// Initialize or extend the existing $functions array with additional functions
$functions += [

    //
    // Mail
    //

    /**
     * Sends a raw email message to a specified recipient.
     *
     * This function uses a default email address from settings if no recipient is provided.
     *
     * @param string $message The email message to send.
     * @param string|null $to Optional. The recipient's email address. If not provided, the default from settings is used.
     *
     * @return string An empty string. (Consider returning a status or confirmation message for better usability)
     *
     * @example
     * // Send a simple email message to the default recipient
     * $result = $functions['mailMessage']('Hello, this is a test message.');
     *
     * // Send a simple email message to a specific recipient
     * $result = $functions['mailMessage']('Hello, this is a test message.', 'user@example.com');
     */
    'mailMessage' => function ($message, $to = null) {
        // If no recipient is provided, fetch the default email address from settings
        if (!$to || empty($to)) {
            $to = Settings::get('mail_default');
        }
        // Send a raw email to the specified recipient
        Mail::rawTo($to, $message);
        return "";
    },

    //
    // TELEGRAM
    //

    /**
     * Sends a Telegram message containing the client's IP address and location information.
     *
     * This function fetches the client's IP address, retrieves location data using an external API,
     * and sends the information as a message to a specified Telegram chat.
     *
     * @param string $text   The base text of the message to send.
     * @param string|null $bot    Optional. The Telegram bot token. If not provided, it fetches from settings.
     * @param string|null $chat   Optional. The title of the Telegram chat. If not provided, it fetches from settings.
     * @param int $time       Optional. The cache duration in seconds for storing IP address data. Default is 3600 seconds (1 hour).
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Send a Telegram message with the client's IP and location
     * $result = $functions['telegramIP']('New visitor detected');
     */
    'telegramIP' => function ($text, $bot = null, $chat = null, $time = 3600) {

        // Return immediately if no text is provided
        if (empty($text)) {
            return "";
        }

        // Fetch bot token from settings if not provided
        if (!$bot || empty($bot)) {
            $bot = Settings::get('telegram_bot');
        }

        // Fetch chat title from settings if not provided
        if (!$chat || empty($chat)) {
            $chat = Settings::get('telegram_chat');
        }

        // Retrieve the chat ID using the telegramGetChats function
        $chat = telegramGetChats($bot, $chat);

        // If text is empty or bot token is missing, return an error message
        if (empty($text) || (!$bot)) {
            return "Could not send Telegram Message";
        }

        // Determine the client's IP address
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Check if IP is passed from a proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // Fallback to remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        $new = false; // Flag to indicate if the IP address was newly fetched
        // Attempt to retrieve cached IP address data
        $IPaddress = Cache::get("CACHED-USER-IP-" . $ip_address);

        if (!$IPaddress) {
            // Initialize a cURL session to fetch location data based on IP address
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://ip-api.com/php/$ip_address?fields=country,regionName,city",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "content-type: application/json"
                ),
            ));

            $IPaddress = curl_exec($curl); // Execute the cURL request
            // Cache the serialized IP address data for the specified duration
            Cache::add("CACHED-USER-IP-" . $ip_address, $IPaddress, $time); // cache for 60 minutes by default or user-specified
            $new = true;
            curl_close($curl); // Close the cURL session
        }

        $response = unserialize($IPaddress); // Unserialize the cached IP address data

        // Append location information to the base text
        $text = ($text . "\nFrom  " . $response["city"] . ", " . $response["country"]);

        // Construct the Telegram API URL using the bot token
        $website = "https://api.telegram.org/bot" . $bot;
        $params = ['chat_id' => $chat, 'text' => $text]; // Define the parameters for the message

        // Initialize a cURL session to send the Telegram message
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);               // Exclude headers in the output
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);           // Return the transfer as a string
        curl_setopt($ch, CURLOPT_POST, 1);                     // Use POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));       // Set the POST fields
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);       // Disable SSL peer verification (not recommended for production)
        $result = curl_exec($ch);                              // Execute the cURL session
        curl_close($ch);                                        // Close the cURL session

        return ""; // Return an empty string (consider returning a status or confirmation)
    },

    /**
     * Sends a Telegram message to a specified chat.
     *
     * This function sends a simple text message to a Telegram chat using the provided bot token and chat ID or title.
     *
     * @param string $text   The message text to send.
     * @param string|null $bot    Optional. The Telegram bot token. If not provided, it fetches from environment variables.
     * @param string|null $chat   Optional. The title of the Telegram chat. If not provided, it fetches from environment variables.
     *
     * @return string An empty string. (Consider returning a status or confirmation message)
     *
     * @example
     * // Send a Telegram message to the default chat
     * $result = $functions['telegram']('Hello, this is a test message.');
     *
     * // Send a Telegram message to a specific chat
     * $result = $functions['telegram']('Hello, this is a test message.', 'BOT_TOKEN', 'Chat Title');
     */
    'telegram' => function ($text, $bot = null, $chat = null) {

        // Fetch bot token from environment variables if not provided
        if (!$bot || empty($bot)) {
            $bot = env('TELEGRAM_BOT', null);
        }

        // Fetch chat title from environment variables if not provided
        if (!$chat || empty($chat)) {
            $chat = env('TELEGRAM_CHAT', null);
        }

        // Retrieve the chat ID using the telegramGetChats function
        $chat = telegramGetChats($bot, $chat);

        // If text is empty, bot token is missing, or chat ID is not found, return an error message
        if (empty($text) || (!$bot) || (!$chat)) {
            return "No message or no BOT";
        }

        // Construct the Telegram API URL using the bot token
        $website = "https://api.telegram.org/bot" . $bot;
        $params = ['chat_id' => $chat, 'text' => $text]; // Define the parameters for the message

        // Initialize a cURL session to send the Telegram message
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);               // Exclude headers in the output
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);           // Return the transfer as a string
        curl_setopt($ch, CURLOPT_POST, 1);                     // Use POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));       // Set the POST fields
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);       // Disable SSL peer verification (not recommended for production)
        $result = curl_exec($ch);                              // Execute the cURL session
        curl_close($ch);                                        // Close the cURL session

        return ""; // Return an empty string (consider returning a status or confirmation)
        // Uncomment the line below for debugging purposes to view the API response
        // return ("X $website/sendMessage&chat_id=$chat&text=$text XX $result X"); 
    },

    /**
     * Retrieves and displays all Telegram chats associated with a specific bot.
     *
     * This function fetches updates from the Telegram API and extracts chat IDs and their corresponding titles.
     *
     * @param string|null $bot Optional. The Telegram bot token. If not provided, it fetches from environment variables.
     *
     * @return string A string representation of the chats array. (Consider returning the array directly for better usability)
     *
     * @example
     * // Retrieve and print all chats for the default bot
     * $result = $functions['telegramChats']();
     */
    'telegramChats' => function ($bot = null) {

        // Fetch bot token from environment variables if not provided
        if (!$bot || empty($bot)) {
            $bot = env('TELEGRAM_BOT', null);
        }

        // Construct the Telegram API URL using the bot token
        $website = "https://api.telegram.org/bot$bot";
        $params = []; // No parameters needed for getUpdates
        // Initialize a cURL session to fetch updates from Telegram
        $ch = curl_init($website . '/getUpdates');
        curl_setopt($ch, CURLOPT_HEADER, false);               // Exclude headers in the output
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);           // Return the transfer as a string
        curl_setopt($ch, CURLOPT_POST, 1);                     // Use POST method
        // curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));     // No POST fields required
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);       // Disable SSL peer verification (not recommended for production)
        $result = curl_exec($ch);                              // Execute the cURL session
        curl_close($ch);                                        // Close the cURL session

        $result = json_decode($result, true);                  // Decode the JSON response into an associative array
        $result = $result["result"];                           // Extract the 'result' array containing updates

        // Initialize an array to store chat IDs and their corresponding titles
        $chats = array();
        foreach ($result as $key => $ritem) {
            // Check if the update contains a message and a chat object
            if (array_key_exists("message", $ritem) && array_key_exists("chat", $ritem["message"])) {
                // Map chat ID to chat title
                $chats[$ritem["message"]["chat"]["id"]] = $ritem["message"]["chat"]["title"];
            }
        }
        // Return a string representation of the chats array (for debugging purposes)
        return print_r($chats, true);
    },

];

// Closing PHP tag is optional and often omitted in PHP-only files to prevent accidental output
?>
