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
 * @version 		$Id: index.class.php 416 2009-04-19 18:25:22Z Raymond_Benc $
 */
class Video_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($aOrder = $this->request()->getArray('order'))
		{
			if (Phpfox::getService('video.category.process')->updateOrder($aOrder))
			{
				$this->url()->send('admincp.video', null, Phpfox::getPhrase('video.category_order_successfully_updated'));
			}
		}		
		
		if ($iDelete = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('video.category.process')->delete($iDelete))
			{
				$this->url()->send('admincp.video', null, Phpfox::getPhrase('video.category_successfully_deleted'));
			}
		}
	
		$this->template()->setTitle(Phpfox::getPhrase('video.manage_categories'))
			->setBreadcrumb(Phpfox::getPhrase('video.manage_categories'), $this->url()->makeUrl('admincp.video'))
			->setPhrase(array('video.are_you_sure_this_will_delete_all_videos_that_belong_to_this_category_and_cannot_be_undone'))
			->setHeader(array(
					'jquery/ui.js' => 'static_script',
					'admin.js' => 'module_video',
					'<script type="text/javascript">$Behavior.admincpEditVideo = function() { $Core.video.url(\'' . $this->url()->makeUrl('admincp.video') . '\'); }</script>'
				)
			)
			->assign(array(
					'sCategories' => Phpfox::getService('video.category')->display('admincp')->get()
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>