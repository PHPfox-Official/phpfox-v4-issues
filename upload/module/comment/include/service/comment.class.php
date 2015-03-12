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
 * @package  		Module_Comment
 * @version 		$Id: comment.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Comment_Service_Comment extends Phpfox_Service 
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('comment');
	}

	public function getQuote($iId)
	{		
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_getquote_start')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('cmt.comment_id, cmt.author, comment_text.text AS text, u.user_id')
			->from($this->_sTable, 'cmt')
			->join(Phpfox::getT('comment_text'), 'comment_text', 'comment_text.comment_id = cmt.comment_id')
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = cmt.user_id')
			->where('cmt.comment_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aRow['comment_id']))
		{
			return false;
		}
			
		if ($aRow['comment_id'] && !$aRow['user_id'])
		{
			$aRow['user_id'] = $aRow['author'];
		}
		
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_getquote_end')) ? eval($sPlugin) : false);
		
		return $aRow;
	}

	public function getComment($iId)
	{
		list($iCnt, $aRows) = $this->get('cmt.*', array('AND cmt.comment_id = ' . $iId), 'cmt.time_stamp DESC', 0, 1, 1);
		
		return (isset($aRows[0]['comment_id']) ? $aRows[0] : array());
	}
	
	public function get($sSelect, $aConds, $sSort = 'cmt.time_stamp DESC', $iRange = '', $sLimit = '', $iCnt = null, $bIncludeOwnerDetails = false)
	{
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_get__start')) ? eval($sPlugin) : false);
		$aRows = array();
		
		if ($iCnt === null)
		{
			(($sPlugin = Phpfox_Plugin::get('comment.service_comment_get_count_query')) ? eval($sPlugin) : false);
			
			$iCnt = $this->database()->select('COUNT(*)')
				->from($this->_sTable, 'cmt')
				->where($aConds)
				->execute('getSlaveField');		
		}

		if ($iCnt)
		{			
			if (Phpfox::isUser())
			{
				$this->database()->select('cr.comment_id AS has_rating, cr.rating AS actual_rating, ')
					->leftJoin(Phpfox::getT('comment_rating'), 'cr', 'cr.comment_id = cmt.comment_id AND cr.user_id = ' . (int) Phpfox::getUserId());
			}			
			
			if ($bIncludeOwnerDetails === true)
			{
				$this->database()->select(Phpfox::getUserField('owner', 'owner_') . ', ')->leftJoin(Phpfox::getT('user'), 'owner', 'owner.user_id = cmt.owner_user_id');
			}
			
			if(Phpfox::isModule('like'))
			{
				$this->database()->select('l.like_id AS is_liked, ')
						->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_mini\' AND l.item_id = cmt.comment_id AND l.user_id = ' . Phpfox::getUserId());
			}
			
			(($sPlugin = Phpfox_Plugin::get('comment.service_comment_get_query')) ? eval($sPlugin) : false);
			
			$aRows = $this->database()->select($sSelect . ", " . (Phpfox::getParam('core.allow_html') ? "comment_text.text_parsed" : "comment_text.text") ." AS text, " . Phpfox::getUserField())
				->from($this->_sTable, 'cmt')
				->leftJoin(Phpfox::getT('comment_text'), 'comment_text', 'comment_text.comment_id = cmt.comment_id')				
				->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = cmt.user_id')
				// ->leftJoin(Phpfox::getT('user_field'), 'user_field', 'user_field.user_id = cmt.user_id')
				->where($aConds)
				->order($sSort)
				->limit($iRange, $sLimit, $iCnt)
				->execute('getSlaveRows');			
		}	

		$oUrl = Phpfox::getLib('url');
		$oParseOutput = Phpfox::getLib('parse.output');
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['link'] = '';
			if ($aRow['user_name'])
			{
				$aRows[$iKey]['link'] = $oUrl->makeUrl($aRow['user_name']);
				$aRows[$iKey]['is_guest'] = false;
			}
			else 
			{
				$aRows[$iKey]['full_name'] = $oParseOutput->clean($aRow['author']);
				$aRows[$iKey]['is_guest'] = true;
				if ($aRow['author_url'])
				{
					$aRows[$iKey]['link'] = $aRow['author_url'];	
				}
			}
			$aRows[$iKey]['unix_time_stamp'] = $aRow['time_stamp'];
			$aRows[$iKey]['time_stamp'] = Phpfox::getTime(Phpfox::getParam('comment.comment_time_stamp'), $aRow['time_stamp']);
			$aRows[$iKey]['posted_on'] = Phpfox::getPhrase('comment.user_link_at_item_time_stamp', array(
					'item_time_stamp' => Phpfox::getTime(Phpfox::getParam('comment.comment_time_stamp'), $aRow['time_stamp']),
					'user' => $aRow
				)
			);
			$aRows[$iKey]['update_time'] = Phpfox::getTime(Phpfox::getParam('comment.comment_time_stamp'), $aRow['update_time']);
			$aRows[$iKey]['post_convert_time'] = Phpfox::getLib('date')->convertTime($aRow['time_stamp'], 'comment.comment_time_stamp');
		}

		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_get__end')) ? eval($sPlugin) : false);
		return array($iCnt, $aRows);
	}
	
	public function getCommentForEdit($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_getcommentforedit')) ? eval($sPlugin) : false);	
		
		return $this->database()->select('cmt.*, comment_text.text AS text')
			->from($this->_sTable, 'cmt')
			->join(Phpfox::getT('comment_text'), 'comment_text', 'comment_text.comment_id = cmt.comment_id')
			->where('cmt.comment_id = ' . (int) $iId)
			->execute('getSlaveRow');		
	}
	
	public function hasAccess($iId, $sUserPerm, $sGlobalPerm)
	{
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_hasaccess_start')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('u.user_id')
			->from($this->_sTable, 'cmt')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = cmt.user_id')
			->where('cmt.comment_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_hasaccess_end')) ? eval($sPlugin) : false);
		
		if (!isset($aRow['user_id']))
		{
			return false;
		}
		
		if ((Phpfox::getUserId() == $aRow['user_id'] && Phpfox::getUserParam('comment.' . $sUserPerm)) || Phpfox::getUserParam('comment.' . $sGlobalPerm))
		{
			return $aRow['user_id'];
		}
		
		return false;
	}
	
	public function getPendingComments()
	{		
		$aComments = $this->database()->select('c.*, ' . (Phpfox::getParam('core.allow_html') ? "ct.text_parsed" : "ct.text") . ' AS text, ' . Phpfox::getUserField())
			->from($this->_sTable, 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
			->where('c.owner_user_id = ' . Phpfox::getUserId() . ' AND c.view_id = 1')
			->group('c.comment_id')
			->execute('getSlaveRows');
		
		foreach ($aComments as $iKey => $aComment)
		{			
			if (Phpfox::isModule($aComment['type_id']) == false)
			{
				unset($aComments[$iKey]);
				continue;
			}
			$aComments[$iKey]['item_message'] = Phpfox::getPhrase('comment.user_link_left_a_comment_on_your_item', array(
					'user' => $aComment,
					'item_name' => Phpfox::callback($aComment['type_id'] . '.getCommentItemName'),
					'link' => Phpfox::getLib('url')->makeUrl('request.view.comment', array('id' => $aComment['comment_id']))
				)
			);
		}
		
		return $aComments;
	}
	
	public function getForRss($sType, $iItem)
	{
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_getforrss__start')) ? eval($sPlugin) : false);
		$oUrl = Phpfox::getLib('url');
		
		$aSql = array(
			"AND cmt.type_id = '" . Phpfox::getLib('database')->escape($sType) . "'",
			'AND cmt.item_id = ' . $iItem,
			'AND cmt.view_id = 0'
		);
				
		// Get the comments for this page
		list($iCnt, $aRows) = $this->get('cmt.*', $aSql, 'cmt.time_stamp DESC', 0, Phpfox::getParam('rss.total_rss_display'));

		$aItems = array();
		foreach ($aRows as $aRow)
		{
			$aItems[] = array(
				'title' => Phpfox::getPhrase('comment.by_full_name', array('full_name' => Phpfox::getLib('parse.output')->clean($aRow['full_name']))),
				'link' => $oUrl->makeUrl('comment.view', array('id' => $aRow['comment_id'])),
				'description' => $aRow['text'],
				'time_stamp' => $aRow['unix_time_stamp'],
				'creator' => Phpfox::getLib('parse.output')->clean($aRow['full_name'])
			);
		}
		
		$aRss = array(
			'href' => $oUrl->makeUrl('comment.rss', array('type' => $sType, 'item' => $iItem)),
			'title' => (Phpfox::hasCallback($sType, 'getRssTitle') ? Phpfox::callback($sType . '.getRssTitle', $iItem) : Phpfox::getPhrase('comment.latest_comments')),
			'description' => Phpfox::getPhrase('comment.latest_comments_on_site_title', array('site_title' => Phpfox::getParam('core.site_title'))),
			'items' => $aItems
		);
		(($sPlugin = Phpfox_Plugin::get('comment.service_comment_getforrss__end')) ? eval($sPlugin) : false);
		return $aRss;
	}
	
	public function getSpamTotal()
	{
		return $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('view_id = 9')
			->execute('getSlaveField');
	}
	
	public function getCommentsForFeed($sType, $iItemId, $iLimit = 2, $mPager = null, $iCommentId = null)
	{
		if ($mPager !== null)
		{
			$this->database()->limit(Phpfox::getLib('request')->getInt('page'), $iLimit, $mPager);
		}
		else 
		{
			$this->database()->limit($iLimit);
		}
		
		if ($iCommentId !== null)
		{
			$this->database()->where('c.comment_id = ' . (int) $iCommentId . '');
		}
		else
		{
			$this->database()->where('c.parent_id = 0 AND c.type_id = \'' . $this->database()->escape($sType) . '\' AND c.item_id = ' . (int) $iItemId . ' AND c.view_id = 0');
		}

		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_mini\' AND l.item_id = c.comment_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aFeedComments = $this->database()->select('c.*, ' . (Phpfox::getParam('core.allow_html') ? "ct.text_parsed" : "ct.text") .' AS text, ' . Phpfox::getUserField())
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')			
			->order('c.time_stamp DESC')						
			->execute('getSlaveRows');
						
		$aComments = array();
		if (count($aFeedComments))
		{
			foreach ($aFeedComments as $iFeedCommentKey => $aFeedComment)
			{
				$aFeedComments[$iFeedCommentKey]['post_convert_time'] = Phpfox::getLib('date')->convertTime($aFeedComment['time_stamp'], 'comment.comment_time_stamp');
				
				// $this->_iNested = 0;
				
				if (Phpfox::getParam('comment.comment_is_threaded'))
				{
					$aFeedComments[$iFeedCommentKey]['children'] = $this->_getChildren($aFeedComment['comment_id'], $sType, $iItemId, $iCommentId);
				}
			}					
						
			$aComments = array_reverse($aFeedComments);			
		}	
		
		return $aComments;	
	}	
	
	/**
	 *
	 * @param int $iUserId owner (user_id) of the item to comment on (owner of the blog for example)
	 * @param type $iPrivacy
	 * @return boolean 
	 */
	public function canPostComment($iUserId, $iPrivacy)
	{
		$bCanPostComment = true;
		if ($iUserId != Phpfox::getUserId() && !Phpfox::getUserParam('privacy.can_comment_on_all_items'))
		{
			$bIsFriend = Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $iUserId);
			
			switch ((int) $iPrivacy)
			{
				case 1:					
					if ($bIsFriend <= 0)
					{
						$bCanPostComment = false;						
					}
					break;
				case 2:
					if ($bIsFriend > 0)
					{
						$bCanPostComment = true;
					}
					else 
					{
						if (!Phpfox::getService('friend')->isFriendOfFriend($iUserId))
						{
							$bCanPostComment = false;	
						}
					}
					break;
				case 3:
					$bCanPostComment = false;
					break;
			}
		}	
		
		return $bCanPostComment;	
	}
	
	public function massMail($sModule, $iItemId, $iOwnerUserId, $aMessage = array())
	{
        if ($sPlugin = Phpfox_Plugin::get('comment.service_comment_massmail__0')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
        
		$aRows = $this->database()->select('c.*')
			->from($this->_sTable, 'c')
			->where('c.type_id = \'' . $this->database()->escape($sModule) . '\' AND item_id = ' . (int) $iItemId . ' AND view_id = 0')
			->group('c.user_id')
			->execute('getSlaveRows');

        if ($sPlugin = Phpfox_Plugin::get('comment.service_comment_massmail__1')){eval($sPlugin);}
            
		foreach ($aRows as $aRow)
		{
			if ($aRow['user_id'] == $iOwnerUserId)
			{
				continue;
			}
			
			Phpfox::getLib('mail')->to($aRow['user_id'])
				->subject($aMessage['subject'])
				->message($aMessage['message'])
				->notification('comment.add_new_comment')
				->send();
				
			Phpfox::getService('notification.process')->add('comment_' . $sModule, $iItemId, $aRow['user_id']);
		}
	}
	
	public function __call($sMethod, $aArguments)
	{
		if ($sPlugin = Phpfox_Plugin::get('comment.service_comment___call'))
		{
			return eval($sPlugin);
		}
		
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _getChildren($iParentId, $sType, $iItemId, $iCommentId = null, $iCnt = 0)
	{
		$iTotalComments = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
			->where('c.parent_id = ' . (int) $iParentId . ' AND c.type_id = \'' . $this->database()->escape($sType) . '\' AND c.item_id = ' . (int) $iItemId . ' AND c.view_id = 0')
			->execute('getSlaveField');
		
		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'feed_mini\' AND l.item_id = c.comment_id AND l.user_id = ' . Phpfox::getUserId());		
		}
		
		if ($iCommentId === null)
		{
			$this->database()->limit(Phpfox::getParam('comment.thread_comment_total_display'));
		}
		
		$aFeedComments = $this->database()->select('c.*, ' . (Phpfox::getParam('core.allow_html') ? "ct.text_parsed" : "ct.text") .' AS text, ' . Phpfox::getUserField())
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
			->where('c.parent_id = ' . (int) $iParentId . ' AND c.type_id = \'' . $this->database()->escape($sType) . '\' AND c.item_id = ' . (int) $iItemId . ' AND c.view_id = 0')
			->order('c.time_stamp ASC')
			->execute('getSlaveRows');
		
		$iCnt++;
		if (count($aFeedComments))
		{	
			foreach ($aFeedComments as $iFeedCommentKey => $aFeedComment)
			{
				$aFeedComments[$iFeedCommentKey]['iteration'] = $iCnt;
				
				$aFeedComments[$iFeedCommentKey]['post_convert_time'] = Phpfox::getLib('date')->convertTime($aFeedComment['time_stamp'], 'comment.comment_time_stamp');
				$aFeedComments[$iFeedCommentKey]['children'] = $this->_getChildren($aFeedComment['comment_id'], $sType, $iItemId, $iCommentId, $iCnt);			
			}						
		}	
		
		return array('total' => (int) ($iTotalComments - Phpfox::getParam('comment.thread_comment_total_display')), 'comments' => $aFeedComments);
	}
	
	public function getInfoForAction($aItem)
	{
		$aRow = $this->database()->select('c.comment_id, ct.text as title, c.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('comment'), 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'c.comment_id = ct.comment_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
			->where('c.comment_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
		$aRow['link'] = '';//Phpfox::getLib('url')->permalink('blog', $aRow['blog_id'], $aRow['title']);
		return $aRow;
	}
}

?>
