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
 * @version 		$Id: post.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Forum_Service_Post_Post extends Phpfox_Service 
{
	private $_aCallback = null;
	private $_iTotalPostCount = 0;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('forum_post');
	}
	
	public function callback($aCallback)
	{
		$this->_aCallback = $aCallback;
		
		return $this;
	}
	
	public function getPost($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('forum.service_post_getpost')) ? eval($sPlugin) : false);
		
		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'forum_post\' AND l.item_id = fp.post_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aPost = $this->database()->select('fp.*, ' . (Phpfox::getParam('core.allow_html') ? 'fpt.text_parsed' : 'fpt.text') . ' AS text, ' . Phpfox::getUserField() . ', u.joined, u.country_iso, uf.signature, uf.total_post, ft.forum_id, ft.group_id, ft.user_id AS thread_user_id, ft.title AS thread_title')
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')
			->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = fp.user_id')
			->where('fp.post_id = ' . $iId)
			->execute('getRow');
			
		$aPost['aFeed'] = array(				
			'privacy' => 0,
			'comment_privacy' => 0,
			'like_type_id' => 'forum_post',
			'feed_is_liked' => ($aPost['is_liked'] ? true : false),
			'item_id' => $aPost['post_id'],
			'user_id' => $aPost['user_id'],
			'total_like' => $aPost['total_like'],
			'feed_link' => Phpfox::permalink('forum.thread', $aPost['thread_id'], $aPost['thread_title']) . 'view_' . $aPost['post_id'] . '/',
			'feed_title' => $aPost['thread_title'],
			'feed_display' => 'mini',
			'feed_total_like' => $aPost['total_like'],
			'report_module' => 'forum_post',
			'report_phrase' => Phpfox::getPhrase('forum.report_this_post'),
			'time_stamp' => $aPost['time_stamp']
		);			
		
		
		if ($aPost['total_attachment'])
		{
			list($iAttachmentCnt, $aPost['attachments']) = Phpfox::getService('attachment')->get('attachment.item_id = ' . $aPost['post_id'] . ' AND attachment.view_id = 0 AND attachment.category_id = \'forum\' AND attachment.is_inline = 0', 'attachment.attachment_id DESC', '', '', false);				
		}
		
		$aPost['last_update_on'] = Phpfox::getPhrase('forum.last_update_on_time_stamp_by_update_user', array(
				'time_stamp' => Phpfox::getTime(Phpfox::getParam('forum.forum_time_stamp'), $aPost['update_time']),
				'update_user' => $aPost['update_user']				
			)
		);		
			
		return $aPost;
	}
	
	public function getForEdit($iId)
	{
		return $this->database()->select('fp.*, ft.forum_id, fpt.text, ft.group_id, ' . Phpfox::getUserField())
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')
			->where('fp.post_id = ' . $iId)
			->execute('getRow');
	}
	
	public function getQuotes($iThread, $mId)
	{
		if (strpos($mId, ','))
		{
			$sIds = '';
			$aParts = explode(',', $mId);
			foreach ($aParts as $iPart)
			{
				if (empty($iPart))
				{
					continue;
				}
				
				if (!is_numeric($iPart))
				{
					continue;
				}
				
				$sIds .= $iPart . ',';
			}
			$sIds = rtrim($sIds, ',');
		}
		else 
		{
			$sIds = $mId;
		}		
		
		$aPosts = $this->database()->select('fp.post_id, fp.user_id, fpt.text')
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')
			->where('fp.post_id IN(' . $sIds . ') AND fp.thread_id = ' . (int) $iThread . ' AND fp.view_id = 0')
			->order('fp.time_stamp ASC')
			->execute('getRows');		
			
		$sQuotes = '';
		foreach ($aPosts as $aPost)
		{
			$sQuotes .= "[quote={$aPost['user_id']}]\n" . Phpfox::getLib('parse.bbcode')->stripCode($aPost['text'], array('quote', 'attachment')) . "\n[/quote]\n\n\n";
		}
				
		return $sQuotes;
	}
	
	public function get($mConditions = array(), $sOrder = 'ft.time_update DESC', $iPage = '', $iPageSize = '', $bCount = true)
	{
		$aPosts = array();		
		$iCnt = ($bCount ? $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'fp')
			->where($mConditions)
			->execute('getSlaveField') : true);		
			
		if ($iCnt)
		{
			$aPosts = $this->database()->select('f.forum_id, f.name AS forum_name, f.name_url AS forum_url, ft.title AS thread_title, ft.group_id, ft.thread_id, ft.title_url AS thread_title_url, fp.post_id, fp.view_id, fp.time_stamp, fp.title, ' . (Phpfox::getParam('core.allow_html') ? 'fpt.text_parsed' : 'fpt.text') . ' AS text, ' . Phpfox::getUserField())
				->from(Phpfox::getT('forum_post'), 'fp')
				->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')
				->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
				->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')							
				->where($mConditions)
				->order($sOrder)
				->limit($iPage, $iPageSize, $iCnt)				
				->execute('getSlaveRows');		

			$iTotal = ($iPage > 1 ? (($iPageSize * $iPage) - $iPageSize) : 0);		
			foreach ($aPosts as $iKey => $aPost)
			{
				$iTotal++;
				if (isset($this->_aCallback['group_id']))
				{
					$sLink = Phpfox::getLib('url')->makeUrl($this->_aCallback['url_home'], array($aPost['thread_title_url'], 'post' => $aPost['post_id']));	
				}
				else 
				{
					$sLink = Phpfox::getLib('url')->makeUrl('forum', array($aPost['forum_url'] . '-' . $aPost['forum_id'], $aPost['thread_title_url'], 'post' => $aPost['post_id']));	
				}
				
				$aPosts[$iKey]['count'] = $iTotal;
				$aPosts[$iKey]['text'] = Phpfox::getLib('search')->highlight('keyword', $aPost['text']);		
				$aPosts[$iKey]['forum_info_phrase'] = Phpfox::getPhrase('forum.title_posted_in_forum_name', array(
						'link' => $sLink,
						'title' => Phpfox::getLib('parse.output')->clean($aPost['thread_title']),
						'forum_link' => (isset($this->_aCallback['group_id']) ? Phpfox::getLib('url')->makeUrl($this->_aCallback['url_home']) : Phpfox::getLib('url')->makeUrl('forum', array($aPost['forum_url'] . '-' . $aPost['forum_id']))),
						'forum_name' => (isset($this->_aCallback['group_id']) ? $this->_aCallback['title'] : $aPost['forum_name'])
					)
				);
			}	
		}	
		
		if (!$bCount)
		{
			return $aPosts;
		}
		
		return array($iCnt, $aPosts);		
	}
	
	public function getSearch($mConditions = array(), $sOrder = 'ft.time_update DESC')
	{
		$aPosts = $this->database()->select('fpt.post_id')
			->from(Phpfox::getT('forum_post_text'), 'fpt')
			->join(Phpfox::getT('forum_post'), 'fp', 'fp.post_id = fpt.post_id')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')	
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')
			->where($mConditions)
			->order($sOrder)				
			->execute('getSlaveRows');		
		
		$aSearchIds = array();
		foreach ($aPosts as $aPost)
		{
			$aSearchIds[] = $aPost['post_id'];
		}
				
		return $aSearchIds;		
	}	
	
	public function getPreview($iThreadId)
	{
		return $this->database()->select('fp.time_stamp, ' . (Phpfox::getParam('core.allow_html') ? 'fpt.text_parsed' : 'fpt.text') . ' AS text, ' . Phpfox::getUserField())
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')			
			->where('fp.thread_id = ' . (int) $iThreadId)
			->order('fp.time_stamp DESC')
			->limit(Phpfox::getParam('forum.total_forum_post_preview'))
			->execute('getSlaveRows');	
	}	
	
	public function getForRss($iId)
	{
		$aRows = $this->database()->select('fp.post_id, ft.title, ft.title_url, ft.forum_id, ft.group_id, ft.time_stamp, ' . (Phpfox::getParam('core.allow_html') ? 'fpt.text_parsed' : 'fpt.text') . ' AS description, f.name AS forum_name, f.name_url AS forum_url, ' . Phpfox::getUserField())
			->from(Phpfox::getT('forum_post'), 'fp')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fp.thread_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fp.user_id')
			->join(Phpfox::getT('forum_post_text'), 'fpt', 'fpt.post_id = fp.post_id')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
			->where('fp.thread_id = ' . (int) $iId)
			->order('fp.time_stamp DESC')
			->execute('getSlaveRows');
			
		if (!count($aRows))
		{
			return array();
		}
		
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['link'] = ($aRow['group_id'] ? Phpfox::getLib('url')->makeUrl('group.forum', array($aRow['title_url'], 'id' => $aRow['group_id'], 'post' => $aRow['post_id'])) : Phpfox::getLib('url')->makeUrl('forum', array($aRow['forum_url'] . '-' . $aRow['forum_id'], $aRow['title_url'], 'post' => $aRow['post_id'])));
			$aRows[$iKey]['creator'] = $aRow['full_name'];
		}
			
		$aRss = array(
			'href' => Phpfox::getLib('url')->makeUrl('forum', array($aRows[0]['forum_url'] . '-' . $aRows[0]['forum_id'], $aRows[0]['title_url'])),
			'title' => Phpfox::getPhrase('forum.latest_posts_in') . ': ' . $aRows[0]['title'],
			'description' => Phpfox::getPhrase('forum.latest_forum_posts_on') . ': ' . Phpfox::getParam('core.site_title'),
			'items' => $aRows
		);		
		
		return $aRss;
	}	
	
	public function getPostPage($iThreadId, $iPostId, $iTotal)
	{
		$this->_iTotalPostCount = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('forum_post'))
			->where('thread_id = ' . (int) $iThreadId . ' AND post_id <= ' . (int) $iPostId)
			->execute('getSlaveField');
		
		return ceil($this->_iTotalPostCount / $iTotal);
	}
	
	public function getPostCount()
	{
		return $this->_iTotalPostCount;
	}
	
	public function getPendingPost()
	{
		return (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('forum_post'))
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_post_post__call'))
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
