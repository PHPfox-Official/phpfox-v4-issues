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
 * @version 		$Id: facebook.class.php 4671 2012-09-19 07:52:40Z Miguel_Espinoza $
 */
class Facebook_Service_Facebook extends Phpfox_Service 
{
	private $_sToken = null;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('fbconnect');
	}
	
	public function checkEmail($sEmail)
	{
		$aUser = $this->database()->select('u.user_id, u.user_name, fb.fb_user_id')
			->from(Phpfox::getT('user'), 'u')
			->leftJoin(Phpfox::getT('fbconnect'), 'fb', 'fb.user_id = u.user_id')
			->where('u.email = \'' . $this->database()->escape($sEmail) . '\'')
			->execute('getSlaveRow');
			
		return (isset($aUser['user_id']) ? $aUser : false);
	}
	
	public function getUser($iFacebookUserId)
	{
		$aUser = $this->database()->select('u.*, fb.fb_user_id')
			->from($this->_sTable, 'fb')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fb.user_id')
			->where('fb.fb_user_id = \'' . $this->database()->escape($iFacebookUserId) . '\'')
			->execute('getSlaveRow');
		
		return $aUser;
	}
	
	public function connect($sUrl)
	{
		$mReturn = Phpfox::getLib('request')->send('https://www.facebook.com/dialog/oauth', array(
				'client_id' => '' . Phpfox::getParam('facebook.facebook_app_id') . '',
				'redirect_uri' => $sUrl
			)
		);			
	}
	
	public function get($sAction, $sUrl)
	{
		if (empty($_REQUEST['code']))
		{
			return Phpfox_Error::trigger('Missing request code.', E_USER_ERROR);
		}
		
		$mReturn = Phpfox::getLib('request')->send('https://graph.facebook.com/oauth/access_token', array(
				'client_id' => '' . Phpfox::getParam('facebook.facebook_app_id') . '',
				'redirect_uri' => $sUrl,
				'client_secret' => '' . Phpfox::getParam('facebook.facebook_secret') . '',
				'code' => $_REQUEST['code']
			)
		);	
		
		$aParts = explode('access_token=', $mReturn);	
		
		if (!isset($aParts[1]))
		{
			return Phpfox_Error::set('Unable to find security token.', E_USER_ERROR);
		}
		
		$aParts = explode('&expires', $aParts[1]);	
		$this->_sToken = $aParts[0];
		$mReturn = file_get_contents('https://graph.facebook.com/' . $sAction . '?access_token=' . $this->_sToken);		
		
		if (!function_exists('json_decode'))
		{
			return Phpfox_Error::set('Server is missing the PHP function json_decode().', E_USER_ERROR);
		}
					
		return json_decode($mReturn);			
	}
	
	public function getToken()
	{
		return $this->_sToken;
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
		if ($sPlugin = Phpfox_Plugin::get('facebook.service_facebook__call'))
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