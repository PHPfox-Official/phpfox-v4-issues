<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: api.class.php 5112 2013-01-11 06:56:25Z Raymond_Benc $
 */
class Forum_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('feed');
		$this->_oApi = Phpfox::getService('api');
	}
	
	public function get()
	{
		/*
		@title 
		@info Get all public forums. 
		@method GET
		@extra
		@return forum_id=#{Forum ID#|int}&name=#{Name of the forum|string}&description=#{Description of the forum|string}&sub_forum=#{An array of sub forums|array}
		*/		
		
		$aForums = Phpfox::getService('forum')->getForums();
		$aForums = $this->_rebuildForum($aForums);

		return $aForums;
	}
	
	public function threads($iId = 0)
	{
		/*
		@title
		@info Get all threads from a specific forum.
		@method GET
		@extra id=#{ID# of the forum|int|yes}
		@return thread_id=#{Thread ID#|int}&title=#{Title of the thread|string}&posted=#{Time stamp of when the thread was created|int}&updated=#{Time stamp of when the thread was last updated|int}&views=#{Total number of views|int}&permalink=#{Link to the thread|string}&last_post=#{Last person to post in the thread|string}&last_post_profile=#{Profile link of the last person who posted in the thread|string}
		*/
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iId = $this->_oApi->get('id');
		}			
		
		$aCond = array();
		$aCond[] = 'ft.forum_id = ' . $iId . ' AND ft.group_id = 0 AND ft.view_id = 0 AND ft.is_announcement = 0';
		list($iCnt, $aThreads) = Phpfox::getService('forum.thread')->get($aCond, 'ft.time_update DESC', $this->_oApi->get('page'), 10);
		$aReturn = array();
		foreach ($aThreads as $iKey => $aThread)
		{
			$aReturn[$iKey] = array(
					'thread_id' => $aThread['thread_id'],
					'title' => $aThread['title'],
					'posted' => $aThread['time_stamp'],
					'updated' => $aThread['time_update'],
					'views' => (int) $aThread['total_view'],
					'permalink' => Phpfox::permalink('forum.thread', $aThread['thread_id'], $aThread['title'])
					);
			
			if (empty($aThread['last_full_name']))
			{
				$aReturn[$iKey]['last_post'] = $aThread['full_name'];
				$aReturn[$iKey]['last_post_profile'] = Phpfox::getLib('url')->makeUrl($aThread['user_name']);
			}
			else
			{
				$aReturn[$iKey]['last_post'] = $aThread['last_full_name'];
				$aReturn[$iKey]['last_post_profile'] = Phpfox::getLib('url')->makeUrl($aThread['last_user_name']);
			}		
		}
		
		return $aReturn;
	}
	
	public function thread($iId = 0)
	{
		/*
		@title
		@info Get a specific thread and all of its posts.
		@method GET
		@extra
		@return thread_id=#{Thread ID#|int}&title=#{Title of the thread|string}&last_time_stamp=#{Last time the thread was updated|int}&permalink=#{URL to the thread|string}&posts=#{Array of posts|array}
		*/		
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iId = $this->_oApi->get('id');
		}
		
		$aCond = array();
		$aCond[] = 'ft.thread_id = ' . $iId;
		list($iCnt, $aThread) = Phpfox::getService('forum.thread')->getThread($aCond, array(), 'fp.time_stamp ASC', $this->_oApi->get('page'), 20);

		$aReturn = array(
				'thread_id' => $aThread['thread_id'],
				'title' => $aThread['title'],
				'last_time_stamp' => $aThread['last_time_stamp'],
				'permalink' => Phpfox::permalink('forum.thread', $aThread['thread_id'], $aThread['title'])
				);
		
		if (isset($aThread['posts']) && !empty($aThread['posts']))
		{
			foreach ($aThread['posts'] as $aPost)
			{
				$aReturn['posts'][] = array(
						'post_id' => $aPost['post_id'],
						'time_stamp' => $aPost['time_stamp'],
						'lkes' => $aPost['total_like'],
						'post' => Phpfox::getLib('parse.output')->parse($aPost['text']),
						'posted_by' => $aPost['full_name'],
						'posted_by_url' => Phpfox::getLib('url')->makeUrl($aPost['user_name'])
						);
			}
		}
		
		return $aReturn;
	}
	
	public function addThread()
	{
		/*
		@title
		@info Add a thread. On success it will return the new thread information.
		@method POST
		@extra id=#{Forum ID#|int|yes}&title=#{Title of the thread|string|yes}&post=#{Post content|string|yes}
		@return thread_id=#{Thread ID#|int}&title=#{Title of the thread|string}&last_time_stamp=#{Last time the thread was updated|int}&permalink=#{URL to the thread|string}&posts=#{Array of posts|array}
		*/		
		
		$aVals = array(
				'forum_id' => $this->_oApi->get('id'),
				'title' => $this->_oApi->get('title'),
				'text' => $this->_oApi->get('post')
				);
		$iId = Phpfox::getService('forum.thread.process')->add($aVals);
		
		return $this->thread($iId);
	}
	
	public function addPost()
	{
		/*
		@title
		@info Add a reply to a thread.
		@method POST
		@extra id=#{Thread ID#|int|yes}&post=#{Post content|string|yes}
		@return thread_id=#{Thread ID#|int}&title=#{Title of the thread|string}&posted=#{Time stamp of when the thread was created|int}&updated=#{Time stamp of when the thread was last updated|int}&views=#{Total number of views|int}&permalink=#{Link to the thread|string}&last_post=#{Last person to post in the thread|string}&last_post_profile=#{Profile link of the last person who posted in the thread|string}
		*/
	
		$aVals = array(
				'thread_id' => $this->_oApi->get('id'),
				'text' => $this->_oApi->get('post')
		);
		
		if (Phpfox::getService('forum.post.process')->add($aVals))
		{
			return true;
		}
		
		return false;
	}	
	
	private function _rebuildForum($aForums)
	{
		$aUnset = array(
				'parent_id', 'view_id', 'is_category', 'is_closed', 'name_url'
				);
		foreach ($aForums as $iKey => $aForum)
		{
			$aForums[$iKey]['permalink'] = Phpfox::permalink('forum', $aForum['forum_id'], $aForum['name']);
			
			foreach ($aUnset as $sUnset)
			{
				unset($aForums[$iKey][$sUnset]);
			}	
			
			if (isset($aForum['sub_forum']) && !empty($aForum['sub_forum']))
			{
				$aForums[$iKey]['sub_forum'] = $this->_rebuildForum($aForum['sub_forum']);
			}		
		}	
		
		return $aForums;
	}
}

?>