<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.php 3650 2011-12-05 06:51:59Z Raymond_Benc $ 
 */

// Make sure we are running PHP5.
if (version_compare(phpversion(), '5', '<') === true)
{
	exit('phpFphpFox 2 or higher requires PHP 5 or newer.');
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
define('PHPFOX_DIR', dirname(dirname(__FILE__)) . PHPFOX_DS);

define('PHPFOX_START_TIME', array_sum(explode(' ', microtime())));

// Require phpFox Init
require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'init.inc.php');

if (Phpfox::getParam('core.url_rewrite') != '3')
{
	exit();
}

if (Phpfox::getLib('request')->get('req3') == '')
{
	Phpfox::getLib('url')->send('admincp.theme.index');
}

Phpfox::run();

ob_end_flush();

?>