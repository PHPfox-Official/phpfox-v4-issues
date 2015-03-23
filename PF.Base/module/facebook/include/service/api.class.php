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
 * @version 		$Id: api.class.php 2096 2010-11-09 10:35:56Z Raymond_Benc $
 */
class Facebook_Service_Api extends Phpfox_Service 
{
	private $_oFb = null;
	
	private $_oApi = null;
	
	private $_aSession = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{		
	}	
	
	/**
	 * @deprecated 2.0.7
	 */	
	public function isUser()
	{
		return Phpfox_Error::set('This method has been depreciated since v2.0.7.');
	}
	
	/**
	 * @deprecated 2.0.7
	 */	
	public function getUserId()
	{
		return Phpfox_Error::set('This method has been depreciated since v2.0.7.');		
	}
	
	/**
	 * @deprecated 2.0.7
	 */
	public function setStatus($sStatus)
	{
		return Phpfox_Error::set('This method has been depreciated since v2.0.7.');		
	}
	
	/**
	 * @deprecated 2.0.7
	 */	
	public function sendEmail($sUserId, $sSubject, $sMessage, $sMessageHtml)
	{
		return Phpfox_Error::set('This method has been depreciated since v2.0.7.');	
	}
	
	/**
	 * @deprecated 2.0.7
	 */	
	public function getUserInfo()
	{		
		return Phpfox_Error::set('This method has been depreciated since v2.0.7.');	
	}
	
	/**
	 * @deprecated 2.0.7
	 */	
	public function logout($sNext)
	{
		return Phpfox_Error::set('This method has been depreciated since v2.0.7.');	
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
		if ($sPlugin = Phpfox_Plugin::get('facebook.service_api__call'))
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