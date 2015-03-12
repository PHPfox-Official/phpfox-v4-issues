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
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Notification_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('notification');
		$this->_oApi = Phpfox::getService('api');		
	}
	
	public function get()
	{
		/*
		@title 
		@info Get all list of notifications for a user.
		@method GET
		@extra
		@return notification_id=#{Notification ID#|int}&link=#{Link to item|string}&message=#{Notice|string}&icon=#{Notification icon|string}
		*/		
		
		$aNotifications = array();
		$aRows = Phpfox::getService('notification')->get();
		foreach ($aRows as $aRow)
		{
			$aNotifications[] = array(
				'notification_id' => $aRow['notification_id'],
				'link' => $aRow['link'],
				'message' => $aRow['message'],
				'icon' => $aRow['icon']
			);
		}
		return $aNotifications;
	}	
	
	public function getNewCount()
	{
		/*
		@title
		@info Get the total number of new notifications.
		@method GET
		@extra
		@return
		*/		
		
		return (int) Phpfox::getService('notification')->getUnseenTotal();
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
		if ($sPlugin = Phpfox_Plugin::get('notification.service_api__call'))
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