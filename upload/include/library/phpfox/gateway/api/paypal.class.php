<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * PayPal Payment Gateway API
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: paypal.class.php 7204 2014-03-18 18:56:27Z Fern $
 */
class Phpfox_Gateway_Api_Paypal implements Phpfox_Gateway_Interface
{
	/**
	 * Holds an ARRAY of settings to pass to the form
	 *
	 * @var array
	 */
	private $_aParam = array();
	
	/**
	 * Holds an ARRAY of supported currencies for this payment gateway
	 *
	 * @var array
	 */
	private $_aCurrency = array('USD', 'GBP', 'EUR', 'AUD', 'CAD', 'JPY', 'NZD', 'CHF', 'HKD', 'SGD', 'SEK', 'DKK', 'PLN', 'NOK', 'HUF', 'CZK', 'ILS', 'MXN', 'BRL', 'MYR', 'PHP', 'TWD', 'THB', 'RUB');
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
		
	}	
	
	/**
	 * Set the settings to be used with this class and prepare them so they are in an array
	 *
	 * @param array $aSetting ARRAY of settings to prepare
	 */
	public function set($aSetting)
	{
		$this->_aParam = $aSetting;
		
		if (Phpfox::getLib('parse.format')->isSerialized($aSetting['setting']))
		{
			$this->_aParam['setting'] = unserialize($aSetting['setting']);
		}
	}
	
	/**
	 * Each gateway has a unique list of params that must be passed with the HTML form when posting it
	 * to their site. This method creates that set of custom fields.
	 *
	 * @return array ARRAY of all the custom params
	 */
	public function getEditForm()
	{		
		return array(
			'paypal_email' => array(
				'phrase' => Phpfox::getPhrase('core.paypal_email'),
				'phrase_info' => Phpfox::getPhrase('core.the_email_that_represents_your_paypal_account'),
				'value' => (isset($this->_aParam['setting']['paypal_email']) ? $this->_aParam['setting']['paypal_email'] : '')
			)
		);
	}
	
	/**
	 * Returns the actual HTML <form> used to post information to the 3rd party gateway when purchasing
	 * an item using this specific payment gateway
	 *
	 * @return bool FALSE if we can't use this payment gateway to purchase this item or ARRAY if we have successfully created a form
	 */
	public function getForm()
	{		
		$bCurrencySupported = true;
				
		if (!in_array($this->_aParam['currency_code'], $this->_aCurrency))
		{
			if (!empty($this->_aParam['alternative_cost']))
			{
				$aCosts = unserialize($this->_aParam['alternative_cost']);
				foreach ($aCosts as $aCost)
				{
					$sCode = key($aCost);
					$iPrice = $aCost[key($aCost)];
					
					if (in_array($sCode, $this->_aCurrency))
					{
						$this->_aParam['amount'] = $iPrice;
						$this->_aParam['currency_code'] = $sCode;
						$bCurrencySupported = false;
						break;
					}
				}
			   
				if ($bCurrencySupported === true)
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		$aForm = array(
			'url' => ($this->_aParam['is_test'] ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr'),
			'param' => array(
				'business' => $this->_aParam['setting']['paypal_email'],
				'item_name' => $this->_aParam['item_name'],
				'item_number' => $this->_aParam['item_number'],
				'currency_code' => $this->_aParam['currency_code'],
				'notify_url' => Phpfox::getLib('gateway')->url('paypal'),
				'return' => $this->_aParam['return'],
				'no_shipping' => '1',
				'no_note' => '1'
			)
		);
		
		if ($this->_aParam['recurring'] > 0)
		{
	        switch ($this->_aParam['recurring'])
	        {
	            case '1':
	                $t3 = 'M'; 
	                $p3 = 1;
	                break;
	            case '2':
	                $t3 = 'M'; 
	                $p3 = 3;
	                break;
	            case '3':
	                $t3 = 'M'; 
	                $p3 = 6;
	                break;
	            case '4':
	                $t3 = 'Y'; 
	                $p3 = 1;
	                break;              
	        }			
			
			if ((!isset($this->_aParam['recurring_cost']) || empty($this->_aParam['recurring_cost'])) 
				&& !empty($this->_aParam['alternative_recurring_cost']))
			{
				$aCosts = unserialize($this->_aParam['alternative_recurring_cost']);
				$bPassed = false;
				foreach ($aCosts as $aCost)
				{
					foreach($aCost as $sKey => $iCost)
					{
						if (in_array($sKey, $this->_aCurrency))
						{
							// Make all in the same currency
							$this->_aParam['currency_code'] = $sKey;
							$this->_aParam['amount'] = unserialize($this->_aParam['alternative_cost']);
							$this->_aParam['amount'] = $this->_aParam['amount'][0][$sKey];
							
							$this->_aParam['recurring_cost'] = $iCost;
							if (is_array($this->_aParam['recurring_cost']))
							{
								$aRec = array_values($this->_aParam['recurring_cost']);
								$this->_aParam['recurring_cost'] = array_shift($aRec);
							}
							$bPassed = true;
							break;
						}
					}
					
					if($bPassed)
					{
						break;
					}
				}
			   
				if ($bPassed === false)
				{
					return false;
				}
			}
			
			// If recurring is not zero, set the recurring settings
			if($this->_aParam['recurring_cost'] > 0)
			{
			/* 
				a1 is optional an price for the trial period @see https://cms.paypal.com/uk/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_Appx_websitestandard_htmlvariables#id08A6HI00JQU 
				a3 is the price of the transaction required
			*/
				$aForm['param']['cmd'] = '_xclick-subscriptions';
				$aForm['param']['a1'] = $this->_aParam['amount'];
				$aForm['param']['a3'] = $this->_aParam['recurring_cost']; // $aCosts[$this->_aParam['currency_code']]; change made for 3.7.1
				$aForm['param']['t1'] = $t3;
				$aForm['param']['p1'] = $p3;
				$aForm['param']['t3'] = $t3;
				$aForm['param']['p3'] = $p3;
				$aForm['param']['src'] = '1';
				$aForm['param']['sra'] = '1';
			}
			// if zero, why to set recurring?
			else
			{
				$aForm['param']['cmd'] = '_xclick';
				$aForm['param']['amount'] = $this->_aParam['amount'];
			}
		}
		else 
		{
			$aForm['param']['cmd'] = '_xclick';
			$aForm['param']['amount'] = $this->_aParam['amount'];
		}
		
		return $aForm;
	}
	
	/**
	 * Performs the callback routine when the 3rd party payment gateway sends back a request to the server,
	 * which we must then back and verify that it is a valid request. This then connects to a specific module
	 * based on the information passed when posting the form to the server.
	 *
	 */
	public function callback()
	{
		Phpfox::log('Starting PayPal callback');
		
        // Read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        
        // Loop through each of the variables posted by PayPal
        foreach ($_POST as $key => $value) 
        {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }		
        
        Phpfox::log('Attempting callback');
        
        // Post back to PayPal system to validate
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Host: ". ($this->_aParam['is_test'] ? 'www.sandbox.paypal.com' : 'www.paypal.com') . "\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen(($this->_aParam['is_test'] ? 'ssl://www.sandbox.paypal.com' : 'www.paypal.com'), ($this->_aParam['is_test'] ? 443 : 80), $error_no, $error_msg, 30);     
        fputs($fp, $header . $req);

        $bVerified = false;
        while (!feof($fp)) 
		{
			$res = fgets($fp, 1024);
			$res = strtoupper($res);
			if (strcmp($res, 'VERIFIED') == 0) 
			{  
				$bVerified = true;
				break;	
			}			
		}		
		fclose($fp);
		
		if ($bVerified === true)
		{
			Phpfox::log('Callback OK');
			
			$aParts = explode('|', $this->_aParam['item_number']);
			
			Phpfox::log('Attempting to load module: ' . $aParts[0]);
			
			if (Phpfox::isModule($aParts[0]))
			{
				Phpfox::log('Module is valid.');
				Phpfox::log('Checking module callback for method: paymentApiCallback');
				if (Phpfox::hasCallback($aParts[0], 'paymentApiCallback'))
				{
					Phpfox::log('Module callback is valid.');
					Phpfox::log('Building payment status: ' . (isset($this->_aParam['payment_status']) ? $this->_aParam['payment_status'] : '') . ' (' . (isset($this->_aParam['txn_type']) ? $this->_aParam['txn_type'] : '') . ')');
					
					$sStatus = null;				
					if (isset($this->_aParam['payment_status']))
					{
						switch ($this->_aParam['payment_status'])
						{
							case 'Completed':
								$sStatus = 'completed';
								break;
							case 'Pending':
								$sStatus = 'pending';
								break;
							case 'Refunded':
							case 'Reversed':
								$sStatus = 'cancel';
								break;
						}
					}
					
					if (isset($this->_aParam['txn_type']))
					{
						switch ($this->_aParam['txn_type'])
						{
							case 'subscr_cancel': 
							case 'subscr_failed':
								$sStatus = 'cancel';
								break;
						}
					}
					
					Phpfox::log('Status built: ' . $sStatus);
					
					if ($sStatus !== null)
					{
						Phpfox::log('Executing module callback');
						Phpfox::callback($aParts[0] . '.paymentApiCallback', array(
								'gateway' => 'paypal',
								'ref' => $this->_aParam['txn_id'],						
								'status' => $sStatus,
								'item_number' => $aParts[1],
								'total_paid' => (isset($this->_aParam['mc_gross']) ? $this->_aParam['mc_gross'] : null)
							)
						);
						
						header('HTTP/1.1 200 OK');				
					}
					else 
					{
						Phpfox::log('Status is NULL. Nothing to do');
					}
				}
				else 
				{
					Phpfox::log('Module callback is not valid.');
				}
			}
			else 
			{
				Phpfox::log('Module is not valid.');
			}
		}
		else 
		{
			Phpfox::log('Callback FAILED');
		}		
	}
}

?>
