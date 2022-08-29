<?php

use Mercator\TwigExt\Models\Settings;

$functions += [

	//
	// Mail
	//
	'mailMessage' => function ($message, $to=null) {
		if (!$to || empty($to))
			$to=Settings::get('mail_default');
		 Mail::rawTo($to, $message );
		return "";
	},

	//
	// TELEGRAM
	//

	'telegramIP' => function ($text, $bot, $chat, $time=3600) {

		if (empty($text) or (!$bot)) return "";

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		$new = false;
		$IPaddress = Cache::get("CACHED-USER-IP-" . $ip_address);

		if (!$IPaddress) {

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
				) ,
			));

			$IPaddress = curl_exec($curl);
			Cache::add("CACHED-USER-IP-" . $ip_address, $IPaddress, $time); // cache for 60 minutes by default or whatever the user specified
			$new = true;
			curl_close($curl);

		}

		$response = unserialize($IPaddress);

		$text = urlencode("\nInfo: " . $text . "\nLocation: " . $response["city"] . ", " . $response["country"] . ($new ? "\n\nhttps://www.google.com/maps/search/?api=1&query=" . $response['city'] . "%2C" . $response['country'] : ""));

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $bot . "/sendMessage?chat_id=" . $chat . "&text=$text");
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$head = curl_exec($ch);
		curl_close($ch);

		return "";
	},

	'telegram' => function ($text, $bot=null, $chat=null) {

		if (empty($text) or (!$bot))
			return "";

		if (!$bot || empty($bot))
			$bot=Settings::get('telegram_bot');
		if (!$chat || empty($chat))
			$chat=Settings::get('telegram_chat');

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $bot . "/sendMessage?chat_id=" . $chat . "&text=$text");
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$head = curl_exec($ch);
		curl_close($ch);

		return "";
	},

];

?>
