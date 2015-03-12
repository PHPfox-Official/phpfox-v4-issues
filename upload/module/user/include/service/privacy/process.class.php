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
 * @version 		$Id: process.class.php 5592 2013-03-28 12:54:36Z Raymond_Benc $
 */
class User_Service_Privacy_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function update($aVals, $iUserId = null)
	{
		if ($iUserId !== null && $iUserId != Phpfox::getUserId())
		{
			Phpfox::getUserParam('user.can_edit_other_user_privacy', true);
		}
		else 
		{
			$iUserId = Phpfox::getUserId();
		}

		$this->database()->delete(Phpfox::getT('user_notification'), 'user_id = ' . $iUserId);
		$this->database()->delete(Phpfox::getT('user_privacy'), 'user_id = ' . $iUserId);
		
		if (Phpfox::getUserParam('user.can_control_notification_privacy') && isset($aVals['notification']))
		{
			foreach ($aVals['notification'] as $sVar => $iVal)
			{
				if (!$iVal)
				{
					continue;
				}
				
				$this->database()->insert(Phpfox::getT('user_notification'), array(
						'user_id' => $iUserId,
						'user_notification' => $sVar
					)
				);
			}		
		}
		
		if (Phpfox::getUserParam('user.can_control_profile_privacy') && isset($aVals['privacy']))
		{
			foreach ($aVals['privacy'] as $sVar => $iVal)
			{
				if (!$iVal)
				{
					continue;
				}
				
				$this->database()->insert(Phpfox::getT('user_privacy'), array(
						'user_id' => $iUserId,
						'user_privacy' => $sVar,
						'user_value' => $iVal
					)
				);
			}		
		}

		if (Phpfox::getUserParam('user.can_control_profile_privacy'))
		{
			foreach ($aVals as $sVar => $aVal)
			{
				if (!preg_match('/(.*)\.(.*)/', $sVar, $aMatches))
				{
					continue;
				}
				
				if (!isset($aMatches[1]))
				{
					continue;
				}
				
				if (!Phpfox::isModule($aMatches[1]))
				{
					continue;
				}
							
				$iId = $this->database()->insert(Phpfox::getT('user_privacy'), array(
						'user_id' => $iUserId,
						'user_privacy' => $sVar,
						'user_value' => (int) $aVal[$sVar]
					)
				);
				/*
				if ($aVal[$sVar] == '4')
				{
					Phpfox::getService('privacy.process')->update('user', $iId, (isset($aVal['privacy_list']) ? $aVal['privacy_list'] : array()));			
				}
				*/					
			}		
		}		
				
		if (isset($aVals['blocked']))
		{
			foreach ($aVals['blocked'] as $iBlockId)
			{
				if (!is_numeric($iBlockId))
				{
					continue;
				}		
				
				Phpfox::getService('user.block.process')->delete($iBlockId);
			}
		}
		
		if (isset($aVals['special']))
		{
			if (isset($aVals['special']['dob_setting']))
			{
				Phpfox::getService('user.field.process')->update($iUserId, 'dob_setting', (int) $aVals['special']['dob_setting']);
				$this->cache()->remove(array('udob', $iUserId));
			}
		}
		
		if (Phpfox::getUserParam('user.can_be_invisible') && isset($aVals['invisible']))
		{
			$this->database()->update(Phpfox::getT('user'), array('is_invisible' => (int) $aVals['invisible']), 'user_id = ' . (int) $iUserId);			
		}
		
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_privacy_process__call'))
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