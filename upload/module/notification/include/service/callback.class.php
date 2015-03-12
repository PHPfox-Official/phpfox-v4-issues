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
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Notification_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getBlockDetailsFeed()
	{
		return array(
			'title' => Phpfox::getPhrase('notification.notifications')
		);
	}
	
	public function onDeleteUser($iUser)
	{
		$this->database()->delete(Phpfox::getT('notification'), 'user_id = ' . (int) $iUser . ' OR owner_user_id = ' . (int) $iUser . '');
	}
	
	public function getGlobalNotifications()
	{
		$iTotal = Phpfox::getService('notification')->getUnseenTotal();
		if ($iTotal > 0)
		{				
			Phpfox::getLib('ajax')->call('$(\'#js_total_new_notifications\').html(\'' . (int) $iTotal . '\').css({display: \'block\'}).show();');
		}
	}
	
	public function getApiSupportedMethods()
	{
		$aMethods = array();
		
		$aMethods[] = array(
			'call' => 'getNewCount',
			'requires' => array(
				'user_id' => 'user_id'
			),
			'detail' => Phpfox::getPhrase('notification.get_the_total_number_of_unseen_notifications_if_you_do_not_pass_the_user_id_we_will_return_information_about_the_user_that_is_currently_logged_in'),
			'type' => 'GET',			
			'response' => '{"api":{"total":5,"pages":0,"current_page":0},"output":5}'			 
		);	
		
		$aMethods[] = array(
			'call' => 'get',
			'requires' => array(
				'user_id' => 'user_id'
			),
			'detail' => Phpfox::getPhrase('notification.get_all_of_the_users_notifications_if_you_do_not_pass_the_user_id_we_will_return_information_about_the_user_that_is_currently_logged_in'),
			'type' => 'GET',			
			'response' => '{"api":{"total":0,"pages":0,"current_page":0},"output":[{"notification_id":"3","link":"http:\/\/[DOMAIN_REPLACE]\/john-doe\/comment-id_1\/","message":"Jane Doe commented on your wall","icon":"http:\/\/[DOMAIN_REPLACE]\/module\/blog\/static\/image\/default\/default\/activity.png"}]}'
		);		
		
		return array(
			'module' => 'notification', 
			'module_info' => '', 
			'methods' => $aMethods
		);
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
		if ($sPlugin = Phpfox_Plugin::get('notification.service_callback__call'))
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