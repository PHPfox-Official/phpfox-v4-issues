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
 * @package 		Phpfox_Component
 * @version 		$Id: message.class.php 4156 2012-05-08 14:12:50Z Miguel_Espinoza $
 */
class Im_Component_Block_Message extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		/* When using the ajax function getUpdate we pass aRoom to getMessage so we dont
		 * have to get the text for each message one at a time.
		 */
		if ($this->getParam('aRoom', '') == '')
		{
			$aRoom = Phpfox::getService('im')->getChat($this->getParam('im_id'), $this->getParam('im_static', true));
		}
		else
		{
			$aRoom = $this->getParam('aRoom');
			
		}
		
		if (!isset($aRoom['parent_id']))
		{
			return false;
		}
			
		if ($this->getParam('aMessages','') != '') 
		{
			$aMessages = $this->getParam('aMessages');
		}
		else
		{
			/* This should not be needed but for now its a safety net*/
			//list($iLastMessage, $iClearedTime) = Phpfox::getService('im')->getLastMessageForRoom($aRoom['parent_id']);
			$aMessages = Phpfox::getService('im')->getMessages($aRoom['parent_id'], true);
		}
		
		$this->template()->assign(array(
				'aMessages' => $aMessages,
				'bLoggedIn' => ($aRoom['is_logged_in']),
				'bIsFirst' => $this->getParam('bIsFirst', true)
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('im.component_block_message_clean')) ? eval($sPlugin) : false);
	}
}

?>