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
 * @package  		Module_Privacy
 * @version 		$Id: privacy.class.php 6872 2013-11-11 16:30:16Z Fern $
 */
class Privacy_Service_Privacy extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('privacy');
	}
	
	public function get($sModule, $iItemId)
	{
		(($sPlugin = Phpfox_Plugin::get('privacy.service_privacy_get')) ? eval($sPlugin) : false);
		
		$aRows = $this->database()->select('privacy.*')
			->from($this->_sTable, 'privacy')
			->where("module_id = '" . $this->database()->escape($sModule) . "' AND item_id = " . (int) $iItemId . "")
			->execute('getSlaveRows');		
		
		return $aRows;
	}
	
	/**
	 * Verify if a user is allowed to view a private item (eg. blog, photo etc...)
	 *
	 * @param string $sCategory Is the module name
	 * @param int $iItemId Is the item unique ID#
	 * @param int $iUserId Is the items users ID#
	 * @param bool $bRedirect Option to redirect on failure
	 * @return bool Return true if user can view the item, or false on failure
	 */
	public function verify($sCategory, $iItemId, $iUserId, $bRedirect = true)
	{
		$iCnt = 0;
		if (Phpfox::getUserParam('core.can_view_private_items'))
		{
			$iCnt = 1;
		}		
		
		if (!Phpfox::getUserId())
		{
			$iCnt = 0;
		}		

		if ($iCnt === 0)
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from($this->_sTable)
				->where("item_id = " . (int) $iItemId . " AND module_id = '" . $this->database()->escape($sCategory) . "' AND user_id = " . Phpfox::getUserId() . "")
				->execute('getSlaveField');
		}		
		
		if ((int) $iCnt === 0)
		{			
			if ($bRedirect)
			{				
				Phpfox::getLib('url')->send('privacy.invalid');
			}
			
			return false;
		}
		
		return true;
	}
	
	public function getForBrowse(&$aUser)
	{
		$sPrivacy = '0';
		if ($aUser['user_id'] == Phpfox::getUserId() || Phpfox::getUserParam('privacy.can_view_all_items'))
		{
			$sPrivacy = '0,1,2,3,4';
		}
		else 
		{
			if ($aUser['is_friend'])
			{
				$sPrivacy = '0,1,2';
			}
			elseif ($aUser['is_friend_of_friend'])
			{
				$sPrivacy = '0,2';
			}			
		}
		
		return $sPrivacy;
	}
	
	public function check($sModule, $iItemId, $iUserId, $iPrivacy, $iIsFriend = null, $bReturn = false)
	{
		$bCanViewItem = true;
		if ($iUserId != Phpfox::getUserId() && !Phpfox::getUserParam('privacy.can_view_all_items'))
		{
			switch ($iPrivacy)
			{
				case 1:
					if ((int) $iIsFriend <= 0)
					{
						$bCanViewItem = false;
					}
					break;
				case 2:
					if ((int) $iIsFriend > 0)
					{
						$bCanViewItem = true;
					}
					else 
					{
						if (!Phpfox::getService('friend')->isFriendOfFriend($iUserId))
						{
							$bCanViewItem = false;	
						}
					}
					break;
				case 3:
					$bCanViewItem = false;
					break;
				case 4:
					if (Phpfox::isUser())
					{
						$iCheck = (int) $this->database()->select('COUNT(privacy_id)')
							->from($this->_sTable, 'p')
							->join(Phpfox::getT('friend_list_data'), 'fld', 'fld.list_id = p.friend_list_id AND fld.friend_user_id = ' . Phpfox::getUserId())
							->where('p.module_id = \'' . $this->database()->escape($sModule) . '\' AND p.item_id = ' . (int) $iItemId . '')
							->execute('getSlaveField');
						
						if ($iCheck === 0)
						{
							$bCanViewItem = false;
						}
					}
					else 
					{
						$bCanViewItem = false;
					}
					break;
			}
		}
		
		if ($bReturn === true)
		{
			return $bCanViewItem;
		}
		
		if ($bCanViewItem === false)
		{
			Phpfox::getLib('url')->send('privacy.invalid');
		}
	}
	
	public function getPhrase($iPrivacy)
	{
		switch ((int) $iPrivacy)
		{
			case 1:
				$sPhrase = Phpfox::getPhrase('privacy.friends');
				break;
			case 2:
				$sPhrase = Phpfox::getPhrase('privacy.friends_of_friends');
				break;
			case 3:
				$sPhrase = Phpfox::getPhrase('privacy.only_me');
				break;
			case 4:
				$sPhrase = Phpfox::getPhrase('privacy.custom');
				break;
			default:
				$sPhrase = Phpfox::getPhrase('privacy.everyone');
				break;
		}
		
		(($sPlugin = Phpfox_Plugin::get('privacy.service_privacy_getphrase')) ? eval($sPlugin) : '');
		
		return $sPhrase;
	}
	
	public function buildPrivacy($aCond = array())
	{		
		$bIsCount = (isset($aCond['count']) ? true : false);
		
		$oObject = Phpfox::getService($aCond['service']);
		
		if (Phpfox::getUserParam('core.can_view_private_items'))
		{
			$oObject->getQueryJoins($bIsCount, true);
			
			// http://www.phpfox.com/tracker/view/14708/
			if(!$bIsCount && isset($aCond['join']) && !empty($aCond['join']))
			{
				$this->database()->leftjoin(
					$aCond['join']['table'], 
					$aCond['join']['alias'], 
					$aCond['join']['alias'] . "." . $aCond['join']['field'] . ' = ' . $aCond['alias'] . "." . $aCond['field']
				);
			}
					
			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])
				->where(str_replace('%PRIVACY%', '0,1,2,3,4', $this->search()->getConditions()))
				->union();			
			
			return;
		}		
		
		$aUserCond = array();
		$aFriendCond = array();
		$aFriendOfFriends = array();
		$aCustomCond = array();
		$aPublicCond = array();
		foreach ($this->search()->getConditions() as $sCond)
		{			
			$aFriendCond[] = str_replace('%PRIVACY%', '1,2', $sCond);
			$aFriendOfFriends[] = str_replace('%PRIVACY%', '2', $sCond);
			$aUserCond[] = str_replace('%PRIVACY%', (Phpfox::getParam('core.friends_only_community') ? '' : '') . '1,2,3,4', $sCond);
			$aCustomCond[] = str_replace('%PRIVACY%', '4', $sCond);
			$aPublicCond[] = str_replace('%PRIVACY%', '0', $sCond);
		}		
		
		// Users items
		if (Phpfox::isUser())
		{							
			$oObject->getQueryJoins($bIsCount, true);
					
			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])
				->where(array_merge(array('AND ' . $aCond['alias'] . '.user_id = ' . Phpfox::getUserId()), $aUserCond))									
				->union();
		}				
			
		// Items based on custom lists
		if (Phpfox::isUser())
		{			
			$oObject->getQueryJoins($bIsCount);
										
			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])						
				->join(Phpfox::getT('privacy'), 'p', 'p.module_id = \'' . str_replace('.', '_', $aCond['module_id']) . '\' AND p.item_id = ' . $aCond['alias'] . '.' . $aCond['field'])
				->join(Phpfox::getT('friend_list_data'), 'fld', 'fld.list_id = p.friend_list_id AND fld.friend_user_id = ' . Phpfox::getUserId() . '')
				->where($aCustomCond)									
				->union();
		}					
			
		// Friend of friends items		
		if (!Phpfox::getParam('core.friends_only_community') && Phpfox::isUser())
		{			
			$oObject->getQueryJoins($bIsCount);

			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])		
				->join(Phpfox::getT('friend'), 'f1', 'f1.is_page = 0 AND f1.user_id = ' . $aCond['alias'] . '.user_id')
				->join(Phpfox::getT('friend'), 'f2', 'f2.is_page = 0 AND f2.user_id = ' . Phpfox::getUserId() . ' AND f2.friend_user_id = f1.friend_user_id')
				->where(array_merge(array($aCond['alias'] . '.user_id = f1.user_id AND ' . $aCond['alias'] . '.user_id != ' . Phpfox::getUserId() . ''), $aFriendOfFriends))				
				->union();
		}		
				
		// Friends items					
		if (Phpfox::isUser())
		{			
			$oObject->getQueryJoins($bIsCount, true);
			
			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])
				->join(Phpfox::getT('friend'), 'f', 'f.is_page = 0 AND f.user_id = ' . $aCond['alias'] . '.user_id AND f.friend_user_id = ' . Phpfox::getUserId())
				->where($aFriendCond)
				->union();	
		}	
		
		if (Phpfox::getParam('core.friends_only_community'))
		{
			// Public items
			$oObject->getQueryJoins($bIsCount);
						
			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])				
				->where(array_merge(array('AND ' . $aCond['alias'] . '.user_id != ' . Phpfox::getUserId()), $aPublicCond))
				->union();
			
			// Public items for the specific user
			$oObject->getQueryJoins($bIsCount, true);
							
			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])				
				->where(array_merge(array('AND ' . $aCond['alias'] . '.user_id = ' . Phpfox::getUserId()), $aPublicCond))
				->union();			
		}
		else 
		{
			// Public items
			$oObject->getQueryJoins($bIsCount);

			$this->database()->select(($bIsCount ? (isset($aCond['distinct']) ? 'COUNT(DISTINCT ' . $aCond['distinct'] . ')' : 'COUNT(*)') : $aCond['alias'] . '.*'))
				->from($aCond['table'], $aCond['alias'])				
				->where($aPublicCond)						
				->where($aPublicCond)
				->union();			
		}
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
		if ($sPlugin = Phpfox_Plugin::get('privacy.service_privacy__call'))
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
