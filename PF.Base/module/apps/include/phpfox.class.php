<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Module
 * @version 		$Id: phpfox.class.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
class Module_Apps
{
	public static $aDevelopers = array(
		array(
			'name' => 'Miguel Espinoza',
			'website' => 'www.phpfox.com'
		)
	);
	
	public static $aTables = array(
		'app',
		'app_access',
		'app_category',
		'app_category_data',
		'app_disallow',
		'app_installed',
		'app_key'
	);
	
	public static $aInstallWritable = array(
		'file/pic/app/'
	);	
}

?>