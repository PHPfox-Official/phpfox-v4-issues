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
 * @version 		$Id: index.class.php 6186 2013-06-28 14:19:43Z Miguel_Espinoza $
 */
class Marketplace_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($aOrder = $this->request()->getArray('order'))
		{
			if (Phpfox::getService('marketplace.category.process')->updateOrder($aOrder))
			{
				$this->url()->send('admincp.marketplace', null, Phpfox::getPhrase('marketplace.category_order_successfully_updated'));
			}
		}		
		
		if ($iDelete = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('marketplace.category.process')->delete($iDelete))
			{
				$this->url()->send('admincp.marketplace', null, Phpfox::getPhrase('marketplace.category_successfully_deleted'));
			}
		}
	
		$this->template()->setTitle(Phpfox::getPhrase('marketplace.manage_categories'))
			->setBreadcrumb(Phpfox::getPhrase('marketplace.manage_categories'), $this->url()->makeUrl('admincp.marketplace'))
			->setPhrase(array(
					'marketplace.are_you_sure_this_will_delete_all_listings_that_belong_to_this_category_and_cannot_be_undone'
				)
			)
			->setHeader(array(
					'jquery/ui.js' => 'static_script',
					'admin.js' => 'module_marketplace',
					'<script type="text/javascript">$Behavior.mrktAdminUrl = function() { $Core.marketplace.url(\'' . $this->url()->makeUrl('admincp.marketplace') . '\'); };</script>'
				)
			)
			->assign(array(
					'sCategories' => Phpfox::getService('marketplace.category')->display('admincp')->get()
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>