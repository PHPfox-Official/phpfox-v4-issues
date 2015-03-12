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
 * @package  		Module_Friend
 * @version 		$Id: small.class.php 2760 2011-07-27 13:39:18Z Raymond_Benc $
 */
class Friend_Component_Block_Profile_Small extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{				
		$aUser = (PHPFOX_IS_AJAX ? Phpfox::getService('user')->get(Phpfox::getUserId(), true)  : $this->getParam('aUser'));

		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'friend.view_friend'))
		{
			return false;
		}

		$iTotal = (int) Phpfox::getComponentSetting($aUser['user_id'], 'friend.friend_display_limit_profile', Phpfox::getParam('friend.friend_display_limit'));
		
		$aRows = Phpfox::getService('friend')->get('friend.is_page = 0 AND friend.user_id = ' . $aUser['user_id'], 'friend.is_top_friend DESC, friend.ordering ASC, RAND()', 0, $iTotal, false);
		
		$iCount = count($aRows);
		
		if (!$iCount)
		{
			return false;
		}		
		
		$sFriendsLink = Phpfox::getService('user')->getLink($aUser['user_id'], $aUser['user_name'], 'friend');

		$this->template()->assign(array(
				'sHeader' => '<a href="' . $this->url()->makeUrl($aUser['user_name'], 'friend') . '">' . Phpfox::getPhrase('friend.friends') . ' (' . $aUser['total_friend'] . ')</a>',
				'aFriends' => $aRows,
				'sFriendsLink' => $sFriendsLink,
				'sBlockJsId' => 'profile_friend',
				'aFriendLists' => Phpfox::getService('friend.list')->getListForProfile($aUser['user_id'])			
			)
		);
		
		if (Phpfox::getUserParam('friend.can_remove_friends_from_profile') && $aUser['user_id'] == Phpfox::getUserId())
		{
			$this->template()->assign(array(
					'aEditBar' => array(
						'ajax_call' => 'friend.getEditBar',
						'params' => '&amp;type_id=profile'
					)				
				)
			);
			
			$this->template()->assign('sDeleteBlock', 'profile');
		}		
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_profile_small_clean')) ? eval($sPlugin) : false);
	}
	
	public function widget()
	{
		return true;
	}
}

?>