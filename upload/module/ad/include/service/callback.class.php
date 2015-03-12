<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Ad Callback Service.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Module_Ad
 * @version 		$Id: callback.class.php 4620 2012-09-09 12:55:15Z Raymond_Benc $
 */
class Ad_Service_Callback extends Phpfox_Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
		(($sPlugin = Phpfox_Plugin::get('ad.service_callback_construct__start')) ? eval($sPlugin) : false);
    }

    /**
     * Handles API callback for payment gateways.
     *
     * @param array $aParams ARRAY of params passed from the payment gateway after a payment has been made.
     * @return bool|null FALSE if payment is not valid|Nothing returned if everything went well.
     */
    public function paymentApiCallback($aParams)
    {
		Phpfox::log('Module callback recieved: ' . var_export($aParams, true));
		Phpfox::log('Attempting to retrieve purchase from the database');
		
		define('PHPFOX_API_CALLBACK', true); // used to override security checks in the processes
	
		if (preg_match('/sponsor/i', $aParams['item_number']))
		{	    
		    // we get the sponsored ad
		    $iId = preg_replace("/[^0-9]/", '', $aParams['item_number']);
		    Phpfox::log('Ad is sponsored');
		    $aInvoice = $this->database()
			    ->select('*')
			    ->from(Phpfox::getT('ad_invoice'))
			    ->where('invoice_id = ' . $iId . ' AND is_sponsor = 1')
			    ->execute('getSlaveRow');		    

		    $aAd = Phpfox::getService('ad')->getSponsor($aInvoice['ad_id']);
		}
		else
		{
		    $aAd = Phpfox::getService('ad')->getForEdit($aParams['item_number']);	   
		    $aInvoice = Phpfox::getService('ad')->getInvoice($aAd['ad_id']);	    
		}

		if (empty($aAd) || $aAd === false)
		{
		    Phpfox::log('Purchase is not valid');
		    return false;
		}
		if (empty($aInvoice) ||$aInvoice === false)
		{			
		    Phpfox::log('Not a valid invoice');
		    return false;
		}
	
		Phpfox::log('Purchase is valid: ' . var_export($aInvoice, true));
	
		if ($aParams['status'] == 'completed')
		{
		    if ($aParams['total_paid'] == $aInvoice['price'])
		    {
				Phpfox::log('Paid correct price');
		    }
		    else
		    {
				Phpfox::log('Paid incorrect price');
		
				return false;
		    }
		}
		else 
		{
			Phpfox::log('Payment is not marked as "completed".');
			
			return false;
		}		

		Phpfox::log('Handling purchase');
	
		$this->database()->update(Phpfox::getT('ad_invoice'), array(
			'status' => $aParams['status'],
			'time_stamp_paid' => PHPFOX_TIME
			), 'invoice_id = ' . $aInvoice['invoice_id']
		);	
	
		if (isset($aAd['auto_publish']))
		{
		    // its a sponsor ad
		    $this->database()->update(Phpfox::getT('ad_sponsor'), array(
			    'is_custom' => $aAd['auto_publish'] == 1 ? '3' : '2', // 3 means it should be published, 2 means its pending approval
			    'is_active' => $aAd['auto_publish'] == 1 ? '1' : '0'
			    ), 'sponsor_id = ' . $aAd['sponsor_id']);	
		    
		    if ($aAd['auto_publish'] == 1)
		    {
				$sModule = $aAd['module_id'];
		
				$sSection = '';
				if (strpos($sModule, '-') !== false)
				{
				    $aModule = explode('-',$sModule);
				    $sModule = $aModule[0];
				    $sSection = $aModule[1];
				}

				Phpfox::callback($sModule . '.enableSponsor', array('item_id' => $aAd['item_id'], 'section' => $sSection));			
		    }		   
		}
		else
		{
		    $this->database()->update(Phpfox::getT('ad'), array(
			    'is_custom' => '2'
			    ), 'ad_id = ' . $aAd['ad_id']
		    );
		}
		$this->cache()->remove('ad', 'substr');
	
		Phpfox::log('Handling complete');
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
		if ($sPlugin = Phpfox_Plugin::get('ad.service_callback__call'))
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