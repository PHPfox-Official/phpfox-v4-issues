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
 * @package  		Module_Theme
 * @version 		$Id: phpfox.class.php 5345 2013-02-13 09:44:03Z Raymond_Benc $
 */
class Module_Theme 
{	
	public static $aTables = array(
		'theme',		
		'theme_css',
		'theme_style',
		'theme_style_logo',
		'theme_template',
		'theme_umenu'
	);
	
	public static $aInstallWritable = array(
		'file/css/'
	);		
}

?>