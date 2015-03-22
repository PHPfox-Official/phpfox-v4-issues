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
define('PHPFOX_DIR', dirname(__FILE__) . PHPFOX_DS . 'base' . PHPFOX_DS);
define('PHPFOX_START_TIME', array_sum(explode(' ', microtime())));

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/base/include/init.inc.php');

spl_autoload_register(function($class) {
	$class = strtolower($class);
	$class = str_replace("\\", '/', $class);
	if (substr($class, 0, 5) == 'core/' || substr($class, 0, 5) == 'apps/' || substr($class, 0, 4) == 'api/') {
		$path = PHPFOX_DIR_PARENT . $class . '.php';

		require($path);
	}
});

function Error() {
	$Reflect = (new ReflectionClass('Core\Exception'))->newInstanceWithoutConstructor();

	return call_user_func_array([$Reflect, 'toss'], func_get_args());
}

Phpfox::run();