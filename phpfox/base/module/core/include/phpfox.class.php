<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Core
 * @version 		$Id: phpfox.class.php 4165 2012-05-14 10:43:25Z Raymond_Benc $
 */
class Module_Core 
{	
	public static $aTables = array(
		'admincp_dashboard',
		'admincp_login',
		'block',
		'block_order',
		'block_source',
		'cache',
		'component',
		'component_setting',
		'country',
		'country_child',
		'cron',
		'cron_log',
		'currency',
		'install_log',
		'menu',
		'module',
		'password_request',
		'plugin',
		'plugin_hook',
		'product',
		'product_dependency',
		'product_install',
		'rewrite',
		'search',
		'seo_meta',
		'seo_nofollow',
		'setting',
		'setting_group',
		'site_stat',
		'version'
	);
	
	public static $aInstallWritable = array(
		'file/cache/',
		'file/gzip/',
		'file/log/',
		'file/static/',
		'file/session/',
		'file/pic/watermark/',
		'file/pic/icon/',
		'file/settings/'
	);
}

?>