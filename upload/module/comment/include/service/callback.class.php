<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Comment Callbacks
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Comment
 * @version 		$Id: callback.class.php 5425 2013-02-25 14:16:35Z Raymond_Benc $
 */
class Comment_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 *
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('comment');
	}	
	
	public function getSiteStatsForAdmin($iStartTime, $iEndTime)
	{
		$aCond = array();
		$aCond[] = 'view_id = 0';
		if ($iStartTime > 0)
		{
			$aCond[] = 'AND time_stamp >= \'' . $this->database()->escape($iStartTime) . '\'';
		}	
		if ($iEndTime > 0)
		{
			$aCond[] = 'AND time_stamp <= \'' . $this->database()->escape($iEndTime) . '\'';
		}			
		
		$iCnt = (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where($aCond)
			->execute('getSlaveField');
		
		return array(
			'phrase' => 'comment.comment_on_items',
			'total' => $iCnt
		);
	}	
	
	public function getRequestLink()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_service_callback_getrequestlink__start')) ? eval($sPlugin) : false);
		
		$iTotalApproveCount = $this->database()->select('COUNT(*)')->from(Phpfox::getT('comment'))->where('owner_user_id = ' . Phpfox::getUserId() . ' AND view_id = 1')->execute('getSlaveField');
		
		if (!Phpfox::getParam('request.display_request_box_on_empty') && !$iTotalApproveCount)
		{
			return null;
		}		
		
		return '<li><a href="' . Phpfox::getLib('url')->makeUrl('request', '#comment') . '"' . (!$iTotalApproveCount ? ' onclick="alert(\'' . Phpfox::getPhrase('comment.nothing_new_to_approve') . '\'); return false;"' : '') . '><img src="' . Phpfox::getLib('template')->getStyle('image', 'misc/comment.png') . '" alt="" class="v_middle" /> ' . Phpfox::getPhrase('comment.comments_pending_approval_total', array('total' => $iTotalApproveCount)) . '</a></li>';
	}
	
	public function getRedirectRequest($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_service_callback_getredirectrequest__start')) ? eval($sPlugin) : false);
		$aItem = $this->database()->select('comment_id, type_id, item_id')
			->from($this->_sTable)
			->where('comment_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aItem['item_id']))
		{
			return false;
		}

		return Phpfox::callback($aItem['type_id'] . '.getRedirectComment', $aItem['item_id']) . 'comment_' . $aItem['comment_id'] . '/#comment-view';
	}
	
	public function getNotificationSettings()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_service_callback_getnotificationsettings__start')) ? eval($sPlugin) : false);
		return array('comment.add_new_comment' => array(
				'phrase' => Phpfox::getPhrase('comment.new_comments'),
				'default' => 1
			),
			'comment.approve_new_comment' => array(
				'phrase' => Phpfox::getPhrase('comment.comments_for_approval'),
				'default' => 1
			)
		);		
	}

	public function getReportRedirect($iId)
	{
		return $this->getRedirectRequest($iId);
	}
	
	public function getUserCountFieldPending()
	{
		return 'comment_pending';
	}
	
	public function getNotificationFeedPending($aRow)
	{		
		return array(
			'message' => Phpfox::getPhrase('comment.user_link_added_a_comment_and_is_pending_your_approval', array('user' => $aRow)),
			'link' => Phpfox::getLib('url')->makeUrl('request', '#comment_id_' . $aRow['item_id'])
		);
	}
	
	public function getBlockDetailsDisplay($sType)
	{
		if ($sType == 'profile' && !Phpfox::getParam('comment.allow_comments_on_profiles'))
		{
			return false;	
		}		
		
		return array(
			'title' => Phpfox::getPhrase('comment.comment_title')
		);
	}

	public function hideBlockDisplay($sType)
	{
		return array(
			'table' => ($sType == 'profile' ? 'user_design_order' : '')
		);		
	}	

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_service_callback_ondeleteuser__start')) ? eval($sPlugin) : false);
		$aComments = $this->database()
			->select('comment_id')
			->from($this->_sTable)
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');
		foreach ($aComments as $aComment)
		{
			Phpfox::getService('comment.process')->delete($aComment['comment_id']);
		}
		$this->database()->delete(Phpfox::getT('comment_rating'), 'user_id = ' . (int)$iUser);
	}
	
	public function spamCheck()
	{
		return array(
			'phrase' => Phpfox::getPhrase('comment.comment_title'),
			'value' => Phpfox::getService('comment')->getSpamTotal(),
			'link' => Phpfox::getLib('url')->makeUrl('admincp.comment', array('view' => 'spam'))
		);		
	}

	public function reparserList()
	{
		return array(
			'name' => Phpfox::getPhrase('comment.comments_text'),
			'table' => 'comment_text',
			'original' => 'text',
			'parsed' => 'text_parsed',
			'item_field' => 'comment_id'
		);
	}

	public function getDashboardActivity()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		
		return array(
			Phpfox::getPhrase('comment.comments_activity') => $aUser['activity_comment']
		);
	}

	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => Phpfox::getPhrase('comment.new_comments_stats'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('comment'))
				->where('view_id = 0 AND time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}
	
	public function updateCounterList()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_service_callback_updatecounterlist__start')) ? eval($sPlugin) : false);
		$aList = array();		
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('comment.update_owner_id_for_comments_only_for_those_that_upgraded_from_v1_6_21'),
			'id' => 'comment-order-id'
		);	

		return $aList;
	}		
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_service_callback_updatecounter__start')) ? eval($sPlugin) : false);
		if (!file_exists(PHPFOX_DIR . 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('comment.your_old_v1_6_21_setting_file_must_exist', array('file' => 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php')));
		}
		
		require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php');
		
		$sTable = (isset($_CONF['db']['prefix']) ? $_CONF['db']['prefix'] : '') . 'comments';
		
		if (!$this->database()->tableExists($sTable))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('comment.the_database_table_table_does_not_exist', array('table' => $sTable)));
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('comment'))
			->where('type_id = \'profile\'')
			->execute('getSlaveField');			
			
		$aRows = $this->database()->select('m.comment_id, i.user_id AS owner_user_id')
			->from(Phpfox::getT('comment'), 'm')
			->join($sTable, 'oc', 'oc.cid = m.upgrade_item_id')
			->join(Phpfox::getT('user'), 'i', 'i.upgrade_user_id = oc.itemid')
			->where('type_id = \'profile\'')
			->limit($iPage, $iPageLimit, $iCnt)
			->execute('getSlaveRows');
			
		foreach ($aRows as $aRow)
		{
			$this->database()->update(Phpfox::getT('comment'), array('owner_user_id' => $aRow['owner_user_id']), 'comment_id = ' . (int) $aRow['comment_id']);
		}

		(($sPlugin = Phpfox_Plugin::get('comment.component_service_callback_updatecounter__end')) ? eval($sPlugin) : false);
		return $iCnt;
	}
	
	public function sendLikeEmailProfile_My($iItemId, $aFeed)
	{
		return Phpfox::getPhrase('comment.a_href_user_link_full_name_a_likes_your_a_href_link_comment_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl($aFeed['user_name'], array('feed' => $aFeed['feed_id'], 'flike' => 'fcomment'))
				)
			);
	}

	public function getActivityPointField()
	{
		return array(
			Phpfox::getPhrase('comment.comments_activity') => 'activity_comment'
		);
	}

	public function pendingApproval()
	{
		return array(
			'phrase' => Phpfox::getPhrase('comment.comments_approve'),
			'value' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('comment'))->where('view_id = 1')->execute('getSlaveField'),
			'link' => Phpfox::getLib('url')->makeUrl('admincp.comment', array('view' => 'approval'))
		);
	}

	public function getAjaxProfileController()
	{
		return 'comment.profile';
	}
	
	public function getProfileMenu($aUser)
	{
		return false;
		
		if (!Phpfox::getParam('profile.show_empty_tabs'))
		{		
			if (!isset($aUser['total_comment']))
			{
				return false;
			}

			if (isset($aUser['total_comment']) && (int) $aUser['total_comment'] === 0)
			{
				return false;
			}
		}
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('profile.guestbook'),
			'url' => 'profile.comment',
			'total' => (int) (isset($aUser['total_comment']) ? $aUser['total_comment'] : 0)
		);		
		
		return $aMenus;
	}		

	public function getActions()
	{
		return array(
			'dislike' => array(
				'enabled' => true,
				'action_type_id' => 2, // 2 = dislike
				'phrase' => Phpfox::getPhrase('like.dislike'),
				'phrase_in_past_tense' => 'disliked',
				'item_phrase' => Phpfox::getPhrase('comment.item_phrase'),
				'item_type_id' => 'comment', // used to differentiate between photo albums and photos for example. This is not a phrase
				'table' => 'comment',
				'column_update' => 'total_dislike',
				'column_find' => 'comment_id',
				'where_to_show' => array('')			
			)
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
		if (preg_match("/^getNewsFeed(.*?)$/i", $sMethod, $aMatches))
		{
			return Phpfox::callback(strtolower($aMatches[1]) . '.getCommentNewsFeed', $aArguments[0], (isset($aArguments[1]) ? $aArguments[1] : null));
		}
		elseif (preg_match("/^getFeedRedirect(.*?)$/i", $sMethod, $aMatches))
		{	
			return Phpfox::callback(strtolower($aMatches[1]) . '.getFeedRedirect', $aArguments[0], $aArguments[1]);
		}
		elseif (preg_match("/^getNotificationFeed(.*?)$/i", $sMethod, $aMatches))
		{			
			if (empty($aMatches[1]))
			{
				$aMatches[1] = 'feed';
			}
			return Phpfox::callback(strtolower($aMatches[1]) . '.getCommentNotificationFeed', $aArguments[0]);
		}
		elseif (preg_match("/^getNotification(.*?)$/i", $sMethod, $aMatches))
		{
			return Phpfox::callback(strtolower($aMatches[1]) . '.getCommentNotification', $aArguments[0]);
		}
		elseif (preg_match("/^getAjaxCommentVar(.*?)$/i", $sMethod, $aMatches))
		{
			return Phpfox::callback(strtolower($aMatches[1]) . '.getAjaxCommentVar');
		}
		elseif (preg_match("/^getCommentItem(.*?)$/i", $sMethod, $aMatches))
		{
			return Phpfox::callback(strtolower($aMatches[1]) . '.getCommentItem', $aArguments[0]);
		}	
		elseif (preg_match("/^addComment(.*?)$/i", $sMethod, $aMatches))
		{
			return Phpfox::callback(strtolower($aMatches[1]) . '.addComment', $aArguments[0], (isset($aArguments[1]) ? $aArguments[1] : null), (isset($aArguments[2]) ? $aArguments[2] : null));
		}
		/*
		elseif (preg_match("/^sendLikeEmail(.*?)$/i", $sMethod, $aMatches))
		{			
			return Phpfox::getPhrase('comment.a_href_user_link_full_name_a_likes_your_a_href_link_comment_a', array(
						'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
						'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
						'link' => Phpfox::callback(strtolower($aMatches[1]) . '.getFeedRedirect', $aArguments[0])
					)
				);			
		}
		*/
		
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('comment.service_callback__call'))
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