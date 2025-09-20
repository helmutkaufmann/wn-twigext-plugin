<?php

$filters += [

	// Additional fsenameilters

	'basename' => 'basename',

	'dirname' => 'dirname',

	'addslashes' => 'addslashes',

	'bin2hex' => 'bin2hex',

	'hex2bin' => 'hex2bin',

	'urlencode' => 'urlencode',

	'htmlspecialchars' => 'htmlspecialchars',

	'urldecode' => 'urldecode',

	'base64_encode' => 'base64_encode',

	'base64_decode' => 'base64_decode',

	'shuffle' => function($array) {
		$temparray=$array;
		shuffle($temparray);
		return $temparray;
	}

]

?>
