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
 * @version 		$Id: phpfox.class.php 1558 2010-05-04 12:51:22Z Raymond_Benc $
 */
class Module_Marketplace
{	
	public static $aTables = array(
		'marketplace',
		'marketplace_category',
		'marketplace_category_data',
		'marketplace_image',
		'marketplace_invite',
		'marketplace_invoice',
		'marketplace_text'
	);
	
	public static $aInstallWritable = array(
		'file/pic/marketplace/'
	);		
}

?>