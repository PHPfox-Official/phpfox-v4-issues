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
 * @version 		$Id: purchase.class.php 7178 2014-03-10 19:07:21Z Fern $
 */
class Marketplace_Component_Controller_Purchase extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true); // http://www.phpfox.com/tracker/view/10670/
		$bInvoice = ($this->request()->get('invoice') ? true : false);		
		$iId = $this->request()->get('id');
		if ($bInvoice)
		{
			if (($aInvoice = Phpfox::getService('marketplace')->getInvoice($this->request()->get('invoice'))))
			{
				if ($aInvoice['user_id'] != Phpfox::getUserId())
				{
					return Phpfox_Error::display(Phpfox::getPhrase('marketplace.unable_to_purchase_this_item'));
				}
				
				$iId = $aInvoice['listing_id'];
				$aUserGateways = Phpfox::getService('api.gateway')->getUserGateways($aInvoice['marketplace_user_id']);
				$aActiveGateways = Phpfox::getService('api.gateway')->getActive(); // http://www.phpfox.com/tracker/view/15060/
				$aPurchaseDetails = array(
					'item_number' => 'marketplace|' . $aInvoice['invoice_id'],
					'currency_code' => $aInvoice['currency_id'],
					'amount' => $aInvoice['price'],
					'item_name' => $aInvoice['title'],
					'return' => $this->url()->makeUrl('marketplace.invoice', array('payment' => 'done')),
					'recurring' => '',
					'recurring_cost' => '',
					'alternative_cost' => '',
					'alternative_recurring_cost' => ''						
				);				
				
				if (is_array($aUserGateways) && count($aUserGateways))
				{
					foreach ($aUserGateways as $sGateway => $aData)
					{						
						if (is_array($aData['gateway']))
						{
							foreach ($aData['gateway'] as $sKey => $mValue)
							{
								$aPurchaseDetails['setting'][$sKey] = $mValue;
							}
						}
						else 
						{
							$aPurchaseDetails['fail_' . $sGateway] = true;
						}
						
						// http://www.phpfox.com/tracker/view/15060/
						// Payment gateways added after user configured their payment gateway settings
						if(empty($aActiveGateways))
						{
							continue;
						}
						$bActive = false;
						foreach ($aActiveGateways as $aActiveGateway)
						{
							if($sGateway == $aActiveGateway['gateway_id'])
							{
								$bActive = true;
							}
						}
						if(!$bActive)
						{	
							$aPurchaseDetails['fail_' . $aActiveGateway['gateway_id']] = true;
						}
					}
				}
				
				$this->setParam('gateway_data', $aPurchaseDetails);								
			}
		}
		
		if (!($aListing = Phpfox::getService('marketplace')->getForEdit($iId, true)))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('marketplace.unable_to_find_the_listing_you_are_looking_for'));
		}
		
		if ($this->request()->get('process'))
		{
			if (($iInvoice = Phpfox::getService('marketplace.process')->addInvoice($aListing['listing_id'], $aListing['currency_id'], $aListing['price'])))
			{
				$this->url()->send('marketplace.purchase', array('invoice' => $iInvoice));
			}
			else 
			{
				
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('marketplace.review_and_confirm_purchase'))
			->setBreadcrumb(Phpfox::getPhrase('marketplace.marketplace'), $this->url()->makeUrl('marketplace'))
			->setBreadcrumb(Phpfox::getPhrase('marketplace.review_and_confirm_purchase'), null, true)
			->assign(array(
					'aListing' => $aListing,
					'bInvoice' => $bInvoice
				)			
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_purchase_clean')) ? eval($sPlugin) : false);
	}
}

?>
