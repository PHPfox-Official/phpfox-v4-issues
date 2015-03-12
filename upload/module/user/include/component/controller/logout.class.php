<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Logout controller - www.site.com/user/logout/
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: logout.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class User_Component_Controller_Logout extends Phpfox_Component 
{
	/**
	 * Process the controller
	 *
	 */
	public function process()
	{
		if ($this->request()->get('req3') != 'done')
		{
			Phpfox::getService('user.auth')->logout();
			
			$this->url()->send('');	
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('user.logout'));
	}
}

?>