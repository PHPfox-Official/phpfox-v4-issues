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
 * @package  		Module_User
 * @version 		$Id: setting.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Group_Setting extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		Phpfox::getUserParam('user.can_add_user_group_setting', true);
		
		$aGroups = Phpfox::getService('user.group')->get('user_group.is_special = 1');
		
		$aForms = array();
		if (($iSetting = $this->request()->getInt('id')) && ($aForms = Phpfox::getService('user.group.setting')->getSetting($iSetting)) && isset($aForms['setting_id']))
		{
			foreach ($aGroups as $iKey => $aGroup)
			{
				if ($aGroup['user_group_id'] == '1')
				{
					$aGroups[$iKey]['value'] = $aForms['default_admin'];
				}
				elseif ($aGroup['user_group_id'] == '3')
				{
					$aGroups[$iKey]['value'] = $aForms['default_guest'];
				}
				elseif ($aGroup['user_group_id'] == '4')
				{
					$aGroups[$iKey]['value'] = $aForms['default_staff'];
				}
				else 
				{
					$aGroups[$iKey]['value'] = $aForms['default_user'];
				}
			}
		}
		
		$aValidation = array(
			'name' => Phpfox::getPhrase('user.select_varname')
			// 'info' => Phpfox::getPhrase('user.add_info_regarding_setting')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));		
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			// Check that all the fields are valid
			if ($oValid->isValid($aVals))
			{
				if (isset($aForms['setting_id']))
				{
					if (Phpfox::getService('user.group.setting.process')->updateSetting(array_merge($aVals, array('setting_id' => $aForms['setting_id']))))
					{
						$this->url()->send('admincp', array('user', 'group', 'add', 'id' => $this->request()->getInt('gid'), '#setting' . $aForms['setting_id']), Phpfox::getPhrase('user.setting_successfully_updated'));
					}
				}
				else 
				{
					if (Phpfox::getService('user.group.setting.process')->addSetting($aVals))
					{
						$this->url()->send('admincp', array('user', 'group', 'setting'), Phpfox::getPhrase('user.setting_successfully_added'));
					}
				}
			}
		}

		if ($sCacheSetting = Phpfox::getLib('session')->get('cache_new_user_setting'))
		{
			Phpfox::getLib('session')->remove('cache_new_user_setting');
		}				

		if (isset($aForms['name']))
		{
			Phpfox::getLib('database')->select('language_phrase.text, ')
				->leftJoin(Phpfox::getT('language_phrase'), 'language_phrase', "language_phrase.language_id = l.language_id AND language_phrase.var_name = 'user_setting_{$aForms['name']}'");
		}
		$aLanguages = Phpfox::getService('language')->get();

		$this->template()->setBreadcrumb(Phpfox::getPhrase('user.user_groups'), $this->url()->makeUrl('admincp.user.group'))
			->setBreadcrumb(Phpfox::getPhrase('user.manage_user_groups'), $this->url()->makeUrl('admincp.user.group'))
			->setBreadcrumb(Phpfox::getPhrase('user.add_user_group_setting'), null, true)
			->setTitle(Phpfox::getPhrase('user.add_user_group_setting'))
			->assign(array(
				'aProducts' => Phpfox::getService('admincp.product')->get(),
				'aModules' => Phpfox::getService('admincp.module')->getModules(),
				'aLanguages' => $aLanguages,
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'aTypes' => array('boolean','integer','string','array'),
				'aUserGroups' => $aGroups,
				'sCacheSetting' => $sCacheSetting,
				'aForms' => $aForms,
				'iGroupId' => $this->request()->getInt('gid')
			)
		);

		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_group_setting_process')) ? eval($sPlugin) : false);
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_group_setting_clean')) ? eval($sPlugin) : false);
	}
}

?>