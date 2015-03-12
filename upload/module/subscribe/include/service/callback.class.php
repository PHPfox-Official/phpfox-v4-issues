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
 * @package 		Phpfox_Service
 * @version 		$Id: callback.class.php 4052 2012-03-26 11:15:21Z Miguel_Espinoza $
 */
class Subscribe_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function paymentApiCallback($aParams)
	{
		Phpfox::log('Module callback recieved: ' . var_export($aParams, true));
		Phpfox::log('Attempting to retrieve purchase from the database');	
		
		if (!($aPurchase = Phpfox::getService('subscribe.purchase')->getPurchase($aParams['item_number'])))
		{
			Phpfox::log('Purchase is not valid');
			
			return false;
		}
		
		Phpfox::log('Purchase is valid: ' . var_export($aPurchase, true));
		
		if ($aParams['status'] == 'completed')
		{
			if ($aParams['total_paid'] == $aPurchase['price'])
			{
				Phpfox::log('Paid correct price');
			}
			else 
			{
				Phpfox::log('Paid incorrect price');
				
				return false;
			}
		}
		else if ($aParams['status'] == 'cancel')
		{
			Phpfox::log('Cancel subscription.');
		}
		else 
		{
			Phpfox::log('Payment is not marked as "completed".');
			
			return false;
		}		
		
		Phpfox::log('Handling purchase');
		Phpfox::getService('subscribe.purchase.process')->update($aPurchase['purchase_id'], $aPurchase['package_id'], $aParams['status'], $aPurchase['user_id'], $aPurchase['user_group_id'], $aPurchase['fail_user_group']);
		Phpfox::log('Handling complete');
	}
	
	public function getDashboardMenus()
	{
		if (!Phpfox::getParam('subscribe.enable_subscription_packages'))
		{
			return false;
		}
		
		return array(
			'subscribe.upgrades' => '#subscribe.listUpgrades?id=js_core_dashboard'
		);
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('subscribe.service_callback__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>