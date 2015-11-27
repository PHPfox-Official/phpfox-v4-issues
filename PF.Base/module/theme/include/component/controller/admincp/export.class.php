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
 * @version 		$Id: export.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Export extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aTheme = Theme_Service_Theme::instance()->getTheme($this->request()->getInt('theme'));
		
		if (!isset($aTheme['theme_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('theme.theme_is_not_valid'));
		}		
		
		$oArchiveExport = Phpfox::getLib('archive.export')->set(array('zip'));
		
		if ($aVals = $this->request()->get('val'))
		{
			if (($aData = Theme_Service_Theme::instance()->export($aVals)))
			{
				$oArchiveExport->download('phpfox-theme-' . $aData['name'] . '', 'zip', $aData['folder']);
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('theme.export_theme'))
				->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
				->setBreadCrumb(Phpfox::getPhrase('theme.export_theme'), $this->url()->makeUrl('current'))				
				->setBreadcrumb($aTheme['name'], null, true)
				->assign(array(
				'aStyles' => Theme_Service_Style_Style::instance()->get(array('theme_id = ' . $aTheme['theme_id'])),
				'aTheme' => $aTheme				
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_file_clean')) ? eval($sPlugin) : false);
	}
}

?>