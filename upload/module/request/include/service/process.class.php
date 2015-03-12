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
 * @package  		Module_Request
 * @version 		$Id: process.class.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
class Request_Service_Process extends Phpfox_Service 
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('request');
	}
	
	public function add($sType, $iItemId, $iUserId, $iSentUserId = null)
	{
		// $this->database()->updateCounter('user_count', Phpfox::callback($sType . '.getUserCountField'), 'user_id', $iUserId);

		(Phpfox::isModule('notification') ? Phpfox::getService('notification.process')->add($sType, $iItemId, $iUserId, ($iSentUserId === null ? Phpfox::getUserId() : $iSentUserId)) : null);
		
		return true;
	}
	
	public function delete($sType, $iItemId, $iUserId)
	{
		$this->database()->updateCounter('user_count', Phpfox::callback($sType . '.getUserCountField'), 'user_id', $iUserId, true);
		
		(Phpfox::isModule('notification') ? Phpfox::getService('notification.process')->delete($sType, $iItemId, $iUserId) : null);
		
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
		if ($sPlugin = Phpfox_Plugin::get('request.service_process__call'))
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