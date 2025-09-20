<?php

// Import necessary classes and facades
use Mercator\TwigExt\Models\Settings;

// Initialize or extend the existing $functions array with additional functions
$functions += [

    //
    // Geocode Address
    //
    
    /**
     * Geocodes a given address to retrieve its geographical coordinates (longitude and latitude).
     *
     * This function utilizes the Nominatim API from OpenStreetMap to convert a human-readable address
     * into geographical coordinates. It sends a GET request to the API, parses the JSON response,
     * and returns an object containing the longitude and latitude of the first matching location.
     *
     * **Note:** Ensure compliance with Nominatim's [Usage Policy](https://operations.osmfoundation.org/policies/nominatim/)
     * by respecting rate limits and providing a valid User-Agent string.
     *
     * @param string $address The physical address to geocode (e.g., "1600 Amphitheatre Parkway, Mountain View, CA").
     *
     * @return object|null An object containing `longitude` and `latitude` properties if successful, or `null` if no results are found.
     *
     * @throws Exception If the cURL request fails or the API response is invalid.
     *
     * @example
     * ```php
     * $geo = $functions['geocodeAddress']("1600 Amphitheatre Parkway, Mountain View, CA");
     * echo "Longitude: " . $geo->longitude . ", Latitude: " . $geo->latitude;
     * ```
     */
    'geocodeAddress' => function ($address) {
        // Validate the input address
        if (empty($address) || !is_string($address)) {
            throw new InvalidArgumentException("Invalid address: Address must be a non-empty string.");
        }

        // URL-encode the address to safely include it in the API request URL
        $address = urlencode($address);

        // Construct the Nominatim API URL with the encoded address and desired response format
        $json = "https://nominatim.openstreetmap.org/search.php?q=$address&format=jsonv2";

        // Initialize a new cURL session
        $ch = curl_init($json);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0"
        ); // Set a valid User-Agent to comply with Nominatim's usage policy
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout to prevent hanging indefinitely

        // Execute the cURL request and store the response
        $jsonfile = curl_exec($ch);

        // Check for cURL errors
        if ($jsonfile === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL Error: $error");
        }

        // Check HTTP status code for non-200 responses
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            curl_close($ch);
            throw new Exception("HTTP Error: Received status code $httpCode from API.");
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response into an associative array
        $decoded = json_decode($jsonfile, true);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Error: " . json_last_error_msg());
        }

        // Check if the response contains at least one result
        if (empty($decoded)) {
            return null; // No results found for the given address
        }

        // Convert the first result into an object
        $geo = (object)$decoded[0];

        // Map the 'lon' and 'lat' properties to 'longitude' and 'latitude' for clarity
        $geo->longitude = isset($geo->lon) ? $geo->lon : null;
        $geo->latitude = isset($geo->lat) ? $geo->lat : null;

        // Ensure both longitude and latitude are set, otherwise return null
        if (is_null($geo->longitude) || is_null($geo->latitude)) {
            return null;
        }

        return $geo;
    },

];
?>