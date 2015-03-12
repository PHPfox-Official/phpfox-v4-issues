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
 * @package  		Module_Feed
 * @version 		$Id: process.class.php 7199 2014-03-17 19:37:13Z Fern $
 */
class Feed_Service_Process extends Phpfox_Service 
{	
	private $_bAllowGuest = false;
	private $_iLastId = 0;
	private $_aCallback = array();
	private $_bIsCallback = false;
	private $_bIsNewLoop = false;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('feed');
	}
	
	public function clearCache($sType, $iItemId)
	{
		if (!Phpfox::getParam('feed.cache_each_feed_entry'))
		{
			return;
		}
				
		$iParentId = Phpfox::getLib('request')->getInt('parent_id');
		if ($sType == 'feed_mini' && !empty($iParentId))
		{
			$sTable = '';
			if (Phpfox::getLib('request')->get('pmodule') == 'event')
			{
				$sTable = 'event_';
			}
			elseif (Phpfox::getLib('request')->get('pmodule') == 'pages')
			{
				$sTable = 'pages_';
			}
			
			$aFeed = $this->database()->select('*')
				->from(Phpfox::getT($sTable . 'feed'))
				->where('feed_id = ' . (int) $iParentId)
				->execute('getSlaveRow');		
			if (isset($aFeed['feed_id']))
			{
				$sType = $aFeed['type_id'];
				$iItemId = $aFeed['item_id'];				
			}
		}		
		elseif ($sType == 'forum_post')
		{
			$this->cache()->remove(array('feeds', 'forum_' . $iItemId));
			/*$sType = 'forum_reply';*/
		}
        else if ($sType == 'feed')
        {
            $aVal = Phpfox::getLib('request')->getArray('val');
            
            if (isset($aVal['is_via_feed']) && $aVal['is_via_feed'] > 0 )
            {
                $iItemId = $this->database()->select('item_id')
                    ->from(Phpfox::getT('feed'))
                    ->where('feed_id = ' . (int)$aVal['is_via_feed'])
                    ->execute('getSlaveField');
                
                $sType .= '_comment';
            }
        }
        else if ($sType == 'pages')
        {
            $aVal = Phpfox::getLib('request')->getArray('val');
            
            if (isset($aVal['is_via_feed']) && $aVal['is_via_feed'] > 0)
            {
                $aRow = $this->database()->select('type_id, item_id')
                        ->from(Phpfox::getT('pages_feed'))
                        ->where('feed_id = ' . (int)$aVal['is_via_feed'])
                        ->execute('getSlaveRow');
                
                if (!empty($aRow) && isset($aRow['item_id']) && $aRow['item_id'] > 0)
                {
                    $sType = $aRow['type_id'];
                    $iItemId = $aRow['item_id'];
                }
            }
        }
        
		
		$this->cache()->remove(array('feeds', $sType . '_' . $iItemId));
	}
	
	public function callback($aCallback)
	{
		if (isset($aCallback['module']))
		{
			$this->_bIsCallback = true;
			$this->_aCallback = $aCallback;			
		}
		
		return $this;
	}
	
	public function allowGuest()
	{
		$this->_bAllowGuest = true;
		
		return $this;
	}			
	
	public function add($sType, $iItemId, $iPrivacy = 0, $iPrivacyComment = 0, $iParentUserId = 0, $iOwnerUserId = null, $bIsTag = 0, $iParentFeedId = 0, $sParentModuleName = null)
	{			
		//Plugin call
		if (($sPlugin = Phpfox_Plugin::get('feed.service_process_add__start')))
		{
			eval($sPlugin);
		}
		
		if ((!Phpfox::isUser() && $this->_bAllowGuest === false) || (defined('PHPFOX_SKIP_FEED') && PHPFOX_SKIP_FEED))
		{
			return false;
		}		
		
		if ($iParentUserId === null)
        {
			$iParentUserId = 0;
		}
		
		$iNewTimeStamp = PHPFOX_TIME;
		$iNewTimeStampCheck = Phpfox::getLib('date')->mktime(0, 0, 0, date('n', PHPFOX_TIME), date('j', PHPFOX_TIME), date('Y', PHPFOX_TIME));
		if (Phpfox::getParam('feed.can_add_past_dates'))
		{
			$aVals = (array) Phpfox::getLib('request')->getArray('val');	
			if (PHPFOX_IS_AJAX)
			{
				$oReq = Phpfox::getLib('request');
				if ($oReq->get('start_year') && $oReq->get('start_month') && $oReq->get('start_day'))
				{
					$aVals['start_year'] = $oReq->get('start_year');
					$aVals['start_month'] = $oReq->get('start_month');
					$aVals['start_day'] = $oReq->get('start_day');
				}	
			}	
			if (!empty($aVals['start_year']) && !empty($aVals['start_month']) && !empty($aVals['start_day']))
			{
				$iMakeNewTimeStamp = Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['start_month'], $aVals['start_day'], $aVals['start_year']);	
				if ($iMakeNewTimeStamp < $iNewTimeStampCheck)
				{
					$iNewTimeStamp = $iMakeNewTimeStamp;
					$this->cache()->remove(array('timeline', Phpfox::getUserId()));
				}
			}		
		}		
		
		$aParentModuleName = explode('_', $sParentModuleName);
		
		$aInsert = array(
			'privacy' => (int) $iPrivacy,
			'privacy_comment' => (int) $iPrivacyComment,
			'type_id' => $sType,
			'user_id' => (defined('FEED_FORCE_USER_ID') ? FEED_FORCE_USER_ID : ($iOwnerUserId === null ? Phpfox::getUserId() : (int) $iOwnerUserId)),
			'parent_user_id' => $iParentUserId,
			'item_id' => $iItemId,
			'time_stamp' => $iNewTimeStamp,
			'parent_feed_id' => (int) $iParentFeedId,
			'parent_module_id' => (Phpfox::isModule($aParentModuleName[0]) ? $this->database()->escape($sParentModuleName) : null),
			'time_update' => $iNewTimeStamp,
		);
		
		if (!$this->_bIsCallback && !Phpfox::getParam('feed.add_feed_for_comments') && preg_match('/^(.*)_comment$/i', $sType))
		{
			$aInsert['feed_reference'] = true;
		}		
		
		if (empty($aInsert['parent_module_id']))
		{
			unset($aInsert['parent_module_id']);
		}
		if (defined('PHPFOX_APP_ID'))
		{
			$aInsert['app_id'] = PHPFOX_APP_ID;
		}
		
		//Plugin call
		if (($sPlugin = Phpfox_Plugin::get('feed.service_process_add__end')))
		{
			eval($sPlugin);
		}

		if ($this->_bIsNewLoop)
		{
			$aInsert['feed_reference'] = (int)$bIsTag;
			$this->database()->insert(Phpfox::getT('feed'), $aInsert);
		}
		else
		{
			$this->_iLastId = $this->database()->insert(Phpfox::getT(($this->_bIsCallback ? $this->_aCallback['table_prefix'] : '') . 'feed'), $aInsert);
		}
		
		if ($this->_bIsCallback && $this->_aCallback['module'] == 'pages' && !$this->_bIsNewLoop && $iParentUserId > 0)
		{			
			$aUser = $this->database()->select('u.user_id, p.view_id')
				->from(Phpfox::getT('user'), 'u')
				->join(Phpfox::getT('pages'), 'p', 'p.page_id = u.profile_page_id')
				->where('u.profile_page_id = ' . (int) $iParentUserId)
				->execute('getSlaveRow');

			if (!$aUser['view_id'])
			{
				if (isset($aUser['user_id']) && Phpfox::getUserId() == $aUser['user_id'])
				{
					$this->_bIsNewLoop = true;
					$this->_bIsCallback  = false;
					$this->_aCallback = array();
					$this->add($sType, $iItemId, $iPrivacy, $iPrivacyComment);
				}
				else
				{
					$this->_bIsNewLoop = true;
					$this->_bIsCallback  = false;
					$this->_aCallback = array();
					// $this->add($sType, $iItemId, $iPrivacy, $iPrivacyComment, 0, Phpfox::getUserId());
					$this->add($sType, $iItemId, $iPrivacy, $iPrivacyComment, 0, $iOwnerUserId === null ? Phpfox::getUserId() : $iOwnerUserId);
				}
			}
		}
		
		if ($sPlugin = Phpfox_Plugin::get('feed.service_process_add__end2'))
		{
			eval($sPlugin);
		}
		
		return $this->_iLastId;
	}
	
	public function update($sType, $iItemId, $iPrivacy = 0, $iPrivacyComment = 0)
	{		
		$this->database()->update($this->_sTable, array(
				'privacy' => (int) $iPrivacy,
				'privacy_comment' => (int) $iPrivacyComment,
			), 'type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int) $iItemId
		);
		
		return true;
	}	
	
	/**
	 * Deletes an entry from the feeds
	 *
	 * @param string $sType module as defined in: type_id
	 * @param integer $iId numeric as defined in item_id
	 */
	public function delete($sType, $iId, $iUser = false)
	{		
		$aFeeds = $this->database()->select('feed_id, user_id')
			->from(Phpfox::getT(($this->_bIsCallback ? $this->_aCallback['table_prefix'] : '') . 'feed'))
			->where('type_id = \'' . $sType . '\' AND item_id = ' . (int) $iId . ($iUser != false ? ' AND user_id = ' . (int)$iUser : ''))
			->execute('getRows');
			
		foreach ($aFeeds as $aFeed)
		{			
			// $this->cache()->remove('feed_' . $aFeed['user_id'], 'substr');			
			if ($iUser != false)
			{
				$this->database()->delete(Phpfox::getT('feed'), 'feed_id = ' . $aFeed['feed_id']);
			}
		}
		if ($iUser == false)
		{
			$this->database()->delete(Phpfox::getT('feed'), 'type_id = \'' . $sType . '\' AND item_id = ' . (int) $iId);
		}
		if ($sPlugin = Phpfox_Plugin::get('feed.service_process_delete__end'))
		{
			eval($sPlugin);
		}
	}
	
	public function deleteChild($sType, $iId)
	{		
		$this->database()->delete(Phpfox::getT('feed'), 'type_id = \'' . $sType . '\' AND child_item_id = ' . (int) $iId);
	}
	
	public function deleteFeed($iId, $sModule = null, $iItem = 0)
	{
		$aCallback = null;
		if (!empty($sModule))
		{
			if (Phpfox::hasCallback($sModule, 'getFeedDetails'))
			{
				$aCallback = Phpfox::callback($sModule . '.getFeedDetails', $iItem);
			}
		}
				
		$aFeed = Phpfox::getService('feed')->callback($aCallback)->getFeed($iId);
		if (!isset($aFeed['feed_id']))
		{			
			return false;
		}
		
		// http://www.phpfox.com/tracker/view/15253/
		if($aFeed['type_id'] == 'photo')
		{
			Phpfox::callback($aFeed['type_id'] . '.deleteFeedItem', $aFeed['item_id']);
		}
		
		if ($sPlugin = Phpfox_Plugin::get('feed.service_process_deletefeed'))
		{
			eval($sPlugin);
		}		
		
		$bCanDelete = false;
		if (Phpfox::getUserParam('feed.can_delete_own_feed') && ($aFeed['user_id'] == Phpfox::getUserId()))
		{
			$bCanDelete = true;
		}
		
		if (defined('PHPFOX_FEED_CAN_DELETE'))
		{
			$bCanDelete = true;
		}
		
		if (Phpfox::getUserParam('feed.can_delete_other_feeds'))
		{
			$bCanDelete = true;
		}		

		if ($bCanDelete === true)
		{		
			
			if (isset($aCallback['table_prefix']))
			{
				$this->database()->delete(Phpfox::getT($aCallback['table_prefix']  . 'feed'), 'feed_id = ' . (int) $iId);				
			}

			//$this->database()->delete(Phpfox::getT('feed'), 'feed_id = ' . $aFeed['feed_id'] . ' AND user_id = ' . $aFeed['user_id'] .' AND time_stamp = ' . $aFeed['time_stamp']);
			if ($aFeed['type_id'] == 'feed_comment')
			{
				$aCore = Phpfox::getLib('request')->getArray('core');
				if (isset($aCore['is_user_profile']) && $aCore['profile_user_id'] != Phpfox::getUserId())
				{

					$this->database()->delete(Phpfox::getT('feed'), 'user_id = ' . $aFeed['user_id'] .' AND time_stamp = ' . $aFeed['time_stamp'] . ' AND parent_user_id = ' . $aCore['profile_user_id']);
				}
				elseif (isset($aCore['is_user_profile']) && $aCore['profile_user_id'] == Phpfox::getUserId())
				{
					$this->database()->delete(Phpfox::getT('feed'), 'feed_id = ' . (int) $aFeed['feed_id']);
				}
				$this->database()->delete(Phpfox::getT('feed'), 'user_id = ' . $aFeed['user_id'] .' AND time_stamp = ' . $aFeed['time_stamp'] . ' AND parent_user_id = ' . Phpfox::getUserId());
			}
			else
			{
				$this->database()->delete(Phpfox::getT('feed'), 'user_id = ' . $aFeed['user_id'] .' AND time_stamp = ' . $aFeed['time_stamp']);
			}
			
			// Delete likes that belonged to this feed
			$this->database()->delete(Phpfox::getT('like'), 'type_id = "'. $aFeed['type_id'] .'" AND item_id = ' . $aFeed['item_id']);
				
			if (!empty($sModule))
			{
				if (Phpfox::hasCallback($sModule, 'deleteFeedItem'))
				{
					Phpfox::callback($sModule . '.deleteFeedItem', $iItem);
				}
			}
			
			// $this->cache()->remove('feed_' . $aFeed['user_id'], 'substr');			
			
			return true;
		}
		
		return false;
	}	

	public function addComment($aVals)
	{		
		if (empty($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}
		
		if (empty($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		
		if (empty($aVals['parent_user_id']))
		{
			$aVals['parent_user_id'] = 0;
		}
		
		if (!Phpfox::getService('ban')->checkAutomaticBan($aVals['user_status']))
		{
			return false;
		}		
		        
		$sStatus = $this->preParse()->prepare($aVals['user_status']);
		
		$iStatusId = $this->database()->insert(Phpfox::getT(($this->_bIsCallback ? $this->_aCallback['table_prefix'] : '') . 'feed_comment'), array(
				'user_id' => (int) Phpfox::getUserId(),
				'parent_user_id' => (int) $aVals['parent_user_id'],
				'privacy' => $aVals['privacy'],
				'privacy_comment' => $aVals['privacy_comment'],
				'content' => $sStatus,
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		if ($this->_bIsCallback)
		{
			if ($sPlugin = Phpfox_Plugin::get('feed.service_process_addcomment__1'))
			{
				eval($sPlugin);
			}
			$sLink = $this->_aCallback['link'] . 'comment-id_' . $iStatusId . '/';
	
			if (!empty($this->_aCallback['notification']) && !Phpfox::getUserBy('profile_page_id'))
			{
				Phpfox::getLib('mail')->to($this->_aCallback['email_user_id'])
					->subject($this->_aCallback['subject'])
					->message(sprintf($this->_aCallback['message'], $sLink))
                    ->notification( ($this->_aCallback['notification'] == 'pages_comment' ? 'comment.add_new_comment' : $this->_aCallback['notification']))
					->send();			
				if (Phpfox::isModule('notification'))
				{
					Phpfox::getService('notification.process')->add($this->_aCallback['notification'], $iStatusId, $this->_aCallback['email_user_id']);		
				}
			}
			
			return Phpfox::getService('feed.process')->add($this->_aCallback['feed_id'], $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], (int) $aVals['parent_user_id']);			
		}
		
		$aUser = $this->database()->select('user_name')
			->from(Phpfox::getT('user'))
			->where('user_id = ' . (int) $aVals['parent_user_id'])
			->execute('getRow');
		
		$sLink = Phpfox::getLib('url')->makeUrl($aUser['user_name'], array('comment-id' => $iStatusId));

		/* When a user is tagged it needs to add a special feed */
		if (!isset($aVals['feed_reference']) || empty($aVals['feed_reference']))
		{
			Phpfox::getLib('mail')->to($aVals['parent_user_id'])
			->subject(array('feed.full_name_wrote_a_comment_on_your_wall', array('full_name' => Phpfox::getUserBy('full_name'))))
			->message(array('feed.full_name_wrote_a_comment_on_your_wall_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink)))
			->notification('comment.add_new_comment')
			->send();
			
			if (Phpfox::isModule('notification'))
			{
				Phpfox::getService('notification.process')->add('feed_comment_profile', $iStatusId, $aVals['parent_user_id']);		
			}
			if (isset($aVals['feed_type']))
			{
				return Phpfox::getService('feed.process')->add($aVals['feed_type'], $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], (int) $aVals['parent_user_id']);
			}
		}
		else
		{ // This is a special feed
			// Send mail 
			
			return Phpfox::getService('feed.process')->add('feed_comment', $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], (int) $aVals['parent_user_id'], null,$aVals['feed_reference']);
		}
		return Phpfox::getService('feed.process')->add('feed_comment', $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], (int) $aVals['parent_user_id'], null, 0, (isset($aVals['parent_feed_id']) ? $aVals['parent_feed_id'] : 0), (isset($aVals['parent_module_id']) ? $aVals['parent_module_id'] : null));
	}
	
	public function getLastId()
	{
		return (int) $this->_iLastId;
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
		$aDeprecated = array(
			'approve',
			'like',
			'rate',	
			'updateCommentText',
			'deleteLikes'
		);
		
		if (in_array($sMethod, $aDeprecated))
		{
			return Phpfox_Error::set('Method deprecated since 2.1.0beta1');	
		}
		
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('feed.service_process__call'))
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
