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
 * @version 		$Id: category.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Report_Component_Controller_Admincp_Category extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($aIds = $this->request()->getArray('id')))
		{
			foreach ($aIds as $iId)
			{
				if (!is_numeric($iId))
				{
					continue;
				}
				
				Phpfox::getService('report.process')->delete($iId);
			}
			
			$this->url()->send('admincp.report.category', null, Phpfox::getPhrase('report.successfully_deleted_categories'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('report.manage_categories'))
			->setBreadcrumb(Phpfox::getPhrase('report.manage_categories'), $this->url()->makeUrl('admincp.report'))
			->assign(array(
					'aCategories' => Phpfox::getService('report')->getCategories()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('report.component_controller_admincp_category_clean')) ? eval($sPlugin) : false);
	}
}

?>