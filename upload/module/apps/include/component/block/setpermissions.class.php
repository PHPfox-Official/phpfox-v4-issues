<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Component_Block_Setpermissions extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 * This block is called from an ajax call to set the permissions on an app
	 */
	public function process()
	{		
		// Check if app exists
		$aApp = Phpfox::getService('apps')->getAppById($this->getParam('id'));
		if (empty($aApp) || !isset($aApp['app_id']))
		{
			$this->alert(Phpfox::getPhrase('apps.that_app_does_not_exist')); 
			return;
		}
		
		// get all the permissions that we can show
		$aPermissions = Phpfox::getService('apps')->getPermissions($aApp['app_id']); 
		//d($aPermissions);
		$this->template()
			->assign(array(
				'aPermissions' => $aPermissions,
				'aApp' => $aApp
			))
			->setHeader(array(
		
			));
		
		//return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('apps.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>