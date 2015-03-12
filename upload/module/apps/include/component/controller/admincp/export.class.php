<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: export.class.php 5259 2013-01-29 14:30:29Z Raymond_Benc $
 */
class Apps_Component_Controller_Admincp_Export extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (count(($aVals = $this->request()->getArray('val'))))
		{
			Phpfox::getService('apps')->export($aVals);
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('apps.export_apps'))
			->setBreadcrumb(Phpfox::getPhrase('apps.export_apps'))
			->assign(array(
						'aApps' => Phpfox::getService('apps')->getAllApps()					
					)
				);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('apps.component_controller_admincp_export_clean')) ? eval($sPlugin) : false);
	}
}

?>