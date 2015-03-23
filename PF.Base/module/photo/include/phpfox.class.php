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
 * @package  		Module_Photo
 * @version 		$Id: phpfox.class.php 3076 2011-09-12 18:09:12Z Raymond_Benc $
 */
class Module_Photo
{	
	public static $aTables = array(
		'photo',
		'photo_album',
		'photo_album_info',
		'photo_battle',
		'photo_category',
		'photo_category_data',
		'photo_feed',
		'photo_info',
		'photo_rating',
		'photo_tag',
		'photo_track',
		//'photo_redirect'
	);
	
	public static $aInstallWritable = array(
		'file/pic/photo/'
	);	
}

?>