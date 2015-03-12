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
class Mail_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('mail');
		$this->_oApi = Phpfox::getService('api');		
	}
	
	public function add()
	{
		/*
		@title 
		@info Compose a new message.
		@method POST
		@extra user_id=#{User ID#|int|yes}&subject=#{Subject|string|yes}&message=#{Message|string|yes}
		@return id=#{Mail ID#|int}&permalink=#{URL to message|string}
		*/		
		
		$aVals = array(
				'to' => array($this->_oApi->get('user_id')),
				'subject' => $this->_oApi->get('subject'),
				'message' => $this->_oApi->get('message')
				);

		if (($aIds = Phpfox::getService('mail.process')->add($aVals)) !== false)
		{
			$aReturn = array(
					'id' => (Phpfox::getParam('mail.threaded_mail_conversation') ? $aIds : $aIds[0]),
					'permalink' => (Phpfox::getParam('mail.threaded_mail_conversation') ? Phpfox::getLib('url')->makeUrl('mail.thread', array('id' => $aIds)) : Phpfox::getLib('url')->makeUrl('mail.view.' . $aIds[0])),
					);
			
			return $aReturn;	
		}
	}
	
	public function getNewCount()
	{
		/*
		@title
		@info Gets the total number of new messages for the active user.
		@method GET
		*/
				
		return (int) Phpfox::getService('mail')->getUnseenTotal();
	}	
	
	public function message()
	{
		/*
		@title
		@info Get a message.
		@method GET
		@extra id=#{ID# of the message|int|yes}
		@return id=#{Item ID#|int}&title=#{Title of the item|string}&description=#{Description of the item|string}&likes=#{Total number of likes|int}&permalink=#{Link to the item|string}
		*/		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			list($aThread, $aMessages) = Phpfox::getService('mail')->getThreadedMail($this->_oApi->get('id'));
		
			$aReturn = array('id' => $aThread['thread_id'], 'permalink' => Phpfox::getLib('url')->makeUrl('mail.thread', array('id' => $aThread['thread_id'])), 'users' => array(), 'conversation' => array());
			foreach ($aThread['users'] as $aUser)
			{
				$aReturn['users'][] = array(
						'user_id' => $aUser['user_id'],
						'full_name' => $aUser['full_name'],
						'user_name' => $aUser['user_name']
				);
			}
		
			foreach ($aMessages as $aMessage)
			{
				$aReturn['conversation'][] = array(
						'id' => $aMessage['message_id'],
						'user_id' => $aMessage['user_id'],
						'message' => Phpfox::getLib('parse.output')->parse($aMessage['text']),
						'from' => $aMessage['full_name'],
						'from_url' => Phpfox::getLib('url')->makeUrl($aMessage['user_name'])
				);
			}
		
			return $aReturn;
		}
		else
		{
			$aMessage = Phpfox::getService('mail')->getMail($this->_oApi->get('id'));
			$aReturn = array(
					'id' => $aMessage['mail_id'],
					'permalink' => Phpfox::getLib('url')->makeUrl('mail.view.' . $aMessage['mail_id']),
					'subject' => $aMessage['subject'],
					'conversation' => $aMessage['text'],
					'users' => array(
							array(
									'user_id' => $aMessage['owner_user_id'],
									'full_name' => $aMessage['owner_full_name'],
									'user_name' => $aMessage['owner_user_name']
							),
							array(
									'user_id' => $aMessage['viewer_user_id'],
									'full_name' => $aMessage['viewer_full_name'],
									'user_name' => $aMessage['viewer_user_name']
							)
					)
			);
		
			return $aReturn;
		}		
	}
	
	public function get()
	{
		/*
		@title
		@info Get all the messages of the user that is logged in.
		@method GET
		@extra
		@return id=#{Message ID#|int}&subject=#{Subject|string}&preview=#{Preview of the message|string}&from=#{From|string}&from_url=#{Profile link of the person who sent the message|string}&permalink=#{Link to the message|string}&new=#{Check to see if the message is read or not. <b>True</b> is a new message|bool}
		*/		
		$iUserId = Phpfox::getUserId();
		
		$aCond = array();
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$aCond[] = 'AND m.viewer_user_id = ' . $iUserId . ' AND m.is_archive = 0';
		}
		else
		{
			$aCond[] = 'AND m.viewer_folder_id = 0 AND m.viewer_user_id = ' . $iUserId . ' AND m.viewer_type_id = 0';
		}

		$aMessages = array();
		list($iTotal, $aMessageRows, $aTotals) = Phpfox::getService('mail')->get($aCond);
		foreach ($aMessageRows as $iKey => $aMessageRow)
		{
			$aMessages[$iKey] = array(
					'id' => (Phpfox::getParam('mail.threaded_mail_conversation') ? $aMessageRow['thread_id'] : $aMessageRow['mail_id']),
					'subject' => (Phpfox::getParam('mail.threaded_mail_conversation') ? '' : $aMessageRow['subject']),
					'preview' => $aMessageRow['preview'],
					'from' => $aMessageRow['full_name'],
					'from_url' => Phpfox::getLib('url')->makeUrl($aMessageRow['user_name']),
					'permalink' => (Phpfox::getParam('mail.threaded_mail_conversation') ? Phpfox::getLib('url')->makeUrl('mail.thread', array('id' => $aMessageRow['thread_id'])) : Phpfox::getLib('url')->makeUrl('mail.view.' . $aMessageRow['mail_id'])),
					'new' => ($aMessageRow['viewer_is_new'] ? true : false)
					);
			
			if (Phpfox::getParam('mail.threaded_mail_conversation'))
			{
				unset($aMessages[$iKey]['subject']);	
			}
		}

		return $aMessages;
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
		if ($sPlugin = Phpfox_Plugin::get('mail.service_api__call'))
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