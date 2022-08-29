<?php

use Illuminate\Support\Str;

//
// Helper class allowing access to arbitray methods of arbitrary classes
//
class twigextStaticClass {

	private $twigextCallerClass;

	public function __construct($thisClass) {
		$this->twigextCallerClass = $thisClass;
	}

	public function __call($method, $args) {
			// Error handling to be added
			return call_user_func_array(array($this->twigextCallerClass, $method), $args);
	}
}

$functions += [
	'cache' => function () {
		  return new twigextStaticClass("Cache");
	},
	'storage' => function () {
		  return new twigextStaticClass("Storage");
	},
	'crypt' => function () {
		  return new twigextStaticClass("Crypt");
	},
	'cookie' => function () {
		  return new twigextStaticClass("Cookie");
	},
	'hash' => function () {
		  return new twigextStaticClass("Hash");
	},
	'session' => function () {
		  return new twigextStaticClass("Session");
	},
	'str' => function () {
		  return new twigextStaticClass("Str");
	},
	'accesObject'=> function ($name) {
		  return new twigextStaticClass($name);
	},
];
