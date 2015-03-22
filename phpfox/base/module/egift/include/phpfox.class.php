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
class Module_Egift
{
	public static $aDevelopers = array(
		array(
			'name' => 'Miguel Espinoza',
			'website' => 'www.phpfox.com'
		)
	);
	
	public static $aTables = array(
		'egift',
		'egift_category',
		'egift_invoice'
		);

	public static $aInstallWritable = array(
		'file/pic/egift/'
	);
}

?>