<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: ajax.php 6708 2013-10-01 14:36:56Z Miguel_Espinoza $
 */
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

if (isset($_GET['ajax_page_display']))
{
	define('PHPFOX_IS_AJAX_PAGE', true);
}
else 
{
	define('PHPFOX_IS_AJAX', true);
}

// Require phpFox Init
require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'init.inc.php');

if (!Phpfox::getService('ban')->check('ip', Phpfox::getIp()))
{
	exit();
}

$oAjax = Phpfox::getLib('ajax');
$oAjax->process();
echo $oAjax->getData();
if ($oAjax->bIsModeration == true)
{
	echo '$(window).trigger("moderation_ended");';
}