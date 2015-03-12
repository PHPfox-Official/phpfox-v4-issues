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
 * @package  		Module_User
 * @version 		$Id: lost-password.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class User_Component_Controller_Lost_Password extends Phpfox_Component 
{
	/**
	 * Process the controller
	 *
	 */
	public function process()
	{
		$this->template()->setTitle(Phpfox::getPhrase('user.lost_password'))
			->setBreadcrumb(Phpfox::getPhrase('user.lost_password'));
	}
}

?>