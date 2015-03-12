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
 * @version 		$Id: index.class.php 4906 2012-10-22 04:52:14Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Style_Css_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_setMenuName('admincp.theme');
		
		$aStyle = Phpfox::getService('theme.style')->getStyle($this->request()->getInt('id'));
		
		if (!isset($aStyle['theme_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('theme.not_a_valid_style'));
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
							,plugins: "phpfox"
						});		
					</script>'
				)
			);			
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('theme.edit_css'))
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb($aStyle['theme_name'], $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb(Phpfox::getPhrase('theme.styles'), $this->url()->makeUrl('admincp.theme.style', array('id' => $aStyle['theme_id'])))
			->setBreadcrumb($aStyle['name'], $this->url()->makeUrl('admincp.theme.style', array('id' => $aStyle['theme_id'])))
			->setBreadcrumb(Phpfox::getPhrase('theme.edit_css'), null, true)
			->setHeader(array(
					'template.css' => 'style_css',
					'style.js' => 'module_theme'
				)
			)
			->assign(array(
					'aFiles' => Phpfox::getService('theme.style')->getFiles($aStyle['theme_folder'], $aStyle['folder'], $aStyle['style_id']),
					'aStyle' => $aStyle,
					'aProducts' => Phpfox::getService('admincp.product')->get(),
					'aCustomDataContent' => (defined('PHPFOX_IS_HOSTED_SCRIPT') ? Phpfox::getService('theme.style')->getStyleContent($aStyle['style_id']) : '')
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_style_css_clean')) ? eval($sPlugin) : false);
	}
}

?>