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
 * @version 		$Id: request.class.php 5382 2013-02-18 09:48:39Z Miguel_Espinoza $
 */
class Friend_Service_Request_Request extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('friend_request');
	}
	
	public function isRequested($iUserId, $iFriendId)
	{
		if ($iFriendId === $iUserId)
		{
			return true;
		}
		
		$aRow = $this->database()->select('*')
			->from($this->_sTable)
			->where('user_id = ' . (int) $iFriendId . ' AND friend_user_id = ' . (int) $iUserId)
			->limit(1)
			->execute('getSlaveRow');
				
		if (isset($aRow['request_id']))
		{
			return true;
		}
		
		return false;
	}
	
	public function get($iPage = 0, $iLimit = 5, $iRequestId = 0)
	{
		$aCond = array();
		
		(($sPlugin = Phpfox_Plugin::get('friend.service_request_request_get')) ? eval($sPlugin) : false);
		
		$aCond[] = 'fr.user_id = ' . Phpfox::getUserId() . ' AND fr.is_ignore = 0';
		
		if ($iRequestId > 0)
		{
			$aCond[] = 'AND fr.request_id = ' . (int) $iRequestId;
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'fr')
			->where($aCond)
			->execute('getSlaveField');			
		
		$aRows = $this->database()->select('fr.request_id, fr.is_seen, fr.message, fr.friend_user_id, fr.time_stamp, fr.relation_data_id , ' . Phpfox::getUserField())
			->from($this->_sTable, 'fr')
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = fr.friend_user_id')
			->where($aCond)
			->limit($iPage, $iLimit, $iCnt)
			->order('fr.is_seen ASC, fr.time_stamp DESC')
			->group('fr.request_id')
			->execute('getSlaveRows');		
		
		$sIds = '';
		foreach ($aRows as $iKey => $aRow)
		{
			$sIds .= $aRow['request_id'] . ',';
			
			list($iTotal, $aMutual) = Phpfox::getService('friend')->getMutualFriends($aRow['friend_user_id'], 5);
			
			$aRows[$iKey]['mutual_friends'] = array('total' => $iTotal, 'friends' => $aMutual);
            if ($sPlugin = Phpfox_Plugin::get('friend.service_request_get__2')){eval($sPlugin);}
		}
		$sIds = rtrim($sIds, ',');
		
		if (!empty($sIds))
		{
			$this->database()->update(Phpfox::getT('friend_request'), array('is_seen' => '1'), 'request_id IN(' . $sIds . ')');
		}
				
        if ($sPlugin = Phpfox_Plugin::get('friend.service_request_get__3')){eval($sPlugin);}
        
		return array($iCnt, $aRows);
	}
	
	public function getPending($iPage = '', $sLimit = '')
	{		
		$aRows = array();		
		$sWhere = 'fr.friend_user_id = ' . Phpfox::getUserId();
		if (Phpfox::getParam('friend.hide_denied_requests_from_pending_list'))
		{
			$sWhere .= ' AND fr.is_ignore != 1';
		}
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'fr')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fr.user_id')
			->where($sWhere)
			->execute('getSlaveField');

		if ($iCnt)
		{				
			$aRows = $this->database()->select('fr.request_id, ' . Phpfox::getUserField())
				->from($this->_sTable, 'fr')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = fr.user_id')
				->where($sWhere)
				->limit($iPage, $sLimit, $iCnt)
				->order('fr.time_stamp DESC')
				->execute('getSlaveRows');				
		}		
		
		return array($iCnt, $aRows);
	}
	
	public function getTotal()
	{
		return $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('friend_request'))
			->where('user_id = ' . Phpfox::getUserId() . ' AND is_ignore = 0')
			->execute('getSlaveField');
	}
	
	public function getUnseenTotal()
	{
		return $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('friend_request'))
			->where('user_id = ' . Phpfox::getUserId() . ' AND is_seen = 0 AND is_ignore = 0')
			->execute('getSlaveField');
	}	
	
	public function getRequest($iRequestId)
	{
		$aRow = $this->database()->select('*')
			->from(Phpfox::getT('friend_request'))
			->where('request_id = ' . (int) $iRequestId)
			->execute('getSlaveRow');
		
		if (!isset($aRow['request_id']))
		{
			return false;
		}
		
		return (Phpfox::getUserId() == $aRow['user_id'] ? $aRow : false);
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
		if ($sPlugin = Phpfox_Plugin::get('friend.service_request_request__call'))
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