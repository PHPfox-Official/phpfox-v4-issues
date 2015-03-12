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
 * @version 		$Id: add.class.php 5945 2013-05-23 12:42:06Z Miguel_Espinoza $
 */
class Custom_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$bHideOptions = true;
		$iDefaultSelect = 4;
		$bIsEdit = false;
		
		if (($iEditId = $this->request()->getInt('id')))
		{
			Phpfox::getUserParam('custom.can_manage_custom_fields', true);
			
			$aField = Phpfox::getService('custom')->getForCustomEdit($iEditId);
			if (isset($aField['field_id']))
			{				
				$bIsEdit = true;
				
				$this->template()->assign(array(
						'aForms' => $aField
					)
				);
				
				if (isset($aField['option']) && $aField['var_type'] == 'select')
				{
					$bHideOptions = false;				
				}
			}
		}
		else 
		{
			Phpfox::getUserParam('custom.can_add_custom_fields', true);
			$this->template()->assign(array('aForms' => array()));
		}
		
		$aFieldValidation = array(
			'product_id' => Phpfox::getPhrase('custom.select_a_product_this_custom_field_will_belong_to'),
			//'module_id' => Phpfox::getPhrase('custom.select_a_module_this_custom_field_will_belong_to'),
			'type_id' => Phpfox::getPhrase('custom.select_a_module_this_custom_field_will_belong_to'),
			'var_type' => Phpfox::getPhrase('custom.select_what_type_of_custom_field_this_is')
		);
		
		$oCustomValidator = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_custom_field', 
				'aParams' => $aFieldValidation,
				'bParent' => true
			)
		);		
		
		$this->template()->assign(array(
				'sCustomCreateJs' => $oCustomValidator->createJS(),
				'sCustomGetJsForm' => $oCustomValidator->getJsForm()	
			)
		);		
	
		if (($aVals = $this->request()->getArray('val')))
		{			
			if ($oCustomValidator->isValid($aVals))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('custom.process')->update($aField['field_id'], $aVals))
					{
						$this->url()->send('admincp.custom.add', array('id' => $aField['field_id']), Phpfox::getPhrase('custom.field_successfully_updated'));
					}
				}
				else 
				{
					if (Phpfox::getService('custom.process')->add($aVals))
					{
						$this->url()->send('admincp.custom.add', null, Phpfox::getPhrase('custom.field_successfully_added'));
					}
				}
			}
			
			if (isset($aVals['var_type']) && $aVals['var_type'] == 'select')
			{
				$bHideOptions = false;
				$iCnt = 0;
				$sOptionPostJs = '';
				foreach ($aVals['option'] as $iKey => $aOptions)
				{
					if (!$iKey)
					{
						continue;
					}
					
					$aValues = array_values($aOptions);
					if (!empty($aValues[0]))
					{
						$iCnt++;
					}
					
					foreach ($aOptions as $sLang => $mValue)
					{
						$sOptionPostJs .= 'option_' . $iKey . '_' . $sLang . ': \'' . str_replace("'", "\'", $mValue) . '\',';	
					}
				}
				$sOptionPostJs = rtrim($sOptionPostJs, ',');		
				$iDefaultSelect = $iCnt;		
			}
		}
		
		$aTypes = array();
		foreach (Phpfox::massCallback('getCustomFieldLocations') as $sModule => $aCustomFields)
		{
			foreach ($aCustomFields as $sKey => $sPhrase)
			{
				$aTypes[$sKey] = $sPhrase;
			}
		}
		
		$aGroupTypes = array();
		foreach (Phpfox::massCallback('getCustomGroups') as $sModule => $aCustomGroups)
		{
			foreach ($aCustomGroups as $sKey => $sPhrase)
			{
				$aGroupTypes[$sKey] = $sPhrase;
			}
		}			
		
		$aGroupValidation = array(
			'product_id' => Phpfox::getPhrase('custom.select_a_product_this_custom_field_will_belong_to'),
			'module_id' => Phpfox::getPhrase('custom.select_a_module_this_custom_field_will_belong_to'),
			'type_id' => Phpfox::getPhrase('custom.select_where_this_custom_field_should_be_located')			
		);
		
		$oGroupValidator = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_group_field', 
				'aParams' => $aGroupValidation,
				'bParent' => true
			)
		);			
		
		$this->template()->assign(array(
				'sGroupCreateJs' => $oGroupValidator->createJS(),
				'sGroupGetJsForm' => $oGroupValidator->getJsForm(false)
			)
		);		
		
		$aUserGroups = Phpfox::getService('user.group')->get();
		foreach ($aUserGroups as $iKey => $aUserGroup)
		{
			if (!Phpfox::getUserGroupParam($aUserGroup['user_group_id'], 'custom.has_special_custom_fields'))
			{
				unset($aUserGroups[$iKey]);
			}
		}
		// only show the input if there are custom fields
		$this->template()->assign(array('bShowUserGroups' => (count($aUserGroups)>0)));
		
		
		$this->template()->setTitle(Phpfox::getPhrase('custom.add_a_new_custom_field'))
			->setBreadcrumb($bIsEdit ? 'Edit Custom Field' : Phpfox::getPhrase('custom.add_a_new_custom_field'))
			->setPhrase(array(
					'custom.are_you_sure_you_want_to_delete_this_custom_option'
				)
			)
			->setHeader(array(
					'<script type="text/javascript"> var bIsEdit = ' . ($bIsEdit ?  'true' : 'false') .'</script>',
					'admin.js' => 'module_custom',
					'<script type="text/javascript">$Behavior.custom_admin_add_init = function(){$Core.custom.init(' . ($bIsEdit==true ? 1 : $iDefaultSelect) . '' . (isset($sOptionPostJs) ? ', {' . $sOptionPostJs . '}' : '') . ');};</script>'
				)
			)
			->assign(array(
					'aTypes' => $aTypes,
					'aLanguages' => Phpfox::getService('language')->getAll(),
					'aGroupTypes' => $aGroupTypes,
					'aGroups' => Phpfox::getService('custom.group')->get(),								
					'bHideOptions' => $bHideOptions,
					'bIsEdit' => $bIsEdit,
					'aUserGroups' => $aUserGroups
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('custom.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>
