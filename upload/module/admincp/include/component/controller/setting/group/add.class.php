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
 * @version 		$Id: add.class.php 1931 2010-10-25 11:58:06Z Raymond_Benc $
 */
class Admincp_Component_Controller_Setting_Group_Add extends Phpfox_Component 
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
		
		$aValidation = array(
			'var_name' => Phpfox::getPhrase('admincp.add_a_title_for_the_group'),
			'info' => Phpfox::getPhrase('admincp.add_information_regarding_group')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_setting_form', 'aParams' => $aValidation));		
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				if ($sVarName = Phpfox::getService('admincp.setting.group.process')->add($aVals))
				{
					$this->url()->send('admincp.setting.group.add', null, Phpfox::getPhrase('admincp.added') . ': ' . $sVarName);
				}
			}
		}		
		
		$this->template()->setBreadCrumb(Phpfox::getPhrase('admincp.add_setting_group'))
			->setTitle(Phpfox::getPhrase('admincp.add_setting_group'))
			->assign(array(
				'aProducts' => Phpfox::getService('admincp.product')->get(),
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'aModules' => Phpfox::getLib('module')->getModules()
			)
		);
			
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_group_add_process')) ? eval($sPlugin) : false);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_group_add_clean')) ? eval($sPlugin) : false);
	}
}

?>