<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Redirect to a users profile based on the user ID# passed.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: user.class.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
class Feed_Component_Controller_User extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$sLink = Phpfox::getService('user')->getLink($this->request()->get('id'));

		if ($sLink === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('feed.invalid_user'));
		}
		
		$this->url()->send($sLink);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('feed.component_controller_user_clean')) ? eval($sPlugin) : false);
	}
}

?>