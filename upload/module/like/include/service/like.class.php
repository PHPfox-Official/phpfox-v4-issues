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
 * @version 		$Id: like.class.php 7054 2014-01-20 18:35:55Z Fern $
 */
class Like_Service_Like extends Phpfox_Service 
{
	private $_iTotalLikeCount = 0;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('like');	
	}
	
	public function getTotalLikes()
	{
		return $this->_iTotalLikeCount;
	}
	
	public function getLikesForFeed($sType, $iItemId, $bIsLiked = false, $iLimit = 4, $bLoadCount = false)
	{
		if ($bIsLiked)
		{
			// $iLimit--;
		}
		
		$sWhere = '(l.type_id = \'' . $this->database()->escape(str_replace('-','_',$sType)) . '\' OR l.type_id = \'' . str_replace('_','-',$sType) . '\') AND l.item_id = ' . (int) $iItemId;
		
		if (Phpfox::getParam('like.show_user_photos'))
		{
			$this->database()->where($sWhere);
		}
		else
		{
			// $this->database()->where($sWhere);
			$this->database()->where($sWhere . ' AND l.user_id != ' . Phpfox::getUserId());
			/*if (Phpfox::getParam('feed.cache_each_feed_entry'))
			{
				$this->database()->where($sWhere);
			}
			else
			{
				//$this->database()->where($sWhere . ' AND l.user_id != ' . Phpfox::getUserId());
			}*/
		}
		
		$aRowLikes = $this->database()->select('l.*, ' . Phpfox::getUserField() .', a.time_stamp as action_time_stamp')
			->from($this->_sTable, 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')			
            ->leftjoin(Phpfox::getT('action'), 'a', 'a.item_id = l.item_id AND a.user_id = l.user_id AND a.item_type_id = "' . str_replace('_', '-', $this->database()->escape($sType)) .'"')
			->order('l.time_stamp DESC')
			->group('u.user_id')
			->limit($iLimit)
			->execute('getSlaveRows');
		
		$aLikes = array();
        $aDontCount = array();
        foreach ($aRowLikes as $iKey => $aLike)
        {        	
            if (!empty($aLike['action_time_stamp']) && $aLike['action_time_stamp'] > $aLike['time_stamp'])
            {
                $aDontCount[] = $aLike['like_id'];

                continue;
            }
            
            $aLikes[$aLike['user_id']] = $aLike;
        }
		$this->_iTotalLikeCount = count($aLikes);
                
        if ($bLoadCount == true)
        {
            //$sWhere = 'l.type_id = \'' . $this->database()->escape($sType) . '\' AND l.item_id = ' . (int) $iItemId;
            if (!empty($aDontCount))
            {
                $sWhere .= ' AND l.like_id NOT IN (' . implode(',', $aDontCount) . ')';
            }
            $this->_iTotalLikeCount = $this->database()->select('COUNT(*)')
                    ->from(Phpfox::getT('like'), 'l')
                    ->where($sWhere)
                    ->execute('getSlaveField') ;
        }
		return $aLikes;
	}
	
	public function getTotalLikeCount()
	{
		return $this->_iTotalLikeCount;
	}
	
	/* Gets the dislikes to be displayed when the user clicked on "thumbsdown X people", in a child comment 
	 * when nested comments are enabled. The function getActionsFor is too much */
	public function getDislikes($sType, $iItemId, $bGetCount = false)
	{
		if ($sType == 'feed_mini')
		{
			$sType = 'comment';
		}
		if (strpos($sType, 'feed') !== false)
		{
			$sType = 'feed';
		}
		$sType = str_replace('_', '-', $sType);
		if ($bGetCount == true)
		{
			$this->database()
				->select('COUNT(*)')
				->order('u.full_name ASC');
			$sGetHow = 'getSlaveField';
		}
		else
		{
			$this->database()
				->select(Phpfox::getUserField() )
				->group('u.user_id');
			$sGetHow = 'getSlaveRows';
		}
		$aDislikes = $this->database()
			->from(Phpfox::getT('action'), 'a')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = a.user_id')			
			->where('a.item_type_id = "' . $this->database()->escape($sType) . '" AND a.item_id = ' . (int)$iItemId)			
			->execute($sGetHow);
		return $aDislikes;
	}
	
	public function getLikes($sType, $iItemId)
	{
	    if ($sType == 'feed')
	    {
            $this->database()->where('(l.type_id = "feed" OR l.type_id = "feed_comment") AND l.item_id = ' . (int)$iItemId);
	    }
	    else
	    {
			$this->database()->where('l.type_id = \'' . $this->database()->escape($sType) . '\' AND l.item_id = ' . (int) $iItemId);
	    }
		$aLikes = $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('like'), 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->order('u.full_name ASC')
			->group('u.user_id')
			->execute('getRows');
		
		return $aLikes;
	}	
	
	public function getForMembers($sType, $iItemId)
	{
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('like'), 'l')
			->where('l.type_id = \'' . $this->database()->escape($sType) . '\' AND l.item_id = ' . (int) $iItemId)
			->execute('getSlaveField');
		
		$aLikes = $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('like'), 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->where('l.type_id = \'' . $this->database()->escape($sType) . '\' AND l.item_id = ' . (int) $iItemId)
			->order('u.full_name ASC')
			->group('u.user_id')
			->limit(5)
			->execute('getRows');			
					
		return array($iCnt, $aLikes);		
	}

	/** This function checks if a specific item has been marked by the current user, for example if
	 * an item has been Disliked. Called from the like.link block
	 * @param int $iType `phpfox_action`.`action_type_id` like dislike, approve,...
	 * @param int 
	 * */
	public function hasBeenMarked($iActionType, $sTypeId, $iItemId, $iUserId = null)
	{
		if ($iUserId == null)
		{
			$iUserId = Phpfox::getUserId();
		}
		
		$oParse = Phpfox::getLib('parse.input');
		
		$sTypeId = $oParse->clean(str_replace('_', '-', $sTypeId));		
		
		$sWhere = 'action_type_id = ' . (int)$iActionType;
		if ($sTypeId == 'forum-reply')
		{
			$sWhere .= ' AND (item_type_id = "' . $sTypeId . '" OR item_type_id = "forum-post")';
		}
		else
		{
			$sWhere .= ' AND item_type_id = "' . $sTypeId . '"';
		}
		
		$sWhere .= ' AND item_id = ' . (int)$iItemId . ' AND user_id = ' . (int)$iUserId;
		
		$iActionId = $this->database()->select('action_id')
			->from(Phpfox::getT('action'))
			->where($sWhere)
			->execute('getSlaveField');

		return ((int)$iActionId) > 0;
	}
	
	/* Used to get information about dislikes for a specific item.
	 * Called from the block like.displayactions
	 */
	public function getActionsFor($sItemTypeId, $iItemId)
	{
		static $aCache = array();
		
		$_sItemTypeId = $sItemTypeId;
		$_iItemId = $iItemId;
		
		if (isset($aCache[$_sItemTypeId  . $_iItemId]))
		{
			return $aCache[$_sItemTypeId  . $_iItemId];
		}
				
		$aOut = array();
		$oParse = Phpfox::getLib('parse.input');
		$sItemTypeId = str_replace('_','-', $sItemTypeId);
		$aModule = explode('-', $sItemTypeId);
		if ($aModule[0] == 'feed' && $sItemTypeId != 'feed-comment')
		{
		    $sItemTypeId = 'feed';
		}
	
		$oUrl = Phpfox::getLib('url');
		
		
		// Check that the module exists
		if (!Phpfox::isModule($aModule[0]) || !Phpfox::hasCallback($aModule[0], 'getActions'))
		{
			$aCache[$_sItemTypeId  . $_iItemId] = false;
			
			return false;			
		}
		
		$aCallback = Phpfox::callback($aModule[0] . '.getActions');
		// find this specific callback
		$aThisAction = null;
		foreach ($aCallback as $aAction)
		{
			if (str_replace('_', '-', $aAction['item_type_id']) == $sItemTypeId || ($aModule[0] . '-' . $aAction['item_type_id']) == $sItemTypeId || ($aModule[0] == $aAction['item_type_id']))
			{
				$aThisAction = $aAction;
				break;
			}
		}
		
		if ($aThisAction == null)
		{
			$aCache[$_sItemTypeId  . $_iItemId] = false;
			
			return false;			
		}
		if (!isset($aThisAction['phrase_in_past_tense']))
		{
			$aCache[$_sItemTypeId  . $_iItemId] = false;
			
			return false;			
		}
		
        $sWhere = 'a.item_type_id = "'. $oParse->clean($sItemTypeId) .'" AND a.item_id = ' . (int)$iItemId;
		// get all the actions related to this item
		$aActions = $this->database()->select('a.*, u.user_name, u.full_name, f.friend_id as is_friend, l.type_id as like_type_id, l.time_stamp as like_time_stamp')
			->from(Phpfox::getT('action'), 'a')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = a.user_id')
			->leftjoin(Phpfox::getT('friend'), 'f', 'f.friend_user_id = a.user_id AND f.user_id = ' . Phpfox::getUserId())
            ->leftjoin(Phpfox::getT('like'), 'l', 'l.item_id = a.item_id AND l.type_id = "'. str_replace('-', '_', $oParse->clean($sItemTypeId)) .'"')
            ->group('a.action_id')
			->where($sWhere)
			->execute('getSlaveRows');
        
		foreach ($aActions as $aAction)
		{
            if (isset($aAction['like_time_stamp']) && $aAction['like_time_stamp'] > $aAction['time_stamp'])
            {
               // continue;
            }
            
			if (!isset($aOut[$aAction['action_type_id']]))
			{
				$aOut[$aAction['action_type_id']] = array(
					'friends' => array(	), // array to store the user_id of friends who have voted
					'votes_from_friends' => 0, // counter used here
					'votes_from_non_friends' => 0, // votes from non-friends
					'total_votes_combined' => 0,				
					'phrase' => '',
					'phrase_for_friends' => '',
					'did_i_mark_it' => false
				);
			}
			// friends and total_marks count different things
			if ($aAction['is_friend'] > 0 || true)
			{
				if ($aAction['user_id'] != Phpfox::getUserId() && Phpfox::getParam('feed.total_likes_to_display') > $aOut[$aAction['action_type_id']]['votes_from_friends'])
				{
					// find the user id				
					$aOut[$aAction['action_type_id']]['friends'][$aAction['user_id']] = array('user_id' => $aAction['user_id'], 'user_name' => $aAction['user_name'], 'full_name' => $aAction['full_name']);
					$aOut[$aAction['action_type_id']]['phrase_for_friends'] .= '<a href="'. $oUrl->makeUrl($aAction['user_name']) . '">' . $aAction['full_name'] . '</a>, ';
					$aOut[$aAction['action_type_id']]['votes_from_friends']++;
				}				
			}
			else if ($aAction['user_id'] != Phpfox::getUserId())
			{
				$aOut[$aAction['action_type_id']]['votes_from_non_friends']++;
			}
			if ($aAction['user_id'] == Phpfox::getUserId())
			{
				$aOut[$aAction['action_type_id']]['did_i_mark_it'] = true;
			}
			
			$aOut[$aAction['action_type_id']]['total_votes_combined']++;
            $aOut[$aAction['action_type_id']]['time_stamp'] = $aAction['time_stamp'];
		}
		
		
		
		// now the phrases
		foreach ($aOut as $iKey => $aAction)
		{		
			if ($aAction['did_i_mark_it'])
			{	
				if ($aAction['votes_from_friends'] > 0)
				{				
					$aOut[$iKey]['phrase'] = Phpfox::getPhrase('like.disliked_friends_and_you', array('my_friends' => rtrim($aAction['phrase_for_friends'], ', '), 'item_type' => $aThisAction['item_phrase']));
				}
				else if ($aAction['votes_from_non_friends'] > 0 && $aAction['votes_from_friends'] == 0)
				{
					if ($aAction['votes_from_non_friends'] == 1)
					{						
						// You and one other disliked this {item_type}
						// $aOut[$iKey]['phrase'] = 'You and ' . $aAction['votes_from_non_friends'] . ' other ' . $aThisAction['phrase_in_past_tense'] . ' this ' . $aThisAction['item_phrase'];
						// disliked_you_and_one_more
						// You and one other disliked this {item_type}
						$aOut[$iKey]['phrase'] = Phpfox::getPhrase('like.disliked_you_and_one_more', array('item_type' => $aThisAction['item_phrase']));
					}
					else
					{
						// You and {votes_from_non_friends} others disliked this {item_type}
						$aOut[$iKey]['phrase'] = Phpfox::getPhrase('like.disliked_many_users', array('votes_from_non_friends' => $aAction['votes_from_non_friends'], 'item_type' => $aThisAction['item_phrase']));
						// $aOut[$iKey]['phrase'] = 'You and ' . $aAction['votes_from_non_friends'] . ' others ' . $aThisAction['phrase_in_past_tense'] . ' this ' . $aThisAction['item_phrase'];
					}
					
				}
				else
				{
					// You disliked this {item_type}
					// dislike_you_disliked
					$aOut[$iKey]['phrase'] = Phpfox::getPhrase('like.dislike_you_disliked', array('item_type' => $aThisAction['item_phrase'])); 
				}
			}
			else
			{
				if ($aAction['votes_from_friends'] > 0)
				{		
					$aOut[$iKey]['phrase'] = Phpfox::getPhrase('like.dislike_friends_disliked_this', array('my_friends' => rtrim($aAction['phrase_for_friends'], ', '), 'item_type' => $aThisAction['item_phrase']));
				}
				else if ($aAction['votes_from_non_friends'] > 0)
				{
					$aOut[$iKey]['phrase'] = Phpfox::getPhrase('like.disliked_users_disliked_this', array('non_friends' => $aAction['votes_from_non_friends'], 'item_type' => $aThisAction['item_phrase']));
				}
			}			
		}
		
		$aCache[$_sItemTypeId  . $_iItemId] = $aOut;
		
		return $aOut;
		
	}
	
        /* @return bool true if Phpfox::getUSerId() has liked $iItemId
         * 
         */
        public function didILike($sType, $iItemId, $aLikes = array())
        {
            $sType = str_replace('-', '_', $sType);
            if (empty($aLikes) || !is_array($aLikes))
            {
				$aLikes = $this->getLikes($sType, $iItemId);
			}
            foreach ($aLikes as $aLikes)
            {
                if ($aLikes['user_id'] == Phpfox::getUserId())
                {
                    return true;
                }
            }
            return false;
        }
	
	/**
	 * Gets how many dislikes a specific item has
	 * @param type $iItemId
	 * @param type $sActionType
	 * @return int
	 */
	public function getTotalMarks($iItemId, $sItemTypeId)
	{
	    $oParse = Phpfox::getLib('parse.input');
	    $iTotal = $this->database()->select('COUNT(action_id)')
            ->from(Phpfox::getT('action'))
            ->where('action_type_id = 2 AND item_type_id = "' . $oParse->clean($sItemTypeId) . '" AND item_id = ' . (int)$iItemId . '')
            ->execute('getSlaveField');
	    return $iTotal;
	}
	
	/* This function gets all the likes and all the dislikes for a specific item.
	* It is used in the ajax component in the like module in the _loadLikes function.
	* @return array 
	* 		returns array(
	* 			'likes' => array(
	* 				'total' => 44,
	*				'phrase' => 'phrase in plain text, already parsed and ready to output'
	*			),
	* 			'dislikes' => array(
	* 				'total' => 12,
	* 				'phrase' => 'phrase ready to output'
	* 			));
	*/ 
	public function getAll($sType, $iItem)
	{
		$aLikes = $this->getLikes($sType, $iItem);
		$aFeed = array('likes' => $aLikes);
		$aFeed['type_id'] = $sType;
		$aFeed['item_id'] = $iItem;
		$sLikePhrase = Phpfox::getService('feed')->getPhraseForLikes($aFeed);
		
		$aDislikes = $this->getActionsFor($sType, $iItem);
		
		$aOut = array(
			'likes' => array(
				'total' => count($aLikes),
				'phrase' => $sLikePhrase
			),
			'dislikes' => array(
				'total' => isset($aDislikes[2]) ? $aDislikes[2]['total_votes_combined'] : 0,
				'phrase' => isset($aDislikes[2]) ? $aDislikes[2]['phrase'] : ''
			)
		);
		
		return $aOut;		
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
		if ($sPlugin = Phpfox_Plugin::get('like.service_like__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>
