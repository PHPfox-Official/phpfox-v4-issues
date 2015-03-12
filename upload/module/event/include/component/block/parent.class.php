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
 * @version 		$Id: parent.class.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
class Event_Component_Block_Parent extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aEventParent = $this->getParam('aEventParent');
		
		$aEvents = Phpfox::getService('event')->getForParentBlock($aEventParent['module'], $aEventParent['item']);

		if (!count($aEvents) && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		if (!Phpfox::getService('group')->hasAccess($aEventParent['item'], 'can_use_event'))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('event.upcoming_events'),
				'sBlockJsId' => 'parent_event',
				'aEvents' => $aEvents,
				'aEventParent' => $aEventParent
			)
		);
		
		if (count($aEvents) == 5)
		{
			$this->template()->assign('aFooter', array(
					'View More' => $this->url()->makeUrl($aEventParent['url'][0], $aEventParent['url'][1])
				)
			);
		}
		
		return 'block';		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_block_parent_clean')) ? eval($sPlugin) : false);
	}		
}

?>