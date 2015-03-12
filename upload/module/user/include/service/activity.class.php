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
 * @package  		Module_User
 * @version 		$Id: activity.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class User_Service_Activity extends Phpfox_Service
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user_activity');
	}
	
	public function getTop($sCategory)
	{		
		return Phpfox::callback($sCategory . '.getTopUsers');
	}
	
	public function update($iUserId, $sType, $sMethod = '+', $iCnt = 0)
	{		
		if (!$iUserId)
		{
			return false;
		}
			
		if ($sMethod != '+' && $sMethod != '-')
		{			
			return Phpfox_Error::trigger('Invalid activity method: ' . $sMethod);
		}

        /* Adding a hook based on this request http://www.phpfox.com/tracker/view/13054/ 
         * if ($sPlugin = Phpfox_Plugin::get('user.service_activity_update_1')){eval($sPlugin);if (isset($mReturn)){return $mReturn;}}
         */
		$sModule = $sType;
		$sModuleExtra = null;
		if (preg_match('/(.*)_(.*)/i', $sModule, $aMatches))
		{
			$sModule = $aMatches[1];
		}
				
		if (Phpfox::isModule($sModule) && Phpfox::hasCallback($sType, 'getTotalItemCount'))
		{
			$aTotalItemInfo = Phpfox::callback($sType . '.getTotalItemCount', $iUserId);
			$this->database()->select('uf.' . $aTotalItemInfo['field'] . ', ')->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = ua.user_id');			
		}
		
		$iPoints = Phpfox::getUserParam($sModule . '.points_' . $sType);
		
		$aRow = $this->database()->select("ua.activity_" . $sType . ", ua.activity_total, ua.activity_points, u.user_group_id")
			->from($this->_sTable, 'ua')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ua.user_id')
			->where('ua.user_id = ' . (int) $iUserId)
			->execute('getRow');			
			
		if ($iUserId != Phpfox::getUserId())
		{
			$iPoints = Phpfox::getService('user.group.setting')->getGroupParam($aRow['user_group_id'], $sModule . '.points_' . $sType);
		}
		
		$iTotal = 1;
		
		if ($iCnt)
		{
			$iTotal = ($iTotal * $iCnt);
			$iPoints = ($iPoints * $iCnt);			
		}
		
		if ($sMethod == '+')
		{
			$iItemTotal = ($aRow['activity_' . $sType] + $iTotal);
			$iPoints = ($aRow['activity_points'] + $iPoints);
			$iTotal = ($aRow['activity_total'] + $iTotal);
		}
		else 
		{
			$iItemTotal = ($aRow['activity_' . $sType] - $iTotal);
			$iPoints = ($aRow['activity_points'] - $iPoints);
			$iTotal = ($aRow['activity_total'] - $iTotal);	
			
			if ($iItemTotal < 0)
			{
				$iItemTotal = 0;
			}
			
			if ($iPoints < 0)
			{
				$iPoints = 0;	
			}	
			
			if ($iTotal < 0)
			{
				$iTotal = 0;	
			}						
		}		
		
		$this->database()->query("
			UPDATE " . $this->_sTable . "
			SET activity_" . $sType . " = " . (int) (isset($aTotalItemInfo['total']) ? $aTotalItemInfo['total'] : $iItemTotal) . ",
				activity_total = {$iTotal},
				activity_points = {$iPoints}
			WHERE user_id = " . (int) $iUserId . "
		");
		
		if (isset($aTotalItemInfo))
		{
			if ($sMethod == '+')
			{
				$iNewFieldCount = ($aRow[$aTotalItemInfo['field']] + 1);	
			}
			else 
			{
				$iNewFieldCount = ((int) $aRow[$aTotalItemInfo['field']] <= 0 ? 0 : ($aRow[$aTotalItemInfo['field']] - 1));
			}
			
			if (isset($aTotalItemInfo['total']))
			{
				$iNewFieldCount	= $aTotalItemInfo['total'];
			}
			
			 $this->database()->update(Phpfox::getT('user_field'), array($aTotalItemInfo['field'] => $iNewFieldCount), 'user_id = ' . (int) $iUserId);
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_activity_update')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function doGiftPoints($iTrgUser, $iAmount)
	{
		Phpfox::getUserParam('core.can_gift_points', true);
		$iAmount = (int)$iAmount;        
		// How many points do we have?
		if ( (Phpfox::getUserBy('activity_points') < 1) || ($iAmount > Phpfox::getUserBy('activity_points')) )
		{
			return Phpfox_Error::set('You do not have enough points to gift');
		}
		else if (Phpfox::getUserBy('activity_points') == 1)
		{
			$iAmount = 1;
		}
		$iAmount = abs($iAmount);
		// Get current values
		$aValues = $this->database()->select('activity_points, user_id, activity_points_gifted')
			->from(Phpfox::getT('user_activity'))
			->where('user_id = ' . Phpfox::getUserId() . ' OR user_id = ' . (int)$iTrgUser)
			->execute('getSlaveRows');
		
		foreach ($aValues as $aValue)
		{
			if ($aValue['user_id'] == Phpfox::getUserId())
			{
				$aSender = $aValue;
				continue;
			}
			else if ($aValue['user_id'] == $iTrgUser)
			{
				$aReceiver = $aValue; 
				continue;
			}
		}
		
		if (!isset($aSender) || !isset($aReceiver))
		{
			return Phpfox_Error::set('Invalid Transaction');
		}
		
		// Substract points
		$this->database()->update(Phpfox::getT('user_activity'), array('activity_points' => ($aSender['activity_points'] - ((int)$iAmount))), 'user_id = ' . Phpfox::getUserId());
		// Add points
		$this->database()->update(Phpfox::getT('user_activity'), array('activity_points' => ($aReceiver['activity_points'] + ((int)$iAmount))), 'user_id = ' . (int)$iTrgUser);
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_activity__call'))
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