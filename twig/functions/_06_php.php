<?php


$functions += [

		/**
		* @deprecated as of v1.2: Use Twig standard filter "format_datetime"
		*/
		'strftime' => function ($time, $format = '%d.%m.%Y %H:%M:%S') {
        $timeObj = new Carbon($time);
        return strftime($format, $timeObj->getTimestamp());
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "upper"
 		*/
    , 'uppercase' => function ($string) {
        return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "lower"
 		*/
    , 'lowercase' => function ($string) {
        return mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
    }

    , 'ucfirst' => function ($string) {
        return ucfirst($string);
    }
    , 'lcfirst' => function ($string) {
        return lcfirst($string);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "upper"
 		*/
    , 'uppercase' => function ($string) {
        return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "trimStart"
 		*/
    , 'ltrim' => function ($string, $charlist = " \t\n\r\0\x0B") {
        return ltrim($string, $charlist);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "trimEnd"
 		*/
    , 'rtrim' => function ($string, $charlist = " \t\n\r\0\x0B") {
        return rtrim($string, $charlist);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "u.repeat"
 		*/
    , 'str_repeat' => function ($string, $multiplier = 1) {
        return str_repeat($string, $multiplier);
    }
		
    , 'plural' => function ($string, $count = 2) {
        return str_plural($string, $count);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "u.padBoth"
 		*/
    , 'strpad' => function ($string, $pad_length, $pad_string = ' ') {
        return str_pad($string, $pad_length, $pad_string, $pad_type = STR_PAD_BOTH);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "u.padStart"
 		*/
    , 'leftpad' => function ($string, $pad_length, $pad_string = ' ') {
        return str_pad($string, $pad_length, $pad_string, $pad_type = STR_PAD_LEFT);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard filter "u.padEnd"
 		*/
    , 'rightpad' => function ($string, $pad_length, $pad_string = ' ') {
        return str_pad($string, $pad_length, $pad_string, $pad_type = STR_PAD_RIGHT);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard function "reverse"
 		*/
    , 'rtl' => function ($string) {
        return strrev($string);
    }

		/**
 		* @deprecated as of v1.2: Use Twig standard function "replace"
 		*/
    , 'str_replace' => function ($string, $search, $replace) {
        return str_replace($search, $replace, $string);
    }

    , 'strip_tags' => function ($string, $allow = '') {
        return strip_tags($string, $allow);
    }

    , 'var_dump' => function ($expression) {
        ob_start();
        var_dump($expression);
        $result = ob_get_clean();
        return $result;
    }
];

?>
