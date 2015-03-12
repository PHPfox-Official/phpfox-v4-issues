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
 * @version 		$Id: process.class.php 3467 2011-11-07 15:36:34Z Miguel_Espinoza $
 */
class Janrain_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('janrain');
	}
	
	public function add($aUserInfo)
	{
		$aVals = array(
			'user_group_id' => NORMAL_USER_ID,
			'joined' => PHPFOX_TIME,
			'last_ip_address' => Phpfox::getIp(),
			'last_activity' => PHPFOX_TIME			
		);
							
		$aVals['full_name'] = $aUserInfo['displayName'];
						
		if (empty($aVals['full_name']))
		{
			Phpfox::getLib('url')->send('janrain.account', array('type' => 'full-name'));
		}					
							
		if (!empty($aUserInfo['preferredUsername']))
		{
			$aVals['user_name'] = $aUserInfo['preferredUsername'];
		}							

		if (empty($aVals['user_name']))
		{
			$aVals['user_name'] = $aUserInfo['displayName'];
		}
							
		if (!empty($aUserInfo['email']))
		{
			Phpfox::getService('user.validate')->email($aUserInfo['email']);					
			if (Phpfox_Error::get())
			{
				Phpfox::getLib('url')->send('janrain.account', array('type' => 'email'));
			}
		}
							
		$aVals['user_name'] = Phpfox::getLib('parse.input')->prepareTitle('user', $aVals['user_name'], 'user_name', null, Phpfox::getT('user'));
		$aVals['email'] = (empty($aUserInfo['email']) ? null : $aUserInfo['email']);
		$aVals['gender'] = (!isset($aUserInfo['gender']) ? '0' : ($aUserInfo['gender'] == 'female' ? '2' : '1'));		
		
		$iUserId = $this->database()->insert(Phpfox::getT('user'), $aVals);
						
		$aExtras = array(
			'user_id' => $iUserId
		);

		$this->database()->insert(Phpfox::getT('user_activity'), $aExtras);
		$this->database()->insert(Phpfox::getT('user_field'), $aExtras);
		$this->database()->insert(Phpfox::getT('user_space'), $aExtras);
		$this->database()->insert(Phpfox::getT('user_count'), $aExtras);	
		
		$this->database()->insert($this->_sTable, array(
				'user_id' => $iUserId,
				'identifier' => md5($aUserInfo['identifier']),
				'time_stamp' => PHPFOX_TIME
			)
		);	
		
		if (!empty($aUserInfo['photo']))
		{
			$sImage = $aUserInfo['photo'];
			$sNewImage = md5($iUserId . PHPFOX_TIME . uniqid()) . '%s.jpg';
			Phpfox::getLib('file')->writeToCache($sNewImage, file_get_contents($sImage));
			copy(PHPFOX_DIR_CACHE . $sNewImage, Phpfox::getParam('core.dir_user') . sprintf($sNewImage, ''));
			unlink(PHPFOX_DIR_CACHE . $sNewImage);
			foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
			{
				Phpfox::getLib('image')->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sNewImage, ''), Phpfox::getParam('core.dir_user') . sprintf($sNewImage, '_' . $iSize), $iSize, $iSize);
				Phpfox::getLib('image')->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sNewImage, ''), Phpfox::getParam('core.dir_user') . sprintf($sNewImage, '_' . $iSize . '_square'), $iSize, $iSize, false);
			}		
			Phpfox::getLib('database')->update(Phpfox::getT('user'), array('user_image' => $sNewImage, 'server_id' => 0), 'user_id = ' . (int) $iUserId);		
		}		
		
		// Taken from user.process->add
		$iFriendId = (int) Phpfox::getParam('user.on_signup_new_friend');
		if ($iFriendId > 0)
		{
			$this->database()->insert(Phpfox::getT('friend'), array(
					'list_id' => 0,
					'user_id' => $iUserId,
					'friend_user_id' => $iFriendId,
					'time_stamp' => PHPFOX_TIME
				)
			);
			
			$this->database()->insert(Phpfox::getT('friend'), array(
					'list_id' => 0,
					'user_id' => $iFriendId,
					'friend_user_id' => $iUserId,
					'time_stamp' => PHPFOX_TIME
				)
			);

			Phpfox::getService('friend.process')->updateFriendCount($iUserId, $iFriendId);
			Phpfox::getService('friend.process')->updateFriendCount($iFriendId, $iUserId);
		}
		return $iUserId;
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
		if ($sPlugin = Phpfox_Plugin::get('janrain.service_process__call'))
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