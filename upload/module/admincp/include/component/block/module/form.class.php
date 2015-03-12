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
 * @version 		$Id: form.class.php 4883 2012-10-11 05:28:17Z Raymond_Benc $
 */
class Admincp_Component_Block_Module_Form extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sModuleFormTitle = $this->getParam('module_form_title', Phpfox::getPhrase('admincp.module'));
		if (preg_match('/([a-zA-Z]+)\.([a-zA-Z]+)/i', $sModuleFormTitle, $aMatches) && isset($aMatches[2]) && Phpfox::isModule($aMatches[1]))
		{
			$sModuleFormTitle = Phpfox::getPhrase($sModuleFormTitle);
		}
		
		$this->template()->assign(array(
				'aModules' => Phpfox::getService('admincp.module')->getModules(),
				'bUseClass' => $this->getParam('class'),
				'sModuleFormTitle' => $sModuleFormTitle,
				'bModuleFormRequired' => $this->getParam('module_form_required', true),
				'sModuleFormValue' => $this->getParam('module_form_value', Phpfox::getPhrase('admincp.select') . ':'),
				'sModuleFormId' => $this->getParam('module_form_id', 'module_id')
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_block_module_form_clean')) ? eval($sPlugin) : false);
	}
}

?>