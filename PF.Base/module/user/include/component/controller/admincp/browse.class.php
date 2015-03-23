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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Browse extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		define('PHPFOX_IS_ADMIN_SEARCH', true);

		$this->template()->setSectionTitle('Members');
		
		return Phpfox_Module::instance()->setController('user.browse');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_browse_clean')) ? eval($sPlugin) : false);
	}
}

?>