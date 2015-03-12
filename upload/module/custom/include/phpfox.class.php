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
 * @version 		$Id: phpfox.class.php 2616 2011-05-20 09:36:46Z Miguel_Espinoza $
 */
class Module_Custom
{	
	public static $aTables = array(
		'custom_field',
		'custom_group',
		'custom_option',
		'custom_relation',
		'custom_relation_data'
	);
}

?>