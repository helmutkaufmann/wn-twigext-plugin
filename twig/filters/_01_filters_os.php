<?php 

$filters += [
        
	// Additional fsenameilters
      		

	'basename' => function ($path, $suffix=null) {
		return basename($path, $suffix);
	},

	'dirname' => function ($path, $levels=1) {
		return dirname($path, $levels);
	},
/*
	'addslashes' => function ($file) {
		return addslashes($file);
	},

	'bin2hex' => function ($string) {
		return bin2hex($string);
	},

	'hex2bin' => function ($string) {
		return hex2bin($string);
	},

	'urlencode' => function ($string) {
		return urlencode($string) ;
	},
	
	'htmlspecialchars' => function ($string) {
		return htmlspecialchars($string) ;
	},

	'urldecode' => function ($string) {
		return urldecode($string);
	},

	'base64_encode' => function ($string) {
		return base64_encode($string);
	},

	'base64_decode' => function ($string) {
		return base64_decode($string);
	}
*/       	
            
];

?>

