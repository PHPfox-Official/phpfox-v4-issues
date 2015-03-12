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
 * @version 		$Id: register.class.php 7250 2014-04-04 16:55:18Z Fern $
 */
class Subscribe_Component_Controller_Register extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sCacheUserId = null;
		if ($this->request()->getInt('login') && Phpfox::getLib('session')->get('cache_user_id'))
		{
			$sCacheUserId = Phpfox::getLib('session')->get('cache_user_id');
		}
		
		if (!($aPurchase = Phpfox::getService('subscribe.purchase')->getInvoice($this->request()->getInt('id'), true, $sCacheUserId)))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('subscribe.unable_to_find_this_invoice'));
		}	
		
		if (empty($aPurchase['status']))
		{
			$this->setParam('gateway_data', array(
					'item_number' => 'subscribe|' . $aPurchase['purchase_id'],
					'currency_code' => $aPurchase['default_currency_id'],
					'amount' => $aPurchase['default_cost'],
					'item_name' => $aPurchase['title'],
					'return' => $this->url()->makeUrl('subscribe.complete'),
					'recurring' => $aPurchase['recurring_period'],
					'recurring_cost' => (isset($aPurchase['default_recurring_cost']) ? $aPurchase['default_recurring_cost'] : ''),
					'alternative_cost' => $aPurchase['cost'],
					'alternative_recurring_cost' => $aPurchase['recurring_cost'],
				)
			);
		}
			
        if ( ($sPlugin = Phpfox_Plugin::get('subscribe.component_controller_register__1')) ){eval($sPlugin); if (isset($mReturnPlugin)){return $mReturnPlugin;}}
		$this->template()->setTitle(Phpfox::getPhrase('subscribe.membership_packages'))
			->setFullSite()
			->setBreadcrumb(Phpfox::getPhrase('subscribe.membership_packages'), $this->url()->makeUrl('subscribe'))
			->setBreadcrumb(Phpfox::getPhrase('subscribe.subscriptions'), $this->url()->makeUrl('subscribe.list'))
			->setBreadcrumb(Phpfox::getPhrase('subscribe.select_payment_gateway'), null, true)
			->assign(array(
					'aPurchase' => $aPurchase
				)
			);				
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('subscribe.component_controller_register_clean')) ? eval($sPlugin) : false);
	}
}

?>
