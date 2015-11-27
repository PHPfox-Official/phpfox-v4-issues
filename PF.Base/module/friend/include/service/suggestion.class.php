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
 * @version 		$Id: suggestion.class.php 3327 2011-10-20 09:26:10Z Miguel_Espinoza $
 */
class Friend_Service_Suggestion extends Phpfox_Service 
{
	private $_aUsers = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getSingle()
	{		
		$this->_build();		

		if (is_array($this->_aUsers) && count($this->_aUsers))
		{
			$iRand = rand(1, count($this->_aUsers));
			
			if (isset($this->_aUsers[$iRand]))
			{
				$aUser = Phpfox::getService('user')->getUser($this->_aUsers[$iRand]['friend_user_id']);				
				if (isset($aUser['user_id']))
				{
					return $aUser;
				}
			}
		}
		
		return false;
	}
	
	public function get()
	{
		$this->_build();
		
		if (!is_array($this->_aUsers))
		{
			return array();
		}
		
		if (!count($this->_aUsers))
		{
			return array();
		}
		
		$sUsers = '';
		foreach ($this->_aUsers as $aUser)
		{
			$sUsers .= $aUser['friend_user_id'] . ',';
		}
		$sUsers = rtrim($sUsers, ',');
		
		if (empty($sUsers))
		{
			return array();
		}
		
		$aUsers = $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('user'), 'u')
			->where('user_id IN(' . $sUsers . ')')			
			->execute('getSlaveRows');
		
		return $aUsers;
	}
	
	public function reBuild($iUserId = null)
	{
		$this->cache()->remove('friend_suggestion_' . ($iUserId === null ? Phpfox::getUserId() : $iUserId));
	}
	
	public function remove($iUserId)
	{
		$this->database()->insert(Phpfox::getT('friend_hide'), array(
				'user_id' => Phpfox::getUserId(),
				'friend_user_id' => (int) $iUserId,
				'time_stamp' => PHPFOX_TIME
			)
		);	
		
		$this->reBuild();
		
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
		if ($sPlugin = Phpfox_Plugin::get('friend.service_suggestion__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

	private function _build()
	{
		$sCacheId = $this->cache()->set('friend_suggestion_' . Phpfox::getUserId());		
		if (!($this->_aUsers = $this->cache()->get($sCacheId, Phpfox::getParam('friend.friend_suggestion_timeout'))))
		{
			$aCache = array();
			
			// Lets get some of the users friends
			$aFriends = $this->database()->select('friend_user_id')
				->from(Phpfox::getT('friend'), 'f')				
				->where('f.user_id = ' . (int) Phpfox::getUserId())
				->limit(Phpfox::getParam('friend.friend_suggestion_search_total'))
				->order('RAND()')
				->execute('getSlaveRows');
			
			$iCnt = 0;
			foreach ($aFriends as $aFriend)
			{
				// Lets find some friends of this persons list of friends				
				$aSubFriends = $this->database()->select('f.friend_user_id, u.country_iso, uf.country_child_id, uf.city_location')
					->from(Phpfox::getT('friend'), 'f')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
					->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = f.friend_user_id')
					->leftJoin(Phpfox::getT('friend_hide'), 'fh', 'fh.user_id = ' . Phpfox::getUserId() . ' AND fh.friend_user_id = f.friend_user_id')
					->leftJoin(Phpfox::getT('friend_request'), 'fr', 'fr.user_id = f.friend_user_id AND fr.friend_user_id = ' . Phpfox::getUserId())
					->where('f.user_id = ' . (int) $aFriend['friend_user_id'] . ' AND ' . $this->database()->isNull('fh.hide_id') . ' AND ' . $this->database()->isNull('fr.request_id') .' AND u.profile_page_id = 0')					
					->limit(Phpfox::getParam('friend.friend_suggestion_search_total'))
					->order('RAND()')
					->execute('getSlaveRows');					
				
				foreach ($aSubFriends as $aSubFriend)
				{
					if ($aSubFriend['friend_user_id'] == Phpfox::getUserId())
					{
						continue;
					}
					
					if (!isset($aCache[$aSubFriend['friend_user_id']]))
					{
						$iCnt++;
						
						$aCache[$aSubFriend['friend_user_id']] = $aSubFriend;
					}
				}			
				
				if ($iCnt >= 100)
				{
					break;
				}			
			}
			
			unset($aFriends, $aFriend);
			
			$sQuery = '';
			foreach ($aCache as $iFriendId => $aFriend)
			{
				$sQuery .= ',' . $iFriendId;
			}
			$sQuery = ltrim($sQuery, ',');	
			
			if (empty($sQuery))
			{
				return false;
			}		
			
			$aFriends = $this->database()->select('friend_user_id')
				->from(Phpfox::getT('friend'), 'f')
				->where('user_id = ' . (int) Phpfox::getUserId() . ' AND friend_user_id IN(' . $sQuery . ')')
				->execute('getSlaveRows');
			foreach ($aFriends as $aFriend)
			{
				unset($aCache[$aFriend['friend_user_id']]);
			}		
			
			$aCurrentUser = Phpfox::getService('user')->get(Phpfox::getUserId());		
			
			$iCnt = 0;
			$this->_aUsers = array();	
			foreach ($aCache as $iKey => $aUser)
			{
				if (Phpfox::getParam('friend.friend_suggestion_user_based'))
				{
					if (!empty($aCurrentUser['country_iso']) && $aCurrentUser['country_iso'] != $aUser['country_iso'])
					{
						continue;
					}
					
					if (!empty($aCurrentUser['country_child_id']) && $aCurrentUser['country_child_id'] != $aUser['country_child_id'])
					{
						continue;
					}	
					
					if (!empty($aCurrentUser['city_location']) && $this->_city($aCurrentUser['city_location']) != $this->_city($aUser['city_location']))
					{
						continue;
					}	
				}
				
				if ($sPlugin = Phpfox_Plugin::get('friend.service_suggestion__build_search'))
				{
					eval($sPlugin);					
				}				
				
				$iCnt++;
				
				if ($iCnt === 22)
				{
					break;
				}
				
				$this->_aUsers[$iCnt] = $aUser;
			}
			
			$this->cache()->save($sCacheId, $this->_aUsers);
		}		
	}
	
	private function _city($sCity)
	{	
		return md5(preg_replace('/\s/m', '', $sCity));
	}
}

?>