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
 * @version 		$Id: index.class.php 1931 2010-10-25 11:58:06Z Raymond_Benc $
 */
class Admincp_Component_Controller_Module_Index extends Phpfox_Component
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
		
		Phpfox::getUserParam('admincp.can_manage_modules', true);
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if (Phpfox::getService('admincp.module.process')->updateActive($aVals))
			{
				$this->url()->send('admincp.module', null, Phpfox::getPhrase('admincp.module_s_updated'));
			}			
		}		
		
		if ($sDeleteId = $this->request()->get('delete'))
		{
			$sCachePhrase = Phpfox::getPhrase('admincp.module_successfully_deleted');
			
			if (Phpfox::getService('admincp.module.process')->delete($sDeleteId))
			{
				$this->url()->send('admincp.module', null, $sCachePhrase);
			}
		}
		
		if (($sModuleInstall = $this->request()->get('install')))
		{
			if (Phpfox::getService('admincp.module.process')->install($sModuleInstall, array(
						'table' => true,
						'post_install' => true,
						'insert' => true
					)
				)
			)
			{
				$sCachePhrase = Phpfox::getPhrase('admincp.module_successfully_installed');
				
				Phpfox::getLib('cache')->remove();
				
				$this->url()->send('admincp.module', null, $sCachePhrase);
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.manage_modules'))
			->setBreadCrumb(Phpfox::getPhrase('admincp.manage_modules'))
			->assign(array(
				'aModules' => Phpfox::getService('admincp.module')->get(true)
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_module_index_clean')) ? eval($sPlugin) : false);
	}
}

?>