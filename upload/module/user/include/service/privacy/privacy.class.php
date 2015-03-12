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
 * @version 		$Id: privacy.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class User_Service_Privacy_Privacy extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getUserSettings($iUserId = null)
	{		
		if ($iUserId !== null && $iUserId != Phpfox::getUserId())
		{
			Phpfox::getUserParam('user.can_edit_other_user_privacy', true);
		}
		
		$aNotifications = array();
		$aRows = $this->database()->select('user_notification')
			->from(Phpfox::getT('user_notification'))
			->where('user_id = ' . ($iUserId === null ? Phpfox::getUserId() : (int) $iUserId))
			->execute('getSlaveRows');
		
		foreach ($aRows as $aRow)
		{
			$aNotifications[$aRow['user_notification']] = true;
		}	
		
		$aPrivacy = array();
		$aRows = $this->database()->select('user_privacy, user_value')
			->from(Phpfox::getT('user_privacy'))
			->where('user_id = ' . ($iUserId === null ? Phpfox::getUserId() : (int) $iUserId))
			->execute('getSlaveRows');
		foreach ($aRows as $aRow)
		{
			$aPrivacy[$aRow['user_privacy']] = $aRow['user_value'];
		}
		
		return array(
			'notification' => $aNotifications,
			'privacy' => $aPrivacy
		);
	}	
	
	public function get($iUserId = null)
	{
		$aUserPrivacy = Phpfox::getService('user.privacy')->getUserSettings($iUserId);	
		$aNotifications = Phpfox::massCallback('getNotificationSettings');
		$aProfiles = Phpfox::massCallback('getProfileSettings');
		$aItems = Phpfox::massCallback('getGlobalPrivacySettings');
		
		if (is_array($aNotifications))
		{
			foreach ($aNotifications as $sModule => $aModules)
			{		
				if (!is_array($aModules))
				{
					continue;
				}
				foreach ($aModules as $sKey => $aNotification)
				{
					if (isset($aUserPrivacy['notification'][$sKey]))
					{
						$aNotifications[$sModule][$sKey]['default'] = 0;
					}
				}
			}		
		}
		
		foreach ($aProfiles as $sModule => $aModules)
		{			
			foreach ($aModules as $sKey => $aProfile)
			{
				if (isset($aUserPrivacy['privacy'][$sKey]))
				{
					$aProfiles[$sModule][$sKey]['default'] = $aUserPrivacy['privacy'][$sKey];
				}
				else 
				{
					$aProfiles[$sModule][$sKey]['default'] = (isset($aProfiles[$sModule][$sKey]['default']) ? $aProfiles[$sModule][$sKey]['default'] : 0);
				}
			}		
		}	

		foreach ($aItems as $sModule => $aModules)
		{			
			foreach ($aModules as $sKey => $aItem)
			{
				$aItems[$sModule][$sKey]['custom_id'] = str_replace('.', '_', $sKey);
			}	
		}	
		
		return array(
			$aUserPrivacy,
			$aNotifications,
			$aProfiles,
			$aItems
		);
	}
	
	public function hasAccess($iUserId, $sPrivacy, $bRedirect = false)
	{	
		static $aPrivacy = array();
		static $aIsFriend = array();
		static $aUserAge = array();
		
		if (Phpfox::getUserParam('user.can_override_user_privacy'))
		{
			return true; 
		}
		
		if ($iUserId == Phpfox::getUserId())
		{
			return true;			
		}
		
		$iUserAgeLimit = Phpfox::getParam('user.user_profile_private_age');
		
		if ($iUserAgeLimit > 0)
		{
			if (!isset($aUserAge[$iUserId]))
			{
				$aUserAge[$iUserId] = (int) Phpfox::getService('user')->age($this->database()->select('birthday')->from(Phpfox::getT('user'))->where('user_id = ' . (int) $iUserId)->execute('getSlaveField'));				
			}
			
			if ($aUserAge[$iUserId] < $iUserAgeLimit)
			{
				if (!Phpfox::isUser())
				{
					return false;
				}
				
				if (!isset($aIsFriend[$iUserId][Phpfox::getUserId()]))
				{
					$aIsFriend[$iUserId][Phpfox::getUserId()] = Phpfox::getService('friend')->isFriend($iUserId, Phpfox::getUserId());
				}				
				
				return $aIsFriend[$iUserId][Phpfox::getUserId()];
			}
		}
		
		$bPass = true;
		if (!isset($aPrivacy[$iUserId]))
		{			
			$aSettings = $this->database()->select('user_id, user_privacy, user_value')
				->from(Phpfox::getT('user_privacy'))
				->where('user_id = ' . (int) $iUserId)
				->execute('getSlaveRows');
				
			if (empty($aSettings))
			{
				$aPrivacy[$iUserId] = array();		
			}				
			else 
			{
				foreach ($aSettings as $aSetting)
				{
					$aPrivacy[$aSetting['user_id']][$aSetting['user_privacy']] = $aSetting['user_value'];
				}				
			}
		}	
		
		if (isset($aPrivacy[$iUserId][$sPrivacy]))
		{
			switch ($aPrivacy[$iUserId][$sPrivacy])
			{
				// Network (Logged in users)
				case '1':
					if (!Phpfox::isUser())
					{
						$bPass = false;
					}
					break;
				// Friends Only
				case '2':
					if (!Phpfox::isUser())
					{
						$bPass = false;
					}
					else 
					{
						if (!isset($aIsFriend[$iUserId][Phpfox::getUserId()]) && Phpfox::isModule('friend'))
						{
							$aIsFriend[$iUserId][Phpfox::getUserId()] = Phpfox::getService('friend')->isFriend($iUserId, Phpfox::getUserId());
						}
						
						if (isset($aIsFriend[$iUserId]) && !$aIsFriend[$iUserId][Phpfox::getUserId()])
						{
							$bPass = false;
						}						
					}					
					break;
				// Preferred List
				case '3':
					
					break;
				// No one
				case '4':
					$bPass = false;
					break;
			}
		}
		
		if (Phpfox::getService('user.block')->isBlocked($iUserId, Phpfox::getUserId()))
		{
			$bPass = false;	
		}
		
		if ($bPass === false && $bRedirect === true)
		{
			
		}
		
		return $bPass;
	}
	
	public function getValue($sVar)
	{
		static $aPrivacy = array();	
		
		$iUserId = Phpfox::getUserId();
		
		if (!isset($aPrivacy[$iUserId]))
		{
			$aSettings = $this->database()->select('user_id, user_privacy, user_value')
				->from(Phpfox::getT('user_privacy'))
				->where('user_id = ' . (int) $iUserId)
				->execute('getSlaveRows');
				
			if (empty($aSettings))
			{
				$aPrivacy[$iUserId] = array();		
			}				
			else 
			{
				foreach ($aSettings as $aSetting)
				{
					$aPrivacy[$aSetting['user_id']][$aSetting['user_privacy']] = $aSetting['user_value'];
				}				
			}
		}		
		
		return (int) (isset($aPrivacy[$iUserId][$sVar]) ? $aPrivacy[$iUserId][$sVar] : 0);
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_privacy_privacy__call'))
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