<?php

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
define('PHPFOX_DIR_INSTALL', PHPFOX_DIR . 'install' . PHPFOX_DS);

define('PHPFOX_NO_PLUGINS', true);
define('PHPFOX_NO_USER_SESSION', true);
define('PHPFOX_NO_CSRF', true);
define('PHPFOX_INSTALLER', true);

// Require phpFox Init
require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'init.inc.php');

$oFile = Phpfox::getLib('file');
if (!$oFile->isWritable(PHPFOX_DIR_CACHE))
{
	if ($oFile->isWritable($oFile->getTempDir()))
	{
		define('PHPFOX_TMP_DIR', $oFile->getTempDir());
	}
	else 
	{
		define('PHPFOX_INSTALLER_NO_TMP', true);
	}
}

require_once(PHPFOX_DIR_INSTALL . 'include' . PHPFOX_DS . 'installer.class.php');

$oInstaller = new Phpfox_Installer();
$oInstaller->run();
?>