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
 * @package  		Module_Group
 * @version 		$Id: callback.class.php 3917 2012-02-20 18:21:08Z Raymond_Benc $
 */
class Group_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('group');
	}
	
	public function getAjaxCommentVar()
	{
		return 'group.can_post_comment_on_group';
	}	
	
	public function getCommentItem($iId)
	{		
		$aGroup = $this->database()->select('is_public, group_id AS comment_item_id, user_id AS comment_user_id')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if ($aGroup['is_public'] == '1')
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.this_group_is_still_pending_an_admins_approval_and_this_feature_cannot_be_used_yet'));
		}
		
		$aGroup['comment_view_id'] = 1;
			
		return $aGroup;
	}	

	public function enableSponsor($aParams)
	{
	    return Phpfox::getService('group.process')->sponsor($aParams['item_id'], 1);
	}

	public function getLink($aParams)
	{
	    $aGroup = $this->database()->select('g.title_url')
		    ->from(Phpfox::getT('group'),'g')
		    ->where('g.group_id = ' . (int)$aParams['item_id'])
		    ->execute('getSlaveRow');
	    if (empty($aGroup))
	    {
			return false;
	    }
	    return Phpfox::getLib('url')->makeUrl('group.' . $aGroup['title_url']);
	}
	
	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{
		$aGroup = $this->database()->select('m.group_id, m.view_id, m.title, m.title_url, u.full_name, u.user_id, u.user_name')
			->from($this->_sTable, 'm')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
			->where('m.group_id = ' . (int) $aVals['item_id'])
			->execute('getSlaveRow');
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::trigger(Phpfox::getPhrase('group.invalid_callback_on_the_group'));
		}					
				
		if ($aGroup['view_id'] != '2')
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('comment_group', $aVals['item_id'], $aVals['text_parsed'], $iUserId, $aGroup['user_id'], $aVals['comment_id']) : null);
		}
		
			$sLink = Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']);
			Phpfox::getLib('mail')
				->to($aGroup['user_id'])
				->subject(array('group.full_name_left_you_a_comment_on_site_title', array('full_name' => $sUserName, 'site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('group.full_name_left_you_a_comment_on_your_group_title', array('full_name' => $sUserName, 'title' => $aGroup['title'], 'link' => $sLink)))
				->fromName(Phpfox::getUserBy('full_name'))
				->notification('comment.add_new_comment')
				->send();
				
			$this->database()->updateCounter('group', 'total_comment', 'group_id', $aGroup['group_id']);
	}
	
	public function updateCommentText($aVals, $sText)
	{
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('comment_group', $aVals['item_id'], $sText, $aVals['comment_id']) : null);
	}		
	
	public function getItemName($iId, $sName)
	{
		return '<a href="' . Phpfox::getLib('url')->makeUrl('comment.view', array('id' => $iId)) . '">' . Phpfox::getPhrase('group.on_name_s_group', array('name' => $sName)) . '</a>';
	}	

	public function addEvent($iId)
	{
		if ($aGroup = Phpfox::getService('group')->getGroup($iId, true))
		{
			if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_create_event', true))
			{
				Phpfox::getLib('url')->send('group', array($aGroup['title_url'], 'event'), Phpfox::getPhrase('group.you_are_not_allowed_to_add_an_event_to_this_group'));
			}
			
			if ($aGroup['view_id'] != '0' && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);
			}			
			
			if (Phpfox::getService('group')->checkAccess($aGroup['group_id'], 'can_use_event') > 1 && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);
			}			
			
			return array(
				'host' => $aGroup['title'],
				'city' => $aGroup['city'],
				'country_iso' => $aGroup['country_iso'],
				'url_home' => 'group.' . $aGroup['title_url'],
				'module' => 'group',
				'item' => $aGroup['group_id'],
				'view_id' => $aGroup['view_id']
			);	
		}		
		
		return false;
	}
	
	public function addForum($iId)
	{
		if ($aGroup = Phpfox::getService('group')->getGroup($iId, true))
		{
			if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_use_forum', true))
			{
				if (PHPFOX_IS_AJAX)
				{
					return false;
				}
				else 
				{
					Phpfox::getLib('url')->send('group', array($aGroup['title_url'], 'forum'), Phpfox::getPhrase('group.you_are_not_allowed_to_post_within_the_forums_of_this_group'));
				}
			}			
			
			if ($aGroup['view_id'] != '0' && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);
			}
			
			if (Phpfox::getService('group')->checkAccess($aGroup['group_id'], 'can_use_forum') > 1 && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);
			}				
			
			return array(
				'module' => 'group',
				'item' => $aGroup['group_id'],
				'group_id' => $aGroup['group_id'],
				'url_home' => 'group.' . $aGroup['title_url'],
				'title' => $aGroup['title']	
			);	
		}
		
		return false;
	}
	
	public function addPhoto($iId)
	{
		if ($aGroup = Phpfox::getService('group')->getGroup($iId, true))
		{
			if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_upload_photo'))
			{
				Phpfox::getLib('url')->send('group', array($aGroup['title_url'], 'photo'), Phpfox::getPhrase('group.you_are_not_allowed_to_upload_photos_to_this_group'));
			}		
			
			if ($aGroup['view_id'] != '0' && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);				
			}
			
			if (Phpfox::getService('group')->checkAccess($aGroup['group_id'], 'can_use_photo') > 1 && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);
			}				
			
			return array(
				'module' => 'group',
				'item' => $aGroup['group_id'],
				'group_id' => $aGroup['group_id'],
				'url_home' => 'group.' . $aGroup['title_url'],
				'title' => $aGroup['title'],
				'title_url' => $aGroup['title_url']
			);	
		}
		
		return false;
	}	
	
	public function uploadVideo($iId)
	{
		static $aGroup = array();
		
		if ((isset($aGroup[$iId]) && isset($aGroup[$iId]['group_id'])) || ($aGroup[$iId] = Phpfox::getService('group')->getGroup($iId, true)))
		{
			if (!Phpfox::getService('group')->hasAccess($aGroup[$iId]['group_id'], 'can_upload_video', true))
			{
				Phpfox::getLib('url')->send('group', array($aGroup[$iId]['title_url'], 'video'), Phpfox::getPhrase('group.you_are_not_allowed_to_upload_videos_to_this_group'));
			}	

			if ($aGroup[$iId]['view_id'] != '0' && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);	
			}				
			
			if (Phpfox::getService('group')->checkAccess($aGroup[$iId]['group_id'], 'can_use_video') > 1 && !defined('PHPFOX_SKIP_FEED_ENTRY'))
			{
				define('PHPFOX_SKIP_FEED_ENTRY', true);
			}
			
			return array(
				'module' => 'group',
				'item' => $aGroup[$iId]['group_id'],
				'url_home' => 'group.' . $aGroup[$iId]['title_url']
			);	
		}		
		
		return false;
	}	
	
	public function getEventInvites($iId)
	{	
		return array(
			'module' => 'group',
			'item' => $iId
		);
	}
	
	public function getCommentNewsFeed($aRow)
	{		
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		

		if ($aRow['owner_user_id'] == $aRow['item_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('group.a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_group', array(
					'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'title_link' => $aRow['link']
				)
			);
		}
		else 
		{
			if ($aRow['item_user_id'] == Phpfox::getUserBy('user_id'))
			{				
				$aRow['text'] = Phpfox::getPhrase('group.a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_group_a', array(
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
						'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
						'title_link' => $aRow['link']	
					)
				);
			}
			else 
			{
				$aRow['text'] = Phpfox::getPhrase('group.a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link', array(
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
						'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
						'title_link' => $aRow['link'],
						'item_user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['viewer_user_id'])),
						'item_user_name' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name'])
					)
				);
			}
		}	

		$aRow['text'] .= Phpfox::getService('feed')->quote($aRow['content']);
		
		return $aRow;
	}
	
	public function getFeedRedirect($iId, $iChild = 0)
	{
		$aListing = $this->database()->select('m.group_id, m.title_url')
			->from($this->_sTable, 'm')
			->where('m.group_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aListing['group_id']))
		{
			return false;
		}

		if ($iChild > 0)
		{
			return Phpfox::getLib('url')->makeUrl('group', array($aListing['title_url'], 'comment' => $iChild, '#comment-view'));
		}		
		return Phpfox::getLib('url')->makeUrl('group', array($aListing['title_url']));
	}	
	
	public function deleteComment($iId)
	{
		$this->database()->updateCounter('group', 'total_comment', 'group_id', $iId, true);
	}	
	
	public function getNewsFeed($aRow)
	{
		if ($sPlugin = Phpfox_Plugin::get('group.service_callback_getnewsfeed_start')){eval($sPlugin);}
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		
		
		$aRow['text'] = Phpfox::getPhrase('group.a_href_user_link_owner_full_name_a_added_a_new_group_a_href_title_link_title_a', array(
				'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
				'owner_full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
				'title_link' => $aRow['link'],
				'title' => Phpfox::getService('feed')->shortenTitle($aRow['content'])
			)
		);		

		$aRow['icon'] = 'module/group.png';	
		$aRow['enable_like'] = true;
		
		return $aRow;
	}

	public function getModuleFeedRedirect($aUrl, $iId)
	{
		$aGroup = $this->database()->select('group_id, title_url')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aGroup['group_id']))
		{
			return false;
		}
		
		return Phpfox::getLib('url')->makeUrl('group', array_merge(array($aGroup['title_url']), $aUrl));
	}
	
	public function getReportRedirect($iId)
	{
		return $this->getFeedRedirect($iId);
	}
	
	public function getBrowseQueryCnt($aCallback)
	{
		$this->database()->join(Phpfox::getT('group_invite'), 'gi', 'gi.group_id = ' . (int) $aCallback['item'] . ' AND gi.member_id = 1 AND gi.invited_user_id = u.user_id');
	}
	
	public function getBrowseQuery($aCallback)
	{
		$this->database()->join(Phpfox::getT('group_invite'), 'gi', 'gi.group_id = ' . (int) $aCallback['item'] . ' AND gi.member_id = 1 AND gi.invited_user_id = u.user_id');
	}	
	
	public function getEventRedirect($iEvent)
	{
		$aEvent = $this->database()->select('v.event_id, v.title_url, g.title_url AS group_title_url')
			->from(Phpfox::getT('event'), 'v')
			->join(Phpfox::getT('group'), 'g', 'v.view_id = 0 AND v.module_id = \'group\' AND v.item_id = g.group_id')	
			->where('v.event_id = ' . (int) $iEvent)
			->execute('getSlaveRow');

		if (!isset($aEvent['event_id']))
		{
			return false;
		}
		
		return Phpfox::getLib('url')->makeUrl('group', array($aEvent['group_title_url'], 'event', 'view', $aEvent['title_url']));
	}
	
	public function getVideoRedirect($iVideo)
	{
		$aVideo = $this->database()->select('v.video_id, v.title_url, g.title_url AS group_title_url')
			->from(Phpfox::getT('video'), 'v')
			->join(Phpfox::getT('group'), 'g', 'v.view_id = 0 AND v.module_id = \'group\' AND v.item_id = g.group_id')	
			->where('v.video_id = ' . (int) $iVideo)
			->execute('getSlaveRow');
	
		if (!isset($aVideo['video_id']))
		{
			return false;
		}
		
		return Phpfox::getLib('url')->makeUrl('group', array($aVideo['group_title_url'], 'video', $aVideo['title_url']));		
	}

	public function getShoutboxData()
	{
		/*
		$aGroup = $this->database()->select('group_id')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iGroup . ' AND view_id = 0')
			->execute('getSlaveRow');
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set('This group not longer exists.');
		}
		*/
		return array(
			'table' => 'group_shoutbox'
		);
	}
	
	public function getBlocksView()
	{
		return array(
			'table' => 'group_design_order',
			'field' => 'group_id'
		);
	}
	
	public function getBlockDetailsProfile()
	{
		return array(
			'title' => Phpfox::getPhrase('group.groups')
		);
	}

	public function hideBlockProfile($sType)
	{
		return array(
			'table' => 'user_design_order'
		);		
	}

	public function getDetailOnBlockUpdate($aVals)
	{
		if (!isset($aVals['item_id']))
		{
			return false;
		}
		
		$aGroup = $this->database()->select('group_id, user_id')
			->from($this->_sTable)
			->where('group_id = ' . (int) $aVals['item_id'] . '')
			->execute('getSlaveRow');		
			
		if (!isset($aGroup['group_id']))
		{
			return false;
		}
		
		if (($aGroup['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin($aGroup['group_id']))
		{
			return array(
				'table' => 'group_design_order',
				'field' => 'group_id',
				'value' => $aGroup['group_id']
			);
		}
		
		return false;
	}	
	
	public function getDetailOnOrderUpdate($aVals)
	{		
		if (!isset($aVals['param']['item_id']))
		{
			return false;
		}		
		
		$aGroup = $this->database()->select('group_id, user_id')
			->from($this->_sTable)
			->where('group_id = ' . (int) $aVals['param']['item_id'] . '')
			->execute('getSlaveRow');		
			
		if (!isset($aGroup['group_id']))
		{
			return false;
		}
		
		if (($aGroup['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin($aGroup['group_id']))
		{
			return array(
				'table' => 'group_design_order',
				'field' => 'group_id',
				'value' => $aGroup['group_id']
			);
		}
		
		return false;	
	}	
	
	public function getDetailOnThemeUpdate($iGroup)
	{
		if (!$iGroup)
		{
			return false;
		}
		
		$aGroup = $this->database()->select('group_id, user_id')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iGroup . '')
			->execute('getSlaveRow');		
			
		if (!isset($aGroup['group_id']))
		{
			return false;
		}
		
		if (($aGroup['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin($aGroup['group_id']))
		{
			return array(
				'table' => 'group',
				'field' => 'designer_style_id',
				'action' => 'group_id',
				'value' => $aGroup['group_id']
			);
		}
		
		return false;
	}	

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		$aGroups = $this->database()
			->select('group_id')
			->from($this->_sTable)
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');
		foreach ($aGroups as $aGroup)
		{
			Phpfox::getService('group.process')->delete($aGroup['group_id']);
		}

		$aInvites = $this->database()
			->select('invite_id')
			->from(Phpfox::getT('group_invite'))
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');
			
		foreach ($aInvites as $aInvite)
		{
			Phpfox::getService('group.process')->deleteMember($aInvite['invite_id']);
		}
	}
	
	public function getUserCountFieldInvite()
	{
		return 'group_invite';
	}	

	public function getNotificationFeedInvite($aRow)
	{		
		return array(
			'message' => Phpfox::getPhrase('group.a_href_link_full_name_a_invited_you_to_a_group', array('link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']), 'full_name' => $aRow['full_name'])),
			'link' => Phpfox::getLib('url')->makeUrl('group.redirect', array('id' => $aRow['item_id']))
		);
	}
	
	public function getRequestLink()
	{
		if (!Phpfox::getParam('request.display_request_box_on_empty') && !Phpfox::getUserBy('group_invite'))
		{
			return null;
		}

		return '<li><a href="' . Phpfox::getLib('url')->makeUrl('group', array('view' => 'invite')) . '"' . (!Phpfox::getUserBy('group_invite') ? ' onclick="alert(\'' . Phpfox::getPhrase('group.no_group_invites') . '\'); return false;"' : '') . '><img src="' . Phpfox::getLib('template')->getStyle('image', 'module/group.png') . '" class="v_middle" /> ' . Phpfox::getPhrase('group.group_invites_total', array('total' => Phpfox::getUserBy('group_invite'))) . '</a></li>';
	}	
	
	public function getGroupAccess()
	{
		return array(
			Phpfox::getPhrase('group.view_members') => 'can_view_members'
		);
	}	
	
	public function getGlobalPrivacySettings()
	{
		return array(
			'group.display_on_profile' => array(
				'phrase' => Phpfox::getPhrase('group.groups')							
			)
		);
	}	
	
	public function legacyRedirect($aRequest)
	{
		if (isset($aRequest['req2']))
		{
			switch ($aRequest['req2'])
			{
				case 'browse':
					if (isset($aRequest['type']))
					{
						$aItem = Phpfox::getService('core')->getLegacyUrl(array(
								'url_field' => 'name_url',
								'table' => 'group_category',
								'field' => 'upgrade_item_id',
								'id' => $aRequest['type'],
								'user_id' => false								
							)
						);		
						
						if ($aItem !== false)
						{
							return array('group', array('category' , $aItem['name_url']));
						}
					}						
					break;
				case 'view':
					if (isset($aRequest['id']))
					{
						$aItem = Phpfox::getService('core')->getLegacyUrl(array(
								'url_field' => 'title_url',
								'table' => 'group',
								'field' => 'upgrade_item_id',
								'id' => $aRequest['id'],
								'user_id' => false								
							)
						);		
						
						if ($aItem !== false)
						{
							return array('group', array($aItem['title_url']));
						}
					}						
					break;					
			}
		}
		
		return 'group';
	}
	
	public function getDashboardLinks()
	{
		return array(
			'submit' => array(
				'phrase' => Phpfox::getPhrase('group.create_a_group'),
				'link' => 'group.add',
				'image' => 'module/group_add.png'
			),
			'edit' => array(
				'phrase' => Phpfox::getPhrase('group.manage_groups'),
				'link' => 'group.view_my',
				'image' => 'module/group_edit.png'
			)
		);
	}	

	public function reparserList()
	{
		return array(
			'name' => Phpfox::getPhrase('group.group_description_text'),
			'table' => 'group_text',
			'original' => 'description',
			'parsed' => 'description_parsed',
			'item_field' => 'group_id'
		);
	}

	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => Phpfox::getPhrase('group.groups'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('group'))
				->where('view_id = 0 AND time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}

	/**
	  * @param int $iId video_id
	  * @return array in the format:
	     * array(
	     *	'title' => 'item title',		    <-- required
	     *  'link'  => 'makeUrl()'ed link',		    <-- required
	     *  'paypal_msg' => 'message for paypal'	    <-- required
	     *  'item_id' => int			    <-- required
	     *  'user_id;   => owner's user id		    <-- required
	     *	'error' => 'phrase if item doesnt exit'	    <-- optional
	     *	'extra' => 'description'		    <-- optional
	     *	'image' => 'path to an image',		    <-- optional
	     *	'image_dir' => 'photo.url_photo|...	    <-- optional (required if image)
	     *	'server_id' => db value			    <-- optional (required if image)
	     * )
	    */
	public function getToSponsorInfo($iId)
	{
	    // check that this user has access to this group
	    $aGroup = $this->database()->select('g.user_id, g.title, g.title_url, g.group_id as item_id, g.view_id, g.user_id, g.short_description as extra, g.image_path as image, g.server_id')
		    ->from(Phpfox::getT('group'),'g')
		    ->where('g.group_id = ' . (int)$iId)
		    ->execute('getSlaveRow');

	    if ($aGroup['view_id'] != 0)
	    {
			return array('error' => Phpfox::getPhrase('group.sponsor_error_privacy'));
	    }

	    if (empty($aGroup))
	    {
			return array('error' => Phpfox::getPhrase('group.sponsor_error_not_found'));
	    }
	    
	    $aGroup['title'] = Phpfox::getPhrase('group.sponsor_title', array('sGroupTitle' => $aGroup['title']));
	    $aGroup['paypal_msg'] = Phpfox::getPhrase('group.sponsor_paypal_message', array('sGroupTitle' => $aGroup['title']));
	    $aGroup['link'] = Phpfox::getLib('url')->makeUrl('group.'.$aGroup['title_url']);
	    $aGroup['image_dir'] = 'group.url_image';
	    $aGroup['image'] = sprintf($aGroup['image'],'_200');
	    
	    return $aGroup;
	}
	
	public function updateCounterList()
	{
		$aList = array();		
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('group.group_members'),
			'id' => 'group-member'			
		);		
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('group.group_invite_count'),
			'id' => 'group-invite-count'			
		);

		return $aList;
	}		
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{
		if ($iId == 'group-invite-count')
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user'))
				->execute('getSlaveField');
				
			$aRows = $this->database()->select('u.user_id, COUNT(gi.invite_id) AS total_invites')
				->from(Phpfox::getT('user'), 'u')
				->leftJoin(Phpfox::getT('group_invite'), 'gi', 'gi.member_id = 0 AND gi.invited_user_id = u.user_id')
				->group('u.user_id')
				->limit($iPage, $iPageLimit, $iCnt)
				->execute('getSlaveRows');

			foreach ($aRows as $aRow)
			{
				$this->database()->update(Phpfox::getT('user_count'), array('group_invite' => $aRow['total_invites']), 'user_id = ' . (int) $aRow['user_id']);
			}
				
			return $iCnt;			
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('group'))
			->execute('getSlaveField');
			
		$aRows = $this->database()->select('g.group_id, COUNT(gi.invite_id) AS total_members')
			->from(Phpfox::getT('group'), 'g')
			->leftJoin(Phpfox::getT('group_invite'), 'gi', 'gi.group_id = g.group_id AND gi.member_id = 1')
			->group('g.group_id')
			->limit($iPage, $iPageLimit, $iCnt)
			->execute('getSlaveRows');
			
		foreach ($aRows as $aRow)
		{
			$this->database()->update(Phpfox::getT('group'), array('total_member' => $aRow['total_members']), 'group_id = ' . (int) $aRow['group_id']);
		}
			
		return $iCnt;
	}
	
	public function getFeedRedirectFeedLike($iId, $iChildId = 0)
	{
		return $this->getFeedRedirect($iChildId);
	}
	
	public function getNewsFeedFeedLike($aRow)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('group.a_href_user_link_full_name_a_likes_their_own_a_href_link_group_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => $aRow['link']
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('group.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_group_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'view_full_name' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name']),
					'view_user_link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name']),
					'link' => $aRow['link']			
				)
			);
		}
		
		$aRow['icon'] = 'misc/thumb_up.png';

		return $aRow;				
	}		

	public function getNotificationFeedNotifyLike($aRow)
	{		
		return array(
			'message' => Phpfox::getPhrase('group.a_href_user_link_full_name_a_likes_your_a_href_link_group_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('group', array('redirect' => $aRow['item_id']))
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('group', array('redirect' => $aRow['item_id']))			
		);				
	}	
	
	public function sendLikeEmail($iItemId)
	{
		return Phpfox::getPhrase('group.a_href_user_link_full_name_a_likes_your_a_href_link_group_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl('group', array('redirect' => $iItemId))
				)
			);
	}			
	
	public function pendingApproval()
	{
		$aPending[] = array(
			'phrase' => Phpfox::getPhrase('group.groups'),
			'value' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('group'))->where('is_public = 1')->execute('getSlaveField'),
			'link' => Phpfox::getLib('url')->makeUrl('group', array('view' => 'approval'))
		);		
		
		return $aPending;
	}	
	
	public function getRedirectComment($iId)
	{
		return $this->getFeedRedirect($iId);
	}
	
	public function getSqlTitleField()
	{
		return array(
			'table' => 'group',
			'field' => 'title'
		);
	}		
	
	public function getActivityFeed($aItem)
	{
		return false;		
	}	
	
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('group_id, title, user_id')
			->from(Phpfox::getT('group'))
			->where('group_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['group_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'group\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'group', 'group_id = ' . (int) $iItemId);	
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::permalink('group', $aRow['group_id'], $aRow['title']);
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(Phpfox::getUserBy('full_name') . " liked your group \"" . $aRow['title'] . "\"")
				->message(Phpfox::getUserBy('full_name') . " liked your group \"<a href=\"" . $sLink . "\">" . $aRow['title'] . "</a>\"\nTo view this group follow the link below:\n<a href=\"" . $sLink . "\">" . $sLink . "</a>")
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('group_like', $aRow['group_id'], $aRow['user_id']);				
		}
	}	
	
	public function deleteLike($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'group\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'group', 'group_id = ' . (int) $iItemId);	
	}	
	
	public function getNotificationLike($aNotification)
	{
		$aRow = $this->database()->select('g.group_id, g.title, g.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('group'), 'g')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = g.user_id')
			->where('g.group_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getService('notification')->getUsers($aNotification) . ' liked ' . Phpfox::getService('user')->gender($aRow['gender'], 1) . ' own group "' . Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...') . '"';	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getService('notification')->getUsers($aNotification) . ' liked your group "' . Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...') . '"';
		}
		else 
		{
			$sPhrase = Phpfox::getService('notification')->getUsers($aNotification) . ' liked <span class="drop_data_user">' . $aRow['full_name'] . '\'s</span> group "' . Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...') . '"';
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('group', $aRow['group_id'], $aRow['title']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
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
		if ($sPlugin = Phpfox_Plugin::get('group.service_callback__call'))
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