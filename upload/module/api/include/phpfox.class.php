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
 * @version 		$Id: phpfox.class.php 2875 2011-08-23 08:42:47Z Miguel_Espinoza $
 */
class Module_Api
{
	public static $aDevelopers = array(
		array(
			'name' => 'Raymond Benc',
			'website' => 'www.phpfox.com'
		)
	);
	
	public static $aTables = array(
		'api_gateway',
		'api_gateway_log'
		//'api_key'
	);
}

?>