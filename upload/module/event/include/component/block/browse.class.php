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
 * @package 		Phpfox_Component
 * @version 		$Id: browse.class.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
class Event_Component_Block_Browse extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iRsvp = $this->request()->get('rsvp', 1);
		$iPage = $this->request()->getInt('page');	
		
		$iPageSize = 20;

		$aEvent = Phpfox::getService('event')->getEvent($this->request()->get('id'), true);
		
		list($iCnt, $aInvites) = Phpfox::getService('event')->getInvites($aEvent['event_id'], $iRsvp, $iPage, $iPageSize);		
		
		Phpfox::getLib('pager')->set(array('ajax' => 'event.browseList', 'page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'aParams' => 
			array(
					'id' => $aEvent['event_id'],
					'rsvp' => $iRsvp
				)
			)
		);
		
		$aLists = array(
			Phpfox::getPhrase('event.attending') => '1',
			Phpfox::getPhrase('event.maybe_attending') => '2',
			Phpfox::getPhrase('event.awaiting_reply') => '0',
			Phpfox::getPhrase('event.not_attending') => '3'
		);
		
		$this->template()->assign(array(
				'aEvent' => $aEvent,
				'aInvites' => $aInvites,
				'bIsInBrowse' => ($iPage > 0 ? true : false),
				'aLists' => $aLists
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_block_browse_clean')) ? eval($sPlugin) : false);
	}
}

?>