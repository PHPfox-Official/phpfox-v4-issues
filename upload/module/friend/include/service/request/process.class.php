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
 * @package  		Module_Friend
 * @version 		$Id: process.class.php 2629 2011-05-25 19:08:51Z Raymond_Benc $
 */
class Friend_Service_Request_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('friend_request');
	}
	
	public function add($iUserId, $iFriendId, $iListid = 0, $sText = null)
	{		
		$aInsert = array(
			'user_id' => $iFriendId,
			'friend_user_id' => $iUserId,
			'time_stamp' => PHPFOX_TIME
		);

		if ((int) $iListid > 0)	
		{
			$aInsert['list_id'] = (int) $iListid;
		}
		
		if ($sText !== null && !empty($sText))
		{
			$aInsert['message'] = str_replace('<br />', " ", substr(Phpfox::getLib('parse.input')->prepare($sText), 0, 255));
		}

		$iId = $this->database()->insert($this->_sTable, $aInsert);		

		// Send the user an email
		$sLink = Phpfox::getLib('url')->makeUrl('friend.accept', array('id' => $iId));
		Phpfox::getLib('mail')->to($iFriendId)
			->subject(array('friend.full_name_added_you_as_a_friend_on_site_title', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title'))))
			->message(array('friend.full_name_added_you_as_a_friend_on_site_title_to_confirm_this_friend_request', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
			->notification('friend.new_friend_request')
			->send();
			
		if (Phpfox::getParam('friend.enable_friend_suggestion'))
		{
			Phpfox::getService('friend.suggestion')->reBuild($iFriendId);
			Phpfox::getService('friend.suggestion')->reBuild($iUserId);
		}

		return true;	
	}
	
	public function delete($iId, $iUserId)
	{
		$this->database()->delete($this->_sTable, 'request_id = ' . (int) $iId . ' AND friend_user_id = ' . (int) $iUserId);
		
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
		if ($sPlugin = Phpfox_Plugin::get('friend.service_request_process__call'))
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