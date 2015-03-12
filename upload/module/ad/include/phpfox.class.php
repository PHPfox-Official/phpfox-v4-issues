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
 * @package 		Phpfox_Module
 * @version 		$Id: phpfox.class.php 4073 2012-03-28 13:25:57Z Miguel_Espinoza $
 */
class Module_Ad
{	
	public static $aTables = array(
		'ad',
		'ad_invoice',
		'ad_plan',
		'ad_track',
		'ad_sponsor',
		'ad_country'
	);
	
	public static $aInstallWritable = array(
		'file/pic/ad/'
	);		
}

?>