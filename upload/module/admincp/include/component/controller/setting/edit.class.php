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
 * @package  		Module_Admincp
 * @version 		$Id: edit.class.php 2825 2011-08-09 20:14:13Z Raymond_Benc $
 */
class Admincp_Component_Controller_Setting_Edit extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		list($aGroups, $aModules, $aProductGroups) = Phpfox::getService('admincp.setting.group')->get();
		$aCond = array();
		$aUrl = array();
		$sSettingTitle = '';
		
		if (($sSettingId = $this->request()->get('setting-id')))
		{
			$aCond[] = " AND setting.setting_id = " . (int) $sSettingId;
			$aUrl = array('setting', 'edit', 'setting-id' => $sSettingId);
		}		
		
		if (($sGroupId = $this->request()->get('group-id')))
		{
			$aCond[] = " AND setting.group_id = '" . Phpfox::getLib('database')->escape($sGroupId) . "' AND setting.is_hidden = 0 ";
			$aUrl = array('setting', 'edit', 'group-id' => $sGroupId);
			foreach ($aGroups as $aGroup)
			{
				if ($aGroup['group_id'] == $sGroupId)
				{
					$sSettingTitle = $aGroup['var_name'];
					break;
				}
			}			
		}
		
		if (($iModuleId = $this->request()->get('module-id')))
		{
			$aCond[] = " AND setting.module_id = '" . Phpfox::getLib('database')->escape($iModuleId) . "' AND setting.is_hidden = 0 ";
			$aUrl = array('setting', 'edit', 'module-id' => $iModuleId);
			foreach ($aModules as $aModule)
			{
				if ($aModule['module_id'] == $iModuleId)
				{
					$sSettingTitle = $aModule['module_id'];
					break;
				}
			}
		}

		if (($sProductId = $this->request()->get('product-id')))
		{
			$aCond[] = " AND setting.product_id = '" . Phpfox::getLib('database')->escape($sProductId) . "' AND setting.is_hidden = 0 ";
			$aUrl = array('setting', 'edit', 'product-id' => $sProductId);
			foreach ($aProductGroups as $aProduct)
			{
				if ($aProduct['product_id'] == $sProductId)
				{
					$sSettingTitle = $aProduct['var_name'];
					break;
				}
			}
		}
		
		$aSettings = Phpfox::getService('admincp.setting')->get($aCond);
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if (Phpfox::getService('admincp.setting.process')->update($aVals))
			{
				$this->url()->send('admincp', $aUrl, Phpfox::getPhrase('admincp.updated'));
			}
		}

		$sWatermarkImage = Phpfox::getParam('core.url_watermark') . sprintf(Phpfox::getParam('core.watermark_image'), '') . '?v=' . uniqid();
		if(!file_exists(Phpfox::getParam('core.dir_watermark') . sprintf(Phpfox::getParam('core.watermark_image'), '')) && Phpfox::getParam('core.allow_cdn'))
		{
			$sWatermarkImage = Phpfox::getLib('cdn')->getUrl(str_replace(PHPFOX_DIR, '', $sWatermarkImage));
		}
		
		$this->template()->setBreadCrumb(Phpfox::getPhrase('admincp.manage_settings'), $this->url()->makeUrl('admincp.setting'))
			->setBreadCrumb(Phpfox::getPhraseT($sSettingTitle, 'module'), null, true)
			->setTitle(Phpfox::getPhrase('admincp.manage_settings'))
			->assign(array(
				'aGroups' => $aGroups,
				'aModules' => $aModules,
				'aProductGroups' => $aProductGroups,			
				'aSettings' => $aSettings,
				'sSettingTitle' => $sSettingTitle,
				'sWatermarkImage' => $sWatermarkImage
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_edit_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_edit_clean')) ? eval($sPlugin) : false);
	}
}

?>
