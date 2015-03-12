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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Pages_Component_Controller_Widget extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		$iPageId = $this->request()->getInt('page_id');
		
		if (($iWidget = $this->request()->getInt('widget_id')) && $aWidget = Phpfox::getService('pages')->getForEditWidget($iWidget))
		{
			$iPageId = $aWidget['page_id'];
			$this->template()->assign('aForms', $aWidget);	
			$bIsEdit = true;
		}	
		
		$aPage = Phpfox::getService('pages')->getPage($iPageId);
		
		$this->template()->assign(array(
				'iPageId' => $iPageId,
				'bIsEdit' => $bIsEdit,
				'sPageUrl' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url'])
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_controller_widget_clean')) ? eval($sPlugin) : false);
	}
}

?>