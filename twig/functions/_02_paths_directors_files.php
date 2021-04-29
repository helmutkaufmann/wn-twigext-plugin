<?php

use Cms\Classes\Theme;

$functions += [

	//
	// PATHS
	//
	'pathBase' => function () {

		  return base_path();

	},
	
	'pathConfig' => function () {

		  return  config_path();

	},
	
	'pathDatabase' => function ($dir="") {

		  return  database_path($dir);

	},


	'pathMedia' => function ($file=null) {

		  return media_path($file);

	},
	
	'pathPlugins' => function ($dir="") {

		  return plugins_path($dir);

	},

	'pathPublic' => function ($dir="") {

		  return public_path($dir);

	},
	
	'pathStorage' => function ($dir="") {

		  return storage_path($dir);

	},


	'pathTemp' => function ($dir="") {

		  return  temp_path($dir);

	},
	
	'pathThemes' => function ($dir="") {
	
		  return  themes_path($dir);

	},
	
	'pathUpload' => function ($dir="") {

		  return  upload_path($dir);

	},
	
	
	//
	// FILES & DIRECTORIES
	//
	

	'glob' => function ($pattern, $prefix="") {

		$fullDir = urldecode(str_replace (".." , "" , base_path() . $pattern)); // most simple xss prevention

		$scannedFiles = glob($fullDir, GLOB_BRACE);

		if (!is_array($scannedFiles))
			return[];

		$files = [];
		foreach ($scannedFiles as $file) {
			if (!in_array(trim($file), ['.', '..', ".gitignore", ".seed"]) && is_file($file)) {
				$files[] = (!strlen($prefix) ? substr($file, strlen(base_path())) : substr($file, strlen(base_path(). $prefix)));
			}
		}

		natcasesort($files);
		return $files;

	},


	'randomBytes' => function (int $length) {

		return random_bytes($length);

	},

];

?>
