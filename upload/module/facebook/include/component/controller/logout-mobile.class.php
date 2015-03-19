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
 * @version 		$Id: logout-mobile.class.php 1494 2010-03-05 14:23:08Z Raymond_Benc $
 */
class Facebook_Component_Controller_Logout_Mobile extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		Phpfox_Module::instance()->setController('facebook.logout');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('facebook.component_controller_logout_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>