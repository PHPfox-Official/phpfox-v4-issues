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
 * @version 		$Id: upgrade.class.php 7107 2014-02-11 19:46:17Z Fern $
 */
class Subscribe_Component_Block_Upgrade extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		// http://www.phpfox.com/tracker/view/15093/
		$bIsThickBox = $this->getParam('bIsThickBox');
		$this->template()->assign(array('bIsThickBox' => $bIsThickBox));
		
		if ($this->request()->getInt('purchase_id'))
		{
			if (!($aPackage = Phpfox::getService('subscribe.purchase')->getInvoice($this->request()->getInt('purchase_id'), true)))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('subscribe.unable_to_find_the_purchase_you_are_looking_for'));
			}			
			
			$iPurchaseId = $aPackage['purchase_id'];
		}
		else 
		{
			if (!($aPackage = Phpfox::getService('subscribe')->getPackage($this->request()->getInt('id'))))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('subscribe.unable_to_find_the_package_you_are_looking_for'));
			}
			
			if (Phpfox::getUserBy('user_group_id') == $aPackage['user_group_id'])
			{
				return Phpfox_Error::set(Phpfox::getPhrase('subscribe.attempting_to_upgrade_to_the_same_user_group_you_are_already_in'));
			}
			
			$aPackage['default_currency_id'] = isset($aPackage['default_currency_id']) ? $aPackage['default_currency_id'] : $aPackage['price'][0]['alternative_currency_id'];
			$aPackage['default_cost'] = isset($aPackage['default_cost']) ? $aPackage['default_cost'] : $aPackage['price'][0]['alternative_cost'];
			$iPurchaseId = Phpfox::getService('subscribe.purchase.process')->add(array(
					'package_id' => $aPackage['package_id'],
					'currency_id' => $aPackage['default_currency_id'],
					'price' => $aPackage['default_cost']
				)
			);	
			/* Make sure we mark it as free only if the default cost is free and its not a recurring charge */
			if ($aPackage['default_cost'] == '0.00' && $aPackage['recurring_period'] == 0)
			{
				$this->template()->assign('bIsFree', true);
				$this->template()->assign('iPurchaseId', $iPurchaseId);
				
				Phpfox::getService('subscribe.purchase.process')->update($iPurchaseId, $aPackage['package_id'], 'completed', Phpfox::getUserId(), $aPackage['user_group_id'], $aPackage['fail_user_group']);
					
				return;
			}
		}
		/* Load the gateway only if its not free */
		if (($aPackage['default_cost'] != '0.00' || $aPackage['recurring_period'] != 0) && $iPurchaseId)
		{
			$this->setParam('gateway_data', array(
					'item_number' => 'subscribe|' . $iPurchaseId,
					'currency_code' => $aPackage['default_currency_id'],
					'amount' => $aPackage['default_cost'],
					'item_name' => $aPackage['title'],
					'return' => $this->url()->makeUrl('subscribe.complete'),
					'recurring' => $aPackage['recurring_period'],
					'recurring_cost' => (isset($aPackage['default_recurring_cost']) ? $aPackage['default_recurring_cost'] : ''),
					'alternative_cost' => (isset($aPackage['price'][0]) ? serialize($aPackage['price']) : ''),
					'alternative_recurring_cost' => (isset($aPackage['recurring_price'][0]) ? serialize($aPackage['recurring_price']) : '')
				)
			);
		}	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('subscribe.component_block_upgrade_clean')) ? eval($sPlugin) : false);
	}
}

?>
