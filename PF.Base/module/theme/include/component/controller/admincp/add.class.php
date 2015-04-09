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
 * @version 		$Id: add.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($val = $this->request()->getArray('val'))) {
			$Theme = new Core\Theme();
			$newTheme = $Theme->make($val);

			Phpfox::addMessage('Theme successfully created.');
			return [
				'redirect' => $this->url()->makeUrl('admincp.theme.manage', ['id' => $newTheme->theme_id])
			];
		}
		
		$this->template()
			->setBreadcrumb('Create a Theme', $this->url()->makeUrl('current'), true)
			->assign(array(
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>