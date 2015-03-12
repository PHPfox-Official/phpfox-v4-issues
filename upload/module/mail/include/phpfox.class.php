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
 * @package  		Module_Mail
 * @version 		$Id: phpfox.class.php 4086 2012-04-05 12:32:32Z Raymond_Benc $
 */
class Module_Mail 
{
	public static $aTables = array(
		'mail',
		'mail_folder',
		'mail_hash',
		'mail_text',
		'mail_thread',
		'mail_thread_forward',
		'mail_thread_text',
		'mail_thread_user'
	);
}

?>