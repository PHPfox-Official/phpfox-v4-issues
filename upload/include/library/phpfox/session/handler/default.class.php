<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Default Server Handler
 * Not much done in this class since we use the default PHP 
 * $_SESSION handling.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: session.class.php 290 2009-03-08 18:07:34Z Raymond_Benc $
 */
class Phpfox_Session_Handler_Default
{	
	/**
	 * Loads session handler. All we do here is start a session.
	 *
	 */
	public function init()
	{
		if(!isset($_SESSION))
		{
			session_start();	
		}
	}
}

?>