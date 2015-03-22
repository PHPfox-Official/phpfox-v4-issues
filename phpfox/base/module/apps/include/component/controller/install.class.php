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
class Apps_Component_Controller_Install extends Phpfox_Component
{
	/**
	 * Class process method which is used to execute this component.
	 */
	public function process()
	{		
		if (!Phpfox::isUser())
		{
			Phpfox::getLib('session')->set('appinstall', $this->request()->get('req3'));
		}
		
		Phpfox::isUser(true);
		/* this shoud not happen*/
		if ($this->getParam('aApp') == null)
		{
			$aApp = Phpfox::getService('apps')->getAppById($this->request()->get('req3'));
		}
		else
		{
			$aApp = $this->getParam('aApp');
		}
		
				
		/* if there is no app */
		if (empty($aApp))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('apps.that_app_was_not_found'));
		}
		
		$aPermissions = Phpfox::getService('apps')->getPermissions();
		
		$aUser = array();
		$aUser['full_name'] = Phpfox::getUserBy('full_name');
		$this->template()
			->setFullSite()
			->assign(array(
				'aApp' => $aApp,
				'aUser' =>$aUser,
				'aPermissions' => $aPermissions
			))
			->setHeader(array(
				'install.css' => 'module_apps',
				'install.js' => 'module_apps'
			))
			->setBreadCrumb('Apps', $this->url()->makeUrl('apps'));			
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