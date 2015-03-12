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
 * @package  		Module_Theme
 * @version 		$Id: index.class.php 2000 2010-10-29 11:24:24Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Template_Index extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iId = $this->request()->getInt('id');
		
		$aTheme = Phpfox::getService('theme')->getTheme($iId);		
		
		if (Phpfox::getParam('core.enabled_edit_area'))
		{
			$this->template()->setHeader(array(
					'editarea/edit_area_full.js' => 'static_script',
					'<script type="text/javascript">				
						editAreaLoader.init({
							id: "js_template_content"	
							,start_highlight: true
							,allow_resize: "both"
							,allow_toggle: false
							,word_wrap: false
							,language: "en"
							,syntax: "html"
							,plugins: "phpfox"
						});		
					</script>'
				)
			);
		}
	
		$this->template()->setTitle(Phpfox::getPhrase('theme.themes'))
			->setTitle(Phpfox::getPhrase('theme.templates'))
			->setTitle($aTheme['name'])
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb($aTheme['name'], $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb(Phpfox::getPhrase('theme.templates'), null, true)
			->setHeader('cache', array(
					'template.js' => 'module_theme',
					'template.css' => 'style_css',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',	
				)
			)			
			->assign(array(
					'aTemplates' => Phpfox::getService('theme.template')->get($aTheme['folder']),
					'aTheme' => $aTheme,
					'aProducts' => Phpfox::getService('admincp.product')->get()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_product_index_clean')) ? eval($sPlugin) : false);
	}
}

?>