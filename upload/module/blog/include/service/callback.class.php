<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Blog Callbacks
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: callback.class.php 7307 2014-05-08 14:35:44Z Fern $
 */
class Blog_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 *
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('blog');
	}
	
	public function getFeedDetails($iItemId)
	{
		return array(
				'module' => 'blog',
				'table_prefix' => 'blog_',
				'item_id' => $iItemId
		);
	}	

	public function getSiteStatsForAdmin($iStartTime, $iEndTime)
	{
		$aCond = array();
		$aCond[] = 'is_approved = 1 AND post_status = 1';
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
			'phrase' => 'blog.blogs',
			'total' => $iCnt
		);
	}	
	
	public function mobileMenu()
	{
		return array(
			'phrase' => Phpfox::getPhrase('blog.blogs'),
			'link' => Phpfox::getLib('url')->makeUrl('blog'),
			'icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'mobile/small_blogs.png'))
		);
	}	
	
	/**
	 * Used for the function core.callback::getRedirection
	 * @return <type>
	 */
	public function getRedirectionTable()
	{
		return Phpfox::getT('blog_redirect');
	}

	public function getTags($sTag, $aConds = array(), $sSort = '', $iPage = '', $sLimit = '')
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettags__start')) ? eval($sPlugin) : false);
		$aBlogs = array();
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('blog'), 'blog')
			->innerJoin(Phpfox::getT('tag'), 'tag', "tag.item_id = blog.blog_id")
			->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
			->where($aConds)
			->execute('getSlaveField');	

		if ($iCnt)
		{
			$aRows = $this->database()->select("blog.*, " . (Phpfox::getParam('core.allow_html') ? "blog_text.text_parsed" : "blog_text.text") ." AS text, " . Phpfox::getUserField())
				->from(Phpfox::getT('blog'), 'blog')
				->innerJoin(Phpfox::getT('tag'), 'tag', "tag.item_id = blog.blog_id")
				->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
				->join(Phpfox::getT('user'), 'u', 'blog.user_id = u.user_id')
				->where($aConds)
				->order($sSort)
				->limit($iPage, $sLimit, $iCnt)				
				->execute('getSlaveRows');	
						
			if (count($aRows))
			{
				foreach ($aRows as $aRow)
				{
					$aBlogs[$aRow['blog_id']] = $aRow;
				}						
			}
		}		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettags__end')) ? eval($sPlugin) : false);
		return array($iCnt, $aBlogs);
	}	
	
	public function getTagSearch($aConds = array(), $sSort)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettagsearch__start')) ? eval($sPlugin) : false);
		$aRows = $this->database()->select("blog.blog_id AS id")
			->from(Phpfox::getT('blog'), 'blog')
			->innerJoin(Phpfox::getT('tag'), 'tag', "tag.item_id = blog.blog_id")
			->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
			->where($aConds)
			->order($sSort)	
			->group('blog.blog_id')
			->execute('getSlaveRows');							
		
		$aSearchIds = array();
		foreach ($aRows as $aRow)
		{
			$aSearchIds[] = $aRow['id'];
		}		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettagsearch__end')) ? eval($sPlugin) : false);
		return $aSearchIds;		
	}	
	
	public function getTagCloud()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettagcloud__start')) ? eval($sPlugin) : false);
		return array(
			'link' => 'blog',
			'category' => 'blog'
		);
	}
	
	public function getActivityFeedComment($aRow)
	{
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_mini\' AND l.item_id = c.comment_id AND l.user_id = ' . Phpfox::getUserId());
		}		
		
		$aItem = $this->database()->select('b.blog_id, b.title, b.time_stamp, b.total_comment, b.total_like, c.total_like, ct.text_parsed AS text, ' . Phpfox::getUserField())
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->join(Phpfox::getT('blog'), 'b', 'c.type_id = \'blog\' AND c.item_id = b.blog_id AND c.view_id = 0')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('c.comment_id = ' . (int) $aRow['item_id'])
			->execute('getSlaveRow');
		
		if (!isset($aItem['blog_id']))
		{
			return false;
		}
		
		$sLink = Phpfox::permalink('blog', $aItem['blog_id'], $aItem['title']);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aItem['title'], (Phpfox::isModule('notification') ? Phpfox::getParam('notification.total_notification_title_length') :50));
		$sUser = '<a href="' . Phpfox::getLib('url')->makeUrl($aItem['user_name']) . '">' . $aItem['full_name'] . '</a>';
		$sGender = Phpfox::getService('user')->gender($aItem['gender'], 1);
		
		if ($aRow['user_id'] == $aItem['user_id'])
		{
			$sMessage = Phpfox::getPhrase('blog.posted_a_comment_on_gender_blog_a_href_link_title_a', array('gender' => $sGender, 'link' => $sLink, 'title' => $sTitle));
		}
		else
		{			
			$sMessage = Phpfox::getPhrase('blog.posted_a_comment_on_user_name_s_blog_a_href_link_title_a', array('user_name' => $sUser, 'link' => $sLink, 'title' => $sTitle));
		}
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getactivityfeedcomment__1')) ? eval($sPlugin) : false);
		
		return array(
			'no_share' => true,
			'feed_info' => $sMessage,
			'feed_link' => $sLink,
			'feed_status' => $aItem['text'],
			'feed_total_like' => $aItem['total_like'],
			'feed_is_liked' => isset($aItem['is_liked']) ? $aItem['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'module/blog.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],
			'like_type_id' => 'feed_mini'
		);		
	}	
		
	public function canShareItemOnFeed(){}

	public function getActivityFeedCustomChecks($aRow)
	{
		if ((defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'blog.view_browse_blogs'))
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['custom_data_cache']['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aRow['custom_data_cache']['item_id'], 'blog.view_browse_blogs'))
		)
		{
			return false;
		}

		return $aRow;
	}
	
	public function getActivityFeed($aRow, $aCallback = null, $bIsChildItem = false)
	{
		if (!Phpfox::getUserParam('blog.view_blogs'))
		{
			return false;
		}
		
		if (Phpfox::isUser())
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'blog\' AND l.item_id = b.blog_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		if ($bIsChildItem)
		{
			$this->database()->select(Phpfox::getUserField('u2') . ', ')->join(Phpfox::getT('user'), 'u2', 'u2.user_id = b.user_id');
		}				
		
		$aRow = $this->database()->select('b.blog_id, b.title, b.time_stamp, b.total_comment, b.total_like, bt.text_parsed AS text, b.module_id, b.item_id')
			->from(Phpfox::getT('blog'), 'b')
			->join(Phpfox::getT('blog_text'), 'bt', 'bt.blog_id = b.blog_id')
			->where('b.blog_id = ' . (int) $aRow['item_id'])
			->execute('getSlaveRow');	

		if (!isset($aRow['blog_id']))
		{
			return false;
		}		
		
		// http://www.phpfox.com/tracker/view/15220/
		if (((defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'blog.view_browse_blogs'))
			|| (!defined('PHPFOX_IS_PAGES_VIEW') && $aRow['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aRow['item_id'], 'blog.view_browse_blogs')))
			)
		{
			return false;
		}
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getactivityfeed__1')) ? eval($sPlugin) : false);

		// http://www.phpfox.com/tracker/view/15450/
		$aRow['item_id'] = $aRow['blog_id'];

		return array_merge(array(
			'feed_title' => $aRow['title'],
			'feed_info' => Phpfox::getPhrase('feed.posted_a_blog'),
			'feed_link' => Phpfox::permalink('blog', $aRow['blog_id'], $aRow['title']),
			'feed_content' => $aRow['text'],
			'total_comment' => $aRow['total_comment'],
			'feed_total_like' => $aRow['total_like'],
			'feed_is_liked' => isset($aRow['is_liked']) ? $aRow['is_liked'] : false,
			'feed_icon' => Phpfox::getLib('image.helper')->display(array('theme' => 'module/blog.png', 'return_url' => true)),
			'time_stamp' => $aRow['time_stamp'],			
			'enable_like' => true,			
			'comment_type_id' => 'blog',
			'like_type_id' => 'blog',
			'custom_data_cache' => $aRow
		), $aRow);
	}
	
	public function addLike($iItemId, $bDoNotSendEmail = false)
	{
		$aRow = $this->database()->select('blog_id, title, user_id')
			->from(Phpfox::getT('blog'))
			->where('blog_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['blog_id']))
		{
			return false;
		}
		
		$this->database()->updateCount('like', 'type_id = \'blog\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'blog', 'blog_id = ' . (int) $iItemId);	
		
		if (!$bDoNotSendEmail)
		{
			$sLink = Phpfox::permalink('blog', $aRow['blog_id'], $aRow['title']);
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject(array('blog.full_name_liked_your_blog_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aRow['title'])))
				->message(array('blog.full_name_liked_your_blog_link_title', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aRow['title'])))
				->notification('like.new_like')
				->send();
					
			Phpfox::getService('notification.process')->add('blog_like', $aRow['blog_id'], $aRow['user_id']);
		}
	}
	
	public function getNotificationLike($aNotification)
	{
		$aRow = $this->database()->select('b.blog_id, b.title, b.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('blog'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
			
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'])
		{
			$sPhrase = Phpfox::getPhrase('blog.users_liked_gender_own_blog_title', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $sTitle));	
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('blog.users_liked_your_blog_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('blog.users_liked_span_class_drop_data_user_row_full_name_s_span_blog_title', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('blog', $aRow['blog_id'], $aRow['title']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);	
	}	
	
	public function deleteLike($iItemId)
	{
		$this->database()->updateCount('like', 'type_id = \'blog\' AND item_id = ' . (int) $iItemId . '', 'total_like', 'blog', 'blog_id = ' . (int) $iItemId);	
	}	
	
	public function getNewsFeed($aRow, $iUserId = null)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getnewsfeed__start')) ? eval($sPlugin) : false);
		
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		
		 
		$aRow['text'] = Phpfox::getPhrase('blog.owner_full_name_added_a_new_blog_a_href_title_link_title_a',
			array(
				'owner_full_name' => $aRow['owner_full_name'], 
				'title' => Phpfox::getService('feed')->shortenTitle($aRow['content']), 
				'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
				'title_link' => $aRow['link']				
			)
		);
		
		$aRow['icon'] = 'module/blog.png';
		$aRow['enable_like'] = true;
		$aRow['comment_type_id'] = 'blog';

		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getnewsfeed__end')) ? eval($sPlugin) : false);
		
		return $aRow;
	}	
	
	public function getCommentNewsFeed($aRow, $iUserId = null)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getcommentnewsfeed__start')) ? eval($sPlugin) : false);
		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');		

		if ($aRow['owner_user_id'] == $aRow['item_user_id'])
		{			
			$aRow['text'] = Phpfox::getPhrase('blog.user_added_a_new_comment_on_their_own_blog', array(
					'user_name' => $aRow['owner_full_name'],
					'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
					'title_link' => $aRow['link']
				)
			);
		}
		elseif ($aRow['item_user_id'] == Phpfox::getUserBy('user_id'))
		{			
			$aRow['text'] = Phpfox::getPhrase('blog.user_added_a_new_comment_on_your_blog', array(
					'user_name' => $aRow['owner_full_name'],
					'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
					'title_link' => $aRow['link']	
				)
			);
		}
		else 
		{			
			$aRow['text'] = Phpfox::getPhrase('blog.user_name_added_a_new_comment_on_item_user_name_blog', array(
					'user_name' => $aRow['owner_full_name'],
					'user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['user_id'])),
					'title_link' => $aRow['link'],
					'item_user_name' => $aRow['viewer_full_name'],
					'item_user_link' => $oUrl->makeUrl('feed.user', array('id' => $aRow['viewer_user_id']))
				)
			);
		}
		
		$aRow['text'] .= Phpfox::getService('feed')->quote($aRow['content']);
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getcommentnewsfeed__end')) ? eval($sPlugin) : false);
		return $aRow;
	}	
	
	public function getTopUsers()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettopusers__start')) ? eval($sPlugin) : false);
		
		$bShowQuery = true;
		if (Phpfox::getParam('blog.cache_top_bloggers'))
		{
			$sCacheId = $this->cache()->set('user_activity_blog');
			if ($aBlogs = $this->cache()->get($sCacheId, Phpfox::getParam('blog.cache_top_bloggers_limit')))
			{
				$bShowQuery = false;
			}
		}
		
		if ($bShowQuery)
		{
			$sCacheId = $this->cache()->set('user_activity_blog');
			$aBlogs = $this->database()->select(Phpfox::getUserField() . ', COUNT(b.blog_id) AS top_total')
				->from(Phpfox::getT('user'), 'u')
				->leftJoin(Phpfox::getT('blog'), 'b', 'b.user_id = u.user_id AND b.is_approved = 1 AND b.post_status = 1')
				->having('top_total > ' . Phpfox::getParam('blog.top_bloggers_min_post'))
				->order('top_total DESC')
				->group('u.user_id')
				->limit(Phpfox::getParam('blog.top_bloggers_display_limit'))
				->execute('getRows');
			
			if (Phpfox::getParam('blog.cache_top_bloggers'))
			{
				$this->cache()->save($sCacheId, $aBlogs);
			}
		}	
		
		if (is_array($aBlogs) && count($aBlogs))
		{
			foreach ($aBlogs as $iKey => $aBlog)
			{
				$aBlogs[$iKey]['link'] = Phpfox::getService('user')->getLink($aBlog['user_id'], $aBlog['user_name'], 'blog');
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettopusers__end')) ? eval($sPlugin) : false);
		
		return $aBlogs;
	}

	public function getTagLinkProfile($aUser)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettaglinkprofile__start')) ? eval($sPlugin) : false);
		return $this->getTagLink();
	}
	
	public function getTagLink()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_gettaglink__start')) ? eval($sPlugin) : false);
		$sExtra = '';
		if (defined('PHPFOX_TAG_PARENT_MODULE'))
		{
			$sExtra .= PHPFOX_TAG_PARENT_MODULE . '.' . PHPFOX_TAG_PARENT_ID . '.';
		}
		
		return Phpfox::getLib('url')->makeUrl($sExtra . 'blog.tag');
	}
	
	public function addTrack($iId, $iUserId = null)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_addtrack__start')) ? eval($sPlugin) : false);
		$this->database()->insert(Phpfox::getT('blog_track'), array(
				'item_id' => (int) $iId,
				'user_id' => Phpfox::getUserBy('user_id'),
				'time_stamp' => PHPFOX_TIME
			)
		);
	}	
	
	public function getLatestTrackUsers($iId, $iUserId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getlatesttrackusers__start')) ? eval($sPlugin) : false);
		$aRows = $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('blog_track'), 'track')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = track.user_id')
			->where('track.item_id = ' . (int) $iId . ' AND track.user_id != ' . (int) $iUserId)
			->order('track.time_stamp DESC')
			->limit(0, 6)
			->execute('getSlaveRows');
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getlatesttrackusers__end')) ? eval($sPlugin) : false);
		return (count($aRows) ? $aRows : false);		
	}

	public function getTagTypeProfile()
	{
		return 'blog';
	}
	
	public function getTagType()
	{
		return 'blog';
	}
	
	public function getFeedRedirect($iId, $iChild = 0)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getfeedredirect__start')) ? eval($sPlugin) : false);
		
		$aBlog = $this->database()->select('b.blog_id, b.title')
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $iId)
			->execute('getSlaveRow');		
			
		if (!isset($aBlog['blog_id']))
		{
			return false;
		}					

		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getfeedredirect__end')) ? eval($sPlugin) : false);
		
		return Phpfox::permalink('blog', $aBlog['blog_id'], $aBlog['title']);
	}
	
	public function getAjaxCommentVar()
	{
		return 'blog.can_post_comment_on_blog';
	}
	
	public function addComment($aVals, $iUserId = null, $sUserName = null)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_addcomment__start')) ? eval($sPlugin) : false);
		
		$aBlog = $this->database()->select('u.full_name, u.user_id, u.gender, u.user_name, b.title, b.blog_id, b.privacy, b.privacy_comment')
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $aVals['item_id'])
			->execute('getSlaveRow');
		
		if ($iUserId === null)
		{
			$iUserId = Phpfox::getUserId();
		}
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add($aVals['type'] . '_comment', $aVals['comment_id'], 0, 0, 0, $iUserId) : null);
		
		// Update the post counter if its not a comment put under moderation or if the person posting the comment is the owner of the item.
		if (empty($aVals['parent_id']))
		{
			$this->database()->updateCounter('blog', 'total_comment', 'blog_id', $aVals['item_id']);
		}
		
		// Send the user an email
		$sLink = Phpfox::permalink('blog', $aBlog['blog_id'], $aBlog['title']);
		
		Phpfox::getService('comment.process')->notify(array(
				'user_id' => $aBlog['user_id'],
				'item_id' => $aBlog['blog_id'],
				'owner_subject' => Phpfox::getPhrase('blog.full_name_commented_on_your_blog_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aBlog['title'])),
				'owner_message' => Phpfox::getPhrase('blog.full_name_commented_on_your_blog_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aBlog['title'])),
				'owner_notification' => 'comment.add_new_comment',
				'notify_id' => 'comment_blog',
				'mass_id' => 'blog',
				'mass_subject' => (Phpfox::getUserId() == $aBlog['user_id'] ? Phpfox::getPhrase('blog.full_name_commented_on_gender_blog', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' =>  Phpfox::getService('user')->gender($aBlog['gender'], 1))) : Phpfox::getPhrase('blog.full_name_commented_on_blog_full_name_s_blog', array('full_name' => Phpfox::getUserBy('full_name'), 'blog_full_name' => $aBlog['full_name']))),
				'mass_message' => (Phpfox::getUserId() == $aBlog['user_id'] ? Phpfox::getPhrase('blog.full_name_commented_on_gender_blog_message', array('full_name' => Phpfox::getUserBy('full_name'), 'gender' => Phpfox::getService('user')->gender($aBlog['gender'], 1), 'link' => $sLink, 'title' => $aBlog['title'])) : Phpfox::getPhrase('blog.full_name_commented_on_blog_full_name_s_blog_message', array('full_name' => Phpfox::getUserBy('full_name'), 'blog_full_name' => $aBlog['full_name'], 'link' => $sLink, 'title' => $aBlog['title'])))
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_addcomment__end')) ? eval($sPlugin) : false);
	}	
	
	public function updateCommentText($aVals, $sText)
	{
		
	}		
	
	public function getItemName($iId, $sName)
	{
		return Phpfox::getPhrase('blog.a_href_link_on_name_s_blog_a', array('link' => Phpfox::getLib('url')->makeUrl('comment.view', array('id' => $iId)), 'name' => $sName));
	}	
	
	public function getAttachmentField()
	{
		return array('blog', 'blog_id');
	}
	
	public function getProfileLink()
	{
		return 'profile.blog';
	}
	
	public function getCommentItem($iId)
	{
		$aRow = $this->database()->select('blog_id AS comment_item_id, privacy_comment, user_id AS comment_user_id')
			->from($this->_sTable)
			->where('blog_id = ' . (int) $iId)
			->execute('getSlaveRow');		
			
		$aRow['comment_view_id'] = '0';
		
		if (!Phpfox::getService('comment')->canPostComment($aRow['comment_user_id'], $aRow['privacy_comment']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('blog.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
			
			unset($aRow['comment_item_id']);
		}
			
		return $aRow;
	}
	
	public function getRssTitle($iId)
	{
		$aRow = $this->database()->select('title')
			->from($this->_sTable)
			->where('blog_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		return 'Comments on: ' . $aRow['title'];
	}	
	
	public function getRedirectComment($iId)
	{
		return $this->getFeedRedirect($iId);
	}
	
	public function getReportRedirect($iId)
	{
		return $this->getFeedRedirect($iId);
	}
	
	public function getCommentItemName()
	{
		return 'blog';
	}
	
	public function processCommentModeration($sAction, $iId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_processcommentmoderation__start')) ? eval($sPlugin) : false);
		// Is this comment approved?
		if ($sAction == 'approve')
		{			
			// Update the blog count
			Phpfox::getService('blog.process')->updateCounter($iId);
			
			// Get the blogs details so we can add it to our news feed
			$aBlog = $this->database()->select('b.blog_id, b.user_id, b.title, b.title_url, ct.text_parsed, c.user_id AS comment_user_id, c.comment_id')			
				->from($this->_sTable, 'b')								
				->join(Phpfox::getT('comment'), 'c', 'c.type_id = \'blog\' AND c.item_id = b.blog_id')
				->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')				
				->where('b.blog_id = ' . (int) $iId)
				->execute('getSlaveRow');
				
			// Add to news feed			
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('comment_blog', $aBlog['blog_id'], $aBlog['text_parsed'], $aBlog['comment_user_id'], $aBlog['user_id'], $aBlog['comment_id']) : null);
			
			// Send the user an email
			if (Phpfox::getParam('core.is_personal_site'))
			{
				$sLink = Phpfox::getLib('url')->makeUrl('blog', $aBlog['title_url']);
			}		
			else 
			{
				$sLink = Phpfox::getService('user')->getLink(Phpfox::getUserId(), Phpfox::getUserBy('user_name'), array('blog', $aBlog['title_url']));
			}
			
			Phpfox::getLib('mail')->to($aBlog['comment_user_id'])
				->subject(array('comment.full_name_approved_your_comment_on_site_title', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('comment.full_name_approved_your_comment_on_site_title_message', array(
							'full_name' => Phpfox::getUserBy('full_name'),
							'site_title' => Phpfox::getParam('core.site_title'),
							'link' => $sLink
						)
					)
				)
				->notification('comment.approve_new_comment')
				->send();							
		}
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_processcommentmoderation__end')) ? eval($sPlugin) : false);
	}
	
	public function getWhatsNew()
	{
		return array(
			'blog.blogs_title' => array(
				'ajax' => '#blog.getNew?id=js_new_item_holder',
				'id' => 'blog',
				'block' => 'blog.new'
			)
		);
	}

	public function globalSearch($sQuery, $bIsTagSearch = false)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_globalsearch__start')) ? eval($sPlugin) : false);
		$sCondition = 'b.is_approved = 1 AND b.privacy = 1 AND b.post_status = 1';
		if ($bIsTagSearch == false)
		{
			$sCondition .= ' AND (b.title LIKE \'%' . $this->database()->escape($sQuery) . '%\' OR bt.text_parsed LIKE \'%' . $this->database()->escape($sQuery) . '%\')';
		}		
		
		if ($bIsTagSearch == true)
		{
			$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', 'tag.item_id = b.blog_id AND tag.category_id = \'blog\' AND tag.tag_url = \'' . $this->database()->escape($sQuery) . '\'');
		}				
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('blog_text'), 'bt', 'bt.blog_id = b.blog_id')
			->where($sCondition)
			->execute('getSlaveField');		
			
		if ($bIsTagSearch == true)
		{
			$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', 'tag.item_id = b.blog_id AND tag.category_id = \'blog\' AND tag.tag_url = \'' . $this->database()->escape($sQuery) . '\'')->group('b.blog_id');
		}			
		
		$aRows = $this->database()->select('b.title, b.title_url, b.time_stamp, ' . Phpfox::getUserField())
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('blog_text'), 'bt', 'bt.blog_id = b.blog_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where($sCondition)
			->limit(10)
			->order('b.time_stamp DESC')
			->execute('getSlaveRows');
			
		if (count($aRows))
		{
			$aResults = array();
			$aResults['total'] = $iCnt;
			$aResults['menu'] = Phpfox::getPhrase('blog.search_blogs');
			
			if ($bIsTagSearch == true)
			{
				$aResults['form'] = '<div><input type="button" value="' . Phpfox::getPhrase('blog.view_more_blogs') . '" class="search_button" onclick="window.location.href = \'' . Phpfox::getLib('url')->makeUrl('blog', array('tag', $sQuery)) . '\';" /></div>';
			}
			else 
			{				
				$aResults['form'] = '<form method="post" action="' . Phpfox::getLib('url')->makeUrl('blog') . '"><div><input type="hidden" name="' . Phpfox::getTokenName() . '[security_token]" value="' . Phpfox::getService('log.session')->getToken() . '" /></div><div><input name="search[search]" value="' . Phpfox::getLib('parse.output')->clean($sQuery) . '" size="20" type="hidden" /></div><div><input type="submit" name="search[submit]" value="' . Phpfox::getPhrase('blog.view_more_blogs') . '" class="search_button" /></div></form>';
			}
			
			foreach ($aRows as $iKey => $aRow)
			{
				$aResults['results'][$iKey] = array(				
					'title' => $aRow['title'],	
					'link' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('blog', $aRow['title_url'])),
					'image' => Phpfox::getLib('image.helper')->display(array(
							'server_id' => $aRow['server_id'],
							'title' => $aRow['full_name'],
							'path' => 'core.url_user',
							'file' => $aRow['user_image'],
							'suffix' => '_120',
							'max_width' => 75,
							'max_height' => 75
						)
					),
					'extra_info' => Phpfox::getPhrase('blog.blog_created_on_time_stamp_by_full_name', array(
							'link' => Phpfox::getLib('url')->makeUrl('blog'),
							'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aRow['time_stamp']),
							'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
							'full_name' => $aRow['full_name']	
						)
					)			
				);
			}
			(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_globalsearch__return')) ? eval($sPlugin) : false);
			return $aResults;
		}
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_globalsearch__end')) ? eval($sPlugin) : false);
	}

	public function deleteComment($iId)
	{
		$this->database()->update($this->_sTable, array('total_comment' => array('= total_comment -', 1)), 'blog_id = ' . (int) $iId);
	}
	
	public function verifyFavorite($iItemId)
	{
		$aItem = $this->database()->select('i.blog_id')
			->from($this->_sTable, 'i')
			->where('i.blog_id = ' . (int) $iItemId . ' AND i.is_approved = 1 AND i.privacy IN(1,2) AND i.post_status = 1')
			->execute('getSlaveRow');
			
		if (!isset($aItem['blog_id']))
		{
			return false;
		}

		return true;
	}

	public function getFavorite($aFavorites)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getfavorite__start')) ? eval($sPlugin) : false);
		$aItems = $this->database()->select('i.title, i.time_stamp, i.title_url, ' . Phpfox::getUserField())
			->from($this->_sTable, 'i')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = i.user_id')
			->where('i.blog_id IN(' . implode(',', $aFavorites) . ') AND i.is_approved = 1 AND i.privacy IN(1,2) AND i.post_status = 1')
			->execute('getSlaveRows');
			
		foreach ($aItems as $iKey => $aItem)
		{
			$aItems[$iKey]['image'] = Phpfox::getLib('image.helper')->display(array(
					'server_id' => $aItem['server_id'],
					'path' => 'core.url_user',
					'file' => $aItem['user_image'],
					'suffix' => '_75',
					'max_width' => 75,
					'max_height' => 75
				)
			);		
			
			if (Phpfox::getParam('core.is_personal_site'))
			{
				$aItems[$iKey]['link'] = Phpfox::getLib('url')->makeUrl('blog', $aItem['title_url']);
			}		
			else 
			{
				$aItems[$iKey]['link'] = Phpfox::getService('user')->getLink($aItem['user_id'], $aItem['user_name'], array('blog', $aItem['title_url']));
			}			
		}
	    
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getfavorite__return')) ? eval($sPlugin) : false);
		return array(
			'title' => Phpfox::getPhrase('blog.search_blogs'),
			'items' => $aItems
		);
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_getfavorite__end')) ? eval($sPlugin) : false);
	}
	
	public function getDashboardLinks()
	{
		return array(
			'submit' => array(
				'phrase' => Phpfox::getPhrase('blog.write_a_blog'),
				'link' => 'blog.add',
				'image' => 'misc/page_white_add.png'
			),
			'edit' => array(
				'phrase' => Phpfox::getPhrase('blog.manage_blogs'),
				'link' => 'profile.blog',
				'image' => 'misc/page_white_edit.png'
			)
		);
	}
	
	public function getDashboardActivity()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		
		return array(
			Phpfox::getPhrase('blog.blogs') => $aUser['activity_blog']
		);
	}

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_ondeleteuser__start')) ? eval($sPlugin) : false);
		// get all the blogs by this user
		$aBlogs = $this->database()
			->select('blog_id')
			->from($this->_sTable)
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');

		foreach ($aBlogs as $aBlog)
		{
			Phpfox::getService('blog.process')->delete($aBlog['blog_id']);
		}
		// delete this user's categories
		$aCats = $this->database()
			->select('category_id')
			->from(Phpfox::getT('blog_category'))
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');
		$sCats = '1=2';
		foreach ($aCats as $aCat)
		{
			$sCats .= ' OR category_id = ' . $aCat['category_id'];
		}
		$this->database()->delete(Phpfox::getT('blog_category'), $sCats);
		$this->database()->delete(Phpfox::getT('blog_category_data'), $sCats);

		// delete the tracks
		$this->database()->delete(Phpfox::getT('blog_track'), 'user_id = ' . $iUser );
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_ondeleteuser__end')) ? eval($sPlugin) : false);
	}
	
	public function getItemView()
	{
		if (Phpfox::getLib('request')->get('req3') != '')
		{
			return true;
		}
	}	
	
	public function getNotificationFeedApproved($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('blog.your_blog_blog_title_has_been_approved', array('blog_title' => Phpfox::getLib('parse.output')->shorten($aRow['item_title'], 20, '...'))),
			'link' => Phpfox::getLib('url')->makeUrl('blog', array('redirect' => $aRow['item_id']))		);		
	}

	public function spamCheck()
	{
		return array(
			'phrase' => Phpfox::getPhrase('blog.blogs'),
			'value' => Phpfox::getService('blog')->getSpamTotal(),
			'link' => Phpfox::getLib('url')->makeUrl('blog', array('view' => 'spam'))
		);		
	}		
	
	public function legacyRedirect($aRequest)
	{
		if (isset($aRequest['req2']))
		{
			switch ($aRequest['req2'])
			{
				case 'view':
					if (isset($aRequest['id']))
					{				
						$aItem = Phpfox::getService('core')->getLegacyUrl(array(
							'url_field' => 'title_url',
								'table' => 'blog',
								'field' => 'upgrade_blog_id',
								'id' => $aRequest['id']
							)
						);
						
						if ($aItem !== false)
						{
							return array($aItem['user_name'], array('blog', $aItem['title_url']));
						}											
					}
					break;
				default:
					return 'blog';
					break;
			}
		}
		
		return false;
	}
	
	public function getCommentNotification($aNotification)
	{
		$aRow = $this->database()->select('b.blog_id, b.title, b.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('blog'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');
		
		if (!isset($aRow['blog_id']))
		{
			return false;
		}
		
		$sUsers = Phpfox::getService('notification')->getUsers($aNotification);
		$sTitle = Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...');
		
		$sPhrase = '';
		if ($aNotification['user_id'] == $aRow['user_id'] && !isset($aNotification['extra_users']))
		{
			$sPhrase = Phpfox::getPhrase('blog.users_commented_on_gender_blog_title', array('users' => $sUsers, 'gender' => Phpfox::getService('user')->gender($aRow['gender'], 1), 'title' => $sTitle));
		}
		elseif ($aRow['user_id'] == Phpfox::getUserId())		
		{
			$sPhrase = Phpfox::getPhrase('blog.users_commented_on_your_blog_title', array('users' => $sUsers, 'title' => $sTitle));
		}
		else 
		{
			$sPhrase = Phpfox::getPhrase('blog.users_commented_on_span_class_drop_data_user_row_full_name', array('users' => $sUsers, 'row_full_name' => $aRow['full_name'], 'title' => $sTitle));
		}
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('blog', $aRow['blog_id'], $aRow['title']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}
	
	public function getCommentNotificationFeed($aRow)
	{
		return array(
			'message' => Phpfox::getPhrase('blog.full_name_wrote_a_comment_on_your_blog_blog_title', array(
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'full_name' => $aRow['full_name'],
					'blog_link' => Phpfox::getLib('url')->makeUrl('blog', array('redirect' => $aRow['item_id'])),
					'blog_title' => Phpfox::getLib('parse.output')->shorten($aRow['item_title'], 20, '...')	
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('blog', array('redirect' => $aRow['item_id'])),
			'path' => 'core.url_user',
			'suffix' => '_50'
		);	
	}
	
	public function reparserList()
	{
		return array(
			'name' => Phpfox::getPhrase('blog.blogs_text'),
			'table' => 'blog_text',
			'original' => 'text',
			'parsed' => 'text_parsed',
			'item_field' => 'blog_id'
		);
	}
	
	public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => Phpfox::getPhrase('blog.blogs'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('blog'))
				->where('post_status = 1 AND time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}	
	
	public function checkFeedShareLink()
	{
		if (!Phpfox::getUserParam('blog.add_new_blog'))
		{
			return false;
		}
	}
	
	public function getFeedRedirectFeedLike($iId, $iChildId = 0)
	{
		return $this->getFeedRedirect($iChildId);
	}
	
	public function getNewsFeedFeedLike($aRow)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_ondeleteuser__start')) ? eval($sPlugin) : false);
		if ($aRow['owner_user_id'] == $aRow['viewer_user_id'])
		{
			$aRow['text'] = Phpfox::getPhrase('blog.a_href_user_link_full_name_a_likes_their_own_a_href_link_blog_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'gender' => Phpfox::getService('user')->gender($aRow['owner_gender'], 1),
					'link' => $aRow['link']
				)
			);
		}
		else 
		{
			$aRow['text'] = Phpfox::getPhrase('blog.a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_blog_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['owner_full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['owner_user_name']),
					'view_full_name' => Phpfox::getLib('parse.output')->clean($aRow['viewer_full_name']),
					'view_user_link' => Phpfox::getLib('url')->makeUrl($aRow['viewer_user_name']),
					'link' => $aRow['link']			
				)
			);
		}
		
		$aRow['icon'] = 'misc/thumb_up.png';
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_ondeleteuser__end')) ? eval($sPlugin) : false);
		return $aRow;				
	}		

	public function getNotificationFeedNotifyLike($aRow)
	{		
		return array(
			'message' => Phpfox::getPhrase('blog.a_href_user_link_full_name_a_likes_your_a_href_link_blog_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']),
					'user_link' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'link' => Phpfox::getLib('url')->makeUrl('blog', array('redirect' => $aRow['item_id']))
				)
			),
			'link' => Phpfox::getLib('url')->makeUrl('blog', array('redirect' => $aRow['item_id']))			
		);				
	}	
	
	/** @deprecated
	 */ 
	public function sendLikeEmail($iItemId, $aFeed)
	{	
		throw new Exception ('Deprecated.');
		return Phpfox::getPhrase('blog.a_href_user_link_full_name_a_likes_your_a_href_link_blog_a', array(
					'full_name' => Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')),
					'user_link' => Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')),
					'link' => Phpfox::getLib('url')->makeUrl('blog', array('redirect' => $iItemId))
				), false, false, $sLang
			);
	}			
	
	public function updateCounterList()
	{
		$aList = array();	

		$aList[] =	array(
			'name' => Phpfox::getPhrase('blog.users_blog_count'),
			'id' => 'blog-total'
		);	
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('blog.update_tags_blogs'),
			'id' => 'blog-tag-update'
		);			

		$aList[] =	array(
			'name' => Phpfox::getPhrase('blog.update_users_activity_blog_points'),
			'id' => 'blog-activity'
		);			
		
		return $aList;
	}		
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_callback_updatecounter__start')) ? eval($sPlugin) : false);
		
		if ($iId == 'blog-total')
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user'))
				->execute('getSlaveField');		
			
			$aRows = $this->database()->select('u.user_id, u.user_name, u.full_name, COUNT(b.blog_id) AS total_items')
				->from(Phpfox::getT('user'), 'u')
				->leftJoin(Phpfox::getT('blog'), 'b', 'b.user_id = u.user_id AND b.is_approved = 1 AND b.post_status = 1')
				->limit($iPage, $iPageLimit, $iCnt)
				->group('u.user_id')
				->execute('getSlaveRows');		
				
			foreach ($aRows as $aRow)
			{
				$this->database()->update(Phpfox::getT('user_field'), array('total_blog' => $aRow['total_items']), 'user_id = ' . $aRow['user_id']);
			}
		}
		elseif ($iId == 'blog-activity')
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user_activity'))
				->execute('getSlaveField');			
					
			$aRows = $this->database()->select('m.user_id, u.user_group_id, m.activity_blog, m.activity_points, m.activity_total, COUNT(oc.blog_id) AS total_items')
				->from(Phpfox::getT('user_activity'), 'm')
				->leftJoin(Phpfox::getT('blog'), 'oc', 'oc.user_id = m.user_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
				->group('m.user_id')
				->limit($iPage, $iPageLimit, $iCnt)
				->execute('getSlaveRows');				
			
			foreach ($aRows as $aRow)
			{
				$iPointsPerBlog = Phpfox::getService('user.group.setting')->getGroupParam( $aRow['user_group_id'], 'blog.points_blog');
				
				$aUpdate = array(
					'activity_points' => (($aRow['activity_total'] - ($aRow['activity_blog'] * $iPointsPerBlog)) + ($aRow['total_items'] * $iPointsPerBlog)), 					
					'activity_total' => (($aRow['activity_total'] - $aRow['activity_blog']) + $aRow['total_items']),
					'activity_blog' => $aRow['total_items']);
				
				$this->database()->update(Phpfox::getT('user_activity'), $aUpdate, 'user_id = ' . $aRow['user_id']);
			}
						
			return $iCnt;
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('tag'))
			->where('category_id = \'blog\'')
			->execute('getSlaveField');			
				
		$aRows = $this->database()->select('m.tag_id, oc.blog_id AS tag_item_id')
			->from(Phpfox::getT('tag'), 'm')
			->where('m.category_id = \'page_id\'')
			->leftJoin(Phpfox::getT('blog'), 'oc', 'oc.blog_id = m.item_id')
			->limit($iPage, $iPageLimit, $iCnt)
			->execute('getSlaveRows');			
			
		foreach ($aRows as $aRow)
		{
			if (empty($aRow['tag_item_id']))
			{
				$this->database()->delete(Phpfox::getT('tag'), 'tag_id = ' . $aRow['tag_id']);
			}
		}
		
		return $iCnt;	
	}

	public function getActivityPointField()
	{
		return array(
			Phpfox::getPhrase('blog.blogs') => 'activity_blog'
		);
	}	
	
	public function pendingApproval()
	{
		return array(
			'phrase' => Phpfox::getPhrase('blog.blogs'),
			'value' => Phpfox::getService('blog')->getPendingTotal(),
			'link' => Phpfox::getLib('url')->makeUrl('blog', array('view' => 'pending'))
		);
	}

	public function getSqlTitleField()
	{
		return array(
			array(
				'table' => 'blog',
				'field' => 'title',
				'has_index' => 'title'
			),
			array(
				'table' => 'blog_category',
				'field' => 'name'
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

	public function getAjaxProfileController()
	{
		return 'blog.index';
	}
	
	public function getProfileMenu($aUser)
	{
		if (!Phpfox::getParam('profile.show_empty_tabs'))
		{
			if (!isset($aUser['total_blog']))
			{
				return false;
			}

			if (isset($aUser['total_blog']) && (int) $aUser['total_blog'] === 0)
			{
				return false;
			}
		}
		
		$aSubMenu = array();
		
		if ($aUser['user_id'] == Phpfox::getUserId() && $this->request()->get('req2') == 'blog')
		{
			$aSubMenu[] = array(
				'phrase' => Phpfox::getPhrase('profile.drafts'),
				'url' => Phpfox::getLib('url')->makeUrl('profile.blog.view_draft'),
				'total' => Phpfox::getService('blog')->getTotalDrafts($aUser['user_id'])
			);
		}
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('profile.blogs'),
			'url' => 'profile.blog',
			'total' => (int) (isset($aUser['total_blog']) ? $aUser['total_blog'] : 0),
			'sub_menu' => $aSubMenu,
			'icon' => 'feed/blog.png'
		);	
		
		return $aMenus;
	}
	
	public function getTotalItemCount($iUserId)
	{
		return array(
			'field' => 'total_blog',
			'total' => $this->database()->select('COUNT(*)')->from(Phpfox::getT('blog'))->where('user_id = ' . (int) $iUserId . ' AND is_approved = 1 AND post_status = 1 AND item_id = 0')->execute('getSlaveField')
		);	
	}
	
	public function getNotificationApproved($aNotification)
	{
		$aRow = $this->database()->select('b.blog_id, b.title, b.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('blog'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $aNotification['item_id'])
			->execute('getSlaveRow');	

		if (!isset($aRow['blog_id']))
		{
			return false;
		}
		
		$sPhrase = Phpfox::getPhrase('blog.your_blog_title_has_been_approved', array('title' => Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getParam('notification.total_notification_title_length'), '...')));
			
		return array(
			'link' => Phpfox::getLib('url')->permalink('blog', $aRow['blog_id'], $aRow['title']),
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog'),
			'no_profile_image' => true
		);			
	}	
	
	public function globalUnionSearch($sSearch)
	{
		$this->database()->select('item.blog_id AS item_id, item.title AS item_title, item.time_stamp AS item_time_stamp, item.user_id AS item_user_id, \'blog\' AS item_type_id, \'\' AS item_photo, \'\' AS item_photo_server')
			->from(Phpfox::getT('blog'), 'item')
			->where($this->database()->searchKeywords('item.title', $sSearch) . ' AND item.is_approved = 1 AND item.privacy = 0 AND item.post_status = 1')
			->union();
	}
	
	public function getSearchInfo($aRow)
	{
		$aInfo = array();
		$aInfo['item_link'] = Phpfox::getLib('url')->permalink('blog', $aRow['item_id'], $aRow['item_title']);
		$aInfo['item_name'] = Phpfox::getPhrase('blog.blog');
		
		return $aInfo;
	}
	
	public function getSearchTitleInfo()
	{
		return array(
			'name' => Phpfox::getPhrase('blog.blog')
		);
	}
	
	public function getGlobalPrivacySettings()
	{
		return array(
			'blog.default_privacy_setting' => array(
				'phrase' => Phpfox::getPhrase('user.blogs')								
			)
		);
	}
	
	public function getCommentNotificationTag($aNotification)
	{
		$aRow = $this->database()->select('b.blog_id, b.title, u.user_name, u.full_name')
					->from(Phpfox::getT('comment'), 'c')
					->join(Phpfox::getT('blog'), 'b', 'b.blog_id = c.item_id')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
					->where('c.comment_id = ' . (int)$aNotification['item_id'])
					->execute('getSlaveRow');
		
		
		$sPhrase = Phpfox::getPhrase('blog.user_name_tagged_you_in_a_comment_in_a_blog', array('user_name' => $aRow['full_name']));
		
		return array(
			'link' => Phpfox::getLib('url')->permalink('blog', $aRow['blog_id'], $aRow['title']) . 'comment_' .$aNotification['item_id'],
			'message' => $sPhrase,
			'icon' => Phpfox::getLib('template')->getStyle('image', 'activity.png', 'blog')
		);
	}

	

	public function getActions()
	{
		return array(
			'dislike' => array(
				'enabled' => true,
				'action_type_id' => 2, // sort of redundant given the key 
				'phrase' => Phpfox::getPhrase('like.dislike'),
				'phrase_in_past_tense' => 'disliked',
				'item_type_id' => 'blog', // used internally to differentiate between photo albums and photos for example.
				'item_phrase' => Phpfox::getPhrase('blog.item_phrase'), // used to display to the user what kind of item is this
				'table' => 'blog',
				'column_update' => 'total_dislike',
				'column_find' => 'blog_id',
				'where_to_show' => array('blog', '')
				)
		);
	}
	
	public function getPagePerms()
	{
		$aPerms = array();
		
		$aPerms['blog.share_blogs'] = Phpfox::getPhrase('mail.who_can_share_blogs');
		$aPerms['blog.view_browse_blogs'] = Phpfox::getPhrase('mail.who_can_view_blogs');
		
		return $aPerms;
	}
	
	public function getPageMenu($aPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'blog.view_browse_blogs'))
		{
			return null;
		}		
		
		$aMenus[] = array(
			'phrase' => Phpfox::getPhrase('blog.blogs'),
			'url' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']) . 'blog/',
			'icon' => 'module/blog.png',
			'landing' => 'blog'
		);
		
		return $aMenus;
	}
	
	public function getPageSubMenu($aPage)
	{
		if (!Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'blog.share_blogs'))
		{
			return null;
		}		
		
		return array(
			array(
				'phrase' => Phpfox::getPhrase('blog.add_new_blog'),
				'url' => Phpfox::getLib('url')->makeUrl('blog.add', array('module' => 'pages', 'item' => $aPage['page_id']))
			)
		);
	}
	
	public function canViewPageSection($iPage)
	{		
		if (!Phpfox::getService('pages')->hasPerm($iPage, 'blog.view_browse_blogs'))
		{
			return false;
		}
		
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('blog.service_callback__call'))
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
