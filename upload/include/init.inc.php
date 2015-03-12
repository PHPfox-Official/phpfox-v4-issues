<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: init.inc.php 6619 2013-09-11 12:08:49Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

@ini_set('memory_limit', '-1');
@set_time_limit(0);

if (!function_exists('memory_get_usage'))
{
	function memory_get_usage() {}
}

if (function_exists('get_magic_quotes_runtime') && get_magic_quotes_runtime())
{
	if (preg_match('/5\.3\.(.*)/i', PHP_VERSION))
	{
		ini_set('magic_quotes_runtime', 0);
	}
	else
	{
		set_magic_quotes_runtime(0);
	}    
}

if (!isset($_SERVER['HTTP_USER_AGENT']))
{
	$_SERVER['HTTP_USER_AGENT'] = '';
}

// Start the debug
define('PHPFOX_MEM_START', memory_get_usage());
define('PHPFOX_TIME_START', array_sum(explode(' ', microtime())));

// Fix for foreign characters when server is set to receive other charset (http://www.w3.org/International/O-HTTP-charset)
header('Content-type: text/html; charset=utf-8');

// Require the needed setting and class files
if (file_exists(PHPFOX_DIR . 'include' . PHPFOX_DS . 'setting' . PHPFOX_DS . 'dev.sett.php') && !defined('PHPFOX_DEBUG'))
{
	require_once(PHPFOX_DIR . 'include' . PHPFOX_DS . 'setting' . PHPFOX_DS . 'dev.sett.php');
}
elseif (file_exists(PHPFOX_DIR . 'file' . PHPFOX_DS . 'log' . PHPFOX_DS . 'debug.php'))
{
	require_once(PHPFOX_DIR . 'file' . PHPFOX_DS . 'log' . PHPFOX_DS . 'debug.php');
}

require_once(PHPFOX_DIR . 'include' . PHPFOX_DS . 'setting' . PHPFOX_DS . 'constant.sett.php');
if (php_sapi_name() == 'litespeed')
{
	ini_set('session.save_handler', 'files');
	ini_set('session.save_path', PHPFOX_DIR_FILE . 'session' . PHPFOX_DS);
}

// Set error reporting enviroment
error_reporting((PHPFOX_DEBUG ? E_ALL | E_STRICT : 0));

require(PHPFOX_DIR_LIB_CORE . 'phpfox' . PHPFOX_DS . 'phpfox.class.php');
require(PHPFOX_DIR_LIB_CORE . 'error' . PHPFOX_DS . 'error.class.php');
require(PHPFOX_DIR_LIB_CORE . 'module' . PHPFOX_DS . 'service.class.php');
require(PHPFOX_DIR_LIB_CORE . 'module' . PHPFOX_DS . 'component.class.php');

// No need to load the debug class if the debug is disabled
if (PHPFOX_DEBUG)
{
	require_once(PHPFOX_DIR_LIB_CORE . 'debug' . PHPFOX_DS . 'debug.class.php');	
}
// http://www.phpfox.com/tracker/view/14329/
else
{
	foreach($_COOKIE AS $sKey => $sValue) 
	{
		if(preg_match('/js_console/i', $sKey))
		{
			setcookie($sKey, "0", time()-(3600*24), Phpfox::getParam('core.cookie_path'), Phpfox::getParam('core.cookie_domain'));
		}
	}
}

set_error_handler(array('Phpfox_Error', 'errorHandler'));

(PHPFOX_DEBUG ? Phpfox_Debug::start('init') : false);

// Default time to GMT
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('GMT');
	
	define('PHPFOX_TIME', time());
}
else 
{
	define('PHPFOX_TIME', strtotime(gmdate("M d Y H:i:s", time())));
}

Phpfox::getLib('setting')->set();

if (!defined('PHPFOX_NO_PLUGINS'))
{
	require(PHPFOX_DIR_LIB_CORE . 'plugin' . PHPFOX_DS . 'plugin.class.php');
	
	Phpfox_Plugin::set();
}
else 
{
	final class Phpfox_Plugin
	{
		public static function set() {}
		public static function get() {return false;}
	}
}

if (!function_exists('json_encode')) 
{
	require(PHPFOX_DIR_LIB . 'json' . PHPFOX_DS . 'JSON.php');
	
	if (!function_exists('json_encode'))
	{
		function json_encode($mData) 
		{
			$json = new Services_JSON();
			
			return ($json->encode($mData));
		}
	}

	if (!function_exists('json_decode'))
	{
		function json_decode($mData, $bIsArray = false) 
		{
			$json = new Services_JSON();
			if ($bIsArray === true)
			{
				return (array) $json->decode($mData);	
			}
			return ($json->decode($mData));
		}
	}
}

// Start a session if needed
if (!defined('PHPFOX_NO_SESSION'))
{
	Phpfox::getLib('session.handler')->init();
}

if (!defined('PHPFOX_NO_USER_SESSION'))
{
	Phpfox::getService('log.session')->setUserSession();
}

// check if user already verified their email
if (!defined('PHPFOX_CLI') || PHPFOX_CLI != true)
{
	Phpfox::getService('user.auth')->handleStatus();
}

(($sPlugin = Phpfox_Plugin::get('init')) ? eval($sPlugin) : false);

(PHPFOX_DEBUG ? Phpfox_Debug::end('init') : false);

?>
