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
 * @version 		$Id: import.class.php 1931 2010-10-25 11:58:06Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Style_Import extends Phpfox_Component
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
		
		$oArchiveImport = Phpfox::getLib('archive.import')->set(array('zip'));
		$bOverwrite = ($this->request()->getInt('overwrite') ? true : false);		
		$sTheme = $this->request()->get('parent-theme');
		
		if (($sStyleToInstall = $this->request()->get('install')) && Phpfox::getService('theme.style.process')->installStyleFromFolder($sTheme, $sStyleToInstall))
		{
			$this->url()->send('admincp.theme.style.import', null, Phpfox::getPhrase('theme.style_successfully_imported'));
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('theme.import_styles'))
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb(Phpfox::getPhrase('theme.import_styles'), null, true)
			->assign(array(
					'aNewStyles' => Phpfox::getService('theme.style')->getNewStyles()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_style_import_clean')) ? eval($sPlugin) : false);
	}
}

?>