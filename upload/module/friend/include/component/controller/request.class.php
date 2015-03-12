<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * If a user is viewing an item that only their friends are allowed to view,
 * we send them here to let them know and see if they want to request to be friends
 * with the other user.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: request.class.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
class Friend_Component_Controller_Request extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$aUser = Phpfox::getService('user')->getUser($this->request()->get('id'));
		
		if (empty($aUser))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('friend.not_a_valid_user_to_be_friends_with'));
		}
		
		if (Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aUser['user_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('friend.you_are_already_friends_with_this_user'));
		}
		
		$this->template()->setBreadcrumb(Phpfox::getPhrase('friend.friends_request'))
			->setTitle(Phpfox::getPhrase('friend.friends_request'))
			->assign(array(
					'aUser' => $aUser
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_controller_request_clean')) ? eval($sPlugin) : false);
	}
}

?>