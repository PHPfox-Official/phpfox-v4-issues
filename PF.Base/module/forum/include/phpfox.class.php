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
 * @package  		Module_Forum
 * @version 		$Id: phpfox.class.php 1678 2010-07-20 11:05:43Z Raymond_Benc $
 */
class Module_Forum
{	
	public static $aTables = array(		
		'forum',
		'forum_access',
		'forum_announcement',
		'forum_moderator',
		'forum_moderator_access',
		'forum_post',
		'forum_post_text',
		'forum_subscribe',
		'forum_thank',
		'forum_thread',
		'forum_thread_track',
		'forum_track'
	);
}

?>