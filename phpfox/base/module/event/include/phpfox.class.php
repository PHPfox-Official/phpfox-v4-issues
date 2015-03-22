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
 * @package  		Module_Event
 * @version 		$Id: phpfox.class.php 2518 2011-04-11 19:18:17Z Raymond_Benc $
 */
class Module_Event
{
	public static $aTables = array(
		'event',
		'event_category',
		'event_category_data',
		'event_feed',
		'event_feed_comment',
		'event_invite',		
		'event_text'
	);
	
	public static $aInstallWritable = array(
		'file/pic/event/'
	);		
}

?>