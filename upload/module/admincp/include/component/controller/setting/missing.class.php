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
 * @version 		$Id: missing.class.php 1390 2010-01-13 13:30:08Z Raymond_Benc $
 */
class Admincp_Component_Controller_Setting_Missing extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iPage = $this->request()->getInt('page', 0);
		
		$aXml = Phpfox::getService('core')->getModulePager('settings', $iPage, 5);		
		
		if ($aXml === false)
		{
			$sPhrase = Phpfox::getPhrase('admincp.missing_settings_successfully_imported');
			
			Phpfox::getLib('cache')->remove('setting', 'substr');
			
			$this->url()->send('admincp.setting', null, $sPhrase);
		}
		
		$aModules = array();
		if (is_array($aXml))
		{
			$iMissing = Phpfox::getService('admincp.setting.process')->findMissingSettings($aXml);
			
			foreach ($aXml as $sModule => $sPhrases)
			{
				$aModules[] = $sModule;
			}
			
			$this->template()->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('admincp.setting.missing', array('page' => ($iPage + 1))) . '">');
		}

		$this->template()->setTitle(Phpfox::getPhrase('admincp.missing_settings'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.settings'), $this->url()->makeUrl('admincp.setting'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.missing_settings'), $this->url()->makeUrl('admincp.setting'), true)
			->assign(array(
					'aModules' => $aModules,
					'iMissing' => $iMissing
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_missing_clean')) ? eval($sPlugin) : false);
	}
}

?>