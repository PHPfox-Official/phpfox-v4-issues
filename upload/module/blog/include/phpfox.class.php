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
 * @package  		Module_Blog
 * @version 		$Id: phpfox.class.php 2251 2010-12-27 19:03:36Z Raymond_Benc $
 */
class Module_Blog 
{	
	public static $aTables = array(
		'blog',
		'blog_category',
		'blog_category_data',
		'blog_text',
		'blog_track'		
	);
}

?>