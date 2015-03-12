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
 * @version 		$Id: feed.class.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
class Request_Component_Block_Feed extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		return false;
		
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		$aMessages = array();		
		$aMessages = Phpfox::massCallback('getRequestLink');
		
		(($sPlugin = Phpfox_Plugin::get('request.component_block_feed_process')) ? eval($sPlugin) : false);
		
		if (!is_array($aMessages))
		{
			return false;
		}
		
		$iCnt = 0;
		foreach (array_values($aMessages) as $sValue)
		{
			if (!empty($sValue))
			{
				$iCnt++;
			}
		}
		
		if (!$iCnt && !Phpfox::getParam('request.display_request_box_on_empty'))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('request.requests'),
				'aMessages' => $aMessages,
				'sDeleteBlock' => 'dashboard'
			)
		);

		return 'block';	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('request.component_block_feed_clean')) ? eval($sPlugin) : false);
	}	
}

?>