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
 * @version 		$Id: add.class.php 2000 2010-10-29 11:24:24Z Raymond_Benc $
 */
class Admincp_Component_Controller_Plugin_Add extends Phpfox_Component
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
		$aValidation = array(
			'product_id' => Phpfox::getPhrase('admincp.select_product'),
			'title' => Phpfox::getPhrase('admincp.provide_a_title_for_your_plugin'),
			'call_name' => Phpfox::getPhrase('admincp.select_a_hook'),
			'php_code' => Phpfox::getPhrase('admincp.provide_php_code_for_your_plugin')		
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));
		
		if (($iEditId = $this->request()->get('id')))
		{			
			$aPlugin = Phpfox::getService('admincp.plugin')->getForEdit($iEditId);
			if (isset($aPlugin['plugin_id']))
			{
				$bIsEdit = true;				
				$this->template()->assign(array(
						'aForms' => $aPlugin						
					)
				);
			}
		}			
		else 
		{
			
		}
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('admincp.plugin.process')->update($aPlugin['plugin_id'], $aVals))
				{
					$this->url()->send('admincp.plugin.add', array('id' => $aPlugin['plugin_id']), Phpfox::getPhrase('admincp.plugin_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('admincp.plugin.process')->add($aVals))
				{
					$this->url()->send('admincp.plugin.add', null, Phpfox::getPhrase('admincp.plugin_successfully_added'));
				}
			}
		}
		
		if (Phpfox::getParam('core.enabled_edit_area'))
		{
			$this->template()->setHeader(array(
					'editarea/edit_area_full.js' => 'static_script',
					'<script type="text/javascript">				
						editAreaLoader.init({
							id: "php_code"	
							,start_highlight: true
							,allow_resize: "both"
							,allow_toggle: false
							,word_wrap: false
							,language: "en"
							,syntax: "php"
						});		
					</script>'
				)
			);
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.create_plugin'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.create_plugin'))					
			->assign(array(
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),			
				'aHooks' => Phpfox::getService('admincp.plugin')->getHooks(),
				'bIsEdit' => $bIsEdit
			)
		);
	}
}	

?>