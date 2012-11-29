<?php
!defined('DS') && define('DS', DIRECTORY_SEPARATOR);

spl_autoload_register(function($class)
{
	$path = __DIR__.DS.$class.'.class.php';
	if(is_readable($path))
	{
		require_once $path;
	}
});