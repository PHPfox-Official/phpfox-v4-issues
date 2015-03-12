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
 * @package  		Module_Emoticon
 * @version 		$Id: phpfox.class.php 1147 2009-10-07 08:18:58Z Raymond_Benc $
 */
class Module_Emoticon 
{	
	public static $aTables = array(
		'emoticon',
		'emoticon_package'
	);
	
	public static $aInstallWritable = array(
		'file/pic/emoticon/',
		'file/pic/emoticon/default/'
	);
}

?>