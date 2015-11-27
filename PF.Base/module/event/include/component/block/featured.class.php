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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Event_Component_Block_Featured extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		list($iTotal, $aFeatured) = Event_Service_Event::instance()->getFeatured();
		
		if (!$iTotal)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('event.featured_events'),
				'aFeatured' => $aFeatured
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
		(($sPlugin = Phpfox_Plugin::get('event.component_block_featured_clean')) ? eval($sPlugin) : false);
	}
}

?>