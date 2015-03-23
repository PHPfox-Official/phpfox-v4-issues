<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.php 7004 2013-12-20 14:23:28Z Raymond_Benc $ 
 */

if (version_compare(phpversion(), '5.4', '<') === true)
{
	exit('PHPfox 4 or higher requires PHP 5.4 or newer.');
}

ob_start();

define('PHPFOX', true);
define('PHPFOX_DS', DIRECTORY_SEPARATOR);
define('PHPFOX_DIR', dirname(__FILE__) . PHPFOX_DS);
define('PHPFOX_START_TIME', array_sum(explode(' ', microtime())));

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/include/init.inc.php');

spl_autoload_register(function($class) {
	$name = strtolower($class);
	$name = str_replace("\\", '/', $name);

	if (substr($name, 0, 5) == 'core/' || substr($name, 0, 5) == 'apps/' || substr($name, 0, 4) == 'api/') {
		$class = str_replace("\\", '/', $class);
		$dir = PHPFOX_DIR_SRC;
		if (substr($name, 0, 5) == 'apps/') {
			$dir = PHPFOX_DIR_SITE;
		}

		$path = $dir . $class . '.php';

		require($path);
	}
});

function phrase() {
	$Reflect = (new ReflectionClass('Phpfox_Locale'))->newInstanceWithoutConstructor();

	return call_user_func_array([$Reflect, 'phrase'], func_get_args());
}

function error() {
	$Reflect = (new ReflectionClass('Core\Exception'))->newInstanceWithoutConstructor();

	return call_user_func_array([$Reflect, 'toss'], func_get_args());
}

Phpfox::run();