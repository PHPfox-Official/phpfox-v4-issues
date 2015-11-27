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

require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'library' . PHPFOX_DS . 'phpfox' . PHPFOX_DS . 'functions' . PHPFOX_DS . 'fallback.php');

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
/*
 * @depreciated 4.0.5
if (file_exists(PHPFOX_DIR . 'include' . PHPFOX_DS . 'setting' . PHPFOX_DS . 'dev.sett.php') && !defined('PHPFOX_DEBUG'))
{
	require_once(PHPFOX_DIR . 'include' . PHPFOX_DS . 'setting' . PHPFOX_DS . 'dev.sett.php');
}
*/
if (file_exists(PHPFOX_DIR . 'file/settings/debug.sett.php') && !defined('PHPFOX_DEBUG')) {
	require(PHPFOX_DIR . 'file/settings/debug.sett.php');
}

require_once(PHPFOX_DIR . 'include' . PHPFOX_DS . 'setting' . PHPFOX_DS . 'constant.sett.php');

$old = PHPFOX_DIR. '../include/setting/server.sett.php';
if (!file_exists(PHPFOX_DIR_SETTINGS . 'license.sett.php')
	|| !file_exists(PHPFOX_DIR_SETTINGS . 'server.sett.php')
	|| file_exists($old)

) {
	define('PHPFOX_NO_PLUGINS', true);
	define('PHPFOX_NO_USER_SESSION', true);
	define('PHPFOX_NO_CSRF', true);
	define('PHPFOX_INSTALLER', true);
	define('PHPFOX_INSTALLER_NO_TMP', true);
	define('PHPFOX_NO_RUN', true);

	if (file_exists($old)
		&& !defined('PHPFOX_IS_UPGRADE')
		&& !class_exists('Phpfox_Installer', false)) {
		define('PHPFOX_IS_UPGRADE', true);
		if (!defined('PHPFOX_DEBUG')) {
			define('PHPFOX_DEBUG', true);
		}
	}
}
else {
	require(PHPFOX_DIR_SETTINGS . 'license.sett.php');
	if (!defined('PHPFOX_IS_TECHIE')) {
		define('PHPFOX_IS_TECHIE', (((PHPFOX_LICENSE_ID == 'techie' || preg_match('/techie\_(.*?)/i', PHPFOX_LICENSE_ID)) && !defined('PHPFOX_IS_TRIAL')) ? true : false));
	}
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
if (PHPFOX_DEBUG) {
	require_once(PHPFOX_DIR_LIB_CORE . 'debug' . PHPFOX_DS . 'debug.class.php');
	$handler = new Whoops\Handler\PrettyPageHandler();
	$handler->setEditor('phpstorm');

	$whoops = new Whoops\Run;
	$whoops->pushHandler($handler);
	$whoops->register();
}
else {

}

// set_error_handler(array('Phpfox_Error', 'errorHandler'));

(PHPFOX_DEBUG ? Phpfox_Debug::start('init') : false);

date_default_timezone_set('GMT');

define('PHPFOX_TIME', time());

$version = PHPFOX_DIR_SETTINGS . 'version.sett.php';
if (file_exists($version)) {
	$version = require($version);

	if (version_compare(Phpfox::VERSION, $version['version'], '>')) {
		define('PHPFOX_NO_PLUGINS', true);
		define('PHPFOX_NO_USER_SESSION', true);
		define('PHPFOX_NO_CSRF', true);
		define('PHPFOX_INSTALLER', true);
		define('PHPFOX_INSTALLER_NO_TMP', true);
		define('PHPFOX_NO_RUN', true);
		define('PHPFOX_IS_UPGRADE', true);
	}
}

Phpfox::getLib('setting')->set();

if (defined('PHPFOX_INSTALLER')) {
	if (isset($_GET['phpfox-upgrade']) || !defined('PHPFOX_IS_UPGRADE')) {
		require(PHPFOX_DIR . 'install/include/installer.class.php');
		(new Phpfox_Installer())->run();
		exit;
	}

	$sMessage = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$sMessage .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en">';
	$sMessage .= '<head><title>Upgrade Taking Place</title><meta http-equiv="Content-Type" content="text/html;charset=utf-8" /><style type="text/css">body{font-family:verdana; color:#000; font-size:9pt; margin:5px; background:#fff;} img{border:0px;}</style></head><body>';
	$sMessage .= file_get_contents(PHPFOX_DIR . 'static' . PHPFOX_DS . 'upgrade.html');
	$sMessage .= '</body></html>';
	echo $sMessage;
	exit;
}

if (!defined('PHPFOX_NO_PLUGINS')) {
	Phpfox_Plugin::set();
}

if (Phpfox_Request::instance()->get('ping-no-session')) {
	define('PHPFOX_NO_SESSION', true);
	define('PHPFOX_NO_APPS', true);
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