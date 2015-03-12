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
 * @version 		$Id: validate.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class User_Service_Validate extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user');
	}
	
	public function user($sUser)
	{		
		Phpfox::getLib('parse.input')->allowTitle($sUser, Phpfox::getPhrase('user.user_name_is_already_in_use'));			
		
		if (!Phpfox::getService('ban')->check('username', $sUser))
		{
			Phpfox_Error::set(Phpfox::getPhrase('user.this_username_is_not_allowed_to_be_used'));
		}

		if (!Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up'))
		{
			$sUser = str_replace(' ', '_', $sUser);
			$sUser = Phpfox::getLib('parse.input')->clean($sUser);
			/* Check if there is a page with the same url as the user name*/
			$aPages = Phpfox::getService('page')->get();
			foreach ($aPages as $aPage)
			{
				if ($aPage['title_url'] == strtolower($sUser))
				{
					return Phpfox_Error::set(Phpfox::getPhrase('user.invalid_user_name'));
				}
			}
		}
		return $this;
	}
	
	public function email($sEmail)
	{
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("email = '" . $this->database()->escape($sEmail) . "'")
			->execute('getField');
		
		if ($iCnt)
		{
			Phpfox_Error::set(Phpfox::getPhrase('user.email_is_in_use_and_user_can_login', array('email' => trim(strip_tags($sEmail)), 'link' => Phpfox::getLib('url')->makeUrl('user.login', array('email' => base64_encode($sEmail))))));
		}
		
		if (!Phpfox::getService('ban')->check('email', $sEmail))
		{
			Phpfox_Error::set(Phpfox::getPhrase('user.this_email_is_not_allowed_to_be_used'));
		}		
		
		return $this;
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_validate__call'))
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