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
 * @version 		$Id: index.class.php 2197 2010-11-22 15:26:08Z Raymond_Benc $
 */
class Group_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($aOrder = $this->request()->getArray('order'))
		{
			if (Phpfox::getService('group.category.process')->updateOrder($aOrder))
			{
				$this->url()->send('admincp.group', null, Phpfox::getPhrase('group.category_order_successfully_updated'));
			}
		}		
		
		if ($iDelete = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('group.category.process')->delete($iDelete))
			{
				$this->url()->send('admincp.group', null, Phpfox::getPhrase('group.category_successfully_deleted'));
			}
		}
	
		$this->template()->setTitle(Phpfox::getPhrase('group.manage_categories'))
			->setBreadcrumb(Phpfox::getPhrase('group.manage_categories'), $this->url()->makeUrl('admincp.group'))
			->setPhrase(array(
					'group.are_you_sure_this_will_delete_all_groups_that_belong_to_this_category_and_cannot_be_undone'
				)
			)
			->setHeader(array(
					'jquery/ui.js' => 'static_script',
					'admin.js' => 'module_group',
					'<script type="text/javascript">$Core.group.url(\'' . $this->url()->makeUrl('admincp.group') . '\');</script>'
				)
			)
			->assign(array(
					'sCategories' => Phpfox::getService('group.category')->display('admincp')->get()
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('group.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>