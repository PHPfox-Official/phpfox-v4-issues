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
 * @version 		$Id: callback.class.php 671 2009-06-12 17:12:28Z Raymond_Benc $
 */
class Api_Component_Controller_Gateway_Callback extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (!($oGateway = Api_Service_Gateway_Gateway::instance()->callback($this->request()->get('req4'))))
		{
		
		}
		
		exit;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('api.component_controller_gateway_callback_clean')) ? eval($sPlugin) : false);
	}
}

?>