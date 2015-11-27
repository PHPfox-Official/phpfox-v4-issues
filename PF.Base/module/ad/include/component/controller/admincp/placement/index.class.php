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
 * @version 		$Id: index.class.php 1547 2010-04-13 12:13:18Z Raymond_Benc $
 */
class Ad_Component_Controller_Admincp_Placement_Index extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($iDelete = $this->request()->getInt('delete')) && Phpfox::getService('ad.process')->deletePlacement($iDelete))
		{
			$this->url()->send('admincp.ad.placement', null, Phpfox::getPhrase('ad.ad_placement_successfully_deleted'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('ad.manage_ad_placements'))
			->setBreadcrumb(Phpfox::getPhrase('ad.manage_ad_placements'), $this->url()->makeUrl('ad.placement'))
			->setActionMenu([
				'New Placement' => [
					'url' => $this->url()->makeUrl('admincp.ad.placement.add'),
					'class' => 'popup'
				]
			])
			->assign(array(
					'aPlacements' => Ad_Service_Ad::instance()->getPlacements()
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_placement_index_clean')) ? eval($sPlugin) : false);
	}
}

?>