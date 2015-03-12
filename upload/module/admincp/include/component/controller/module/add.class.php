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
 * @version 		$Id: add.class.php 5243 2013-01-29 10:46:33Z Raymond_Benc $
 */
class Admincp_Component_Controller_Module_Add extends Phpfox_Component 
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
		
		$bIsEdit = false;
		if (($iEditId = $this->request()->get('id')) || ($iEditId = $this->request()->get('module_id')))
		{
			Phpfox::getUserParam('admincp.can_manage_modules', true);
			
			$aRow = Phpfox::getService('admincp.module')->getForEdit($iEditId);			
			$bIsEdit = true;
			
			if ($aRow['is_menu'] && !empty($aRow['menu']))
			{
				$aMenus = unserialize($aRow['menu']);	
				$aSubs = array();	

				foreach ($aMenus as $sPhrase => $aMenu)
				{
					$aParts = explode('.', $sPhrase);
					
					$aSubs[] = array(
						'phrase' => Phpfox::getService('language.phrase')->getStaticPhrase($sPhrase),
						'link' => implode('.', $aMenu['url']),
						'var_name' => $aParts[1]
					);
				}
				
				$aRow['menu'] = $aSubs;
			}			
			
			$this->template()->assign(array(
					'aForms' => $aRow
				)
			);			
		}			
		else 
		{
			Phpfox::getUserParam('admincp.can_add_new_modules', true);
		}
		
		$aValidation = array(
			'module_id' => Phpfox::getPhrase('admincp.select_name_for_your_module')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));		
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('admincp.module.process')->update($aRow['module_id'], $aVals))
					{
						$this->url()->send('admincp', array('module', 'add', 'id' => $aRow['module_id']), Phpfox::getPhrase('admincp.module_successfully_updated'));	
					}					
				}
				else 
				{
					if (Phpfox::getLib('module')->isModule($aVals['module_id']))
					{
						Phpfox_Error::set(Phpfox::getPhrase('admincp.module_name_already_used'));	
					}
					else 
					{
						if (($sName = Phpfox::getService('admincp.module.process')->add($aVals)))
						{							
							$this->url()->send('admincp', array('module', 'add'), Phpfox::getPhrase('admincp.module_successfully_created_redirect'));
						}
					}
				}
			}
		}		
		
		$aVals = $this->request()->getArray('val');
		$aMenus = array();		
		if (isset($aVals['menu']) || isset($aRow['menu']))
		{
			$aSubMenus = ($bIsEdit ? $aRow['menu'] : $aVals['menu']);
			if (is_array($aSubMenus) && count($aSubMenus))
			{
				foreach ($aSubMenus as $iKey => $aMenu)
				{
					if (empty($aMenu['phrase']))
					{
						continue;
					}
					
					$aMenus[$iKey] = $aMenu;
				}
			}
		}
		
		$this->template()->setBreadCrumb(($bIsEdit ? 'Editing Module: ' . $aRow['module_id'] : Phpfox::getPhrase('admincp.create_module')))
			->setTitle(($bIsEdit ? 'Editing Module: ' . $aRow['module_id'] : Phpfox::getPhrase('admincp.create_module')))		
			->assign(array(
				'aProducts' => Phpfox::getService('admincp.product')->get(),
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'aLanguages' => ($bIsEdit ? Phpfox::getService('language')->getWithPhrase($aRow['phrase_var_name']) : Phpfox::getService('language')->get()),
				'sDir' => PHPFOX_DIR_MODULE,	
				'aMenus' => $aMenus,
				'iMenus' => (($bIsEdit && count($aRow['menu'])) ? (count($aRow['menu']) - 1) : (isset($aVals['menu']) ? (count($aVals['menu']) - 1) : 3)),
				'sPhpfoxDs' => PHPFOX_DS,
				'bIsEdit' => $bIsEdit
			)
		);
			
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_module_add_process')) ? eval($sPlugin) : false);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_module_add_clean')) ? eval($sPlugin) : false);
	}
}

?>