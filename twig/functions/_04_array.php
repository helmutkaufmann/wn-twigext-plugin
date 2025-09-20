<?php

// Initialize or extend the existing $functions array with additional functions
$functions += [

    //
    // Array
    //

    /**
     * Filters elements of an array using a regular expression.
     *
     * This function acts as a wrapper for PHP's built-in `preg_grep` function,
     * allowing you to use it within the `$functions` array for dynamic access.
     *
     * @param array  $array   The input array to be filtered.
     * @param string $pattern The regular expression pattern to apply.
     * @param int    $flags   Optional. Flags to modify the behavior of `preg_grep`.
     *                        Common flags include:
     *                        - PREG_GREP_INVERT: Inverts the match.
     *                        Default is `0` (no flags).
     *
     * @return array|false An array containing all elements of the input array that match the pattern.
     *                     Returns `false` if an error occurred.
     *
     * @example
     * // Filter all elements that contain the word 'apple'
     * $filtered = $functions['preg_grep'](['apple', 'banana', 'cherry'], '/apple/');
     * // $filtered => ['apple']
     */
    'preg_grep' => function ($array, $pattern, $flags = 0) {
        return preg_grep($pattern, $array, $flags);
    },

];

?>