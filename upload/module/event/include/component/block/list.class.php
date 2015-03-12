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
 * @version 		$Id: list.class.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
class Event_Component_Block_List extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$iRsvp = $this->request()->get('rsvp', 1);
		$iPage = $this->request()->getInt('page');		
		$sModule = $this->request()->get('module', false);
		$iItem =  $this->request()->getInt('item', false);
		$aCallback = $this->getParam('aCallback', false);		
		$iPageSize = 6;
		
		if (PHPFOX_IS_AJAX)
		{
			$aCallback = false;
			if ($sModule && $iItem && Phpfox::hasCallback($sModule, 'getEventInvites'))
			{
				$aCallback = Phpfox::callback($sModule . '.getEventInvites', $iItem);				
			}			
			
			$aEvent = Phpfox::getService('event')->callback($aCallback)->getEvent($this->request()->get('id'), true);
			$this->template()->assign('aEvent', $aEvent);
		}
		else 
		{
			$aEvent = $this->getParam('aEvent');			
			$this->template()->assign('aEvent', $aEvent);
		}
		
		if ($aCallback !== false)
		{
			$sModule = $aCallback['module'];
			$iItem = $aCallback['item'];
		}		
		
		list($iCnt, $aInvites) = Phpfox::getService('event')->getInvites($aEvent['event_id'], $iRsvp, $iPage, $iPageSize);		
				
		Phpfox::getLib('pager')->set(array('ajax' => 'event.listGuests', 'page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'aParams' => 
			array(
					'id' => $aEvent['event_id'],
					'module' => $sModule,
					'item' => $iItem,
					'rsvp' => $iRsvp
				)
			)
		);
		
		$this->template()->assign(array(
				'aInvites' => $aInvites,
				'iRsvp' => $iRsvp				
			)
		);		
		
		if (!PHPFOX_IS_AJAX)
		{			
			$sExtra = '';
			if ($aCallback !== false)
			{
				$sExtra .= '&amp;module=' . $aCallback['module'] . '&amp;item=' . $aCallback['item'];	
			}			
			
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('event.event_guests'),
					'aMenu' => array(
						Phpfox::getPhrase('event.attending') => '#event.listGuests?rsvp=1&amp;id=' . $aEvent['event_id'] . $sExtra,
						Phpfox::getPhrase('event.maybe') => '#event.listGuests?rsvp=2&amp;id=' . $aEvent['event_id'] . $sExtra,
						Phpfox::getPhrase('event.can_t_make_it') => '#event.listGuests?rsvp=3&amp;id=' . $aEvent['event_id'] . $sExtra,
						Phpfox::getPhrase('event.not_responded') => '#event.listGuests?rsvp=0&amp;id=' . $aEvent['event_id'] . $sExtra
					),
					'sBoxJsId' => 'event_guests'
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
		(($sPlugin = Phpfox_Plugin::get('event.component_block_list_clean')) ? eval($sPlugin) : false);
	}
}

?>