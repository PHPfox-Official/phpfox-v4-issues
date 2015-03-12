<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Module
 * @version 		$Id: phpfox.class.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
class Module_Link
{
	public static $aDevelopers = array(
		array(
			'name' => 'Raymond_Benc',
			'website' => 'www.phpfox.com'
		)
	);
	
	public static $aTables = array(
		'link',
		'link_embed'
	);
}

?>