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
 * @version 		$Id: process.class.php 4854 2012-10-09 05:20:40Z Raymond_Benc $
 */
class Facebook_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('fbconnect');
	}
	
	public function updateUserPassword($aVals)
	{
		if (empty($aVals['password']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('facebook.enter_a_password'));
		}
		
		$sSalt = '';
		for ($i = 0; $i < 3; $i++)
		{
			$sSalt .= chr(rand(33, 91));
		}
		$aInsert = array();
		$aInsert['password'] = Phpfox::getLib('hash')->setHash($aVals['password'], $sSalt);
		$aInsert['password_salt'] = $sSalt;
		
		$this->database()->update(Phpfox::getT('fbconnect'), array('is_unlinked' => '1'), 'user_id = ' . (int) Phpfox::getUserId());
		$this->database()->update(Phpfox::getT('user'), $aInsert, 'user_id = ' . Phpfox::getUserId());	

		return true;
	}
	
	public function addUser($iUserId, $iFacebookUserId)
	{
		$this->database()->insert($this->_sTable, array(
				'user_id' => $iUserId,
				'fb_user_id' => $iFacebookUserId
			)
		);
		
		return true;
	}
	
	public function shareFeed($sType)
	{
		$this->database()->update($this->_sTable, array(
				'share_feed' => (int) $sType
			), 'user_id = ' . Phpfox::getUserId()
		);
	}
	
	public function sendEmail($sType)
	{		
		$this->database()->update($this->_sTable, array(
				'send_email' => (int) $sType
			), 'user_id = ' . Phpfox::getUserId()
		);		
		
		if ((int) $sType === 2)
		{
			$aUserInfo = Phpfox::getService('facebook.api')->getUserInfo();

			if (Phpfox::getService('facebook')->checkEmail($aUserInfo['email']) !== false)
			{
				return false;
			}						
			
			$this->database()->update(Phpfox::getT('user'), array(
					'email' => $aUserInfo['email']
				), 'user_id = ' . Phpfox::getUserId()
			);
			
			if ($aUserInfo['email'] == $aUserInfo['proxied_email'])
			{
				$this->database()->update($this->_sTable, array(
						'is_proxy_email' => '1'
					), 'user_id = ' . Phpfox::getUserId()
				);				
			}
		}		
		
		return true;
	}

	public function syncAccounts($sEmail, $iFacebookId)
	{
		$sSalt = '';
		for ($i = 0; $i < 3; $i++)
		{
			$sSalt .= chr(rand(33, 91));
		}		

		$this->database()->update(Phpfox::getT('user'), array(
				'password' => Phpfox::getLib('hash')->setHash($iFacebookId, $sSalt),
				'password_salt' => $sSalt,
			), 'email = \'' . $this->database()->escape($sEmail) . '\''
		);
		
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
		if ($sPlugin = Phpfox_Plugin::get('facebook.service_process__call'))
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