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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 4620 2012-09-09 12:55:15Z Raymond_Benc $
 */
class Api_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function processActivityPayment()
	{
		$aParts = explode('|', $this->get('item_number'));

		if (Phpfox::getService('user.process')->purchaseWithPoints($aParts[0], $aParts[1], $this->get('amount'), $this->get('currency_code')))
		{
			Phpfox::addMessage('Purchase successfully completed.');
			
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('') . '\'');
		}
	}
	
	public function updateGatewayActivity()
	{
		if (Phpfox::getService('api.gateway.process')->updateActivity($this->get('gateway_id'), $this->get('active')))
		{
			
		}		
	}
	
	public function updateGatewayTest()
	{
		if (Phpfox::getService('api.gateway.process')->updateTest($this->get('gateway_id'), $this->get('active')))
		{
			
		}			
	}
}

?>