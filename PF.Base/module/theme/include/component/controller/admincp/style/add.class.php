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
 * @version 		$Id: add.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Style_Add extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aStyle = Theme_Service_Style_Style::instance()->getForEdit($iId)))
			{
				$bIsEdit = true;				
				$this->template()->assign(array(
						'aForms' => $aStyle
					)
				);
			}
		}		
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('theme.editing_style') . ': ' . $aStyle['name'] : Phpfox::getPhrase('theme.create_new_style')))->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'));
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Theme_Service_Style_Process::instance()->updateStyle($aStyle['style_id'], $aVals))
				{
					$this->url()->send('admincp.theme.style.add', array('id' => $aStyle['style_id']), Phpfox::getPhrase('theme.style_successfully_updated'));
				}				
			}
			else 
			{
				if (Theme_Service_Style_Process::instance()->addStyle($aVals))
				{
					$this->url()->send('admincp.theme.style.add', null, Phpfox::getPhrase('theme.style_successfully_added'));
				}
			}
		}
		
		if (($iThemeId = $this->request()->getInt('theme')))
		{
			if ($aTheme = Theme_Service_Theme::instance()->getTheme($iThemeId))
			{
				$this->template()->setBreadcrumb($aTheme['name'], $this->url()->makeUrl('admincp.theme'))
					->assign(array(
							'aForms' => array(
								'theme_id' => $aTheme['theme_id']
							)
						)
					);	
			}
		}
		
		$this->template()
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('theme.editing_style') . ': ' . $aStyle['name'] : Phpfox::getPhrase('theme.create_style')), null, true)
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'aStyles' => Theme_Service_Style_Style::instance()->get(),
					'aThemes' => Theme_Service_Theme::instance()->get()
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_style_add_clean')) ? eval($sPlugin) : false);
	}
}

?>