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
 * @version 		$Id: add.class.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
class Api_Component_Controller_Admincp_Gateway_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_setMenuName('admincp.api.gateway');
		
		if (!($aGateway = Phpfox::getService('api.gateway')->getForEdit($this->request()->get('id'))))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('api.unable_to_find_the_payment_gateway'));
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('api.gateway.process')->update($aGateway['gateway_id'], $aVals))
			{
				$this->url()->send('admincp.api.gateway.add', array('id' => $aGateway['gateway_id']), Phpfox::getPhrase('api.gateway_successfully_updated'));
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('api.payment_gateways'))	
			->setBreadcrumb(Phpfox::getPhrase('api.payment_gateways'), $this->url()->makeUrl('admincp.api.gateway'))
			->setBreadcrumb(Phpfox::getPhrase('api.editing') . ': ' . $aGateway['title'], null, true)
			->assign(array(
					'aForms' => $aGateway
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('api.component_controller_admincp_gateway_add_clean')) ? eval($sPlugin) : false);
	}
}

?>