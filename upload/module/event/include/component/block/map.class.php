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
 * @version 		$Id: info.class.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
class Event_Component_Block_Map extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		return false;		
		
		$aEvent = $this->getParam('aEvent');
		if (Phpfox::getUserParam('event.can_view_gmap') == false || !isset($aEvent['gmap']['latitude']))
		{
			return false;
		}
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('event.find_on_map')
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
		(($sPlugin = Phpfox_Plugin::get('event.component_block_info_clean')) ? eval($sPlugin) : false);
	}
}

?>