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
class Admincp_Component_Controller_Component_Add extends Phpfox_Component
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
		if (($iId = $this->request()->getInt('id')) && ($aComponent = Phpfox::getService('admincp.component')->getForEdit($iId)))
		{
			$bIsEdit = true;
			$this->template()->assign(array(
					'aForms' => $aComponent
				)
			);
		}
		
		$aValidation = array(
			'product_id' => Phpfox::getPhrase('admincp.select_product'),
			'component' => Phpfox::getPhrase('admincp.specify_component'),
			'is_active' => Phpfox::getPhrase('admincp.select_component_active'),
			'type' => Phpfox::getPhrase('admincp.select_component_type')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));	

		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('admincp.component.process')->update($iId, $aVals))
					{
						$this->url()->send('admincp.component.add', array('id' => $iId), Phpfox::getPhrase('admincp.component_successfully_updated'));
					}
				}
				else 
				{
					if (Phpfox::getService('admincp.component.process')->add($aVals))
					{
						$this->url()->send('admincp.component', null, Phpfox::getPhrase('admincp.component_successfully_added'));
					}
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('admincp.editing_component') : Phpfox::getPhrase('admincp.add_component')))
			->setBreadcrumb(Phpfox::getPhrase('admincp.manage_components'), $this->url()->makeUrl('admincp.component'))
			->setBreadCrumb(($bIsEdit ? Phpfox::getPhrase('admincp.editing_component') : Phpfox::getPhrase('admincp.add_component')), null, true)
			->assign(array(
				'aProducts' => Phpfox::getService('admincp.product')->get(),
				'aModules' => Phpfox::getService('admincp.module')->getModules(),
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'bIsEdit' => $bIsEdit
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_component_add_clean')) ? eval($sPlugin) : false);
	}
}

?>