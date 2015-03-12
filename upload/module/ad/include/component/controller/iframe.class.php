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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Ad_Component_Controller_Iframe extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		define('PHPFOX_IS_AD_PREVIEW', true);
		define('PHPFOX_DONT_SAVE_PAGE', true);
		define('PHPFOX_IS_AD_IFRAME', true);
		define('PHPFOX_DESIGN_DND', false);
		
		// http://www.phpfox.com/tracker/view/15044/
		Phpfox::getService('pages')->setIsInPage();
		
		$this->template()
			->assign('bNoIFrameHeader', true)
			->assign('sCustomHeader', '
				<style type="text/css">body { background:none; background-color:transparent; margin:auto; text-align:center; }</style>
				<script type="text/javascript">
					window.onload = function(){
						window.parent.fixHeight(\'js_ad_space_' . $this->request()->get('id') . '_frame_' . $this->request()->get('adId').'\', document.body.offsetHeight);
					}
				</script>				
			')
			->assign(array(
					'sBlockIdForAd' => $this->request()->get('id'),
					'adId' => $this->request()->get('adId'),
					'bNoTitle' => (Phpfox::getParam('ad.ad_ajax_refresh') && Phpfox::getParam('ad.multi_ad')) ? true : false
				)
			)
			->setTemplate('blank');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_iframe_clean')) ? eval($sPlugin) : false);
	}
}

?>
