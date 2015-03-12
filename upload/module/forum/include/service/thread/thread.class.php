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
 * @package 		Phpfox_Service
 * @version 		$Id: thread.class.php 7066 2014-01-27 14:37:10Z Fern $
 */
class Forum_Service_Thread_Thread extends Phpfox_Service 
{	
	private $_bIsSearch = false;
	
	private $_bIsTagSearch = false;
	
	private $_bIsNewSearch = false;
	
	private $_isSubscribeSearch = false;
	
	private $_bIsModuleTagSearch = false;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('forum_thread');	
	}
	
	public function isSearch($bIsSearch = true)
	{
		$this->_bIsSearch = $bIsSearch;		
		
		return $this;
	}
	
	public function isTagSearch($bIsTagSearch = false)
	{
		$this->_bIsTagSearch = $bIsTagSearch;		
		
		return $this;
	}		
	
	public function isNewSearch($bIsNewSearch = false)
	{
		$this->_bIsNewSearch = $bIsNewSearch;		
		
		return $this;
	}
	
	public function isSubscribeSearch($bIsSubscribeSearch)
	{
		$this->_isSubscribeSearch = $bIsSubscribeSearch;
		
		return $this;
	}
	
	public function isModuleSearch($bIsModuleTagSearch)
	{
		$this->_bIsModuleTagSearch = $bIsModuleTagSearch;
		
		return $this;
	}
	
	public function getNewTimeStamp()
	{
		$iJoined = Phpfox::getUserBy('joined');
		$iOld =  (PHPFOX_TIME - (Phpfox::getParam('forum.keep_active_posts') * 60));
		
		return ($iJoined > $iOld ? $iJoined : $iOld);
	}
	
	public function get($mConditions = array(), $sOrder = 'ft.time_update DESC', $iPage = '', $iPageSize = '', $bCount = true)
	{
		$aThreads = array();

		if ($this->_bIsTagSearch !== false)
		{
			$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', "tag.item_id = ft.thread_id AND tag.category_id = '" . ($this->_bIsModuleTagSearch ? 'forum_group' : 'forum') . "'");
		}
		
		if ($this->_bIsNewSearch !== false)
		{
			$mConditions[] = 'AND ft.time_update > \'' . $this->getNewTimeStamp() . '\'';			
		}
		
		if ($this->_isSubscribeSearch !== false)
		{
			$this->database()->join(Phpfox::getT('forum_subscribe'), 'fs', 'fs.thread_id = ft.thread_id AND fs.user_id = ' . Phpfox::getUserId());
		}		
		
		$iCnt = ($bCount ? $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'ft')			
			->where($mConditions)
			->execute('getSlaveField') : true);
		
		if ($iCnt)
		{						
				if ($this->_bIsTagSearch !== false)
				{
					$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', "tag.item_id = ft.thread_id AND tag.category_id = '" . ($this->_bIsModuleTagSearch ? 'forum_group' : 'forum') . "'");
				}		
			
				if ($this->_bIsSearch === true)
				{
					$this->database()->select('f.name AS forum_name, f.name_url AS forum_url, ')->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id');					
				}						
				
				if ($this->_bIsNewSearch !== false)
				{
					$mConditions[] = 'AND ft.time_update > \'' . $this->getNewTimeStamp() . '\'';
				}				
							
				if ($this->_isSubscribeSearch !== false)
				{
					$this->database()->join(Phpfox::getT('forum_subscribe'), 'fs', 'fs.thread_id = ft.thread_id AND fs.user_id = ' . Phpfox::getUserId());
				}
				
				if (Phpfox::getParam('forum.forum_database_tracking'))
				{
					$this->database()->select('ftr.thread_id AS is_seen, ftr.time_stamp AS last_seen_time, ')->leftJoin(Phpfox::getT('forum_thread_track'), 'ftr', 'ftr.thread_id = ft.thread_id AND ftr.user_id = ' . Phpfox::getUserId());	
				}
				
				(($sPlugin = Phpfox_Plugin::get('forum.service_thread_get_query')) ? eval($sPlugin) : false);
				
				if (isset($bLeftJoinQuery))
				{				
					$this->database()->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id');
				}
				else 
				{
					$this->database()->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id');
				}				
				
				$aThreads = $this->database()->select('ft.*, ' . Phpfox::getUserField() . ', ' . Phpfox::getUserField('u2', 'last_') . '')				
					->from($this->_sTable, 'ft')
					->leftJoin(Phpfox::getT('user'), 'u2', 'u2.user_id = ft.last_user_id')
					->where($mConditions)
					->order($sOrder)
					->limit($iPage, $iPageSize, $iCnt)
					->execute('getSlaveRows');
			
			foreach ($aThreads as $iKey => $aThread)
			{
				$sCss = 'new';
				if ($aThread['is_closed'])
				{
					$sCss = 'closed';	
				}
				else 
				{
					if (!isset($aThread['is_seen']))
					{
						$aThread['is_seen'] = 0;
					}					
					
					// Thread not seen
					if (!$aThread['is_seen'])
					{						
						// User has signed up after the post so they have already seen the post
						if ((Phpfox::isUser() && Phpfox::getUserBy('joined') > $aThread['time_update']) || (!Phpfox::isUser() && Phpfox::getCookie('visit') > $aThread['time_update']))
						{
							$sCss = 'old';
						}
						elseif (($iLastTimeViewed = Phpfox::getLib('session')->getArray('forum_view', $aThread['thread_id'])) && (int) $iLastTimeViewed > $aThread['time_update'])
						{
							$sCss = 'old';							
						}						
						// Checks if the post is older then our default active post time limit
						elseif ((PHPFOX_TIME - Phpfox::getParam('forum.keep_active_posts') * 60) > $aThread['time_update'])
						{						
							$sCss = 'old';				
						}	
						elseif (!empty($aThread['time_update']) && Phpfox::isUser() && $aThread['time_update'] < Phpfox::getCookie('last_login'))
						{
							$sCss = 'old';	
						}				
					}
					else 
					{						
						// New post was added
						if ($aThread['time_update'] <= $aThread['last_seen_time'])
						{
							$sCss = 'old';							
						}											
					}
				}								
				
				$aThreads[$iKey]['css_class'] = $sCss;
				switch ($sCss)
				{
					case 'new':
						$sCssPhrase = Phpfox::getPhrase('forum.thread_contains_new_posts');
						break;
					case 'old':
						$sCssPhrase = Phpfox::getPhrase('forum.no_new_posts');
						break;
					case 'closed':
						$sCssPhrase = Phpfox::getPhrase('forum.thread_is_closed');
						break;
				}
				$aThreads[$iKey]['css_class_phrase'] = $sCssPhrase;
			}		
		}
		
		if (!$bCount)
		{
			return $aThreads;
		}
		
		return array($iCnt, $aThreads);
	}
	
	public function getSearch($mConditions = array(), $sOrder = 'ft.time_update DESC')
	{
		if ($this->_bIsNewSearch !== false)
		{
			$mConditions[] = 'AND ft.time_update > \'' . $this->getNewTimeStamp() . '\' AND ' . $this->database()->isNull('ftr.thread_id');
			$this->database()->leftJoin(Phpfox::getT('forum_thread_track'), 'ftr', 'ftr.thread_id = ft.thread_id AND ftr.user_id = ' . Phpfox::getUserId());
		}		
		
		$aThreads = $this->database()->select('ft.thread_id')
			->from($this->_sTable, 'ft')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id')				
			->where($mConditions)
			->order($sOrder)				
			->execute('getSlaveRows');	
	
		$aSearchIds = array();
		foreach ($aThreads as $aThread)
		{
			$aSearchIds[] = $aThread['thread_id'];
		}	
		
		return $aSearchIds;		
	}
	
	public function getAnnoucements($iForumId = null, $iGroupId = null)
	{
		if ($iForumId !== null)
		{		
			$aAnnouncements = $this->database()->select('ft.*, ' . Phpfox::getUserField())
				->from(Phpfox::getT('forum_announcement'), 'fa')
				->join($this->_sTable, 'ft', 'ft.thread_id = fa.thread_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id')
				->where('fa.forum_id = ' . (int) $iForumId)
				->order('ft.time_update DESC')
				->execute('getRows');
		}
		else 
		{
			$aAnnouncements = $this->database()->select('ft.*, ' . Phpfox::getUserField())
				->from($this->_sTable, 'ft')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id')
				->where('ft.group_id = ' . (int) $iGroupId . ' AND ft.view_id = 0 AND ft.is_announcement = 1')
				->order('ft.time_update DESC')
				->execute('getRows');			
				
		}
	
		foreach ($aAnnouncements as $iKey => $aAnnouncement)
		{			
			$aAnnouncements[$iKey]['css_class'] = 'old';
			$aAnnouncements[$iKey]['css_class_phrase'] = Phpfox::getPhrase('forum.no_new_posts');
			$aAnnouncements[$iKey]['time_stamp_phrase'] = Phpfox::getTime(Phpfox::getParam('forum.forum_time_stamp'), $aAnnouncement['time_stamp']);
		}
		
		return $aAnnouncements;
	}
	
	public function getForRedirect($iId)
	{
		$aThread = $this->database()->select('ft.thread_id, ft.forum_id, ft.group_id, ft.title_url, f.name_url AS forum_url')
			->from($this->_sTable, 'ft')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
			->where('ft.thread_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aThread['thread_id']))
		{
			return false;
		}
		
		return $aThread;
	}
	
	public function getThread($aThreadCondition = array(), $mConditions = array(), $sOrder = 'fp.time_stamp ASC', $iPage = '', $iPageSize = '', $sPermaView = null)
	{
		if (Phpfox::getParam('forum.forum_database_tracking'))
		{
			$this->database()->select('ftr.thread_id AS is_seen, ftr.time_stamp AS last_seen_time, ')->leftJoin(Phpfox::getT('forum_thread_track'), 'ftr', 'ftr.thread_id = ft.thread_id AND ftr.user_id = ' . Phpfox::getUserId());
		}		

		$aThread = $this->database()->select('ft.thread_id, ft.time_stamp, ft.time_update, ft.group_id, ft.view_id, ft.forum_id, ft.is_closed, ft.user_id, ft.is_announcement, ft.order_id, ft.title_url, ft.time_update AS last_time_stamp, ft.title, fs.subscribe_id AS is_subscribed, ft.poll_id')		
			->from($this->_sTable, 'ft')
			->leftJoin(Phpfox::getT('forum_subscribe'), 'fs', 'fs.thread_id = ft.thread_id AND fs.user_id = ' . Phpfox::getUserId())
			->where($aThreadCondition)
			->execute('getSlaveRow');
		
		if (!isset($aThread['thread_id']))
		{
			return array(0, array());
		}
		
		if (!isset($aThread['is_seen']))
		{
			$aThread['is_seen'] = 0;
		}
		
		// Thread not seen
		if (!$aThread['is_seen'])
		{			
			// User has signed up after the post so they have already seen the post
			if ((Phpfox::isUser() && Phpfox::getUserBy('joined') > $aThread['last_time_stamp']) || (!Phpfox::isUser() && Phpfox::getCookie('visit') > $aThread['last_time_stamp']))
			{
				$aThread['is_seen'] = 1;												
			}
			elseif (($iLastTimeViewed = Phpfox::getLib('session')->getArray('forum_view', $aThread['thread_id'])) && (int) $iLastTimeViewed > $aThread['last_time_stamp'])
			{
				$aThread['is_seen'] = 1;							
			}
			// Checks if the post is older then our default active post time limit
			elseif ((PHPFOX_TIME - Phpfox::getParam('forum.keep_active_posts') * 60) > $aThread['last_time_stamp'])
			{						
				$aThread['is_seen'] = 1;								
			}			
			// http://www.phpfox.com/tracker/view/14893/
			/*elseif (!empty($aThread['last_time_stamp']) && Phpfox::isUser() && $aThread['last_time_stamp'] < Phpfox::getCookie('last_login'))
			{
				$aThread['is_seen'] = 1;
			}*/
		}
		else 
		{		
			// New post was added
			if ($aThread['last_time_stamp'] > $aThread['last_seen_time'])
			{
				$aThread['is_seen'] = 0;
			}					
		}
		
		$sViewId = ' AND fp.view_id = 0';
		if (Phpfox::getUserParam('forum.can_approve_forum_post') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'approve_post'))
		{
			$sViewId = '';				
		}
		
		$mConditions[] = 'fp.thread_id = ' . $aThread['thread_id'] . $sViewId;
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('forum_post'), 'fp')
			->where($mConditions)
			->execute('getSlaveField');
			
		$aThread['last_update_on'] = '';
		
		if ($sPermaView !== null)
		{
			$iCurrentPage = Phpfox::getService('forum.post')->getPostPage($aThread['thread_id'], $sPermaView, $iPageSize);	
			$mConditions[] = 'AND fp.post_id = ' . (int) $sPermaView;			
		}
		
		if (!empty($aThread['poll_id']) && Phpfox::isModule('poll'))
		{
			$aThread['poll'] = Phpfox::getService('poll')->getPollByUrl((int) $aThread['poll_id']);
			$aThread['poll']['bCanEdit'] = false;
		}
		
		(($sPlugin = Phpfox_Plugin::get('forum.service_thread_getthread_query')) ? eval($sPlugin) : false);
		
		if (isset($bLeftJoinQuery))
		{
			$this->database()->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')->leftJoin(Phpfox::getT('user_field'), 'uf', 'uf.user_id = fp.user_id');
		}
		else 
		{
			$this->database()->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = fp.user_id');
		}

		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'forum_post\' AND l.item_id = fp.post_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aThread['posts'] = $this->database()->select('fp.*, ' . (Phpfox::getParam('core.allow_html') ? 'fpt.text_parsed' : 'fpt.text') . ' AS text, ' . Phpfox::getUserField() . ', u.joined, u.country_iso, uf.signature, uf.total_post')
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')			
			->where($mConditions)
			->order($sOrder)
			->limit($iPage, $iPageSize, $iCnt)
			->execute('getSlaveRows');
					
		$sPostIds = '';
		$iTotal = ($iPage > 1 ? (($iPageSize * $iPage) - $iPageSize) : 0);		
		foreach ($aThread['posts'] as $iKey => $aPost)
		{
			$iTotal++;
			$aThread['posts'][$iKey]['count'] = ($sPermaView === null ? $iTotal : Phpfox::getService('forum.post')->getPostCount());
			$aThread['posts'][$iKey]['forum_id'] = $aThread['forum_id'];
			$aThread['posts'][$iKey]['last_update_on'] = Phpfox::getPhrase('forum.last_update_on_time_stamp_by_update_user', array(
					'time_stamp' => Phpfox::getTime(Phpfox::getParam('forum.forum_time_stamp'), $aPost['update_time']),
					'update_user' => $aPost['update_user']				
				)
			);
			
			$aThread['posts'][$iKey]['aFeed'] = array(				
				'privacy' => 0,
				'comment_privacy' => 0,
				'like_type_id' => 'forum_post',
				'feed_is_liked' => ($aPost['is_liked'] ? true : false),
				'item_id' => $aPost['post_id'],
				'user_id' => $aPost['user_id'],
				'total_like' => $aPost['total_like'],
				'feed_link' => Phpfox::permalink('forum.thread', $aThread['thread_id'], $aThread['title']) . 'view_' . $aPost['post_id'] . '/',
				'feed_title' => $aThread['title'],
				'feed_display' => 'mini',
				'feed_total_like' => $aPost['total_like'],
				'report_module' => 'forum_post',
				'report_phrase' => Phpfox::getPhrase('forum.report_this_post'),
				'force_report' => true,
				'time_stamp' => $aPost['time_stamp'],
				'type_id' => 'forum_post'
			);
			
			if(Phpfox::isModule('like') && Phpfox::isModule('feed'))
			{
				$aThread['posts'][$iKey]['aFeed']['feed_like_phrase'] = Phpfox::getService('feed')->getPhraseForLikes($aThread['posts'][$iKey]['aFeed']);
			}
			
			if ($aPost['total_attachment'])
			{
				$sPostIds .= $aPost['post_id'] . ',';
			}
		}
		$sPostIds = rtrim($sPostIds, ',');		

		if (!empty($sPostIds))
		{
			list($iAttachmentCnt, $aAttachments) = Phpfox::getService('attachment')->get('attachment.item_id IN(' . $sPostIds . ') AND attachment.view_id = 0 AND attachment.category_id = \'forum\' AND attachment.is_inline = 0', 'attachment.attachment_id DESC', '', '', false);				

			$aAttachmentCache = array();
			foreach ($aAttachments as $aAttachment)
			{
				$aAttachmentCache[$aAttachment['item_id']][] = $aAttachment;	
			}		
			
			foreach ($aThread['posts'] as $iKey => $aPost)
			{
				if (isset($aAttachmentCache[$aPost['post_id']]))
				{
					$aThread['posts'][$iKey]['attachments'] = $aAttachmentCache[$aPost['post_id']];
				}
			}			
		}
				
		return array($iCnt, $aThread);
	}
	
	public function getActualThread($iId, $aCallback = false)
	{
		if ($aCallback === false)
		{
			$this->database()->select('f.forum_id, f.name_url AS forum_url, f.is_closed AS forum_is_closed, ')->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id');
		}
		
		$aRow = $this->database()->select('ft.*, fs.subscribe_id AS is_subscribed')
			->from($this->_sTable, 'ft')			
			->leftJoin(Phpfox::getT('forum_subscribe'), 'fs', 'fs.thread_id = ft.thread_id AND fs.user_id = ' . Phpfox::getUserId())
			->where('ft.thread_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		$aRow['is_subscribed'] = ($aRow['is_subscribed'] > 0 ? '1' : '0');
		
		return $aRow;
	}	
	
	public function getForEdit($iId)
	{
		if (Phpfox::isModule('poll'))
		{
			$this->database()->select('p.question AS poll_question, ')->leftJoin(Phpfox::getT('poll'), 'p', 'p.poll_id = ft.poll_id');
		}
		
		$aThread = $this->database()->select('ft.*, fpt.text, f.name_url AS forum_url')
			->from($this->_sTable, 'ft')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = ft.start_id')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
			->where('ft.thread_id = ' . (int) $iId)
			->execute('getSlaveRow');	
			
		if ($aThread['is_announcement'])
		{
			$aThread['type_id'] = 'announcement';
		}
		elseif ($aThread['order_id'])
		{
			$aThread['type_id'] = 'sticky';
		}		
			
		return $aThread;	
	}
	
	public function getForRss($iLimit, $sForumIds = null, $iGroupId = 0)
	{
		$aCond = array();
		if ($sForumIds !== null)
		{
			$aCond[] = 'AND ft.forum_id IN(' . $sForumIds . ')';
		}
		$aCond[] = 'AND ft.group_id = ' . (int) $iGroupId . ' AND ft.view_id = 0 AND ft.is_announcement = 0';
		
		$sNotAllowed = Phpfox::getService('forum')->getCanViewForumAccess('can_view_forum');
		if (!empty($sNotAllowed))
		{
			$aCond[] = 'AND ft.forum_id NOT IN(' . $sNotAllowed . ')';
		}		
		$aRows = $this->database()->select('ft.thread_id, ft.title, ft.title_url, ft.forum_id, ft.group_id, ft.time_stamp, ' . (Phpfox::getParam('core.allow_html') ? 'fpt.text_parsed' : 'fpt.text') . ' AS description, f.name AS forum_name, f.name_url AS forum_url, ' . Phpfox::getUserField())
			->from($this->_sTable, 'ft')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = ft.start_id')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
			->where($aCond)
			->limit($iLimit)
			->order('ft.time_stamp DESC')
			->execute('getSlaveRows');
		
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['link'] = Phpfox::permalink('forum.thread', $aRow['thread_id'], $aRow['title']);
			$aRows[$iKey]['creator'] = $aRow['full_name'];
		}
			
		return $aRows;
	}	
	
	public function getForParent($iGroup)
	{
		$aRows = $this->database()->select('ft.title, ft.title_url, ft.time_stamp, ' . Phpfox::getUserField())
			->from($this->_sTable, 'ft')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ft.user_id')
			->where('ft.group_id = ' . (int) $iGroup . ' AND ft.view_id = 0 AND ft.is_announcement = 0')
			->limit(5)
			->order('ft.time_stamp DESC')
			->execute('getSlaveRows');
			
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['time_stamp_phrase'] = Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aRow['time_stamp']);
		}
			
		return $aRows;
	}
	
	public function getPendingThread()
	{
		return (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('forum_thread'))
			->where('view_id = 1')
			->execute('getSlaveField');
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_thread_thread__call'))
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
