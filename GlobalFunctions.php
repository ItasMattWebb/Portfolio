<?php

spl_autoload_register(function($class){
	$filename = str_replace(array('_', '.'), DIRECTORY_SEPARATOR, $class).'.php';

	$file = DIRECTORY_SEPARATOR . $filename;
	if (!file_exists(__DIR__ . $file)){
		$file = DIRECTORY_SEPARATOR . 'Classes'. DIRECTORY_SEPARATOR . $filename;
		if (!file_exists($file)){
			return FALSE;
		}
	}
	require_once(__DIR__ . $file);
});

function file_not_found(){
	include '404.php';
	exit;
}

function file_render($name){
	ob_start();
	include $name;
	return ob_get_clean();
}
