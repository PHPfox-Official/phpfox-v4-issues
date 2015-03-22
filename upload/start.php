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

/**
 * Key to include phpFox
 *
 */
define('PHPFOX', true);

/**
 * Directory Seperator
 *
 */
define('PHPFOX_DS', DIRECTORY_SEPARATOR);

/**
 * phpFox Root Directory
 *
 */
define('PHPFOX_DIR', dirname(__FILE__) . PHPFOX_DS);

define('PHPFOX_BASE', __DIR__ . '/../');

define('PHPFOX_START_TIME', array_sum(explode(' ', microtime())));

require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'init.inc.php');

Phpfox::run();