<?php

$functions += [


	//
	// STRINGS
	//
	'strCamel' => function ($text) {
		  return camel_case(text);
	},

	//
	// HEADERS AND REDIRECT
	//
	'time' => function () {
		  return time();
	},

	'redirect' => function ($url) {
		return redirect()->away($url);
	},

	'header' => function ($info, $flag=false, $code=200) {
		header($info, $flag, $code);
		return "";
	},

	//
	// TEXT
	//

	'addslashes' => function ($file) {
		  return addslashes($file);
	},

	'explode' => function ($string, $delimiter="/", $limit=PHP_INT_MAX) {

		  return explode($delimiter, $string, $limit);

	},

	'breadcrumbs' => function ($string, $delimiter='/', $limit=PHP_INT_MAX) {

		  $crumbs=explode($delimiter, $string, $limit);
		  $bread = Array();
		  $first = true;
		  foreach ($crumbs as $crumb) {
			if (!$first) {
				$bread[] = "$lastCrum/$crumb";
				$lastCrum= "$lastCrum/$crumb";
			}
			else {
				$bread[] = "$crumb";
				$lastCrum = "$crumb";
			}
			$first = false;
		  }

		  return $bread;
	},

	'clientIP' => function () {

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

		return $ip_address;

	},

	'urldecode' => function ($file) {
			return urldecode($file);
	},

	];

?>
