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
 * @package  		Module_Poll
 * @version 		$Id: phpfox.class.php 1174 2009-10-11 13:56:13Z Raymond_Benc $
 */
class Module_Poll
{	
	public static $aTables = array(
		'poll',
		'poll_answer',
		'poll_result',
		'poll_design',
		'poll_track'
	);
	
	public static $aInstallWritable = array(
		'file/pic/poll/'
	);		
}

?>