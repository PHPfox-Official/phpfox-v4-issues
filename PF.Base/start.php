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

/**
 * @param $element
 * @return \Core\jQuery
 */
function j($element) {
	return new \Core\jQuery($element);
}

function phrase() {
	$Reflect = (new ReflectionClass('Phpfox_Locale'))->newInstanceWithoutConstructor();

	return call_user_func_array([$Reflect, 'phrase'], func_get_args());
}

function error() {
	$Reflect = (new ReflectionClass('Core\Exception'))->newInstanceWithoutConstructor();

	return call_user_func_array([$Reflect, 'toss'], func_get_args());
}

if (!defined('PHPFOX_NO_RUN')) {
	Phpfox::run();
}