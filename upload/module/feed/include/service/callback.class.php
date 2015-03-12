<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Callbacks
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: callback.class.php 8 2009-01-05 04:52:08Z Raymond_Benc $
 */
class Feed_Service_Callback extends Phpfox_Service
{
	public function  __construct()
	{
		$this->_sTable = Phpfox::getT('feed');
	}
	
	public function getSiteStatsForAdmin($iStartTime, $iEndTime)
	{
		$aCond = array();
		if ($iStartTime > 0)
		{
			$aCond[] = 'AND time_stamp >= \'' . $this->database()->escape($iStartTime) . '\'';
		}	
		if ($iEndTime > 0)
		{
			$aCond[] = 'AND time_stamp <= \'' . $this->database()->escape($iEndTime) . '\'';
		}			
		
		$iCnt = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('feed_comment'))
			->where($aCond)
			->execute('getSlaveField');
		
		return array(
			'phrase' => 'feed.comments_on_profiles',
			'total' => $iCnt
		);
	}		
	
	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('feed.news_feed'),
			'link' => Phpfox::getLib('url')->makeUrl('feed'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_activity-feed.png'))
		);
	}
	
	public function massAdmincpModuleDelete($iModule)
	{
		$this->database()->delete($this->_sTable, "type_id = '" . $this->database()->escape($iModule) . "'");
	}	
	
	public function getCommentNewsFeed($aRow)
	{
		return false;
		
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('feed.a_href_owner_link_owner_full_name_a_commented_on_their_own_a_href_link_feed_a', array(
					'owner_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'owner_full_name' => $this->preParse()->clean($aRow['owner_full_name']),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id'], '#feed'))			
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('feed.owner_full_name_commented_on_full_names_feed', array(
					'owner_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'owner_full_name' => $this->preParse()->clean($aRow['owner_full_name']),
					'viewer_link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name']),
					'viewer_full_name' => $this->preParse()->clean($aRow['viewer_full_name']),
					'link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name'], array('feed' => $aRow['item_id'], '#feed'))
				)
			);
		}
		
		$aRow['text'] .= Phpfox::getService('feed')->quote($aRow['content']);
		
		return $aRow;
	}
	
	public function getItemName($iId, $sName)
	{
		return '<a href="' . Phpfox::getLib('url')->makeUrl('comment.view', array('id' => $iId)) . '">' . Phpfox::getPhrase('feed.on_name_s_feed', array('name' => $sName)) . '</a>';
	}	
	
	public function deleteComment($iId)
	{
		
	}
	
	public function hideBlockDisplay($sTypeId)
	{		
		return array(
			'table' => ($sTypeId == 'profile' ? 'user_design_order' : 'user_dashboard')
		);
	}
	
	public function getBlockDetailsDisplay($sTypeId)
	{
		switch ($sTypeId)
		{
			case 'dashboard':
				if (!Phpfox::getUserParam('feed.can_remove_feeds_from_dashboard'))
				{
					return false;
				}
				break;
			case 'profile':	
				if (!Phpfox::getUserParam('feed.can_remove_feeds_from_profile'))
				{
					return false;
				}
				break;
			default:
				
				break;
		}
		
		return array(
			'title' => Phpfox::getPhrase('feed.updates')
		);
	}
	
	public function onDeleteUser($iUser)
	{
	    $this->database()->delete($this->_sTable, 'user_id = ' . (int)$iUser);
	    $this->database()->delete($this->_sTable, 'parent_user_id = ' . (int)$iUser);
	    $this->database()->delete(Phpfox::getT('feed_comment'), 'parent_user_id = ' . (int)$iUser); 
	}

	public function getProfileSettings()
	{
		$aOut = array(			
			'feed.view_wall' => array(
				'phrase' => Phpfox::getPhrase('user.view_your_wall'),
				'default' => '0'				
			)
		);			
		
		// Check if all user groups have "profile.can_post_comment_on_profile" disabled
		$aGroups = Phpfox::getService('user.group')->get();
		
		$bShowShareOnWall = false;
		$oUser = Phpfox::getService('user.group.setting');
		foreach ($aGroups as $aGroup)
		{
			if ($oUser->getGroupParam($aGroup['user_group_id'], 'profile.can_post_comment_on_profile'))
			{
				$bShowShareOnWall = true;
				break;
			}
		}
				
		if ($bShowShareOnWall)
		{
			$aOut['feed.share_on_wall'] = array(
				'phrase' => Phpfox::getPhrase('user.share_on_your_wall'),
				'default' => '1',
				'anyone' => false
			);
		}
		
		return $aOut;
	}

	public function getReportRedirect($iId)
	{
		$aFeed = $this->database()->select('f.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('feed_comment'), 'f')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = f.parent_user_id')
			->where('f.feed_comment_id = ' . (int) $iId)
			->execute('getRow');

		if (!isset($aFeed['feed_comment_id']))
		{
			return false;
		}
		
		return Phpfox::getLib('url')->makeUrl($aFeed['user_name'], array('comment-id' => $aFeed['feed_comment_id']));		
	}	
	
	public function getReportRedirectComment($iId)
	{
		$aFeed = $this->database()->select('f.feed_id, ' . Phpfox::getUserField())
			->from(Phpfox::getT('feed_comment'), 'c')
			->join(Phpfox::getT('feed'), 'f', 'type_id = \'feed_comment\' && f.item_id = c.feed_comment_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = f.user_id')
			->where('c.feed_comment_id = ' . (int) $iId)
			->execute('getRow');	

		if (empty($aFeed))
		{
			return false;
		}
		
		return Phpfox::getLib('url')->makeUrl($aFeed['user_name'], array('feed' => $aFeed['feed_id'], '#feed'));
	}
	
	public function getRedirectComment($iId)
	{		
		return $this->getReportRedirect($iId);	
	}
	
	public function pendingApproval()
	{
		return array(
			'phrase' => Phpfox::getPhrase('feed.profile_comments'),
			// 'value' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('feed'))->where('view_id = 1')->execute('getSlaveField'),
			'value' => 0,
			'link' => Phpfox::getLib('url')->makeUrl('admincp.feed', array('view' => 'approval'))
		);
	}

	public function getActivityFeedEgift($aItem)
	{	
		/* Check if this egift is free or paid */
		// `phpfox_egift_invoice`.`birthday_id` = `phpfox_feed`.`feed_id`
		$this->database()->select('e.file_path, g.price, g.status, fc.content, fc.feed_comment_id, fc.total_comment, f.time_stamp, fc.total_like, ' . Phpfox::getUserField('u', 'parent_'))
				->from(Phpfox::getT('egift_invoice'), 'g')
				->join(Phpfox::getT('feed'), 'f', 'f.feed_id = g.birthday_id')
				->join(Phpfox::getT('egift'), 'e', 'e.egift_id = g.egift_id')
				->leftjoin(Phpfox::getT('feed_comment'), 'fc', 'fc.feed_comment_id = ' . $aItem['item_id'])
				->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = fc.parent_user_id')
				// ->leftjoin(Phpfox::getT('like'),'l', 'l.item_id = f.feed_id AND l.type_id = "feed_egift"')
				->where('g.birthday_id = ' . (int)$aItem['feed_id']);
				
		if(Phpfox::isModule('like'))
		{
			$this->database()->select(', l.like_id as is_liked')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_egift\' AND l.item_id = fc.feed_comment_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aInvoice = $this->database()->execute('getSlaveRow');

		if ($aInvoice['price'] > 0 && $aInvoice['status'] != 'completed')
		{
			return false;
		}
		
		$aReturn = array(
			'no_share' => true,
			'feed_status' => $aInvoice['content'],
			'feed_link' => '',
			'total_comment' => $aInvoice['total_comment'],
			'feed_total_like' => $aInvoice['total_like'],
			'feed_is_liked' => (isset($aInvoice['is_liked']) ? $aInvoice['is_liked'] : false),
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/comment.png', 'return_url' => true)),
			'time_stamp' => $aInvoice['time_stamp'],			
			'enable_like' => true,			
			'comment_type_id' => 'feed',
			'like_type_id' => 'feed_egift'	
		);
		
		if (!empty($aInvoice['file_path']))
		{
			$aReturn['feed_image'] = Phpfox::getLib('image.helper')->display(array(
					'server_id' => 0,
					'path' => 'egift.url_egift',
					'file' => $aInvoice['file_path'],
					'suffix' => '_120',
					'max_width' => 120,
					'max_height' => 120,
					'thickbox' => true
				)
			);			
		}		
		
		if (!empty($aInvoice['parent_user_name']) && !defined('PHPFOX_IS_USER_PROFILE') && empty($_POST))
		{
			$aReturn['parent_user'] = Phpfox::getService('user')->getUserFields(true, $aInvoice, 'parent_');
		}		
		
		if (!PHPFOX_IS_AJAX && defined('PHPFOX_IS_USER_PROFILE') && !empty($aInvoice['parent_user_name']) && $aInvoice['parent_user_id'] != Phpfox::getService('profile')->getProfileUserId())
		{
			if (empty($_POST))
			{
				$aReturn['parent_user'] = Phpfox::getService('user')->getUserFields(true, $aInvoice, 'parent_');
			}
			/*			
			$sLink = Phpfox::getLib('url')->makeUrl($aInvoice['parent_user_name'], array('comment-id' => $aInvoice['feed_comment_id']));
			$aReturn['feed_mini'] = true;
			$aReturn['feed_mini_content'] = Phpfox::getPhrase('feed.content_on_a_href_link_parent_full_name_a_s_a_href_wall_link_wall_a', array('content' => strip_tags($aInvoice['content']), 'link' => Phpfox::getLib('url')->makeUrl($aInvoice['parent_user_name']), 'parent_full_name' => $aInvoice['parent_full_name'], 'wall_link' => $sLink));
			
			unset($aReturn['feed_status']);
			 * 
			 */			
		}		
		
		return $aReturn;
	}
	
	public function getActivityFeedComment($aItem)
	{
		/*
		if (!empty($aItem['feed_reference']))
		{
			$aItem['item_id'] = $aItem['feed_reference'];
			return Phpfox::getService('user.callback')->getActivityFeedStatus($aItem);
		}	
		*/
		
		// http://www.phpfox.com/tracker/view/15336/
		if($aItem['user_id'] == Phpfox::getService('profile')->getProfileUserId())
		{
			return false;
		}
		
		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_comment\' AND l.item_id = fc.feed_comment_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aRow = $this->database()->select('fc.*, ' . Phpfox::getUserField('u', 'parent_'))
			->from(Phpfox::getT('feed_comment'), 'fc')			
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = fc.parent_user_id')
			->where('fc.feed_comment_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
	
		$sLink = Phpfox::getLib('url')->makeUrl($aRow['parent_user_name'], array('comment-id' => $aRow['feed_comment_id']));
		
		$aReturn = array(
			'no_share' => true,
			'feed_status' => $aRow['content'],
			'feed_link' => $sLink,
			'total_comment' => $aRow['total_comment'],
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => (isset($aRow['is_liked']) ? $aRow['is_liked'] : false),
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'misc/comment.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => true,			
			'comment_type_id' => 'feed',
			'like_type_id' => 'feed_comment'			
		);
		
		if (!empty($aRow['parent_user_name']) && !defined('PHPFOX_IS_USER_PROFILE') && empty($_POST))
		{
			$aReturn['parent_user'] = Phpfox::getService('user')->getUserFields(true, $aRow, 'parent_');
		}		
				
		if (!PHPFOX_IS_AJAX && defined('PHPFOX_IS_USER_PROFILE') && !empty($aRow['parent_user_name']) && $aRow['parent_user_id'] != Phpfox::getService('profile')->getProfileUserId())
		{			
			$aReturn['feed_info'] = Phpfox::getPhrase('feed.posted_on_parent_full_names_wall', array('parent_user_name' => Phpfox::getLib('url')->makeUrl($aRow['parent_user_name']), 'parent_full_name' => $aRow['parent_full_name']));
			$aReturn['feed_status'] = $aRow['content'];
			// http://www.phpfox.com/tracker/view/15025/
			$aReturn['parent_user_id'] = $aRow['user_id'];
						
			/*
			if (Phpfox::getService('profile')->timeline())
			{
				$aReturn['feed_info'] = Phpfox::getPhrase('feed.posted_on_parent_full_names_wall', array('parent_user_name' => Phpfox::getLib('url')->makeUrl($aRow['parent_user_name']), 'parent_full_name' => $aRow['parent_full_name']));
				$aReturn['feed_status'] = $aRow['content'];
			}
			else
			{
				if (empty($_POST))
				{
					$aReturn['parent_user'] = Phpfox::getService('user')->getUserFields(true, $aRow, 'parent_');
				}
				
				$aRow['content'] = strip_tags($aRow['content']);
				$aRow['content'] = Phpfox::getLib('parse.output')->replaceUserTag($aRow['content']);				
				
				$aReturn['feed_mini'] = true;		
				$aReturn['feed_mini_content'] = Phpfox::getPhrase('feed.content_on_a_href_link_parent_full_name_a_s_a_href_wall_link_wall_a', array('content' => $aRow['content'], 'link' => Phpfox::getLib('url')->makeUrl($aRow['parent_user_name']), 'parent_full_name' => $aRow['parent_full_name'], 'wall_link' => $sLink));	
				unset($aReturn['feed_status']);
							
			}
			*/
		}
		
		return $aReturn;		
	}
	
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		$this->database()->updateCount('like', 'type_id = \'feed_comment\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'feed_comment', 'feed_comment_id = ' . (int) $iItemId);	
	}	
	
	public function addLikeEgift($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'feed_egift\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'feed_comment', 'feed_comment_id = ' . (int) $iItemId);
	}
	
	public function deleteLikeComment($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'feed_comment\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'feed_comment', 'feed_comment_id = ' . (int) $iItemId);	
	}	
	
	public function getAjaxCommentVar()
	{
		return null;
	}	
	
	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{		
		$aRow = $this->database()->select('fc.feed_comment_id, u.full_name, u.user_id, u.gender, u.user_name, u2.user_name AS parent_user_name, u2.full_name AS parent_full_name')
			->from(Phpfox::getT('feed_comment'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = fc.parent_user_id')
			->where('fc.feed_comment_id = ' . (int) $aVals['item_id'])
			->execute('getSlaveRow');
			
		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		if (empty($aVals['parent_id']))
		{
			$this->database()->updateCounter('feed_comment', 'total_comment', 'feed_comment_id', $aRow['feed_comment_id']);		
		}
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->makeUrl($aRow['parent_user_name'], array('comment-id' => $aRow['feed_comment_id']));
		
		Phpfox::getService('comment.process')->notify(array(
				'user_id' => $aRow['user_id'],
				'item_id' => $aRow['feed_comment_id'],
				'owner_subject' => Phpfox::getPhrase('feed.full_name_commented_on_one_of_your_wall_comments', array('full_name' => Phpfox::getUserBy('full_name'))),
				'owner_message' => Phpfox::getPhrase('feed.full_name_commented_on_one_of_your_wall_comments_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink)),
				'owner_notification' => 'comment.add_new_comment',
				'notify_id' => 'comment_feed',
				'mass_id' => 'feed',
				'mass_subject' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('feed.full_name_commented_on_one_of_gender_wall_comments', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1))) : Phpfox::getPhrase('feed.full_name_commented_on_one_of_row_full_name_s_wall_comments', array('full_name' => Phpfox::getUserBy('full_name'), 'row_full_name' => $aRow['full_name']))),
				'mass_message' => (Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getPhrase('feed.full_name_commented_on_one_of_gender_wall_comments_message', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'link' => $sLink)) : Phpfox::getPhrase('feed.full_name_commented_on_one_of_row_full_name_s_wall_comments_message', array('full_name' => Phpfox::getUserBy('full_name'), 'row_full_name' => $aRow['full_name'], 'link' => $sLink)))
			)
		);		
	}		
	
	public function getCommentItem($iId)
	{
		$aRow = $this->database()->select('feed_comment_id AS comment_item_id, privacy_comment, user_id AS comment_user_id')
			->from(Phpfox::getT('feed_comment'))
			->where('feed_comment_id = ' . (int) $iId)
			->execute('getSlaveRow');		
			
		$aRow['comment_view_id'] = '0';
		
		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
			
			unset($aRow['comment_item_id']);
		}
			
		return $aRow;
	}	
	
	public function getCommentNotificationFeed($aNotification)
	{
		$aRow = $this->database()->select('fc.feed_comment_id, u.user_id, fc.content, fc.parent_user_id, u.gender, u.user_name, u.full_name, u2.user_name AS parent_user_name, u2.full_name AS parent_full_name')	
			->from(Phpfox::getT('feed_comment'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = fc.parent_user_id')
			->where('fc.feed_comment_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('feed.users_commented_on_one_of_gender_wall_comments', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1)));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$aMentions = Phpfox::getService('user.process')->getIdFromMentions($aRow['content']);			
			$bUseDefault = true;
			foreach ($aMentions as $iKey => $iUser)
			{
				if ($iUser == $aRow['parent_user_id'])
				{
					$bUseDefault = false;
				}
			}
			if ($bUseDefault)
			{
				$sPhrase = Phpfox::getPhrase('feed.users_commented_on_one_of_your_wall_comments', array('users' => $sUsers));
			}
			else
			{
				$sPhrase = Phpfox::getPhrase('feed.parent_user_name_commented_on_one_of_your_status_updates', array('parent_user_name' => $aRow['parent_full_name']));
			}
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('feed.users_commented_on_one_of_span_class_drop_data_user_row_full_name_s_span_wall_comments', array('users' => $sUsers, 'row_full_name' => $aRow['full_name']));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['parent_user_name'], array('comment-id' => $aRow['feed_comment_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}	
	
	public function getNotificationComment_Link($aNotification)
	{
		$aRow = $this->database()->select('fc.link_id, u.user_id, u.gender, u.user_name, u.full_name')
			->from(Phpfox::getT('link'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.parent_user_id')
			->where('fc.link_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');	
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);		
		
		$sPhrase = '';		
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('feed.users_commented_on_gender_wall', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1)));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('feed.users_commented_on_your_wall', array('users' => $sUsers));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('feed.users_commented_on_one_span_class_drop_data_user_row_full_name_span_wall', array('users' => $sUsers, 'row_full_name' => $aRow['full_name']));
		}			
		
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('plink-id' => $aRow['link_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);		
	}
	
	public function getNotificationComment_Profile($aNotification)
	{
		$aRow = $this->database()->select('fc.feed_comment_id, u.user_id, u.gender, u.user_name, u.full_name')
			->from(Phpfox::getT('feed_comment'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.parent_user_id')
			->where('fc.feed_comment_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
		
		$sType = 'comment-id';
		if (empty($aRow))
		{
			$aRow = $this->database()->select('u.user_id, u.gender, u.user_name, u.full_name')
				->from(Phpfox::getT('user_status'), 'fc')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.user_id')
				->where('fc.status_id = ' . (int) $aNotification['item_id'])
				->execute('getSlaveRow');
			
			$aRow['feed_comment_id'] = (int) $aNotification['item_id'];
			$sType='status-id';
			$bWasChanged = true;
		}
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		if (empty($aRow) || !isset($aRow['user_id']))
        {
            return false;
        }
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			if (isset($bWasChanged))
			{
				$sPhrase = Phpfox::getPhrase('user.user_name_tagged_you_in_a_status_update', array('user_name' => $aNotification['full_name']));
			}
			else
			{
				$sPhrase = Phpfox::getPhrase('feed.users_commented_on_gender_wall', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1)));	
			}
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('feed.users_commented_on_your_wall', array('users' => $sUsers));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('feed.users_commented_on_one_span_class_drop_data_user_row_full_name_span_wall', array('users' => $sUsers, 'row_full_name' => $aRow['full_name']));
		}			
		
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array($sType => $aRow['feed_comment_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}
	
	public function addLikeComment($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('fc.feed_comment_id, fc.content, fc.user_id, u2.user_name, u2.full_name')
			->from(Phpfox::getT('feed_comment'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = fc.parent_user_id')
			->where('fc.feed_comment_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['feed_comment_id']))
		{
			return false;
		}		
		
		$this->database()->updateCount('like', 'type_id = \'feed_comment\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'feed_comment', 'feed_comment_id = ' . (int) $iItemId);		
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('comment-id' => $aRow['feed_comment_id']));
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('user.full_name_liked_a_comment_you_posted_on_row_full_name_s_wall', array('full_name' => Phpfox::getUserBy('full_name'), 'row_full_name' => $aRow['full_name'])))
				->message(array('user.full_name_liked_your_comment_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'content' => Phpfox::getLib('parse.output')->shorten($aRow['content'], 50, '...'), 'row_full_name' => $aRow['full_name'])))
				->notification('like.new_like')
				->send();				
					
			Phpfox::getService('notification.process')->add('feed_comment_like', $aRow['feed_comment_id'], $aRow['user_id']);
		}		
	}	
	
	public function addLikeMini($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('c.comment_id, c.user_id, ct.text_parsed AS text')
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->where('c.comment_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['comment_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'feed_mini\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'comment', 'comment_id = ' . (int) $iItemId);

		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::getLib('url')->makeUrl('comment.view', $iItemId);
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('user.full_name_liked_one_of_your_comments', array('full_name' => Phpfox::getUserBy('full_name'))))
				->message(array('user.full_name_liked_your_comment_message_mini', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'content' => Phpfox::getLib('parse.output')->shorten($aRow['text'], 50, '...'))))
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('feed_mini_like', $aRow['comment_id'], $aRow['user_id']);
		}		
	}
	
	public function deleteLikeMini($iItemId, $bDoNotSendEmail = false)
	{
		$this->database()->updateCount('like', 'type_id = \'feed_mini\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'comment', 'comment_id = ' . (int) $iItemId);	
	}	
	
	public function getNotificationMini_Like($aNotification)
	{
		$aRow = $this->database()->select('c.comment_id, c.user_id, ct.text_parsed AS text')
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->where('c.comment_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');

		$sPhrase = Phpfox::getPhrase('feed.users_liked_your_comment_text_that_you_posted', array('users' => Phpfox::getService('notification')->getUsers($aNotification) , 'text' => Phpfox::getLib('parse.output')->shorten($aRow['text'], Phpfox::getParam('notification.total_notification_title_length'), '...')));	
			
		return array(
			'link' => Phpfox::getLib('url')->makeUrl('comment.view', $aRow['comment_id']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);				
	}
	
	public function getNotificationComment_Like($aNotification)
	{
		$aRow = $this->database()->select('fc.feed_comment_id, fc.content, fc.user_id, u.gender, u.user_name, u.full_name, u2.user_name AS parent_user_name, u2.full_name AS parent_full_name, u2.gender AS parent_gender')	
			->from(Phpfox::getT('feed_comment'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = fc.parent_user_id')
			->where('fc.feed_comment_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sContent = Phpfox::getLib('parse.output')->shorten($aRow['content'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('feed.users_liked_gender_own_comment_content', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'content' => $sContent));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('feed.users_liked_your_comment_content_that_you_posted_on_span_class_drop_data_user_parent_full_name_s_span_wall', array('users' => $sUsers, 'content' => $sContent, 'parent_full_name' => $aRow['parent_full_name']));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('feed.users_liked_span_class_drop_data_user_full_name_s_span_comment_content', array('users' => $sUsers, 'full_name' => $aRow['full_name'], 'content' => $sContent));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->makeUrl($aRow['parent_user_name'], array('comment-id' => $aRow['feed_comment_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}
	
	public function getParentItemCommentUrl($aComment)
	{
		$aFeedComment = $this->database()->select('u.user_name')
			->from(Phpfox::getT('feed_comment'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.parent_user_id')
			->where('fc.feed_comment_id = ' . (int) $aComment['item_id'])
			->execute('getSlaveRow');
			
		return Phpfox::getLib('url')->makeUrl($aFeedComment['user_name'], array('comment-id' => $aComment['item_id']));
	}

	public function exportModule($sProductId, $sModule = null)
	{
		$aSql = array();
		$aSql[] = "product_id = '" . $sProductId . "'";
		if ($sModule !== null)
		{
			$aSql[] = "AND module_id = '" . $sModule . "'";
		} 
		
		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('feed_share'))
			->where($aSql)
			->execute('getRows');
			
		if (!count($aRows))
		{
			return false;
		}
			
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('feed_share');

		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addTag('share', '', array(					
					'module_id' => $aRow['module_id'],
					'title' => $aRow['title'],
					'description' => $aRow['description'],
					'block_name' => $aRow['block_name'],
					'no_input' => $aRow['no_input'],
					'is_frame' => $aRow['is_frame'],
					'ajax_request' => $aRow['ajax_request'],
					'no_profile' => $aRow['no_profile'],
					'icon' => $aRow['icon'],
					'ordering' => $aRow['ordering']
				)
			);
		}
		$oXmlBuilder->closeGroup();

		return true;	
	}
	
	public function installModule($sProduct, $sModule, $aModule)
	{		
		if (isset($aModule['feed_share']))
		{
			// get all the existing feed_share
			$aShares = $this->database()->select('*')
				->from(Phpfox::getT('feed_share'))
				->where('module_id = "' . Phpfox::getLib('parse.input')->clean($sModule) .'" AND product_id = "' . Phpfox::getLib('parse.input')->clean($sProduct) .'"')
				->execute('getSlaveRows');
			$aRows = (isset($aModule['feed_share']['share'][1]) ? $aModule['feed_share']['share'] : array($aModule['feed_share']['share']));
			foreach ($aRows as $aRow)
			{
				foreach($aShares as $aShare)
				{
					if ($aShare['title'] == $aRow['title'])
					{
						break 2;
					}
				}
				$this->database()->insert(Phpfox::getT('feed_share'), array(
						'product_id' => $sProduct,
						'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),						
						'title' => $aRow['title'],
						'description' => $aRow['description'],
						'block_name' => $aRow['block_name'],
						'no_input' => (int) $aRow['no_input'],
						'is_frame' => (int) $aRow['is_frame'],
						'ajax_request' => (empty($aRow['ajax_request']) ? null : $aRow['ajax_request']),
						'no_profile' => (int) $aRow['no_profile'],
						'icon' => (empty($aRow['icon']) ? null : $aRow['icon']),
						'ordering' => (int) $aRow['ordering']
					)
				);
			}
		}
	}	
	
	public function updateCounterList()
	{
		$aList = array();		
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('feed.find_missing_share_buttons'),
			'id' => 'missing-share'
		);		
		
		$aList[] = array(
			'name' => Phpfox::getPhrase('feed.update_feed_time_stamps'),
			'id' => 'update-feed'
		);		
		
		$aList[] = array(
			'name' => Phpfox::getPhrase('feed.update_feed_time_stamps_for_pages'),
			'id' => 'update-pages-feed'
		);	

		$aList[] = array(
			'name' => Phpfox::getPhrase('feed.update_feed_time_stamps_for_events'),
			'id' => 'update-event-feed'
		);
		
		return $aList;
	}	
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{	
		if (!empty($iId))
		{
			$sPrefix = '';
			if ($iId == 'update-pages-feed')
			{
				$sPrefix = 'pages_';
			}
			elseif ($iId == 'update-event-feed')
			{
				$sPrefix = 'event_';
			}			
			//  == 'update-pages-feed'

			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT($sPrefix . 'feed'))
				->where('time_update = 0')
				->execute('getSlaveField');
			
			$aRows = $this->database()->select('feed_id, time_stamp')
				->from(Phpfox::getT($sPrefix . 'feed'))
				->where('time_update = 0')				
				->limit($iPage, $iPageLimit, $iCnt)
				->execute('getSlaveRows');	

			foreach ($aRows as $aRow)
			{
				$this->database()->update(Phpfox::getT('feed'), array('time_update' => $aRow['time_stamp']), 'feed_id = ' . (int) $aRow['feed_id']);
			}
			
			return $iCnt;
		}
		else
		{
			$aModules = Phpfox::getService('core')->getModulePager('feed_share', 0, 200);
			
			foreach ($aModules as $sModule => $aData)
			{
				$iCheck = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('feed_share'))
					->where('module_id = \'' . $this->database()->escape($aData['share']['module_id']) . '\' AND title = \'' . $this->database()->escape($aData['share']['title']) . '\'')
					->execute('getSlaveField');
				
				if (!$iCheck)
				{
					$aRow = $aData['share'];
					$this->database()->insert(Phpfox::getT('feed_share'), array(
							'product_id' => 'phpfox',
							'module_id' => $aData['share']['module_id'],						
							'title' => $aRow['title'],
							'description' => $aRow['description'],
							'block_name' => $aRow['block_name'],
							'no_input' => (int) $aRow['no_input'],
							'is_frame' => (int) $aRow['is_frame'],
							'ajax_request' => (empty($aRow['ajax_request']) ? null : $aRow['ajax_request']),
							'no_profile' => (int) $aRow['no_profile'],
							'icon' => (empty($aRow['icon']) ? null : $aRow['icon']),
							'ordering' => (int) $aRow['ordering']
						)
					);				
				}
			}
		}
		
		return 0;
	}	

	public function getActions()
	{
	    return array(
		'dislike' => array(
			'enabled' => true,
			'action_type_id' => 2, // 2 = dislike
			'phrase' => Phpfox::getPhrase('like.dislike'),
			'phrase_in_past_tense' => 'disliked',
			'item_phrase' => 'comment',
			'item_type_id' => 'feed', // used to differentiate between photo albums and photos for example.
			'table' => 'feed_comment',
			'column_update' => 'total_dislike',
			'column_find' => 'feed_comment_id',
			'where_to_show' => array('', 'photo')			
			)
		);
	}
	
	/**
	 * Used from the Ad module when sponsoring a post in the feed.
	 * Complies with the requirement in the ad.sponsor controller for $aItem
	 * @param $aParams array(sModule => <string>, iItemId
	 * Condition: A user may only sponsor posts that he added.
	 * @return array
	 * 
	 * /* aItem must be in the format:
		     * array(
		     *	'title' => 'item title',		    <-- required	     
		     *  'link'  => 'makeUrl()'ed link',		    <-- required
		     *  'paypal_msg' => 'message for paypal'	    <-- required
		     *  'item_id' => int			    <-- required
		     *  'user_id'   => owner's user id		    <-- required
		     *	'error' => 'phrase if item doesnt exit'	    <-- optional
		     *	'extra' => 'description'		    <-- optional
		     *	'image' => 'path to an image',		    <-- optional
		     *  'image_dir' => 'photo.url_photo|...	    <-- optional (required if image)
		     * )
		    */
	 
	public function getSponsorPostInfo($aParams)
	{
		// We are sponsoring feeds now, not the actual item.
		// Get the feed to check if it has already been sponsored
		$aFeed = $this->database()->select('f.*, fs.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('feed'), 'f')
			->leftjoin(Phpfox::getT('feed_sponsor'), 'fs', 'fs.feed_id = f.feed_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = f.user_id')
			->where('f.type_id = "' . $aParams['sModule'] . '" AND f.item_id = ' . (int)$aParams['iItemId'] . ' AND f.user_id = ' . Phpfox::getUserId())
			->execute('getSlaveRow');
				
		$aInfo = array(
			'title' => 'Sponsoring ' . $aParams['sModule'] . ' #' . $aParams['iItemId'],
			'link' => Phpfox::getLib('url')->makeUrl('photo',array($aParams['iItemId'])),
			'paypal_msg' => 'Purchasing a sponsored feed ',
			'item_id' => $aParams['iItemId'],
			'user_id' => Phpfox::getUserId()
		);
		
		if (Phpfox::isModule($aParams['sModule']) && Phpfox::hasCallback($aParams['sModule'], 'getToSponsorInfo'))
		{
			$aCalled = Phpfox::callback($aParams['sModule'] . '.getToSponsorInfo', $aParams['iItemId']);
			$aInfo = array_merge($aInfo, $aCalled);
		}
		
		return $aInfo;
	}
	
	/**
	  * @param int $iId feed_id
	  * @return array in the format:
	     * array(
	     *	'sModule' => 'module_id',		    <-- required
	     *  'iItemId'  => 'item_id',		    <-- required
	     * )
	    */
	public function getToSponsorInfo($iId)
	{
		$aFeed = $this->database()->select('f.type_id AS sModule, f.item_id AS iItemId')
		    ->from($this->_sTable, 'f')
		    ->where('f.feed_id = ' . (int) $iId)
		    ->execute('getSlaveRow');
		    
		if (empty($aFeed))
	    {
			return false;
	    }

	    return $this->getSponsorPostInfo($aFeed);
	}
	
	public function getLink($aParams)
	{
	    $aFeed = $this->database()->select('f.type_id as section, f.item_id')
			->from($this->_sTable, 'f')
			->where('f.feed_id = ' . (int)$aParams['item_id'])
		    ->execute('getSlaveRow');
		    
	    if (empty($aFeed))
	    {
			return false;
	    }
	    
	    if (Phpfox::isModule($aFeed['section']) && Phpfox::hasCallback($aFeed['section'], 'getLink'))
		{
			return Phpfox::callback($aFeed['section'] . '.getLink', $aFeed);
		}
		
		return false;
	}
	
	public function enableSponsor($aParams)
	{
		$aFeed = $this->database()->select('f.type_id as section, f.item_id')
			->from($this->_sTable, 'f')
			->where('f.feed_id = ' . (int)$aParams['item_id'])
		    ->execute('getSlaveRow');
		    
	    if (empty($aFeed))
	    {
			return false;
	    }

	    if (Phpfox::isModule($aFeed['section']) && Phpfox::hasCallback($aFeed['section'], 'enableSponsor'))
		{
			return Phpfox::callback($aFeed['section'] . '.enableSponsor', $aFeed);
		}
		
		return false;
	}
}

?>
