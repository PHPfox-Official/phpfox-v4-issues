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
 * @package  		Module_Forum
 * @version 		$Id: callback.class.php 7061 2014-01-22 15:15:00Z Fern $
 */
class Forum_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
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
			->from(Phpfox::getT('forum_thread'))
			->where($aCond)
			->execute('getSlaveField');
		
		$aCond = array();
		if ($iStartTime > 0)
		{
			$aCond[] = 'AND time_stamp >= \'' . $this->database()->escape($iStartTime) . '\'';
		}	
		if ($iEndTime > 0)
		{
			$aCond[] = 'AND time_stamp <= \'' . $this->database()->escape($iEndTime) . '\'';
		}			
		
		$iForumCnt = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('forum_post'))
			->where($aCond)
			->execute('getSlaveField');		
		
		return array(array(
				'phrase' => 'forum.forum_threads',
				'total' => $iCnt
			),
			array(
				'phrase' => 'forum.forum_posts',
				'total' => $iForumCnt
			)
		);
	}	
	
	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('forum.forum'),
			'link' => Phpfox::getLib('url')->makeUrl('forum'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_forum.png'))
		);
	}	

	public function enableSponsor($aParams)
	{
	    if ($aParams['section'] == 'thread')
	    {
			return Phpfox::getService('forum.thread.process')->sponsor($aParams['item_id'], 2);
	    }
	}

	public function getLink($aParams)
	{
	    $aItem = $this->database()->select('ft.thread_id, ft.title')
		    ->from(Phpfox::getT('forum_thread'),'ft')
		    ->where('ft.thread_id = ' . (int)$aParams['item_id'])
		    ->execute('getSlaveRow');
		
	    return Phpfox::permalink('forum.thread', $aItem['thread_id'], $aItem['title']);
	}

	public function getAttachmentField()
	{
		return array(
			'forum_post', 
			'post_id'
		);
	}

	public function getTagLink()
	{		
		return Phpfox::getLib('url')->makeUrl('forum.tag');
	}	
	
	public function getTagLinkGroup()
	{		
		return Phpfox::getLib('url')->makeUrl('forum.tag', array('module' => 'group', 'item' => Phpfox::getLib('request')->get('req2')));
	}		

	public function getTagTypeGroup()
	{
		return 'forum';
	}	
	
	public function getTagType()
	{
		return 'forum';
	}	
	
	public function getTagCloud()
	{
		return array(
			'link' => 'forum',
			'category' => 'forum'
		);
	}	

	public function getNewsFeed($aRow)
	{
		if ($sPlugin = Phpfox_Plugin::get('forum.service_callback_getnewsfeed_start')){eval($sPlugin);}
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		
		
		$aRow['text'] = Phpfox::getPhrase('forum.owner_full_name_added_a_new_thread', array(
				'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
				'owner_full_name' => $this->preParse()->clean($aRow['owner_full_name']),
				'title_link' => $aRow['link'],
				'title' => Phpfox::getService('feed')->shortenTitle($aRow['content'])
			)
		);		
		
		$aRow['icon'] = 'module/forum.png';
		$aRow['enable_like'] = true;
		
		return $aRow;
	}		
	
	public function getFeedRedirect($iId)
	{
		$aThread = $this->database()->select('ft.thread_id, ft.forum_id, ft.group_id, ft.title_url, u.user_id, u.user_name, f.name_url AS forum_url')
			->from(Phpfox::getT('forum_thread'), 'ft')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
			->where('ft.thread_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aThread['thread_id']))
		{
			return false;
		}			
		
		if ($aThread['group_id'] > 0)
		{
			return Phpfox::getLib('url')->makeUrl('group.forum', array($aThread['title_url'], 'id' => $aThread['group_id']));
		}
		else 
		{
			return Phpfox::getLib('url')->makeUrl('forum', array($aThread['forum_url'] . '-' . $aThread['forum_id'], $aThread['title_url']));
		}
	}	
	
	public function getFeedRedirectPost($iId)
	{
		$aThread = $this->database()->select('fp.post_id, ft.thread_id, ft.title')
			->from(Phpfox::getT('forum_post'), 'fp')
			->leftJoin(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
			->where('fp.post_id = ' . (int) $iId)
			->execute('getSlaveRow');

		if (!isset($aThread['post_id']))
		{
			return false;
		}				
		
		return Phpfox::permalink('forum.thread', $aThread['thread_id'], $aThread['title']) . 'view_' . $aThread['post_id'] . '/';
	}		

	/**
	  * @param int $iId video_id
	  * @return array in the format:
	     * array(
	     *	'title' => 'item title',		    <-- required
	     *  'link'  => 'makeUrl()'ed link',		    <-- required
	     *  'paypal_msg' => 'message for paypal'	    <-- required
	     *  'item_id' => int			    <-- required
	     *  'user_id'   => owner's user id		    <-- required
	     *	'error' => 'phrase if item doesnt exit'	    <-- optional
	     *	'extra' => 'description'		    <-- optional
	     *	'image' => 'path to an image',		    <-- optional
	     *	'image_dir' => 'photo.url_photo|...	    <-- optional (required if image)
	     * )
	    */
	public function getToSponsorThreadInfo($iId)
	{
	    $aThread = $this->database()->select('fp.user_id, f.name, f.name_url, fpt.text_parsed as extra,
		fp.thread_id as item_id, ft.title, ft.title_url')
		    ->from(Phpfox::getT('forum'),'f')
		    ->join(Phpfox::getT('forum_thread'),'ft','ft.forum_id = f.forum_id')
		    ->join(Phpfox::getT('forum_post'),'fp', 'fp.thread_id = ft.thread_id')
		    ->join(Phpfox::getT('forum_post_text'),'fpt','fpt.post_id = fp.post_id')
		    ->where('fp.thread_id = ' . (int)$iId)
		    ->execute('getSlaveRow');
	    
	    if (empty($aThread))
	    {
			return array('error' => Phpfox::getPhrase('forum.sponsor_error_not_found'));
	    }
	    
	    $aThread['title'] = Phpfox::getPhrase('forum.sponsor_title',array('sThreadTitle' => $aThread['title']));
	    $aThread['paypal_msg'] = Phpfox::getPhrase('forum.sponsor_paypal_message', array('sThreadTitle' => $aThread['title']));
	    $aThread['link'] = Phpfox::getLib('url')->makeUrl('forum.'.$aThread['name_url'].'.'.$aThread['title_url']);
	    
	    return $aThread;
	}
	
	public function getReportRedirectPost($iId)
	{
		return $this->getFeedRedirectPost($iId);
	}

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		// get all the post id
		$aPosts = $this->database()
			->select('post_id')
			->from(Phpfox::getT('forum_post'))
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');
		foreach ($aPosts as $aPost)
		{
			Phpfox::getService('forum.post.process')->delete($aPost['post_id']);
		}
		// Get all the thread id
		$aThreads = $this->database()
			->select('thread_id')
			->from(Phpfox::getT('forum_thread'))
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');
		foreach ($aThreads as $aThread)
		{
			Phpfox::getService('forum.thread.process')->delete($aThread['thread_id']);
		}

		// Delete the moderators
		$iModerator = $this->database()
			->select('moderator_id')
			->from(Phpfox::getT('forum_moderator'))
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveField');
		if (isset($iModerator) && $iModerator > 0)
		{
			$this->database()->delete(Phpfox::getT('forum_moderator_access'), 'moderator_id = ' . $iModerator);
			$this->database()->delete(Phpfox::getT('forum_moderator'), 'user_id = ' . (int)$iUser);
		}

		// Delete the tracks
		$this->database()->delete(Phpfox::getT('forum_thread_track'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(Phpfox::getT('forum_track'), 'user_id = ' . (int)$iUser);
		
		$aForums = $this->database()->select('forum_id')
			->from(Phpfox::getT('forum'))
			->execute('getRows');
		foreach ($aForums as $aForum)
		{
			Phpfox::getService('forum.process')->updateLastPost($aForum['forum_id']);	
		}
		
		// delete the cache moderators
		$this->cache()->remove('forum', 'substr');
		return true;
	}
	
	public function groupMenu($sGroupUrl, $iGroupId)
	{
		return array(
				Phpfox::getPhrase('forum.forum') => array(
					'active' => 'forum',
					'url' => Phpfox::getLib('url')->makeUrl('group', array($sGroupUrl, 'forum')
				)
			)
		);
	}

	public function getGroupAccess()
	{
		return array(
			Phpfox::getPhrase('forum.view_forum') => 'can_use_forum'
		);
	}	
	
	public function getDashboardActivity()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		
		return array(
			Phpfox::getPhrase('forum.forum_posts') => $aUser['activity_forum']
		);
	}
	
	public function getNotificationFeedSubscribed_Post($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('forum.full_name_replied_to_the_thread_title', array(
					'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['item_title'], 20, '...'), 
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('predirect' => $aRow['item_id']))
				)
			),		
			'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('predirect' => $aRow['item_id'])),
			'path' => 'core.url_user',
			'suffix' => '_50'
		);				
	}	

	public function getNotificationFeedSubscribed($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('forum.full_name_replied_to_the_thread_title', array(
					'full_name' => $aRow['full_name'], 'title' => Phpfox::getLib('parse.output')->shorten($aRow['item_title'], 20, '...'), 
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('redirect' => $aRow['item_id']))
				)
			),		
			'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('redirect' => $aRow['item_id'])),
			'path' => 'core.url_user',
			'suffix' => '_50'
		);				
	}
	
	public function getNotificationSettings()
	{
		return array('forum.subscribe_new_post' => array(
				'phrase' => Phpfox::getPhrase('forum.forum_subscriptions'),
				'default' => 1
			)
		);		
	}

	public function legacyRedirect($aRequest)
	{
		if (isset($aRequest['req2']))
		{
			switch ($aRequest['req2'])
			{
				case 'topics':
					if (isset($aRequest['id']))
					{
						$aItem = Phpfox::getService('core')->getLegacyUrl(array(
								'url_field' => 'name_url',
								'table' => 'forum',
								'field' => 'upgrade_item_id',
								'id' => $aRequest['id'],
								'user_id' => false,
								'select' => array(
									'forum_id'
								)				
							)
						);					
						
						if ($aItem !== false)
						{
							return array('forum', array($aItem['name_url'] . '-' . $aItem['forum_id']));
						}
					}					
					break;
				case 'posts':
					if (isset($aRequest['id']))
					{
						$this->database()->select('forum.name_url AS forum_name_url, forum.forum_id AS forum_id, ')->join(Phpfox::getT('forum'), 'forum', 'forum.forum_id = i.forum_id');
						
						$aItem = Phpfox::getService('core')->getLegacyUrl(array(
								'url_field' => 'title_url',
								'table' => 'forum_thread',
								'field' => 'upgrade_item_id',
								'id' => $aRequest['id'],
								'user_id' => false								
							)
						);						
						
						if ($aItem !== false)
						{
							return array('forum', array($aItem['forum_name_url'] . '-' . $aItem['forum_id'], $aItem['title_url']));
						}
					}						
					break;
			}
		}				
		
		return 'forum';
	}
	
	public function reparserList()
	{
		return array(
			'name' => Phpfox::getPhrase('forum.forum_post_text'),
			'table' => 'forum_post_text',
			'original' => 'text',
			'parsed' => 'text_parsed',
			'item_field' => 'post_id'
		);
	}		
	
	public function getNewsFeedReply($aRow)
	{
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		
		$aParts = unserialize($aRow['content']);
		
		$aRow['text'] = Phpfox::getPhrase('forum.full_name_replied_to_the_thread_title_with_link', array(
				'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
				'full_name' => $this->preParse()->clean($aRow['owner_full_name']),
				'thread_link' => $aRow['link'],
				'title' => Phpfox::getService('feed')->shortenTitle($aParts['thread_title'])
			)
		);		
		
		$aRow['icon'] = 'module/forum.png';
		$aRow['enable_like'] = true;
		
		return $aRow;		
	}
	
	public function getFeedRedirectReply($iId)
	{
		return $this->getFeedRedirectPost($iId);
	}
	
	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => Phpfox::getPhrase('forum.forum_posts'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('forum_post'))
				->where('view_id = 0 AND time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}

	public function deleteGroup($iId)
	{
		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('forum_thread'))
			->where('group_id = ' . (int) $iId)
			->execute('getRows');
			
		foreach ($aRows as $aRow)
		{
			Phpfox::getService('forum.thread.process')->delete($aRow['thread_id']);
		}
		
		return true;
	}	

	public function updateCounterList()
	{
		$aList = array();

		$aList[] = array(
			'name' => Phpfox::getPhrase('forum.forum_thread_post_count'),
			'id' => 'forum-thread-post-count'
		);
		
		$aList[] = array(
			'name' => Phpfox::getPhrase('forum.forum_user_post_count'),
			'id' => 'forum-user-post-count'
		);

		$aList[] = array(
			'name' => Phpfox::getPhrase('forum.update_forum_last_post'),
			'id' => 'forum-last-post-info'
		);
		
		(($sPlugin = Phpfox_Plugin::get('forum.service_callback_updatecounterlist')) ? eval($sPlugin) : false);

		return $aList;
	}	

	public function updateCounter($iId, $iPage, $iPageLimit)
	{		
		if ($iId == 'forum-user-post-count')
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user'))
				->execute('getSlaveField');		
			
			$aRows = $this->database()->select('u.user_id, u.user_name, u.full_name, COUNT(fp.post_id) AS total_items, uf.activity_points, uf.activity_total, uf.activity_forum')
				->from(Phpfox::getT('user'), 'u')
				->join(Phpfox::getT('user_activity'), 'uf', 'uf.user_id = u.user_id')
				->leftJoin(Phpfox::getT('forum_post'), 'fp', 'fp.user_id = u.user_id')
				->limit($iPage, $iPageLimit, $iCnt)
				->group('u.user_id')
				->execute('getSlaveRows');				
			
			foreach ($aRows as $aRow)
			{
				$this->database()->update(Phpfox::getT('user_activity'), array(
						'activity_points' => (($aRow['activity_points'] - ($aRow['activity_forum'] * Phpfox::getUserParam('forum.points_forum'))) + ($aRow['total_items'] * Phpfox::getUserParam('forum.points_forum'))),
						'activity_total' => (($aRow['activity_total'] - $aRow['activity_forum']) + $aRow['total_items']),
						'activity_forum' => $aRow['total_items']
					), 'user_id = ' . $aRow['user_id']
				);
				
				$this->database()->update(Phpfox::getT('user_field'), array('total_post' => $aRow['total_items']), 'user_id = ' . $aRow['user_id']);
			}			
			
			return $iCnt;
		}
		elseif ($iId == 'forum-thank')
		{
			if ((int) $iPage === 0)
			{
				$this->database()->update(Phpfox::getT('user_field'), array('total_thank' => 0, 'total_thanked' => 0), 'user_id > 0');
			}			
			
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('forum_thank'))
				->execute('getSlaveField');			
			
			$aRows = $this->database()->select('fp.user_id, ft.user_id AS thanked_user_id')
				->from(Phpfox::getT('forum_thank'), 'ft')
				->join(Phpfox::getT('forum_post'), 'fp', 'fp.post_id = ft.post_id')
				->limit($iPage, $iPageLimit, $iCnt)
				->execute('getSlaveRows');
			foreach ($aRows as $aRow)
			{
				$this->database()->updateCounter('user_field', 'total_thanked', 'user_id', $aRow['user_id']);
				$this->database()->updateCounter('user_field', 'total_thank', 'user_id', $aRow['thanked_user_id']);
			}
				
			return $iCnt;
		}		
		elseif ($iId == 'forum-last-post-info')
		{
		    $aForums = $this->database()->select('f.forum_id')
				->from(Phpfox::getT('forum'), 'f')
				->execute('getSlaveRows');			

		   foreach ($aForums as $aForum)
		   {
		   		$iChild = $this->_getChild($aForum['forum_id']);
				$aThread = $this->database()->select('thread_id, post_id, user_id, last_user_id')
					->from(Phpfox::getT('forum_thread'), 'ft')
					->where('ft.forum_id = ' . (int) $iChild)
					->order('ft.time_update DESC')
					->execute('getRow');
		   		foreach (Phpfox::getService('forum')->id($iChild)->getParents() as $iForumId)
		   		{
				    if (isset($aThread['thread_id']))
				    {
					    $this->database()->update(Phpfox::getT('forum'), array('thread_id' => $aThread['thread_id'], 'post_id' => $aThread['post_id'], 'last_user_id' => (empty($aThread['last_user_id']) ? $aThread['user_id'] : $aThread['last_user_id'])), 'forum_id = ' . $iForumId);
				    }
				    else
				    {
					    $this->database()->update(Phpfox::getT('forum'), array('thread_id' => 0, 'post_id' => 0, 'last_user_id' => 0), 'forum_id = ' . $iForumId);
				    }
		   		}	
		   }

		   return 0;
		}
		
		if ((int) $iPage === 0)
		{
			$this->database()->update(Phpfox::getT('forum'), array('total_post' => 0, 'total_thread' => 0), 'forum_id > 0');
			$this->database()->update(Phpfox::getT('forum_thread'), array('total_post' => 0), 'thread_id > 0');
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('forum_thread'))
			->execute('getSlaveField');
			
		$aRows = $this->database()->select('g.thread_id, g.forum_id, g.total_post, COUNT(gi.post_id) AS total_items, f.total_post AS forum_total_post, f.total_thread AS forum_total_thread')
			->from(Phpfox::getT('forum_thread'), 'g')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = g.forum_id')
			->leftJoin(Phpfox::getT('forum_post'), 'gi', 'gi.thread_id = g.thread_id')
			->group('g.thread_id')
			->limit($iPage, $iPageLimit, $iCnt)
			->execute('getSlaveRows');
						
		foreach ($aRows as $aRow)
		{
			$iTotalPost = ($aRow['total_items'] > 1 ? ($aRow['total_items'] - 1) : 0);
			
			$this->database()->update(Phpfox::getT('forum_thread'), array('total_post' => ($iTotalPost + $aRow['total_post'])), 'thread_id = ' . (int) $aRow['thread_id']);
			if ($aRow['forum_id'] > 0)
			{
				foreach (Phpfox::getService('forum')->id($aRow['forum_id'])->getParents() as $iForumid)
				{
					Phpfox::getService('forum.process')->updateCounter($iForumid, 'total_thread');
					Phpfox::getService('forum.process')->updateCounter($iForumid, 'total_post', false, $iTotalPost);
				}				
			}
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
			$aRow['text'] = Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_their_own_forum_a_href_link_thread_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => $aRow['link']
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_forum_a_href_link_thread_a', array(
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
			'message' => Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_your_forum_a_href_link_thread_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('redirect' => $aRow['item_id']))
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('redirect' => $aRow['item_id']))			
		);				
	}		
	
	public function sendLikeEmail($iItemId)
	{
		return Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_your_forum_a_href_link_thread_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('redirect' => $iItemId))
				)
			);
	}
	
	public function sendLikeEmailReply($iItemId)
	{
		return Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_your_forum_a_href_link_post_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('predirect' => $iItemId))
				)
			);
	}	
	
	public function getNotificationFeedReply_NotifyLike($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_your_forum_a_href_link_post_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('predirect' => $aRow['item_id']))
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('forum.thread', array('predirect' => $aRow['item_id']))			
		);	
	}
	
	public function getNewsFeedReply_FeedLike($aRow)
	{
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_their_own_forum_a_href_link_reply_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => $aRow['link']
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('forum.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_forum_a_href_link_reply_a', array(
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

	public function getFeedRedirectReply_FeedLike($iId, $iChildId)
	{
		Phpfox::getService('notification.process')->delete('forum_post_notifyLike', $iChildId, Phpfox::getUserId());
		
		return $this->getFeedRedirectReply($iChildId);
	}
	
	public function getActivityPointField()
	{
		return array(
			Phpfox::getPhrase('forum.forum_posts') => 'activity_forum'
		);
	}	
	
	public function pendingApproval()
	{
		$aPending[] = array(
			'phrase' => Phpfox::getPhrase('forum.forum_threads'),
			'value' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('forum_thread'))->where('view_id = 1')->execute('getSlaveField'),
			'link' => Phpfox::getLib('url')->makeUrl('forum.search', array('view' => 'pending-thread'))
		);
		
		$aPending[] = array(
			'phrase' => Phpfox::getPhrase('forum.forum_posts'),
			'value' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('forum_post'))->where('view_id = 1')->execute('getSlaveField'),
			'link' => Phpfox::getLib('url')->makeUrl('forum.search', array('view' => 'pending-post'))
		);		
		
		return $aPending;
	}

	public function getSqlTitleField()
	{
		return array(
			array(
				'table' => 'forum',
				'field' => 'name'
			),
			array(
				'table' => 'forum_thread',
				'field' => 'title',
				'has_index' => 'title'
			),
			array(
				'table' => 'forum_post',
				'field' => 'title'
			)			
		);
	}	
	
	/* This like is for first posts in a thread, not for replies */
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		return $this->addLikePost($iItemId, $bDoNotSendEmail);
	}
	public function addLikeReply($iItemId, $bDoNotSendEmail = false)
	{
		return $this->addLikePost($iItemId, $bDoNotSendEmail);
	}
	public function addLikePost($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('fp.post_id, ft.thread_id, ft.title, fp.user_id')
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->where('fp.post_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['post_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'forum_post\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'forum_post', 'post_id = ' . (int) $iItemId);	
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::permalink('forum.thread', $aRow['thread_id'], $aRow['title'], false, null, array('view' => $aRow['post_id']));
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('forum.full_name_liked_one_of_your_forum_posts', array('full_name' => Phpfox::getUserBy('full_name'))))
				->message(array('forum.full_name_liked_your_one_of_your_forum_posts_in', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aRow['title'])))
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('forum_post_like', $aRow['post_id'], $aRow['user_id']);				
		}
	}	
	
	/* This like is for first posts in a thread, not for replies */
	public function deleteLike($iItemId, $bDoNotSendEmail = false)
	{
		return $this->deleteLikePost($iItemId, $bDoNotSendEmail);
	}
	public function deleteLikeReply($iItemId)
	{
		return $this->deleteLikePost($iItemId);
	}
	public function deleteLikePost($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'forum_post\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'forum_post', 'post_id = ' . (int) $iItemId);	
	}	
	
	public function getNotificationPost_Like($aNotification)
	{
		$aRow = $this->database()->select('fp.post_id, ft.thread_id, ft.title, fp.user_id, u.full_name, u.gender')
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')
			->where('fp.post_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');			
		
		if (!isset($aRow['user_id']))
		{
		    return false;
		}
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('forum.users_liked_gender_own_forum_post_in_the_thread_title', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $sTitle));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('forum.users_liked_your_forum_post_in_the_thread_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('forum.users_liked_span_class_drop_data_user_row_full_name_s_span_forum_post_in_the_thread_title', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}		
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('forum.thread', $aRow['thread_id'], $aRow['title'], false, null, array('view' => $aRow['post_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);			
	}
	
	public function getNotificationSubscribed_Post($aNotification)
	{
		$aRow = $this->database()->select('fp.post_id, ft.thread_id, ft.title, fp.user_id')
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->where('fp.post_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');			
		
		if (!isset($aRow['post_id']))
		{
			return false;
		}
			
		$sPhrase = Phpfox::getPhrase('forum.users_replied_to_the_thread_title', array('users' => Phpfox::getService('notification')->getUsers($aNotification), 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));		
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('forum.thread', $aRow['thread_id'], $aRow['title'], false, null, array('view' => $aRow['post_id'])),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}	
		
	public function getNotificationThread_Approved($aNotification)
	{
		$aRow = $this->database()->select('ft.thread_id, ft.title, ft.user_id')
			->from(Phpfox::getT('forum_thread'), 'ft')
			->where('ft.thread_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');			
		
		if (!isset($aRow['thread_id']))
		{
			return false;
		}
			
		$sPhrase = Phpfox::getPhrase('forum.your_thread_has_been_approved', array('thread_title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], 20,'...')));
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('forum.thread', $aRow['thread_id'], $aRow['title'], false, null),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}
	
	public function canShareItemOnFeedReply(){}
	
	public function getActivityFeedPost($aItem, $aCallback = null, $bIsChildItem = false)
	{
		return $this->getActivityFeedReply($aItem, $aCallback, $bIsChildItem);
	}

	public function getActivityFeedCustomChecksPost($aRow)
	{
		if ((defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'forum.view_browse_forum'))
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['custom_data_cache']['group_id'] > 0 && !Phpfox::getService('pages')->hasPerm($aRow['custom_data_cache']['group_id'], 'forum.view_browse_forum'))
		)
		{
			return false;
		}

		return $aRow;
	}

	public function getActivityFeedCustomChecksReply($aRow)
	{
		if ((defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'forum.view_browse_forum'))
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['custom_data_cache']['group_id'] > 0 && !Phpfox::getService('pages')->hasPerm($aRow['custom_data_cache']['group_id'], 'forum.view_browse_forum'))
		)
		{
			return false;
		}

		return $aRow;
	}

	public function getActivityFeedReply($aItem, $aCallback = null, $bIsChildItem = false)
	{
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'forum_post\' AND l.item_id = fp.post_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		if ($bIsChildItem)
		{
			$this->database()->select(Phpfox::getUserField('u2') . ', ')->join(Phpfox::getT('user'), 'u2', 'u2.user_id = fp.user_id');
		}		
		
		$aRow = $this->database()->select('fp.post_id, ft.thread_id, ft.group_id, ft.title, fp.user_id AS post_user_id, fp.total_like, fpt.text_parsed AS text, fp.time_stamp, fpt.text AS normal_text, ' . Phpfox::getUserField())
			->from(Phpfox::getT('forum_post'), 'fp')			
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')
			->where('fp.post_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');	
		
		if (!isset($aRow['post_id']))
		{
			return false;
		}
		
		if ($bIsChildItem)
		{
			$aItem = $aRow;
		}		
		
		if (defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'forum.view_browse_forum')
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['group_id'] > 0 && !Phpfox::getService('pages')->hasPerm($aRow['group_id'], 'forum.view_browse_forum'))
			)
		{
			return false;
		}			
		
		$sLink = Phpfox::permalink('forum.thread', $aRow['thread_id'], $aRow['title'], false, null, array('view' => $aRow['post_id']));
		if ($aRow['user_id'] == $aRow['post_user_id'])
		{
			$sPhrase = Phpfox::getPhrase('feed.replied_on_gender_thread_a_href_link_title_a', array('gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'link' => $sLink, 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], (Phpfox::isModule('notification') ? Phpfox::getParam('notification.total_notification_title_length') : 50), '...')));	
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('feed.replied_on_a_href_user_name_full_name_a_s_thread_a_href_link_title_a', array('user_name' => Phpfox::getLib('url')->makeUrl($aRow['user_name']), 'full_name' => $aRow['full_name'], 'link' => $sLink, 'title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
		}

		// if (Phpfox::getParam('core.allow_html_in_activity_feed') && preg_match('/\[quote(.*)\]/i', $aRow['normal_text']))
		if (preg_match('/\[quote(.*)\]/i', $aRow['normal_text']))
		{
			$aRow['text'] = $aRow['normal_text'];
			$aRow['text'] = str_replace(array('&lt;p&gt;', '&lt;/p&gt;'), array('', ''), $aRow['text']);
			$aRow['text'] = Phpfox::getLib('parse.bbcode')->stripCode($aRow['text'], 'quote');
			$aRow['text'] = Phpfox::getLib('parse.input')->prepare($aRow['text']);						
			$aRow['text'] = trim($aRow['text'], '<br />');
		}	
		
		$aReturn = array(
			'feed_title' => '',
			'feed_info' => $sPhrase,
			'feed_link' => $sLink,
			'feed_content' => $aRow['text'],
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => isset($aRow['is_liked']) ? $aRow['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'module/forum.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => true,			
			'like_type_id' => 'forum_post',
			'custom_data_cache' => $aRow
		);
		
		if ($bIsChildItem)
		{
			$aReturn = array_merge($aReturn, $aItem);
		}		
		
		return $aReturn;
	}

	public function getActivityFeedCustomChecks($aRow)
	{
		if ((defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'forum.view_browse_forum'))
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['custom_data_cache']['group_id'] > 0 && !Phpfox::getService('pages')->hasPerm($aRow['custom_data_cache']['group_id'], 'forum.view_browse_forum'))
		)
		{
			return false;
		}

		return $aRow;
	}
	
	public function getActivityFeed($aItem)
	{
		$this->database()->select('ft.thread_id, ft.title, ft.group_id, ft.user_id, fp.total_like, fpt.text_parsed AS text, ft.time_stamp, fp.post_id')
			->from(Phpfox::getT('forum_thread'), 'ft')
			->join(Phpfox::getT('forum_post'), 'fp', 'fp.post_id = ft.start_id')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')
			->where('ft.thread_id = ' . (int) $aItem['item_id']);
			
		if(Phpfox::isModule('like'))
		{
			$this->database()->select(', l.type_id as like_type_id, l.like_id AS is_liked')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'forum_post\' AND l.item_id = fp.post_id AND l.user_id = ' . Phpfox::getUserId());
		}
			
		$aRow = $this->database()->execute('getSlaveRow');	
		if (!isset($aRow['thread_id']))
		{
			return false;
		}
		
		if (((Phpfox::isModule('pages') && defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getService('pages')->hasPerm(null, 'forum.view_browse_forum') == false) ||
		(!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['group_id'] > 0 && Phpfox::isModule('pages') && !Phpfox::getService('pages')->hasPerm($aRow['group_id'], 'forum.view_browse_forum'))))
		{
			return false;
		}		
		
		$sLink = Phpfox::permalink('forum.thread', $aRow['thread_id'], $aRow['title'], false, null);
		$aRow['feed_info'] = Phpfox::getPhrase('feed.posted_a_thread');
		$aRow['feed_icon'] = Phpfox::getLib('image.helper')->display(array('theme' => 'module/forum.png', 'return_url' => true));
		
		(($sPlugin = Phpfox_Plugin::get('forum.component_service_callback_getactivityfeed__1')) ? eval($sPlugin) : false);
		
		$aOut = array(
			'feed_title' => $aRow['title'],
			'feed_info' => $aRow['feed_info'],
			'feed_link' => $sLink,
			'feed_content' => $aRow['text'],
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => isset($aRow['is_liked']) ? $aRow['is_liked'] : false,
			'feed_icon' => $aRow['feed_icon'],
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => true,			
			'like_type_id' => (!empty($aRow['like_type_id']) ? $aRow['like_type_id'] : 'forum_post'),//'forum_post',
			'like_item_id' => $aRow['post_id'],
			'custom_data_cache' => $aRow
		);
		if ($aItem['type_id'] == 'forum')
		{
			$aOut['like_type_id'] = 'forum_post';
		}
		return $aOut;
	}	
	
	public function globalUnionSearch($sSearch)
	{
		$this->database()->select('item.thread_id AS item_id, item.title AS item_title, item.time_stamp AS item_time_stamp, item.user_id AS item_user_id, \'forum\' AS item_type_id, \'\' AS item_photo, \'\' AS item_photo_server')
			->from(Phpfox::getT('forum_thread'), 'item')
			->where('item.view_id = 0 AND ' . $this->database()->searchKeywords('item.title', $sSearch) . '')
			->union();
	}	
	
	public function getSearchInfo($aRow)
	{
		$aInfo = array();
		$aInfo['item_link'] = Phpfox::getLib('url')->permalink('forum.thread', $aRow['item_id'], $aRow['item_title']);
		$aInfo['item_name'] = Phpfox::getPhrase('search.forum_thread');
		
		return $aInfo;
	}
	
	public function getSearchTitleInfo()
	{
		return array(
			'name' => Phpfox::getPhrase('forum.forum_threads')
		);
	}	
	
	public function getPageMenu($aPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'forum.view_browse_forum'))
		{
			return null;
		}		
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('pages.discussions'),
			'url' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']) . 'forum/',
			'icon' => 'module/forum.png',
			'landing' => 'forum'
		);
		
		return $aMenus;
	}	
	
	public function getPageSubMenu($aPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'forum.share_forum'))
		{
			return null;
		}		
		
		return array(
			array(
				'phrase' => Phpfox::getPhrase('forum.post_a_new_thread'),
				'url' => Phpfox::getLib('url')->makeUrl('forum.post.thread', array('module' => 'pages', 'item' => $aPage['page_id']))
			)
		);
	}	
	
	public function getPagePerms()
	{
		$aPerms = array();
		
		$aPerms['forum.share_forum'] = Phpfox::getPhrase('forum.who_can_start_a_discussion');
		$aPerms['forum.view_browse_forum'] = Phpfox::getPhrase('forum.who_can_view_browse_discussions');
		
		return $aPerms;
	}
	
	public function canViewPageSection($iPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($iPage, 'forum.view_browse_forum'))
		{
			return false;
		}
		
		return true;
	}	

		/**
	 * @description This function filters out thread ids from search results.
	 * @param $aResults Array from search->query it has thread_ids and we need to find their forum
	 * @return the ids of the threads that are not allowed to be shown
	 * */
	public function filterSearchResults($aResults)
	{
		$sInts = implode(',', $aResults);
		preg_match('/([0-9,]*)/', $sInts, $aMatches);

		if (!isset($aMatches[1]) || empty($aMatches[1]))
		{
			return array();
		}

		$aRows = $this->database()
			->select('ft.thread_id as item_id, "forum" as item_type_id')
			->from(Phpfox::getT('forum_access'), 'fa')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.forum_id = fa.forum_id')
			->where('ft.thread_id IN (' . $aMatches[1] .') AND fa.user_group_id = ' . Phpfox::getUserBy('user_group_id') .' AND fa.var_value = 0 AND (fa.var_name = "can_view_forum" OR fa.var_name = "can_view_thread_content")' )
			->execute('getSlaveRows');

		return $aRows;
	}
	
	public function getActions()
	{
		return array(
			'dislike' => array(
				'enabled' => true,
				'action_type_id' => 2, // 2 = dislike
				'phrase' => Phpfox::getPhrase('like.dislike'),
				'item_type_id' => 'forum-reply', // used to differentiate between photo albums and photos for example.
				'phrase_in_past_tense' => 'disliked',
				'table' => 'forum_post',
				'item_phrase' => Phpfox::getPhrase('forum.item_phrase'),
				'column_update' => 'total_dislike',
				'column_find' => 'post_id'				
				)
		);
	}
	
	public function onUserUpdate($aVals)
	{
		if (!isset($aVals['full_name']) || empty($aVals['full_name']) || !isset($aVals['prev_full_name']) || empty($aVals['prev_full_name']))
		{
			return false;
		}
		$this->database()->update(Phpfox::getT('forum_post'), array(
			'update_user' => $aVals['full_name']
			), 
			'user_id = ' . Phpfox::getUserId() . ' AND update_user = "'. $aVals['prev_full_name']. '"');
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_callback__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

	private function _getChild($iForum)
	{
		$aForum = $this->database()->select('f.forum_id')
			->from(Phpfox::getT('forum'), 'f')				
			->where('parent_id = ' . (int) $iForum)
			->execute('getSlaveRow');		
				
		return (isset($aForum['forum_id']) ? $this->_getChild($aForum['forum_id']) : $iForum);			
	}
}

?>
