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
class Theme_Component_Controller_Admincp_Style_Css_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$this->url()->send('admincp');
		}			
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('theme.style.process')->addCss($aVals))
			{
				$this->url()->send('admincp.theme.style.css.add', null, Phpfox::getPhrase('theme.css_file_successfully_added'));
			}
		}		
		
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
							,syntax: "css"
						});		
					</script>'
				)
			);			
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('theme.creating_css_file'))
			->setBreadcrumb(Phpfox::getPhrase('theme.creating_css_file'))
			->assign(array(
					'aStyles' => Phpfox::getService('theme.style')->get()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_style_css_add_clean')) ? eval($sPlugin) : false);
	}
}

?>