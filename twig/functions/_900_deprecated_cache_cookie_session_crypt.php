<?php

//
// The following functions will be deprecated
//
$functions += [

	//
	// CACHE
	//
	'cacheAdd' => function ($key, $value, $seconds=3600) {
		  return Cache::add($key, $value, $seconds);
	},

	'cachePut' => function ($key, $value, $seconds=3600) {
		  Cache::put($key, $value, $seconds);
		  return "";
	},

	'cacheForever' => function ($key, $value) {
		  Cache::forever($key, $value);
		  return "";
	},

	'cacheForget' => function ($key) {
		  Cache::forget($key);
		  return "";
	},

	'cacheFlush' => function () {
		  Cache::flush();
		  return "";
	},

	'cacheGet' => function ($key, $value=null) {
		  return Cache::get($key, $value);
	},

	'cacheIncrement' => function ($key, $i=1) {
		  return Cache::increment($key, $i);
	},

	'cacheDecrement' => function ($key, $value=1) {
		  return Cache::decrement($key, $value);
	},

	'cachePull' => function ($key, $value=null) {
		$value = Cache::pull($key);
		return ($value == null ? $value : $value);
	},

	//
	// COOKIES
	//

	'cookieGet' => function ($key) {
		  return Cookie::get($key);
	},


	'cookieQueue' => function ($key, $value=true, $seconds=86400) {
		  Cookie::queue($key, $value, $seconds);
		  return "";
	},

	'cookieForever' => function ($key, $value=true) {
		  Cookie::forever($key, $value);
		  return "";
	},

	'cookieExpire' => function ($key) {
		  Cookie::Expire($key);
		  return "";
	},

	//
	// SESSION
	//

	'sessionPut' => function ($key, $value) {
		  return Session::put($key, $value);
	},

	'sessionPush' => function ($key, $value) {
		  return Session::push($key, $value);
	},

	'sessionGet' => function ($key, $value="") {
		  return Session::get($key, $value);
	},

	'sessionAll' => function () {
		  return Session::all();
	},

	'sessionPull' => function ($key, $value="") {
		  return Session::pull($key, $value);
	},

	'sessionHas' => function ($key) {
		  return Session::has($key);
	},

	'sessionForget' => function ($key) {
		  return Session::forget($key);
	},

	'sessionFlush' => function () {
		  return Session::has();
	},

	'sessionRegenerate' => function () {
		  return Session::regenerate();
	},

	'sessionFlash' => function ($key, $value) {
		  return Session::flash($key, $value);
	},

	'sessionReflash' => function () {
		  return Session::reflash();
	},

	'sessionKeep' => function ($key) {
		  return Session::keep($key);
	},

	//
	// CRYPT
	//

	'cryptEncryptString' => function ($value) {
		  return encrypt($value);
	},

	'cryptDecryptString' => function ($value) {
		try {
			$decrypted = decrypt($value);
		}
		catch (Exception $ex) {
			return false;
		}
		return $decrypted;
	},

	'cryptEncrypt' => function ($value) {
		  return encrypt($value);
	},

	'cryptDecrypt' => function ($value) {
		try {
			$decrypted = decrypt($value);
		}
		catch (Exception $ex) {
			return false;
		}
		return $decrypted;
	},

	//
	// Config
	//
	'configGet' => function ($api_key, $g) {
		$res = Settings::get($api_key, $g);
		return $res;
	},

	//
	// RANDOM BYTES
	//
	'randomBytes' => function (int $length) {
			return Str::random($length);
	},

];

?>
