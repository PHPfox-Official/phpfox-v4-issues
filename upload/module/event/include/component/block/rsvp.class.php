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
 * @version 		$Id: rsvp.class.php 1245 2009-11-02 16:10:29Z Raymond_Benc $
 */
class Event_Component_Block_Rsvp extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		if (PHPFOX_IS_AJAX)
		{
			$sModule = $this->request()->get('module', false);
			$iItem =  $this->request()->getInt('item', false);	
			$aCallback = false;
			if ($sModule && $iItem && Phpfox::hasCallback($sModule, 'getEventInvites'))
			{
				$aCallback = Phpfox::callback($sModule . '.getEventInvites', $iItem);				
			}			
		}
		
		$aEvent = (PHPFOX_IS_AJAX ? Phpfox::getService('event')->callback($aCallback)->getEvent($this->request()->get('id'), true) : $this->getParam('aEvent'));		
		
		if (PHPFOX_IS_AJAX)
		{	
			$this->template()->assign(array(
					'aEvent' => $aEvent,
					'aCallback' => $aCallback
				)	
			);	
		}
		else 
		{	
			$aCallback = $this->getParam('aCallback', false);
			
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('event.your_rsvp'),
					'aCallback' => $aCallback
				)
			);
			
			return 'block';
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_block_rsvp_clean')) ? eval($sPlugin) : false);
	}
}

?>