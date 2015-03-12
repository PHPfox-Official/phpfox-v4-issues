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
 * @version 		$Id: process.class.php 7260 2014-04-09 13:49:44Z Fern $
 */
class Im_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('im');	
	}
	
	public function add($iUserId)
	{
		Phpfox::isUser(true);
		
		$aRoom = $this->database()->select('im_id, parent_id, is_active')
			->from($this->_sTable)
			->where('user_id = ' . Phpfox::getUserId() . ' AND owner_user_id = ' . (int) $iUserId)
			->execute('getSlaveRow');
			
		if (isset($aRoom['parent_id']))
		{
			$iRoomId = $aRoom['parent_id'];
			
			$aUser = Phpfox::getService('user')->getUser($iUserId);
			
			$this->database()->update($this->_sTable, array('is_active' => '1'), 'im_id = ' . (int) $aRoom['im_id']);
			
			return array($iRoomId, $aUser['full_name'], ($aRoom['is_active'] ? true : false));			
		}
		
		$iRoomId = $this->database()->insert($this->_sTable, array(
				'user_id' => $iUserId,
				'owner_user_id' => Phpfox::getUserId(),
				'is_active' => '0',
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		$this->database()->update($this->_sTable, array('parent_id' => $iRoomId), 'im_id = ' . (int) $iRoomId);
		
		$this->database()->insert($this->_sTable, array(
				'parent_id' => $iRoomId,
				'user_id' => Phpfox::getUserId(),
				'owner_user_id' => $iUserId,
				'is_active' => '1',
				'time_stamp' => PHPFOX_TIME
			)
		);	
		
		$aUser = Phpfox::getService('user')->getUser($iUserId,'full_name');
		
		return array($iRoomId, $aUser['full_name'], false);	
	}
	
	public function delete($iId)
	{
		Phpfox::isUser(true);
		
		$this->database()->delete($this->_sTable, 'parent_id = ' . (int) $iId);
		
		return true;
	}
	
	public function close($iId)
	{
		Phpfox::isUser(true);
		
		$this->database()->update($this->_sTable, array(
				'is_active' => '0'
			), 'parent_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId()
		);
		
		return true;
	}
	
	public function addAlert($iUserId, $iId)
	{
		$this->removeAlert($iUserId, $iId);
		$this->database()->insert(Phpfox::getT('im_alert'), array(
				'user_id' => (int) $iUserId,
				'room_id' => (int) $iId
			)
		);
	}
	
	public function removeAlert($iUserId, $iId)
	{
		$this->database()->delete(Phpfox::getT('im_alert'), 'user_id = ' . (int) $iUserId . ' AND room_id = ' . (int) $iId);
	}	
	
	public function block($iId)
	{
		Phpfox::isUser(true);
		
		$aRoom = $this->database()->select('parent_id, owner_user_id')
			->from($this->_sTable)
			->where('parent_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId())
			->execute('getSlaveRow');
			
		if (!isset($aRoom['parent_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('im.unable_to_block_this_user'));
		}
		
		$this->database()->update($this->_sTable, array(
				'is_active' => '0'
			), 'parent_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId()
		);		
		
		return Phpfox::getService('user.block.process')->add($aRoom['owner_user_id']);
	}
	
	/**
	 * This function is only called from the ajax function im.add
	 * @param type $aVals
	 * @return type 
	 */
	public function addText($aVals)
	{
		Phpfox::isUser(true);
		
		$aValid = array(
			'parent_id' => array(
				'type' => 'int:required'
			),
			'text' => array(
				'type' => 'string:required'
			)
		);
		
		if (isset($aVals['text']) && Phpfox::getLib('parse.format')->isEmpty($aVals['text']) && $aVals['text'] != '0')
		{
			return false;
		}		
		
		$aVals = $this->validator()->allowZero()->process($aValid, $aVals); // Cant use validator because "0" is considered empty 
		//$aVals['text'] = Phpfox::getLib('parse.input')->clean($aVals['text']);
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}		
		
		$aChat = Phpfox::getService('im')->getChat($aVals['parent_id']);
		
		if (!isset($aChat['im_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('im.not_a_valid_chat_room'));
		}
		
		if (!$aChat['is_logged_in'])
		{
			return Phpfox_Error::set(Phpfox::getPhrase('im.unable_to_send_this_user_an_offline_message'));
		}
		Phpfox::getService('ban')->checkAutomaticBan($aVals['text']);
		$aVals['user_id'] = Phpfox::getUserId();
		$aVals['time_stamp'] = PHPFOX_TIME; 
		$aVals['text'] = $this->preParse()->clean($aVals['text']);
		//if ($sPlugin = Phpfox_Plugin::get('im.service_process_addtext_pre_insert')){eval($sPlugin);}
		$iId = $this->database()->insert(Phpfox::getT('im_text'), $aVals);
		
		if (($sPlugin = Phpfox_Plugin::get('im.service_process_addtext_1')))
		{
			eval($sPlugin);
			if (isset($mReturnFromPlugin))
			{
				return $mReturnFromPlugin;
			}
		}
		
		//$this->database()->update($this->_sTable, array('is_active' => '1', 'last_update' => PHPFOX_TIME), 'parent_id = ' . $aVals['parent_id'] . '');		
		
		/* Check if the other user has this chat conversation open */
		$aOpen = $this->database()->select('is_active, is_new')->from($this->_sTable)->where('parent_id = ' . (int)$aVals['parent_id'])->execute('getSlaveRow');
		$aUpdate = array();
		if ($aOpen['is_new'] = 0)
		{
			//$aUpdate = array('is_new' => $iId);
		}
		if ($aOpen['is_active'] != 2)
		{
			$aUpdate['is_active'] = '1';
		}
		if (!empty($aUpdate))
		{
			//$this->database()->update($this->_sTable, $aUpdate, 'parent_id = ' . $aVals['parent_id'] . ' AND owner_user_id = ' . Phpfox::getUserId());
		}
		
		if (Phpfox::getService('im')->canAddAlert($aChat['user_id'], $aChat['parent_id']))
		{
			$this->addAlert($aChat['user_id'], $aChat['parent_id']);
		}
		
		// http://www.phpfox.com/tracker/view/15335/
		$sCacheId = $this->cache()->set('chat_rooms_user_' . $aChat['owner_user_id']);
		if($aChatData = $this->cache()->get($sCacheId))
		{
			$aChatData['room_id'][$aChat['parent_id']] = Phpfox::getUserId();
		}
		else
		{
			$aChatData = array('room_id' => array($aChat['parent_id'] => Phpfox::getUserId()));
		}
		$sCacheId = $this->cache()->set('chat_rooms_user_' . $aChat['owner_user_id']);
		$this->cache()->save($sCacheId, $aChatData);
		
		return true;
	}
	
	public function processNotificationCheck($iParentId)
	{
		$sCacheId = $this->cache()->set('chat_rooms_user_' . Phpfox::getUserId());
		if($aChatData = $this->cache()->get($sCacheId))
		{
			if(count($aChatData['room_id']) > 1)
			{
				unset($aChatData['room_id'][$iParentId]);
				$sCacheId = $this->cache()->set('chat_rooms_user_' . Phpfox::getUserId());
				$this->cache()->save($sCacheId, $aChatData);
			}
			else
			{
				$this->cache()->remove($sCacheId);
			}
		}
	}
	
	public function isSeen($iId)
	{
		Phpfox::isUser(true);
		
		//$this->database()->update($this->_sTable, array('is_new' => '0'), 'parent_id = ' . $iId . ' AND user_id = ' . Phpfox::getUserId());		
	}
	
	/**
	 * This function is called when opening a conversation by clicking an im.link 
	 * Its purpose is to define the currently open chat room as to keep it open in case of
	 * a page refresh.
	 * is_active = 1 : Conversation is active but the messages are not showing
	 * is_active = 2 : Conversation is active and messages are showing
	 * is_active = 0 : Conversation is inactive
	 * @param int $iId
	 * @return int 
	 */
	public function openChat($iId)
	{
		/* set the current open chat as active*/
		$this->database()->update(Phpfox::getT('im'), array('is_active' => 1), 'user_id = ' . Phpfox::getUserId() . ' AND is_active = 2');
		return $this->database()->update(Phpfox::getT('im'), array('is_active' => 2), 'user_id = ' . Phpfox::getUserId() . ' AND parent_id = ' . (int)$iId);
	}
	
	/**
	 * This function updates `phpfox_im`.`is_active` setting parent_id = $iId to 1 
	 * to remember user minimized the room in case of a page refresh
	 * 
	 * @param int|string $iId if INT we close one room specifically, if "all" we close 
	 * all rooms for this user
	 */
	public function hideRoom($iId)
	{
		
		$this->database()->update(Phpfox::getT('im'), array('is_active' => 1), 'user_id = ' . Phpfox::getUserId() . ' AND is_active = 2' . ($iId != 'all' ? ' AND parent_id = ' . (int)$iId : ''));
	}
	public function goOffline()
	{
		Phpfox::isUser(true);
		
		$oSession = Phpfox::getLib('session');
		$oRequest = Phpfox::getLib('request');
		
		$this->database()->update(Phpfox::getT('user'), array('im_hide' => '1'), 'user_id = ' . Phpfox::getUserId());
		$this->database()->update(Phpfox::getT('log_session'), array(
				'im_status' => '2',
				'im_hide' => '1'
			), "session_hash = '" . $this->database()->escape($oSession->get('session')) . "' AND id_hash = '" . $this->database()->escape($oRequest->getIdHash()) . "'"
		);		
	}
	
	public function goOnline()
	{
		Phpfox::isUser(true);
		
		$oSession = Phpfox::getLib('session');
		$oRequest = Phpfox::getLib('request');
		
		$this->database()->update(Phpfox::getT('user'), array('im_hide' => '0'), 'user_id = ' . Phpfox::getUserId());
		$this->database()->update(Phpfox::getT('log_session'), array(
				'im_status' => '0',
				'im_hide' => '0'
			), "session_hash = '" . $this->database()->escape($oSession->get('session')) . "' AND id_hash = '" . $this->database()->escape($oRequest->getIdHash()) . "'"
		);		
	}
	
	public function changeStatus($iStatusId)
	{
		Phpfox::isUser(true);
		
		$iStatusId = (int) $iStatusId;
		
		$iHide = '0';
		if ($iStatusId == 2)
		{
			$iHide = '2';
		}
		
		$oSession = Phpfox::getLib('session');
		$oRequest = Phpfox::getLib('request');
		
		$this->database()->update(Phpfox::getT('user'), array('im_hide' => $iHide), 'user_id = ' . Phpfox::getUserId());
		$this->database()->update(Phpfox::getT('log_session'), array(
				'im_status' => $iStatusId,
				'im_hide' => $iHide
			), "session_hash = '" . $this->database()->escape($oSession->get('session')) . "' AND id_hash = '" . $this->database()->escape($oRequest->getIdHash()) . "'"
		);		
	}
	
	public function playSound($iStatus)
	{
		$this->database()->update(Phpfox::getT('user'), array(
				'im_beep' => (int) $iStatus
			), 'user_id = ' . Phpfox::getUserId()
		);
	}
	
	public function updateOrder($aOrders)
	{
		$iCnt = 0;
		foreach ($aOrders as $iId => $iOrder)
		{
			$iCnt++;
			$this->database()->update(Phpfox::getT('im'), array('ordering' => $iCnt), 'parent_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
		}
	}
	
	public function toggleSound($iEnabled)
	{
		Phpfox::isUser(true);
		$this->database()->update(Phpfox::getT('user'), array('im_beep' => (int)$iEnabled), 'user_id = ' . Phpfox::getUserId());
	}
	
	public function clearConversation($iParent)
	{
		Phpfox::isUser(true);
		$this->database()->update(Phpfox::getT('im'), array('cleared_time_stamp' => PHPFOX_TIME), 'parent_id = ' . (int)$iParent . ' AND user_id = ' . Phpfox::getUserId());
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
		if ($sPlugin = Phpfox_Plugin::get('im.service_process__call'))
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
