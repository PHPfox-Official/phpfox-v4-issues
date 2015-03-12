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
 * @package  		Module_Poll
 * @version 		$Id: callback.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Poll_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('poll');
	}
	
	public function checkFeedShareLink()
	{
		if (!Phpfox::getUserParam('poll.can_create_poll'))
		{
			return false;
		}
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
			'phrase' => 'poll.polls',
			'total' => $iCnt
		);
	}	
	
	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('poll.polls'),
			'link' => Phpfox::getLib('url')->makeUrl('poll'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_polls.png'))
		);
	}	
	
	public function getProfileLink()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getprofilelink_start')) ? eval($sPlugin) : false);
		return 'profile.poll';
	}	
	
	public function getAjaxCommentVar()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getajaxcommentvar_start')) ? eval($sPlugin) : false);
		return 'poll.can_post_comment_on_poll';
	}
	
	public function getCommentItem($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getcommentitem_start')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('poll_id AS comment_item_id, privacy_comment, user_id AS comment_user_id')
			->from($this->_sTable)
			->where('poll_id = ' . (int) $iId)
			->execute('getSlaveRow');		
			
		$aRow['comment_view_id'] = '0';
		
		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('poll.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
			
			unset($aRow['comment_item_id']);
		}
			
		return $aRow;		

	}	
	
	public function getActivityFeedComment($aRow)
	{
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_mini\' AND l.item_id = c.comment_id AND l.user_id = ' . Phpfox::getUserId());
		}		
		
		$aItem = $this->database()->select('b.poll_id, b.privacy, b.question, b.time_stamp, b.total_comment, b.total_like, c.total_like, ct.text_parsed AS text, f.friend_id AS is_friend, ' . Phpfox::getUserField())
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->join(Phpfox::getT('poll'), 'b', 'c.type_id = \'poll\' AND c.item_id = b.poll_id AND c.view_id = 0')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = b.user_id AND f.friend_user_id = " . Phpfox::getUserId())
			->where('c.comment_id = ' . (int) $aRow['item_id'])
			->execute('getSlaveRow');
		
		if (!isset($aItem['poll_id']))
		{
			return false;
		}

		$bCanViewItem = true;
		if (Phpfox::isModule('privacy') && $aItem['privacy'] > 0)
		{
			$bCanViewItem = Phpfox::getService('privacy')->check('poll', $aItem['poll_id'], $aItem['user_id'], $aItem['privacy'], $aItem['is_friend'], true);
		}

		if (!$bCanViewItem)
		{
			return false;
		}
		
		$sLink = Phpfox::permalink('poll', $aItem['poll_id'], $aItem['question']);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aItem['question'], (Phpfox::isModule('notification') ? Phpfox::getParam('notification.total_notification_title_length') :50));
		$sUser = '<a href="' . Phpfox::getLib('url')->makeUrl($aItem['user_name']) . '">' . $aItem['full_name'] . '</a>';
		$sGender = Phpfox::getService('user')->gender($aItem['gender'], 1);
		
		if ($aRow['user_id'] == $aItem['user_id'])
		{
			$sMessage = Phpfox::getPhrase('poll.posted_a_comment_on_gender_poll_a_href_link_title_a',array('gender' => $sGender, 'link' => $sLink, 'title' => $sTitle));
		}
		else
		{			
			$sMessage = Phpfox::getPhrase('poll.posted_a_comment_on_user_name_s_poll_a_href_link_title_a',array('user_name' => $sUser, 'link' => $sLink, 'title' => $sTitle));
		}
		
		return array(
			'no_share' => true,
			'feed_info' => $sMessage,
			'feed_link' => $sLink,
			'feed_status' => $aItem['text'],
			'feed_total_like' => $aItem['total_like'],
			'feed_is_liked' => isset($aItem['is_liked']) ? $aItem['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'module/poll.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],
			'like_type_id' => 'feed_mini'
		);		
	}
	
	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_addcomment_start')) ? eval($sPlugin) : false);
		
		$aPoll = $this->database()->select('u.full_name, u.user_id, u.gender, u.user_name, p.poll_id, p.question, p.privacy, p.privacy_comment')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.poll_id = ' . (int) $aVals['item_id'])
			->execute('getSlaveRow');
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add($aVals['type'] . '_comment', $aVals['comment_id'], $aPoll['privacy'], $aPoll['privacy_comment']) : null);
		
		if (empty($aVals['parent_id']))
		{
			$this->database()->updateCounter('poll', 'total_comment', 'poll_id', $aVals['item_id']);	
		}
		
		// Send the user an email
		$sLink = Phpfox::permalink('poll', $aPoll['poll_id'], $aPoll['question']);
		
		Phpfox::getService('comment.process')->notify(array(
				'user_id' => $aPoll['user_id'],
				'item_id' => $aPoll['poll_id'],
				'owner_subject' => Phpfox::getPhrase('poll.full_name_commented_on_one_of_your_polls_title',array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aPoll['question'])),
				'owner_message' => Phpfox::getPhrase('poll.full_name_commented_on_your_poll_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aPoll['question'])),
				'owner_notification' => 'comment.add_new_comment',
				'notify_id' => 'comment_poll',
				'mass_id' => 'poll',
				'mass_subject' => (Phpfox::getUserId() == $aPoll['user_id'] ? Phpfox::getPhrase('poll.full_name_commented_on_gender_poll',array('full_name' => Phpfox::getUserBy('full_name'),'gender' => Phpfox::getService('user')->gender($aPoll['gender'], 1)))
					:Phpfox::getPhrase('poll.full_name_commented_on_other_full_name_s_poll',array('full_name' => Phpfox::getUserBy('full_name'), 'other_full_name' => $aPoll['full_name']))),
				'mass_message' => (Phpfox::getUserId() == $aPoll['user_id'] ? 
					Phpfox::getPhrase('poll.full_name_commented_on_gender_poll_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aPoll['gender'], 1), 'link' => $sLink, 'title' => $aPoll['question']))
					: 
					Phpfox::getPhrase('poll.full_name_commented_on_other_full_name_s_poll_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a',array('full_name' => Phpfox::getUserBy('full_name'), 'other_full_name' => $aPoll['full_name'], 'link' => $sLink, 'title' => $aPoll['question'])))
			)
		);		
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_addcomment_end')) ? eval($sPlugin) : false);
	}
	
	public function getCommentNotification($aNotification)
	{
		$aRow = $this->database()->select('p.poll_id, p.question, p.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('poll'), 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.poll_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_commented_on_gender_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_commented_on_your_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_commented_on_span_class_drop_data_user_full_name_s_span_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('poll', $aRow['poll_id'], $aRow['question']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}	
	
	public function updateCommentText($aVals, $sText)
	{
		// (Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('comment_poll', $aVals['item_id'], $sText, $aVals['comment_id']) : null);
	}		
	
	public function getItemName($iId, $sName)
	{
		return '<a href="' . Phpfox::getLib('url')->makeUrl('comment.view', array('id' => $iId)) . '">' . Phpfox::getPhrase('poll.on_name_s_poll', array('name' => $sName)) . '</a>';
	}	
	
	public function deleteComment($iPoll)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_deletecomment_start')) ? eval($sPlugin) : false);
		
		$this->database()->update($this->_sTable, array('total_comment' => array('= total_comment -', 1)), 'poll_id = ' . (int)$iPoll);
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_deletecomment_end')) ? eval($sPlugin) : false);
	}	
	
	public function processCommentModeration($sAction, $iId)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_processcommentmoderation_start')) ? eval($sPlugin) : false);
		// Is this comment approved?
		if ($sAction == 'approve')
		{
			// Update the poll count
			Phpfox::getService('poll.process')->updateCounter($iId);
			
			// Get the polls details so we can add it to our news feed
			$aPoll = $this->database()->select('p.poll_id, p.user_id, p.question_url, ct.text_parsed, c.user_id AS comment_user_id, c.comment_id')			
				->from($this->_sTable, 'p')								
				->join(Phpfox::getT('comment'), 'c', 'c.type_id = \'poll\' AND c.item_id = p.poll_id')
				->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')				
				->where('p.poll_id = ' . (int) $iId)
				->execute('getSlaveRow');
				
			// Add to news feed
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('comment_poll', $aPoll['poll_id'], $aPoll['text_parsed'], $aPoll['comment_user_id'], $aPoll['user_id'], $aPoll['comment_id']) : null);
			
			// Send the user an email
			if (Phpfox::getParam('core.is_personal_site'))
			{
				$sLink = Phpfox::getLib('url')->makeUrl('poll', $aPoll['title_url']);
			}		
			else 
			{
				$sLink = Phpfox::getService('user')->getLink(Phpfox::getUserId(), Phpfox::getUserBy('user_name'), array('poll', $aPoll['question_url']));
			}
			Phpfox::getLib('mail')->to($aPoll['comment_user_id'])
				->subject(array('poll.full_name_approved_your_comment_on_site_title', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('poll.full_name_approved_your_comment_on_site_title_message', array(
							'full_name' => Phpfox::getUserBy('full_name'),
							'site_title' => Phpfox::getParam('core.site_title'),
							'link' => $sLink
						)
					)
				)				
				->notification('comment.approve_new_comment')
				->send();
		}
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_processcommentmoderation_end')) ? eval($sPlugin) : false);
	}	

	public function getCommentNewsFeed($aRow)
	{		
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		

		if ($aRow['owner_user_id'] == $aRow['item_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('poll.a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_poll_a', array(
					'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
					'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
					'title_link' => $aRow['link']
				)
			);
		}
		else 
		{
			if ($aRow['item_user_id'] == Phpfox::getUserBy('user_id'))
			{
				$aRow['text'] = Phpfox::getPhrase('poll.a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_poll_a', array(
						'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
						'title_link' => $aRow['link']
					)	
				);
			}
			else 
			{
				$aRow['text'] = Phpfox::getPhrase('poll.a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_name_s_a_a_href_title_link_poll_a', array(
						'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
						'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
						'title_link' => $aRow['link'],
						'item_user_name' => $this->preParse()->clean($aRow['viewer_full_name']),
						'item_user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['viewer_user_id']))
					)
				);
			}
		}
		
		$aRow['text'] .= Phpfox::getService('feed')->quote($aRow['content']);
		
		return $aRow;
	}	
	
	public function getNewsFeed($aRow)
	{
		if ($sPlugin = Phpfox_Plugin::get('poll.service_callback_getnewsfeed_start')){eval($sPlugin);}
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');					
		
		$aRow['text'] = Phpfox::getPhrase('poll.a_href_user_link_full_name_a_added_a_new_poll_a_href_question_url_question_a', array(
				'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['owner_user_id'])),
				'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
				'question_url' => $aRow['link'],
				'question' => Phpfox::getService('feed')->shortenTitle($aRow['content'])
			)
		);	
		
		$aRow['icon'] = 'module/poll.png';	
		$aRow['enable_like'] = true;
		
		return $aRow;
	}
	
	public function getFeedRedirect($iId, $iChild = 0)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getcommentnewsfeed_start')) ? eval($sPlugin) : false);

		$aQuestion = $this->database()->select('p.poll_id, p.question')
			->from($this->_sTable, 'p')
			->where('p.poll_id = ' . (int) $iId)
			->execute('getSlaveRow');		
		
		if (!isset($aQuestion['poll_id']))
		{
			return false;
		}
			
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getcommentnewsfeed_end')) ? eval($sPlugin) : false);		
	
		return Phpfox::permalink('poll', $aQuestion['poll_id'], $aQuestion['question']);
	}
	
	public function getRedirectComment($iId)
	{
		return $this->getFeedRedirect($iId);
	}	
	
	public function getReportRedirect($iId)
	{
		return $this->getFeedRedirect($iId);
	}		
	
	public function addTrack($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_addtrack_start')) ? eval($sPlugin) : false);
		$this->database()->insert(Phpfox::getT('poll_track'), array(
				'item_id' => (int) $iId,
				'user_id' => Phpfox::getUserBy('user_id'),
				'time_stamp' => PHPFOX_TIME
			)
		);
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_addtrack_end')) ? eval($sPlugin) : false);
	}	
	
	public function getLatestTrackUsers($iId, $iUserId)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getlatesttrackusers_start')) ? eval($sPlugin) : false);
		if ($iId === false)
		{
			// user is viewing the general area: poll
			$this->database()->where('track.user_id != ' . (int) $iUserId);
		}
		else
		{
			// user is viewing one specific poll: profile.poll.pollName
			$this->database()->where('track.user_id != ' . (int) $iUserId . ' AND track.item_id = ' . (int)$iId);
		}
		
		$aRows = $this->database()->select('DISTINCT ' . Phpfox::getUserField())
				->from(Phpfox::getT('poll_track'), 'track')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = track.user_id')				
				->order('track.time_stamp DESC')
				->limit(0, 7)
				->execute('getSlaveRows');	
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getlatesttrackusers_end')) ? eval($sPlugin) : false);
		return (count($aRows) ? $aRows : false);		
	}
	
	public function getCommentItemName()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getcommentitemname_start')) ? eval($sPlugin) : false);
		return 'poll';
	}

	public function getWhatsNew()
	{
		return array(
			'poll.polls' => array(
				'ajax' => '#poll.getNew?id=js_new_item_holder',
				'id' => 'poll',
				'block' => 'poll.new'
			)
		);
	}

	public function getDashboardLinks()
	{
		return array(
			'submit' => array(
				'phrase' => Phpfox::getPhrase('poll.create_a_poll'),
				'link' => 'poll.add',
				'image' => 'misc/chart_bar_add.png'
			),
			'edit' => array(
				'phrase' => Phpfox::getPhrase('poll.manage_polls'),
				'link' => 'profile.poll',
				'image' => 'misc/chart_bar_edit.png'
			)
		);
	}	

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{		
		// get all the items from this user		
		$aPolls = $this->database()
			->select('poll_id')
			->from($this->_sTable)
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');

		foreach ($aPolls as $aPoll)
		{
			Phpfox::getService('poll.process')->moderatePoll($aPoll['poll_id'], 2);
		}
		return true;
	}
	
	public function getItemView()
	{
		if (Phpfox::getLib('request')->get('req3') != '')
		{
			return true;
		}
	}	

	/**
	 * Used primarily in the site stats this function returns how many polls are pending
	 * approval
	 * @return array
	 */
	public function pendingApproval()
	{
		return array(
			'phrase' => Phpfox::getPhrase('poll.polls'),
			'value' => Phpfox::getService('poll')->getPendingTotal(),
			'link' => Phpfox::getLib('url')->makeUrl('poll', array('view' => 'pending'))
		);
	}

	public function getDashboardActivity()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		
		return array(
			Phpfox::getPhrase('poll.polls_activity') => $aUser['activity_poll']
		);
	}

	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => Phpfox::getPhrase('poll.polls'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('poll'))
				->where('view_id = 0 AND time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}		
	
	public function getFeedRedirectFeedLike($iId, $iChildId = 0)
	{
		return $this->getFeedRedirect($iChildId);
	}	

	public function getNewsFeedFeedLike($aRow)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('poll.a_href_user_link_full_name_a_likes_their_own_a_href_link_poll_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => $aRow['link']
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('poll.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_poll_a', array(
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
			'message' => Phpfox::getPhrase('poll.a_href_user_link_full_name_a_likes_your_a_href_link_poll_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('poll', array('redirect' => $aRow['item_id']))
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('poll', array('redirect' => $aRow['item_id']))			
		);				
	}		
	
	public function sendLikeEmail($iItemId)
	{
		return Phpfox::getPhrase('poll.a_href_user_link_full_name_a_likes_your_a_href_link_poll_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl('poll', array('redirect' => $iItemId))
				)
			);
	}			

	public function getActivityPointField()
	{
		return array(
			Phpfox::getPhrase('poll.polls_activity') => 'activity_poll'
		);
	}	
	
	public function getSqlTitleField()
	{
		return array(
			array(
				'table' => 'poll',
				'field' => 'question',
				'has_index' => 'question'
			),
			array(
				'table' => 'poll_answer',
				'field' => 'answer'
			)
		);
	}	

	public function tabHasItems($iUser)
	{
		$iCount = $this->database()->select('COUNT(user_id)')
				->from($this->_sTable)
				->where('user_id = ' . (int)$iUser)
				->execute('getSlaveField');
		return $iCount > 0;
	}

	public function canShareItemOnFeed(){}	
	
	public function getActivityFeed($aRow, $aCallback = null, $bIsChildItem = false)
	{
		if ($bIsChildItem)
		{
			$this->database()->select(Phpfox::getUserField('u2') . ', ')->join(Phpfox::getT('user'), 'u2', 'u2.user_id = p.user_id');
		}		
		
		$aRow = Phpfox::getService('poll')->getPollByUrl($aRow['item_id']);				

		$aRow['poll_is_in_feed'] = true;
		$oTpl = Phpfox::getLib('template');
		$oTpl->assign(array('aPoll' => $aRow, 'iKey' => rand(2,900)));
		$sOutput = $oTpl->getTemplate('poll.block.vote', true);
		
		$aReturn = array(
			'feed_title' => $aRow['question'],
			'feed_info' => Phpfox::getPhrase('feed.created_a_poll'),
			'feed_link' => Phpfox::permalink('poll', $aRow['poll_id'], $aRow['question']),
			'total_comment' => $aRow['total_comment'],
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => $aRow['is_liked'],
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'module/poll.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => true,			
			'comment_type_id' => 'poll',
			'like_type_id' => 'poll',			
			'feed_custom_html' => $sOutput
		);
		
		if (!empty($aRow['image_path']))
		{
			$sImage = Phpfox::getLib('image.helper')->display(array(
					'server_id' => $aRow['server_id'],
					'path' => 'poll.url_image',
					'file' => $aRow['image_path'],
					'suffix' => '_' . Phpfox::getParam('poll.poll_max_image_pic_size'),
					'max_width' => Phpfox::getParam('poll.poll_max_image_pic_size'),
					'max_height' => Phpfox::getParam('poll.poll_max_image_pic_size')
				)
			);			
			
			$aReturn['feed_image'] = $sImage;
			$aReturn['feed_custom_width'] = '78px';
		}
		
		if ($bIsChildItem)
		{
			$aReturn = array_merge($aReturn, $aRow);
		}		
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_service_callback_getactivityfeed__1')) ? eval($sPlugin) : false);
		
		return $aReturn;
	}
	
	public function getNotification($aNotification)
	{
		$aRow = $this->database()->select('p.poll_id, p.question, p.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('poll'), 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.poll_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_voted_on_gender_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_voted_on_your_poll_title',array('user_name' =>Phpfox::getService('notification')->getUsers($aNotification), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_voted_on_span_class_drop_data_user_full_name_s_span_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('poll', $aRow['poll_id'], $aRow['question']),
			'message' => $sPhrase
		);	
	}
	
	public function getNotificationLike($aNotification)
	{
		$aRow = $this->database()->select('p.poll_id, p.question, p.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('poll'), 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.poll_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_liked_gender_own_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_liked_your_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('poll.user_name_liked_span_class_drop_data_user_full_name_span_poll_title',array('user_name' => Phpfox::getService('notification')->getUsers($aNotification), 'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('poll', $aRow['poll_id'], $aRow['question']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}
	
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('poll_id, question, user_id')
			->from(Phpfox::getT('poll'))
			->where('poll_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['poll_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'poll\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'poll', 'poll_id = ' . (int) $iItemId);	
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::permalink('poll', $aRow['poll_id'], $aRow['question']);
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('poll.full_name_liked_your_poll_question', array('full_name' => Phpfox::getUserBy('full_name'), 'question' => $aRow['question'])))
				->message(array('poll.full_name_liked_your_poll_question_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'question' => $aRow['question'])))
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('poll_like', $aRow['poll_id'], $aRow['user_id']);				
		}
	}
	
	public function deleteLike($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'poll\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'poll', 'poll_id = ' . (int) $iItemId);	
	}		
	
	public function getNotificationApproved($aNotification)
	{
		$aRow = $this->database()->select('p.poll_id, p.question, p.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('poll'), 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.poll_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');	

		if (!isset($aRow['poll_id']))
		{
			return false;
		}
		
		$sPhrase = Phpfox::getPhrase('poll.your_poll_title_has_been_approved',array('title' => Phpfox::getLib('parse.output')->shorten($aRow['question'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('poll', $aRow['poll_id'], $aRow['question']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog'),
			'no_profile_image' => true
		);			
	}	

	public function getAjaxProfileController()
	{
		return 'poll.index';
	}
	
	public function getProfileMenu($aUser)
	{
		if (!Phpfox::getParam('profile.show_empty_tabs'))
		{		
			if (!isset($aUser['total_poll']))
			{
				return false;
			}

			if (isset($aUser['total_poll']) && (int) $aUser['total_poll'] === 0)
			{
				return false;
			}
		}
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('profile.polls'),
			'url' => 'profile.poll',
			'total' => (int) (isset($aUser['total_poll']) ? $aUser['total_poll'] : 0),
			'icon' => 'feed/poll.png'	
		);	
		
		return $aMenus;
	}
	
	public function getTotalItemCount($iUserId)
	{
		return array(
			'field' => 'total_poll',
			'total' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('poll'))->where('item_id = 0 AND view_id = 0 AND user_id = ' . (int) $iUserId)->execute('getSlaveField')
		);	
	}	
	
	public function globalUnionSearch($sSearch)
	{
		$this->database()->select('item.poll_id AS item_id, item.question AS item_title, item.time_stamp AS item_time_stamp, item.user_id AS item_user_id, \'poll\' AS item_type_id, \'\' AS item_photo, \'\' AS item_photo_server')
			->from(Phpfox::getT('poll'), 'item')
			->where('item.item_id = 0 AND item.view_id = 0 AND ' . $this->database()->searchKeywords('item.question', $sSearch) . ' AND item.privacy = 0')
			->union();
	}
	
	public function getSearchInfo($aRow)
	{
		$aInfo = array();
		$aInfo['item_link'] = Phpfox::getLib('url')->permalink('poll', $aRow['item_id'], $aRow['item_title']);
		$aInfo['item_name'] = Phpfox::getPhrase('search.poll');
		
		return $aInfo;
	}
	
	public function getSearchTitleInfo()
	{
		return array(
			'name' => Phpfox::getPhrase('poll.polls')
		);
	}	
	
	public function getGlobalPrivacySettings()
	{
		return array(
			'poll.default_privacy_setting' => array(
				'phrase' => Phpfox::getPhrase('user.polls')								
			)
		);
	}	
	
	public function getParentItemCommentUrl($aComment)
	{		
		$aRow = $this->database()->select('p.poll_id, p.question')
			->from(Phpfox::getT('poll'), 'p')
			->where('p.poll_id = ' . (int) $aComment['item_id'])
			->execute('getSlaveRow');
			
		if (!isset($aRow['poll_id']))
		{
			return false;
		}
			
		return Phpfox::getLib('url')->permalink('poll', $aRow['poll_id'], $aRow['question']);
	}	
	
	public function getCommentNotificationTag($aNotification)
	{
		$aRow = $this->database()->select('p.poll_id, p.question, u.user_name, u.full_name')
					->from(Phpfox::getT('comment'), 'c')
					->join(Phpfox::getT('poll'), 'p', 'p.poll_id = c.item_id')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
					->where('c.comment_id = ' . (int)$aNotification['item_id'])
					->execute('getSlaveRow');
		
		
		Phpfox::getPhrase('poll.user_name_tagged_you_in_a_comment_in_a_poll', array('user_name' => $aRow['full_name']));
		
		return array(
			'link' => Phpfox::getLib('url')->permalink('poll', $aRow['poll_id'], $aRow['question']) . 'comment_'. $aNotification['item_id'],
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}
	
	public function getActions()
	{
		return array(
			'dislike' => array(
				'enabled' => true,
				'action_type_id' => 2, // 2 = dislike
				'phrase' => Phpfox::getPhrase('like.dislike'),
				'phrase_in_past_tense' => 'disliked',
				'item_type_id' => 'poll', // used to differentiate between photo albums and photos for example.
				'table' => 'poll',
				'item_phrase' => Phpfox::getPhrase('poll.item_phrase'),
				'column_update' => 'total_dislike',
				'column_find' => 'poll_id',
				'where_to_show' => array('poll')
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
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('poll.service_callback__call'))
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
