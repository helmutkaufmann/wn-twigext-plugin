<?php


$functions += [


	//
	// Retrieving files
	//
	
	'storageGet' => function ($file, $disk="local") {
		return Storage::disk($disk) -> get($file);

	},

	
	//
	// File meta information
	//
	'storageExists' => function ($file, $disk="local") {
		return Storage::disk($disk) -> exists($file);

	},
	
	'storageSize' => function ($file, $disk="local") {
		return Storage::disk($disk) -> size($file);

	},
	
	'storageLastModified' => function ($file, $disk="local") {
		return Storage::disk($disk) -> lastModified($file);

	},
	
	//
	// Storing files
	//
	'storagePut' => function ($file, $content, $disk="local") {
		Storage::disk($disk) -> put($file, $content);
		return "";

	},
	
	'storageCopy' => function ($ftom, $to, $disk="local") {
		
		Storage::disk($disk) -> copy($ftom, $to);
		return "";

	},
	
	'storageMove' => function ($ftom, $to, $disk="local") {
		
		Storage::disk($disk) -> move($ftom, $to);
		return "";

	},
	
	//
	// Prepending / appending to files
	//
	'storagePrepend' => function ($file, $content, $disk="local") {
		Storage::disk($disk) -> prepend($file, $content);
		return "";

	},
	
	
	'storageAppend' => function ($file, $content, $disk="local") {
		Storage::disk($disk) -> prepend($file, $content);
		return "";

	},
	
	//
	// Deleting files
	//
	'storageDelete' => function ($files, $disk="local") {
		
		Storage::disk($disk) -> delete($files);
		return "";

	},
	
	//
	// Directories
	//
	'storageFiles' => function ($dir, $disk="local") {
		
		return Storage::disk($disk) -> files($dir);

	},

	'storageAllFiles' => function ($dir, $disk="local") {
		
		return Storage::disk($disk) -> allFiles($dir);

	},
	
	'storageDirectories' => function ($dir, $disk="local") {
		
		return Storage::disk($disk) -> directories($dir);

	},
	
	'storageAllDirectories' => function ($dir, $disk="local") {
		
		return Storage::disk($disk) -> allDirectories($dir);

	},
	
	'storageDeleteDirectory' => function ($dir, $disk="local") {
		
		Storage::disk($disk) -> deleteDirectory($dir);
		return "";

	},
	

];

?>
