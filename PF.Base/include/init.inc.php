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

require_once(PHPFOX_DIR . 'include' . PHPFOX_DS . 'setting' . PHPFOX_DS . 'constant.sett.php');

if (!file_exists(PHPFOX_DIR_SETTINGS . 'license.sett.php')) {
	define('PHPFOX_NO_PLUGINS', true);
	define('PHPFOX_NO_USER_SESSION', true);
	define('PHPFOX_NO_CSRF', true);
	define('PHPFOX_INSTALLER', true);
	define('PHPFOX_INSTALLER_NO_TMP', true);
	define('PHPFOX_NO_RUN', true);
}
else {
	require(PHPFOX_DIR_SETTINGS . 'license.sett.php');
	define('PHPFOX_IS_TECHIE', ((PHPFOX_LICENSE_ID == 'techie' || preg_match('/techie\_(.*?)/i', PHPFOX_LICENSE_ID)) ? true : false));
}

// Set error reporting enviroment
error_reporting((PHPFOX_DEBUG ? E_ALL | E_STRICT : 0));

spl_autoload_register(function($class) {
	// $class = strtolower($class);

	$name = strtolower($class);
	$name = str_replace("\\", '/', $name);

	if (substr($name, 0, 5) == 'core/'
		|| substr($name, 0, 5) == 'apps/'
		|| substr($name, 0, 12) == 'controllers/'
		|| substr($name, 0, 4) == 'api/') {
		$class = str_replace("\\", '/', $class);
		$dir = PHPFOX_DIR_SRC;
		if (substr($name, 0, 5) == 'apps/') {
			$dir = PHPFOX_DIR_SITE;
		}

		$path = $dir . $class . '.php';

		require($path);
		return;
	}

	$class = strtolower($class);
	if (preg_match('/([a-zA-Z0-9]+)_service_([a-zA-Z0-9_]+)/', $name, $matches)) {
		$parts = explode('_', $matches[2]);
		if (count($parts) > 1) {
			if ($parts[0] == $parts[1]) {
				unset($parts[1]);
			}
		}
		$className = $matches[1] . '.' . implode('.', $parts);

		Phpfox::getService($className);
	}
	else if (substr($name, 0, 7) == 'phpfox_') {
		$class = str_replace('_', '.', $class);
		Phpfox::getLibClass($class);
	}
});

require(PHPFOX_DIR_LIB_CORE . 'phpfox' . PHPFOX_DS . 'phpfox.class.php');
require(PHPFOX_DIR_LIB_CORE . 'error' . PHPFOX_DS . 'error.class.php');
require(PHPFOX_DIR_LIB_CORE . 'module' . PHPFOX_DS . 'service.class.php');
require(PHPFOX_DIR_LIB_CORE . 'module' . PHPFOX_DS . 'component.class.php');

// No need to load the debug class if the debug is disabled
if (PHPFOX_DEBUG)
{
	require_once(PHPFOX_DIR_LIB_CORE . 'debug' . PHPFOX_DS . 'debug.class.php');
	$handler = new Whoops\Handler\PrettyPageHandler();
	$handler->setEditor('textmate');

	$whoops = new Whoops\Run;
	$whoops->pushHandler($handler);
	$whoops->register();
}

// set_error_handler(array('Phpfox_Error', 'errorHandler'));

(PHPFOX_DEBUG ? Phpfox_Debug::start('init') : false);

date_default_timezone_set('GMT');

define('PHPFOX_TIME', time());

Phpfox::getLib('setting')->set();

if (!defined('PHPFOX_NO_PLUGINS')) {
	Phpfox_Plugin::set();
}

// Start a session if needed
if (!defined('PHPFOX_NO_SESSION'))
{
	Phpfox_Session_Handler::instance()->init();
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
