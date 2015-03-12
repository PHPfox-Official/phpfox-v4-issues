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
 * @version 		$Id: import.class.php 4961 2012-10-29 07:11:34Z Raymond_Benc $
 */
class Apps_Component_Controller_Admincp_Import extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!empty($_FILES['import']))
		{
			if (Phpfox::getService('apps.process')->import($this->request()->get('key'), $_FILES['import']))
			{
				$this->url()->send('admincp.apps.import', null, 'Successfully imported apps.');
			}
		}
		
		$this->template()->setTitle('Install Apps')
			->setBreadcrumb('Install Apps')
			->assign(array(
					
					)
				);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('apps.component_controller_admincp_import_clean')) ? eval($sPlugin) : false);
	}
}

?>