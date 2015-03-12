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
 * @package  		Module_Subscribe
 * @version 		$Id: phpfox.class.php 4179 2012-05-24 07:42:16Z Miguel_Espinoza $
 */
class Module_Subscribe 
{	
	public static $aTables = array(
		'subscribe_package',
		'subscribe_purchase',
		'subscribe_compare'
	);
	
	public static $aInstallWritable = array(
		'file/pic/subscribe/'
	);		
}

?>