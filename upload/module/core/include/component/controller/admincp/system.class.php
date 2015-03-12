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
 * @version 		$Id: system.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Core_Component_Controller_Admincp_System extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->setTitle(Phpfox::getPhrase('admincp.system_overview'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.tools'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.system_overview'), $this->url()->makeUrl('admincp.core.system'), true)
			->assign(array(
					'aStats' => Phpfox::getService('core.system')->get()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_system_clean')) ? eval($sPlugin) : false);
	}
}

?>