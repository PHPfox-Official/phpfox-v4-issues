<?php

ignore_user_abort(true);
if (!PHPFOX_SAFE_MODE)
{
    @set_time_limit(0);
}

$iCronId = null;

if (php_sapi_name() == 'cli')
{
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
	define('PHPFOX_DIR', dirname(dirname(dirname(__FILE__))) . PHPFOX_DS);
	
	/**
	 * No SESSIONS
	 *
	 */
	define('PHPFOX_NO_SESSION', true);
	
	/**
	 * Do not set user sessions
	 *
	 */
	define('PHPFOX_NO_USER_SESSION', true);	
	
	$iCronId = (int) $_SERVER['argv'][1];
	
	if ($iCronId < 1)
	{
		exit("Invalid cron ID.\n");
	}
	
	// Require phpFox Init
	require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'init.inc.php');	
}

(($sPlugin = Phpfox_Plugin::get('cron_start')) ? eval($sPlugin) : false);

Phpfox::getLib('cron')->exec($iCronId);

(($sPlugin = Phpfox_Plugin::get('cron_end')) ? eval($sPlugin) : false);

?>