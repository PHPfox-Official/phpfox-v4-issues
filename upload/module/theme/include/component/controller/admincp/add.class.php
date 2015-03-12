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
class Theme_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		$aThemes = Phpfox::getService('theme')->get();		
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aTheme = Phpfox::getService('theme')->getForEdit($iId)))
			{
				$bIsEdit = true;
				foreach ($aThemes as $iKey => $aCacheTheme)
				{
					if ($aCacheTheme['theme_id'] == $aTheme['theme_id'])
					{
						unset($aThemes[$iKey]);
					}
				}
				
				$this->template()->assign(array(
						'aForms' => $aTheme
					)
				);
			}
		}		
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('theme.process')->update($aTheme['theme_id'], $aVals))
				{
					$this->url()->send('admincp.theme.add', array('id' => $aTheme['theme_id']), Phpfox::getPhrase('theme.theme_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('theme.process')->add($aVals))
				{
					$this->url()->send('admincp.theme.add', null, Phpfox::getPhrase('theme.theme_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('theme.editing_theme') . ':' . $aTheme['name'] : Phpfox::getPhrase('theme.create_new_theme')))
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('theme.editing_theme') . ':' . $aTheme['name'] : Phpfox::getPhrase('theme.create_theme')), null, true)
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'aThemes' => $aThemes
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>