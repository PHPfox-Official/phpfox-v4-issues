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
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Notification_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('notification');
	}
	
	public function add($sType, $iItemId, $iOwnerUserId, $iSenderUserId = null)
	{
		if ($iOwnerUserId == Phpfox::getUserId())
		{
			return true;
		}
		
		if ($sPlugin = Phpfox_Plugin::get('notification.service_process_add'))
		{
			eval($sPlugin);
		}		

		if (isset($bDoNotInsert) || defined('SKIP_NOTIFICATION'))
		{
			return true;
		}
		
		$aInsert = array(
			'type_id' => $sType,
			'item_id' => $iItemId,
			'user_id' => $iOwnerUserId,	
			'owner_user_id' => ($iSenderUserId === null ? Phpfox::getUserId() : $iSenderUserId),
			'time_stamp' => PHPFOX_TIME		
		);	
		
		$this->database()->insert($this->_sTable, $aInsert);
		
		return true;
	}	
	
	public function delete($sType, $iItemId, $iUserId)
	{		
		$this->database()->delete($this->_sTable, "type_id = '" . $this->database()->escape($sType) . "' AND item_id = " . (int) $iItemId . " AND user_id = " . (int) $iUserId);
		
		return true;
	}	
	
	public function deleteByOwner($sType, $iItemId, $iUserId)
	{
		$this->database()->delete($this->_sTable, "type_id = '" . $this->database()->escape($sType) . "' AND owner_user_id = " . (int) $iItemId . " AND user_id = " . (int) $iUserId);		
		
		return true;
	}	
	
	public function deleteById($iId)
	{
		$this->database()->delete($this->_sTable, 'notification_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
		
		return true;
	}
	
	public function updateSeen($iId)
	{
		$this->database()->update($this->_sTable, array('is_seen' => 1), 'notification_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
	}
	
	public function hide($iId)
	{
		$this->database()->delete($this->_sTable, 'notification_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
		
		return true;
	}
	
	public function deleteAll()
	{
		$this->database()->delete($this->_sTable, 'user_id = ' . Phpfox::getUserId());
		
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
		if ($sPlugin = Phpfox_Plugin::get('notification.service_process__call'))
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