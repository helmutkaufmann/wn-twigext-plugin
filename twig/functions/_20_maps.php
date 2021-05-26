<?php

use Mercator\TwigExt\Models\Settings;

$functions += [

	//
	// Mail
	//
	'geocodeAddress' => function ($address) {

  		$json = "https://nominatim.openstreetmap.org/search.php?q=$address&format=jsonv2";
  		$ch = curl_init($json);
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0");
  		$jsonfile = curl_exec($ch);
  		curl_close($ch);
  		$geo = (object)(json_decode($jsonfile,true)[0]);
  		$geo->longitude = $geo->lon;
  		$geo->latitude =  $geo->lat;
  		return $geo;
	},

];

?>
