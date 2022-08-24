<?php


use Carbon\Carbon;

$filters += [

	'strftime' => function ($time, $format = '%d.%m.%Y %H:%M:%S') {
            $timeObj = new Carbon($time);
            return strftime($format, $timeObj->getTimestamp());
        }
        , 'uppercase' => function ($string) {
            return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
        }
        , 'lowercase' => function ($string) {
            return mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
        }
        , 'ucfirst' => function ($string) {
            return ucfirst($string);
        }
        , 'lcfirst' => function ($string) {
            return lcfirst($string);
        }
        , 'ltrim' => function ($string, $charlist = " \t\n\r\0\x0B") {
            return ltrim($string, $charlist);
        }
        , 'rtrim' => function ($string, $charlist = " \t\n\r\0\x0B") {
            return rtrim($string, $charlist);
        }
        , 'str_repeat' => function ($string, $multiplier = 1) {
            return str_repeat($string, $multiplier);
        }
        , 'plural' => function ($string, $count = 2) {
            return str_plural($string, $count);
        }
        , 'strpad' => function ($string, $pad_length, $pad_string = ' ') {
            return str_pad($string, $pad_length, $pad_string, $pad_type = STR_PAD_BOTH);
        }
        , 'leftpad' => function ($string, $pad_length, $pad_string = ' ') {
            return str_pad($string, $pad_length, $pad_string, $pad_type = STR_PAD_LEFT);
        }
        , 'rightpad' => function ($string, $pad_length, $pad_string = ' ') {
            return str_pad($string, $pad_length, $pad_string, $pad_type = STR_PAD_RIGHT);
        }
        , 'rtl' => function ($string) {
            return strrev($string);
        }
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
