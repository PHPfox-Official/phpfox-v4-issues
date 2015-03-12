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
 * @package  		Module_Comment
 * @version 		$Id: phpfox.class.php 981 2009-09-15 13:53:22Z Raymond_Benc $
 */
class Module_Comment 
{	
	public static $aTables = array(
		'comment',
		'comment_hash',
		'comment_rating',
		'comment_text'
	);
}

?>