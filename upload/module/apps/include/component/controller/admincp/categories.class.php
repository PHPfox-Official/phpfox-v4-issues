<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Component_Controller_AdminCP_Categories extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		
		if ( ($sName = $this->request()->get('newCategory', false)))
		{
			if (Phpfox::getService('apps.category.process')->add($sName))
			{
				Phpfox::addMessage(Phpfox::getPhrase('apps.category_successfully_added'));
			}			
		}
		
		$aCategories = Phpfox::getService('apps')->getCategories();
		$this->template()
			->assign(array(
				'aCategories' => $aCategories
			))
			->setHeader(array(
				'admincp.js' => 'module_apps'
			))
			->setBreadCrumb(Phpfox::getPhrase('apps.app_categories'));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('apps.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>