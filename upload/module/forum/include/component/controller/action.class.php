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
 * @version 		$Id: action.class.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
class Forum_Component_Controller_Action extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$sAction = $this->request()->get('selector_action');
		$aVals = $this->request()->getArray('val');
		$sMessage = '';
		
		switch ($sAction)
		{
			case 'unsubscribe':
				foreach ($aVals['id'] as $iId)
				{
					Phpfox::getService('forum.subscribe.process')->delete($iId, Phpfox::getUserId());
				}
				$sMessage = Phpfox::getPhrase('forum.successfully_unsubscribed_to_thread_s');
				break;
			case 'subscribe':
				foreach ($aVals['id'] as $iId)
				{
					Phpfox::getService('forum.subscribe.process')->add($iId, Phpfox::getUserId());
				}				
				$sMessage = Phpfox::getPhrase('forum.successfully_subscribed_to_thread_s');
				break;
			default:

				break;			
		}
		
		$this->url()->forward($this->request()->get('selector_current'), $sMessage);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_action_clean')) ? eval($sPlugin) : false);
	}
}

?>