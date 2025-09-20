<?php

// Initialize or extend the existing $functions array with additional functions
$functions += [

    //
    // STRINGS
    //

    /**
     * Converts a given text to camelCase.
     *
     * @param string $text The input string to be converted.
     * @return string The camelCase version of the input text.
     */
    'strCamel' => function ($text) {
        // Note: Ensure that the camel_case helper is available (Laravel or similar framework)
        return camel_case($text);
    },

    //
    // HEADERS AND REDIRECT
    //

    /**
     * Retrieves the current Unix timestamp.
     *
     * @return int The current time measured in the number of seconds since the Unix Epoch.
     */
    'time' => function () {
        return time();
    },

    /**
     * Redirects the user to a specified external URL.
     *
     * @param string $url The destination URL to redirect the user to.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the specified URL.
     */
    'redirect' => function ($url) {
        // Note: Ensure that the redirect() helper is available (Laravel framework)
        return redirect()->away($url);
    },

    /**
     * Sends a raw HTTP header to the client.
     *
     * @param string $info The header string to be sent (e.g., 'Location: /home').
     * @param bool $flag Optional. Indicates whether the header should replace a previous similar header.
     * @param int $code Optional. Forces the HTTP response code to the specified value.
     * @return string An empty string. This function does not return any meaningful value.
     */
    'header' => function ($info, $flag = false, $code = 200) {
        header($info, $flag, $code);
        return "";
    },

    //
    // TEXT
    //

    /**
     * Adds backslashes before certain characters in a string.
     *
     * @param string $file The input string where backslashes will be added.
     * @return string The string with backslashes added.
     */
    'addslashes' => function ($file) {
        return addslashes($file);
    },

    /**
     * Splits a string into an array using a specified delimiter.
     *
     * @param string $string The input string to be split.
     * @param string $delimiter The boundary string where the split occurs. Default is '/'.
     * @param int $limit Optional. The maximum number of elements in the resulting array. Default is PHP_INT_MAX.
     * @return array An array of strings created by splitting the input string.
     */
    'explode' => function ($string, $delimiter = "/", $limit = PHP_INT_MAX) {
        return explode($delimiter, $string, $limit);
    },

    /**
     * Generates breadcrumb paths from a given string.
     *
     * @param string $string The input string representing a path (e.g., 'home/products/electronics').
     * @param string $delimiter The delimiter used to split the string. Default is '/'.
     * @param int $limit Optional. The maximum number of segments to split into. Default is PHP_INT_MAX.
     * @return array An array of breadcrumb paths accumulated from the input string.
     */
    'breadcrumbs' => function ($string, $delimiter = '/', $limit = PHP_INT_MAX) {
        // Split the input string into segments based on the delimiter
        $crumbs = explode($delimiter, $string, $limit);
        $bread = [];        // Initialize an array to hold breadcrumb paths
        $first = true;      // Flag to identify the first segment
        foreach ($crumbs as $crumb) {
            if (!$first) {
                // For subsequent segments, append to the last accumulated path
                $bread[] = "$lastCrum/$crumb";
                $lastCrum = "$lastCrum/$crumb";
            } else {
                // For the first segment, initialize the accumulated path
                $bread[] = "$crumb";
                $lastCrum = "$crumb";
            }
            $first = false;  // Reset the flag after processing the first segment
        }

        return $bread;
    },

    /**
     * Retrieves the client's IP address, considering possible proxies.
     *
     * @return string The client's IP address.
     */
    'clientIP' => function () {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP address from shared internet (e.g., proxies)
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Check if IP is passed from a proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // IP address from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    },

    /**
     * Decodes URL-encoded strings.
     *
     * @param string $file The URL-encoded string to decode.
     * @return string The decoded string.
     */
    'urldecode' => function ($file) {
        return urldecode($file);
    },

];

?>