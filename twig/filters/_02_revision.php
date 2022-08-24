<?php

/**
  * Appends this pattern: ? . {last modified date}
  * to an assets filename to force browser to reload
  * cached modified file.
  *
  * See: https://github.com/vojtasvoboda/oc-twigextensions-plugin/issues/25
  *
  * @return array
  */

$filters += [
	
	 'revision' => function ($filename, $format = null) {
        // Remove http/web address from the file name if there is one to load it locally
        $prefix = url('/');
        $filename_ = trim(preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $filename) , '/');
        if (file_exists($filename_)) {
            $timestamp = filemtime($filename_);
            $prepend = ($format) ? date($format, $timestamp) : $timestamp;
            return $filename . "?" . $prepend;
        }
        return $filename;
    }
];

?>
