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
class Admincp_Component_Controller_Product_Add extends Phpfox_Component 
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
		if (($iEditId = $this->request()->get('id')))
		{			
			$aProduct = Phpfox::getService('admincp.product')->getForEdit($iEditId);			
			if (isset($aProduct['product_id']))
			{
				$bIsEdit = true;				
				$this->template()->assign(array(
						'aForms' => $aProduct,
						'aDependencies' => Phpfox::getService('admincp.product')->getDependencies($aProduct['product_id']),
						'aInstalls' => Phpfox::getService('admincp.product')->getInstalls($aProduct['product_id'])
					)
				);
			}
		}
		
		$aValidation = array(
			'product_id' => Phpfox::getPhrase('admincp.add_a_product_id'),
			'title' => Phpfox::getPhrase('admincp.add_a_product_title')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));		
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			$oAdmincpProductProcess = Phpfox::getService('admincp.product.process');
			
			if (isset($aVals['dependency']))
			{
				if (isset($aVals['dependency']['delete']))
				{
					foreach ($aVals['dependency']['delete'] as $iDeleteId)
					{
						$bDeleted = $oAdmincpProductProcess->deleteDependency($iDeleteId);
					}
				}
				
				if (isset($aVals['dependency']['update']))
				{
					foreach ($aVals['dependency']['update'] as $iDependencyId => $aDependency)
					{
						$oAdmincpProductProcess->updateDependency($iDependencyId, $aDependency);	
					}
				}				
				
				$bAdded = $oAdmincpProductProcess->addDependency($aVals['dependency']);
				
				$this->url()->send('admincp', array('product', 'add', 'id' => $aVals['dependency']['product_id']), Phpfox::getPhrase('admincp.product_dependency_updated'));
			}
			elseif (isset($aVals['install']))
			{
				if (isset($aVals['install']['delete']))
				{
					foreach ($aVals['install']['delete'] as $iDeleteId)
					{
						$bDeleted = $oAdmincpProductProcess->deleteInstall($iDeleteId);
					}
				}
				
				if (isset($aVals['install']['update']))
				{
					foreach ($aVals['install']['update'] as $iInstallId => $aInstallUpdate)
					{
						$oAdmincpProductProcess->updateInstall($iInstallId, $aInstallUpdate);	
					}
				}
				
				$bAdded = $oAdmincpProductProcess->addInstall($aVals['install']);
				
				$this->url()->send('admincp', array('product', 'add', 'id' => $aVals['install']['product_id']), Phpfox::getPhrase('admincp.product_install_uninstall_updated'));
			}
			else 
			{
				if ($oValid->isValid($aVals))
				{
					if ($bIsEdit)
					{
						if (Phpfox::getService('admincp.product.process')->update($aProduct['product_id'], $aVals))
						{
							$this->url()->send('admincp', array('product', 'add', 'id' => $aProduct['product_id']), Phpfox::getPhrase('admincp.product_successfully_updated'));	
						}					
					}
					else 
					{
						if (($sName = Phpfox::getService('admincp.product.process')->add($aVals)))
						{							
							$this->url()->send('admincp', array('product', 'add', 'id' => $sName), Phpfox::getPhrase('admincp.product_successfully_created'));
						}
					}
				}
			}
		}		
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('admincp.editing_product') . ': ' . $aProduct['title'] : Phpfox::getPhrase('admincp.create_new_product')))
			->setBreadcrumb(Phpfox::getPhrase('admincp.products'), $this->url()->makeUrl('admincp.product'))
			->setBreadCrumb(($bIsEdit ? Phpfox::getPhrase('admincp.editing_product') . ': ' . $aProduct['title'] : Phpfox::getPhrase('admincp.create_new_product')), null, true)
			->assign(array(
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
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_module_product_clean')) ? eval($sPlugin) : false);
	}
}

?>