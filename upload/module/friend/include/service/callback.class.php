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
 * @version 		$Id: callback.class.php 7274 2014-04-21 13:25:12Z Fern $
 */
class Friend_Service_Callback extends Phpfox_Service 
{
	public function __construct()
	{

	}

	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('friend.friends'),
			'link' => Phpfox::getLib('url')->makeUrl('friend'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_friends.png')),
			'total' => Phpfox::getService('friend.request')->getUnseenTotal()
		);
	}
	
	// This function solves bug http://www.phpfox.com/tracker/view/14597/
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		// No count to update here. Table friend do not use total_like
		// $this->database()->updateCount('like', 'type_id = \'friend\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'friend', 'friend_id = ' . (int) $iItemId);	
		return true;
	}
	
	// This function also solves bug http://www.phpfox.com/tracker/view/14597/
	public function deleteLike($iItemId, $bDoNotSendEmail = false)
	{
		// No count to update here. Table friend do not use total_like
		// $this->database()->updateCount('like', 'type_id = \'friend\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'friend', 'friend_id = ' . (int) $iItemId);	
		return true;
	}
	
	/** This function is called by the api when an App is trying to access user information 
	 * to make sure that its allowed to do so
	 * @return array where the keys are the variables for the permission and the values the phrase
	 *		to display
	 */
	public function getApiPermissions()
	{
		$aPerms = array();
		
		$aPerms['get_friends'] = Phpfox::getPhrase('apps.can_see_who_is_on_my_friends_list');
		
		return $aPerms;
	}
	
	public function getRequestLink()
	{
		static $iTotal = null;
		
		if ($iTotal === null)
		{
			$iTotal = Phpfox::getService('friend.request')->getTotal();
		}
		
		if (!Phpfox::getParam('request.display_request_box_on_empty') && !$iTotal)
		{
			return null;
		}

		return '<li><a href="' . Phpfox::getLib('url')->makeUrl('friend.accept') . '"' . (!$iTotal ? ' onclick="alert(\'' . Phpfox::getPhrase('friend.no_friends_requests') . '\'); return false;"' : '') . '><img src="' . Phpfox::getLib('template')->getStyle('image', 'misc/user.png') . '" alt="" class="v_middle" /> ' . Phpfox::getPhrase('friend.friend_requests_total', array('total' => $iTotal)) . '</a></li>';
	}
	
	public function getActivityFeed($aFeed)
	{
		$aCore = Phpfox::getLib('request')->get('core');
		
		$bForceUser = false;
		if (defined('PHPFOX_CURRENT_USER_PROFILE') || isset($aCore['profile_user_id']))
		{
			$aUser = (array) (isset($aCore['profile_user_id']) ? Phpfox::getService('user')->get($aCore['profile_user_id']) : Phpfox::getService('user')->getUserObject(PHPFOX_CURRENT_USER_PROFILE));
			if (isset($aUser['user_id']))
			{
				if ($aUser['user_id'] == $aFeed['item_id'])
				{
					$aFeed['item_id'] = $aFeed['user_id'];
					$bForceUser = true;				
				}
			}
		}		
		
		// http://www.phpfox.com/tracker/view/14915/
		$iDestinationUserId = 0;
		if(isset($aUser['user_id']) && $aFeed['parent_user_id'] == $aUser['user_id'])
		{
			$iDestinationUserId = $aFeed['user_id'];
			// http://www.phpfox.com/tracker/view/15149/
			// http://www.phpfox.com/tracker/view/15311/
			$bForceUser = true;
		}
		else
		{
			$iDestinationUserId = $aFeed['parent_user_id'];
		}

		$aRow = $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('user'), 'u')
			->where('u.user_id = ' . (int) $iDestinationUserId) // http://www.phpfox.com/tracker/view/14915/
			->execute('getSlaveRow');
		
		// http://www.phpfox.com/tracker/view/14671/
		$iTotalLikes = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('like'))
			->where('item_id = ' . $aFeed['item_id'] . " AND type_id = 'friend'")
			->execute('getSlaveField');
			
		// http://www.phpfox.com/tracker/view/14671/
		$iIsLiked = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('like'))
			->where('item_id = ' . $aFeed['item_id'] . ' AND user_id = ' . Phpfox::getUserId())
			->execute('getSlaveField');
		
		if (!isset($aRow['user_id']))
		{
			return false;
		}
		
		$aParams = array(
			'user' => $aRow,
			'suffix' => '_50_square',
			'max_width' => '50',
			'max_height' => '50'
		);
		
		$sImage = Phpfox::getLib('image.helper')->display($aParams);			
		
		$aReturn = array(
			'feed_title' => $aRow['full_name'],
			'feed_title_sub' => $aRow['user_name'],
			'feed_info' => Phpfox::getPhrase('feed.is_now_friends_with'),
			'feed_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/friend_added.png', 'return_url' => true)),
			// http://www.phpfox.com/tracker/view/14671/
			'feed_total_like' => $iTotalLikes,
			// http://www.phpfox.com/tracker/view/14671/
			'feed_is_liked' => ((int)$iIsLiked > 0 ? true : false),
			'time_stamp' => $aFeed['time_stamp'],			
			'enable_like' => false,		
			'feed_image' => $sImage			
		);	
		
		if ($bForceUser)
		{
			$aReturn['force_user'] = $aUser;
			$aReturn['gender'] = $aUser['gender']; // bug report 13368
		}
		(($sPlugin = Phpfox_Plugin::get('friend.component_service_callback_getactivityfeed__1')) ? eval($sPlugin) : false); 
		return $aReturn;
	}

	public function getNewsFeed($aRow, $iUserid = null)
	{
		if ($sPlugin = Phpfox_Plugin::get('friend.service_callback_getnewsfeed_start')){eval($sPlugin);}
		static $aCache = array();

		if ($iUserid === null && isset($aCache[$aRow['viewer_user_id']][$aRow['owner_user_id']]))
		{
			return false;
		}

		$oUrl = Phpfox::getLib('url');

		$sOwnerImage = '';
		$sViewerImage = '';

		if ($iUserid === null)
		{
			if ($aRow['viewer_user_id'] == Phpfox::getUserId())
			{
				$aRow['text'] = Phpfox::getPhrase('friend.viewer_image_you_and_owner_image_a_href_user_link_full_name_a_are_now_friends', array(
						'viewer_image' => $sViewerImage,
						'owner_image' => $sOwnerImage,
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['owner_user_id'])),
						'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name'])
					)
				);
			}
			elseif ($aRow['owner_user_id'] == Phpfox::getUserId())
			{
				$aRow['text'] = Phpfox::getPhrase('friend.owner_image_you_and_viewer_image_a_href_friend_link_friend_a_are_now_friends', array(
						'viewer_image' => $sViewerImage,
						'owner_image' => $sOwnerImage,		
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['owner_user_id'])),
						'friend_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['viewer_user_id'])),
						'friend' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name'])
					)
				);
			}
			else
			{
				$aRow['text'] = Phpfox::getPhrase('friend.owner_image_a_href_user_link_full_name_a_and_viewer_image', array(
						'viewer_image' => $sViewerImage,
						'owner_image' => $sOwnerImage,
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['owner_user_id'])),					
						'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
						'friend_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['viewer_user_id'])),
						'friend' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name'])
					)
				);
			}
		}
		else
		{
			$aRow['text'] = Phpfox::getPhrase('friend.owner_image_a_href_user_link_full_name_a_and_viewer_image_friends', array(
					'viewer_image' => $sViewerImage,
					'owner_image' => $sOwnerImage,				
					'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['owner_user_id'])),
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'friend_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['viewer_user_id'])),				
					'friend' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name'])					
				)
			);
		}

		$aCache[$aRow['owner_user_id']][$aRow['viewer_user_id']] = true;
		
		$aRow['icon'] = 'misc/friend_added.png';

		return $aRow;
	}

	/**
	* This is the callback to display when a friend request has been accepted
	* @param array $aRow 
			owner_user_id = user who sent the friend request
			user_id = user who accepted the friend request
	*/
	public function getNotificationAccepted($aNotification)
	{
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aNotification['user_name']),
			'message' => Phpfox::getPhrase('friend.full_name_added_you_as_a_friend', array('full_name' => Phpfox::getLib('parse.output')->shorten($aNotification['full_name'],Phpfox::getParam('user.maximum_length_for_full_name')))),
			'icon' => Phpfox::getLib('template')->getStyle('image', 'misc/user.png')
		);							
	}
	
	public function getProfileLink()
	{
		return 'profile.friend';
	}

	public function getNotificationSettings()
	{
		return array('friend.new_friend_accepted' => array(
				'phrase' => Phpfox::getPhrase('friend.new_friend'),
				'default' => 1
			),
			'friend.new_friend_request' => array(
				'phrase' => Phpfox::getPhrase('friend.friend_request'),
				'default' => 1
			)
		);
	}

	public function getBlockDetailsBirthday()
	{
		return array(
			'title' => Phpfox::getPhrase('friend.birthdays')
		);
	}

	public function hideBlockbirthday()
	{
		return array(
				'table' => 'user_dashboard'
			);
	}

	public function getNotificationFeedBirthday($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('friend.user_link_wished_you_a_happy_birthday', array('user' => $aRow)),
			'link' => Phpfox::getLib('url')->makeUrl('friend.mybirthday', array('id' => $aRow['item_id']))
		);
	}

	public function getNotificationBirthday($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('friend.user_link_wished_you_a_happy_birthday', array('user' => $aRow)),
			'link' => Phpfox::getLib('url')->makeUrl('friend.mybirthday', array('id' => $aRow['item_id']))
		);
	}
	
	public function getProfileSettings()
	{
		return array(
			'friend.view_friend' => array(
				'phrase' => Phpfox::getPhrase('user.view_your_friends')
			)
		);
	}

	public function getUserCountFieldRequest()
	{
		return 'friend_request';
	}

	public function getNotificationFeedRequest($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('friend.user_link_asked_to_be_your_friend', array('user' => $aRow)),
			'link' => Phpfox::getLib('url')->makeUrl('friend.accept', array('id' => $aRow['item_id']))
		);
	}

	public function hideBlockMini($sTypeId)
	{
		return array(
			'table' => 'user_dashboard'
		);
	}

	public function hideBlockProfile($sTypeId)
	{
		return array(
			'table' => 'user_design_order'
		);
	}
	
	public function hideBlockSuggestion()
	{
		return array(
			'table' => 'user_dashboard'
		);		
	}
	
	public function getBlockDetailsSuggestion($sTypeId)
	{	
		return array(
			'title' => Phpfox::getPhrase('friend.friend_suggestions')
		);		
	}
	
	public function getBlockDetailsMutualFriend($sTypeId)
	{
		return array(
			'title' => Phpfox::getPhrase('friend.mutual_friends')
		);		
	}	

	public function getBlockDetailsMini($sTypeId)
	{
		if (!Phpfox::getUserParam('friend.can_remove_friends_from_dashboard'))
		{
			return false;
		}

		return array(
			'title' => Phpfox::getPhrase('friend.friends')
		);
	}

	public function getBlockDetailsProfileSmall()
	{
		return array(
			'title' => Phpfox::getPhrase('friend.friends')
		);
	}

	/**
	 * Action to take when user cancelled their account
	 *	Deletes: friends, friends lists and friends requests
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		$aFriends = $this->database()
			->select('friend_id')
			->from(Phpfox::getT('friend'))
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');

		foreach ($aFriends as $aFriend)
		{
			Phpfox::getService('friend.process')->delete($aFriend['friend_id']);
		}
		$aFriendLists = $this->database()
			->select('list_id')
			->where('user_id = ' . (int)$iUser)
			->from(Phpfox::getT('friend_list'))
			->execute('getSlaveRows');
		foreach ($aFriendLists as $aList)
		{
			Phpfox::getService('friend.list.process')->delete($aList['list_id']);
		}
		$this->database()->delete(Phpfox::getT('friend_request'), 'user_id = ' . (int)$iUser . ' OR friend_user_id = ' . (int)$iUser);
	}
	
	public function updateCounterList()
	{
		$aList = array();		
		
		$aList[] =	array(
			'name' => (Phpfox::isModule('photo') ? Phpfox::getPhrase('photo.update_friend_count') : 'Update friend count'),
			'id' => 'video-friend-count'
		);	

		return $aList;
	}		
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user'))
			->execute('getSlaveField');		
			
		$sExtra = '';
		if (($sPlugin = Phpfox_Plugin::get('friend.service_callback__updatecounter')))
		{
			eval($sPlugin);
		}				
			
		$aRows = $this->database()->select('u.user_id')
			->from(Phpfox::getT('user'), 'u')
			->limit($iPage, $iPageLimit, $iCnt)
			->group('u.user_id')
			->execute('getSlaveRows');
					
		foreach ($aRows as $aRow)
		{
			$iTotalFriends = $this->database()->select('COUNT(f.user_id)')
				->from(Phpfox::getT('friend'), 'f')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
				->where('f.user_id = ' . $aRow['user_id'] . ' AND f.is_page = 0') 
				->execute('getSlaveField');		

			$this->database()->update(Phpfox::getT('user_field'), array('total_friend' => $iTotalFriends), 'user_id = ' . $aRow['user_id']);			
		}							
			
		return $iCnt;
	}
	
	public function getAjaxProfileController()
	{
		return 'friend.profile';
	}
	
	public function getProfileMenu($aUser)
	{
		if (!Phpfox::getParam('profile.show_empty_tabs'))
		{		
			if (!isset($aUser['total_friend']))
			{
				return false;
			}

			if (isset($aUser['total_friend']) && (int) $aUser['total_friend'] === 0)
			{
				return false;
			}
		}
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'friend.view_friend'))
		{
			return false;	
		}		
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('profile.friends'),
			'url' => 'profile.friend',
			'total' => (int) (isset($aUser['total_friend']) ? $aUser['total_friend'] : 0),
			'icon' => 'misc/group.png'
		);		
		
		return $aMenus;
	}	

	public function tabHasItems($iUser)
	{
		$iCount = $this->database()->select('COUNT(user_id)')
				->from(Phpfox::getT('friend'))
				->where('user_id = ' . (int)$iUser)
				->execute('getSlaveField');
		return $iCount > 0;
	}

	public function getGlobalNotifications()
	{
		if (Phpfox::isMobile())
		{
			return false;
		}
		
		$iTotal = Phpfox::getService('friend.request')->getUnseenTotal();
		if ($iTotal > 0)
		{
			Phpfox::getLib('ajax')->call('$(\'#js_total_new_friend_requests\').html(\'' . (int) $iTotal . '\').css({display: \'block\'}).show();');
		}
	}	
	
	public function getApiSupportedMethods()
	{
		$aMethods = array();
		
		$aMethods[] = array(
			'call' => 'getFriends',
			'requires' => array(
				'user_id' => 'user_id'
			),
			'detail' => Phpfox::getPhrase('friend.gets_a_full_list_of_friends_for_a_specific_user'),
			'type' => 'GET',
			'response' => '{"api":{"total":1,"pages":0,"current_page":0},"output":[{"user_id":"7","user_name":"jane-doe","full_name":"Jane Doe","joined":"1314110027","country_iso":"US","gender":"Female","photo_50px":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/7_50.jpg","photo_50px_square":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/7_50_square.jpg","photo_120px":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/7_120.jpg","photo_original":"http:\/\/[DOMAIN_REPLACE]\/file\/pic\/user\/7.jpg","profile_url":"http:\/\/[DOMAIN_REPLACE]\/index.php?do=\/jane-doe\/"}]}'
		);
		
		$aMethods[] = array(
			'call' => 'isFriend',
			'requires' => array(
				'user_id' => 'user_id',
				'friend_user_id' => 'friend_user_id'
			),
			'detail' => Phpfox::getPhrase('friend.checks_if_2_users_are_friends_or_not'),
			'type' => 'GET',
			'response' => '{"api":{"total":0,"pages":0,"current_page":0},"output":{"is_friend":true}}'			
		);		
		
		return array(
			'module' => 'friend', 
			'module_info' => '', 
			'methods' => $aMethods
		);
	}		
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('friend.service_callback___call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>
