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
class Forum_Service_Subscribe_Subscribe extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('forum_subscribe');
	}
	
	public function sendEmails($iThreadId, $iPostId = null)
	{
		$aUsers = $this->database()->select('fs.user_id, ft.forum_id, ft.thread_id, ft.group_id, ft.title, f.name AS forum_name')
			->from($this->_sTable, 'fs')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.thread_id = fs.thread_id')
			->leftJoin(Phpfox::getT('forum'), 'f', 'f.forum_id = ft.forum_id')
			->where('fs.thread_id = ' . (int) $iThreadId)
			->execute('getSlaveRows');		
		
		if (count($aUsers))
		{			
			
			
			foreach ($aUsers as $aUser)
			{			
				$sLink = Phpfox::getLib('url')->permalink('forum.thread', $aUser['thread_id'], $aUser['title']) . 'view_' . $iPostId . '/';				
				
				Phpfox::getService('notification.process')->add('forum_subscribed_post', $iPostId, $aUser['user_id']);
				
				Phpfox::getLib('mail')->to($aUser['user_id'])
					->subject(array('forum.reply_to_thread_title', array('title' => $aUser['title'])))
					->message(array('forum.full_name_has_just_replied_to_the_thread_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aUser['title'], 'link' => $sLink)))
					->notification('forum.subscribe_new_post')
					->send();	
			}
		}
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_subscribe_subscribe__call'))
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