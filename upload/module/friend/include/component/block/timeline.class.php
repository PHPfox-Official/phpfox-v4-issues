<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Friend
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */
class Friend_Component_Block_Timeline extends Phpfox_Component
{
	public function process()
	{
		if($this->request()->get('resettimeline')) 
		{ 
		    $aUser = (PHPFOX_IS_AJAX ? Phpfox::getService('user')->get($this->request()->get('profile_user_id'), true)  : $this->getParam('aUser')); 
		} 
		else 
		{ 
		    $aUser = (PHPFOX_IS_AJAX ? Phpfox::getService('user')->get(Phpfox::getUserId(), true)  : $this->getParam('aUser')); 
		}

		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'friend.view_friend'))
		{
			return false;
		}

		if (defined('PAGE_TIME_LINE') && PAGE_TIME_LINE)
		{
			return false;
		}
		$iTotal = 6;
		
		$aRows = Phpfox::getService('friend')->get('friend.is_page = 0 AND friend.user_id = ' . $aUser['user_id'], 'friend.is_top_friend DESC, friend.ordering ASC, RAND()', 0, $iTotal, false);
		
		$iCount = count($aRows);
		
		if (!$iCount)
		{
			return false;
		}		
		
		$sFriendsLink = Phpfox::getService('user')->getLink($aUser['user_id'], $aUser['user_name'], 'friend');

		$this->template()->assign(array(
				'aFriends' => $aRows,
				'sFriendsLink' => $sFriendsLink
			)
		);		
	}
}

?>