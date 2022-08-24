<?php


use Carbon\Carbon;

$filters += [

				'strftime' => function ($time, $format = '%d.%m.%Y %H:%M:%S') {
            $timeObj = new Carbon($time);
            return strftime($format, $timeObj->getTimestamp());
        }
        , 'ucfirst' => function ($string) {
            return ucfirst($string);
        }
        , 'lcfirst' => function ($string) {
            return lcfirst($string);
        }
        , 'plural' => function ($string, $count = 2) {
            return str_plural($string, $count);
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
