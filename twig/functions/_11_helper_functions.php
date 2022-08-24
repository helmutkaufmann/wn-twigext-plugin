<?php

$functions += [

	/**
	 * Works like the config() helper function.
	 *
	 * @return array
	 */
	'config' => function ($key = null, $default = null) {
					return config($key, $default);
	},
	/**
	 * Works like the env() helper function.
	 *
	 * @return array
	 */
	'env' => function ($key, $default = null) {
					return env($key, $default);
	},

	/**
	 * Works like the session() helper function.
	 *
	 * @return array
	 */
	'session' => function ($key = null) {
					return session($key);
	},

	/**
	 * Works like the trans() helper function.
	 *
	 * @return array
	 */
	'trans' => function ($key = null, $parameters = []) {
					return trans($key, $parameters);
	 }
];

?>
