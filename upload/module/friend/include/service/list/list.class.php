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
 * @package  		Module_Friend
 * @version 		$Id: list.class.php 5608 2013-04-03 11:52:10Z Miguel_Espinoza $
 */
class Friend_Service_List_List extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('friend_list');
	}
	
	public function getList($iId, $iUserId)
	{
		$aList = $this->database()->select('fl.*')
			->from($this->_sTable, 'fl')
			->where('fl.list_id = ' . (int) $iId . ' AND fl.user_id = ' . (int) $iUserId)
			->execute('getSlaveRow');

		if (!isset($aList['list_id']))
		{
			return false;
		}
		
		return $aList;
	}
	
	/**
	 * Gets the count of how many friends belong to a specific list
	 *
	 * @param String $sListName List name
	 */
	public function getCountForFolder($iListId)
	{
		$iCount = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('friend'), 'f')
			->where('f.list_id = \'' . (int) ($iListId).'\'')
			->execute('getField');
			
		return (int) $iCount;
		
	}
	
	/**
	 * Gets the folder to which a user belongs to
	 *
	 * @param integer $iUsedId the user's id
	 * @return int
	 */
	public function getFolderPerUser($iUsedId)
	{
		$iListId = $this->database()->select('f.list_id')
		->from(Phpfox::getT('friend'),'f')
		->where('friend_id = ' . (int)($iUsedId))
		->execute('getRow');
		return isset($iListId['list_id']) ? $iListId['list_id'] : 0; //table has set default = 0 anyways
	}	
	
	public function get()
	{
		static $aRows = array();
		
		if ($aRows)
		{
			return $aRows;
		}
		
		$aRows = $this->database()->select('fl.list_id, fl.name, COUNT(fld.friend_user_id) AS used')
			->from($this->_sTable, 'fl')	
			->leftJoin(Phpfox::getT('friend_list_data'), 'fld', 'fld.list_id = fl.list_id')
			->where('fl.user_id = ' . (int) Phpfox::getUserId())
			->group('fl.list_id')
			->order('fl.name ASC')
			->execute('getSlaveRows');

		return $aRows;
	}
	
	public function getUsersInAnyList()
	{
		if (!Phpfox::isUser())
		{
			return array();
		}		
		
		$aLists = $this->database()->select('list_id')->from($this->_sTable)->where('user_id = ' . Phpfox::getUserId())->execute('getSlaveRows');
		if (empty($aLists))
		{
			return array();
		}
		
		$sIn = '(';
		foreach ($aLists as $aList)
		{
			$sIn .= $aList['list_id'] .',';
		}
		$sIn = rtrim($sIn, ',') .')';
		$aUsers = $this->database()->select('friend_user_id')
			->from(Phpfox::getT('friend_list_data'))
			->group('friend_user_id')
			->where('list_id IN ' . $sIn)
			->execute('getSlaveRows');
			
		$aFriends = array();
		foreach ($aUsers as $aUser)
		{
			$aFriends[] = $aUser['friend_user_id'];
		}
		return $aFriends;
	}
	
	public function getListForUser($iUserId)
	{
		static $aLists = null;
		
		if ($aLists === null)
		{
			$aLists = $this->get();
		}
		
		foreach ($aLists as $iKey => $aList)
		{
			$iExists = (int) $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('friend_list_data'))
				->where('list_id = ' . (int) $aList['list_id'] . ' AND friend_user_id = ' . (int) $iUserId)
				->execute('getSlaveField');
			
			$aLists[$iKey]['is_active'] = ($iExists ? true : false);
		}
		
		return $aLists;
	}
	
	public function getListForProfile($iProfileId)
	{
		if (Phpfox::getParam('friend.cache_friend_list'))
		{
			$sCacheId = $this->cache()->set(array('friend_list', $iProfileId));
			if ( ($aList = $this->cache()->get($sCacheId)))
			{
				// if the array was empty when saved to cache it gets stored as 1 or true
				if (!is_array($aList))
				{
					$aList = array();
				}
				return $aList;
			}
		}
		
		$aLists = $this->database()->select('/*getListForProfile*/ fl.list_id, fl.name')			
			->from(Phpfox::getT('friend_list'), 'fl') 
			->where('fl.user_id = ' . (int) $iProfileId . ' AND fl.is_profile = 1')			
			->execute('getSlaveRows');
		
		$aSubList = array();		
		foreach ($aLists as $aList)
		{
			$aList['friends_total'] = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('friend_list_data'), 'fld')
				->join(Phpfox::getT('friend'), 'f', 'f.user_id = ' . (int) $iProfileId . ' AND f.friend_user_id = fld.friend_user_id')
				->where('fld.list_id = ' . (int) $aList['list_id'])
				->execute('getSlaveField');			
			
			$aList['friends'] = $this->database()->select(Phpfox::getUserField())
				->from(Phpfox::getT('friend_list_data'), 'fld')
				->join(Phpfox::getT('friend'), 'f', 'f.user_id = ' . (int) $iProfileId . ' AND f.friend_user_id = fld.friend_user_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = fld.friend_user_id')
				->where('fld.list_id = ' . (int) $aList['list_id'])
				->limit(5)
				->order('fld.ordering DESC')
				->execute('getSlaveRows');

			if (count($aList['friends']))
			{
				$aSubList[$aList['list_id']] = $aList;
			}
		}
		
		if (Phpfox::getParam('friend.cache_friend_list'))
		{
			$sCacheId = $this->cache()->set(array('friend_list', $iProfileId));
			$this->cache()->save($sCacheId, $aSubList);
		}
		return $aSubList;
	}
	
	public function isFolder($sName)
	{		
		return ($this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("name = '" . $this->database()->escape(Phpfox::getLib('parse.input')->clean($sName, 255)) . "' AND user_id = " . Phpfox::getUserId())
			->execute('getField') ? true : false);
	}

	public function reachedLimit()
	{
		if (Phpfox::getUserParam('friend.total_folders') > 0 && $this->database()->select('COUNT(*)')->from($this->_sTable)->where('user_id = ' .  Phpfox::getUserId())->execute('getField') >= Phpfox::getUserParam('friend.total_folders'))
		{
			return true;
		}
		
		return false;
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
		if ($sPlugin = Phpfox_Plugin::get('friend.service_list_list__call'))
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