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
 * @version 		$Id: index.class.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
class Api_Component_Controller_Admincp_Gateway_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->setTitle(Phpfox::getPhrase('api.payment_gateways'))	
			->setBreadcrumb(Phpfox::getPhrase('api.payment_gateways'), $this->url()->makeUrl('admincp.api.gateway'))
			->assign(array(
					'aGateways' => Phpfox::getService('api.gateway')->getForAdmin()
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('api.component_controller_admincp_gateway_index_clean')) ? eval($sPlugin) : false);
	}
}

?>