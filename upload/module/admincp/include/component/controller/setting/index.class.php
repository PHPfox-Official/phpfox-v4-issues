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
 * @version 		$Id: index.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Admincp_Component_Controller_Setting_Index extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		list($aGroups, $aModules, $aProductGroups) = Phpfox::getService('admincp.setting.group')->get();

		$this->template()->setBreadCrumb(Phpfox::getPhrase('admincp.manage_settings'))
			->setTitle(Phpfox::getPhrase('admincp.manage_settings'))		
			->assign(array(
				'aGroups' => $aGroups,
				'aModules' => $aModules,
				'aProductGroups' => $aProductGroups			
			)
		);
			
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_index_process')) ? eval($sPlugin) : false);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_index_clean')) ? eval($sPlugin) : false);
	}
}

?>