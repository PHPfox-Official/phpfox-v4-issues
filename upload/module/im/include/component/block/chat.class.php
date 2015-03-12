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
 * @version 		$Id: chat.class.php 2767 2011-07-29 12:05:18Z Miguel_Espinoza $
 */
class Im_Component_Block_Chat extends Phpfox_Component
{
	private $_bIsLive = true;
	
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->getParam('aChat','') != '')
		{
			$aChat = $this->getParam('aChat');
		}
		else
		{
			$aChat = Phpfox::getService('im')->getChat($this->getParam('im_id'), false);
		}
		
		if ($aChat === false)
		{
			$this->_bIsLive = false;

			return false;
		}
		
		$this->template()->assign(array(
				'aChat' => $aChat
			)
		);
	}
	
	public function isLive()
	{
		return $this->_bIsLive;	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('im.component_block_chat_clean')) ? eval($sPlugin) : false);
	}
}

?>