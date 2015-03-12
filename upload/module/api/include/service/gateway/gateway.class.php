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
 * @version 		$Id: gateway.class.php 7279 2014-04-23 13:41:35Z Fern $
 */
class Api_Service_Gateway_Gateway extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('api_gateway');	
	}
	
	public function getActive()
	{
        if ($sPlugin = Phpfox_Plugin::get('api.service_gateway_gateway_getactive_1')){eval($sPlugin);if (isset($mReturnPlugin)){return $mReturnPlugin;}}
		$aGateways = $this->database()->select('ag.*')
			->from($this->_sTable, 'ag')
			->where('ag.is_active = 1')
			->execute('getRows');	
			
		foreach ($aGateways as $iKey => $aGateway)
		{
			$oGateway = Phpfox::getLib('gateway')->load($aGateway['gateway_id'], $aGateway);
			
			if ($oGateway === false)
			{
				continue;
			}
			
			$aGateways[$iKey]['custom'] = $oGateway->getEditForm();			
		}
			
		return $aGateways;	
	}
	
	public function getUserGateways($iUserId)
	{
		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('user_gateway'))
			->where('user_id = ' . (int) $iUserId)
			->execute('getSlaveRows');
			
		$aGateways = array();
		foreach ($aRows as $iKey => $mValue)
		{
			$aCache = unserialize($mValue['gateway_detail']);
			$bSkip = false;
			foreach ($aCache as $sSettingKey => $sSettingValue)
			{
				if (empty($sSettingValue))
				{
					$bSkip = true;
				}
			}
			
			if ($bSkip === true)
			{
				$aGateways[$mValue['gateway_id']]['gateway'] = null;
				
				continue;
			}
			
			// http://www.phpfox.com/tracker/view/15071/
			$aCache['seller_id'] = $mValue['user_id']; 
			$aGateways[$mValue['gateway_id']]['gateway'] = $aCache; //unserialize($mValue['gateway_detail']);
		}
			
		return $aGateways;
	}
	
	public function get($aGatewayData = array())
	{
		$aGateways = $this->database()->select('ag.*')
			->from($this->_sTable, 'ag')
			->where('ag.is_active = 1')
			->execute('getRows');
		
		foreach ($aGateways as $iKey => $aGateway)
		{
			if (isset($aGatewayData['fail_' . $aGateway['gateway_id']]) && $aGatewayData['fail_' . $aGateway['gateway_id']] === true)
			{
				unset($aGateways[$iKey]);
				
				continue;
			}
			
			if (!($oGateway = Phpfox::getLib('gateway')->load($aGateway['gateway_id'], array_merge($aGateway, $aGatewayData))))
			{				
				unset($aGateways[$iKey]);
				
				continue;
			}
			
			if (($aGateways[$iKey]['form'] = $oGateway->getForm()) === false)
			{				
				unset($aGateways[$iKey]);
			}
		}

		if (!isset($aGatewayData['no_purchase_with_points']) && Phpfox::getParam('user.can_purchase_with_points') && Phpfox::getUserParam('user.can_purchase_with_points'))
		{
			$iTotalPoints = (int) $this->database()->select('activity_points')
				->from(Phpfox::getT('user_activity'))
				->where('user_id = ' . (int) Phpfox::getUserId())
				->execute('getSlaveField');			
			
			$sCurreny = $aGatewayData['currency_code'];
			$aSetting = Phpfox::getParam('user.points_conversion_rate');
			if (isset($aSetting[$sCurreny]))
			{
				// Avoid division by zero
				$iConversion = ($aSetting[$sCurreny] != 0 ? ($aGatewayData['amount'] / $aSetting[$sCurreny]) : 0);
				if ($iTotalPoints >= $iConversion)
				{
					if(isset($aGatewayData['setting']) && is_array($aGatewayData['setting']))
					{
						$sParam = serialize($aGatewayData['setting']);
						unset($aGatewayData['setting']);
					}
					
					$aPointsGateway = array(
						'yourpoints' => $iTotalPoints,
						'yourcost' => $iConversion,		
						'gateway_id' => 'activitypoints',
						'title' => Phpfox::getPhrase('user.activity_points'),
						'description' => Phpfox::getPhrase('user.you_can_purchase_this_with_your_activity_points'),
						'is_active' => '1',
						'form' => array(
							'url' => '#',
							'param' => $aGatewayData
						)
					);
					if(isset($sParam) && !empty($sParam))
					{
						$aPointsGateway['setting'] = $sParam;
					}
					
					$aGateways[] = $aPointsGateway;
				}
				else
				{
					Phpfox_Error::display(Phpfox::getPhrase('user.not_enough_points', array('total' => $iTotalPoints)));
				}
			}	
		}
		
		return $aGateways;
	}
	
	public function callback($sGateway)
	{
		Phpfox::startLog('Callback started.');
		Phpfox::log('Request: ' . var_export($_REQUEST, true));
		
		if (empty($sGateway))
		{
			Phpfox::log('Gateway is empty.');
			Phpfox::getService('api.gateway.process')->addLog(null, Phpfox::endLog());
			
			return false;
		}
		
		$aGateway = $this->database()->select('ag.*')
			->from($this->_sTable, 'ag')
			->where('ag.gateway_id = \'' . $this->database()->escape($sGateway) . '\' AND ag.is_active = 1')
			->execute('getRow');
		
		// http://www.phpfox.com/tracker/view/15424/
		if($sGateway == 'activitypoints' && Phpfox::getParam('user.can_purchase_with_points') && Phpfox::getUserParam('user.can_purchase_with_points'))
		{
			Phpfox::log('Gateway successfully loaded.');
			Phpfox::log('Callback complete');
			Phpfox::getService('api.gateway.process')->addLog($aGateway['gateway_id'], Phpfox::endLog());
			return true;
		}
			
		if (!isset($aGateway['gateway_id']))
		{
			Phpfox::log('"' . $sGateway . '" is not a valid gateway.');
			Phpfox::getService('api.gateway.process')->addLog(null, Phpfox::endLog());
			
			return false;
		}

		Phpfox::log('Attempting to load gateway: ' . $aGateway['gateway_id']);
		
		if (!($oGateway = Phpfox::getLib('gateway')->load($aGateway['gateway_id'], array_merge($_REQUEST, $aGateway))))
		{
			Phpfox::log('Unable to load gateway.');
			Phpfox::getService('api.gateway.process')->addLog($aGateway['gateway_id'], Phpfox::endLog());
			
			return false;
		}
		
		Phpfox::log('Gateway successfully loaded.');
		
		$mReturn = $oGateway->callback();
		
		Phpfox::log('Callback complete');
		
		Phpfox::getService('api.gateway.process')->addLog($aGateway['gateway_id'], Phpfox::endLog());
		
		if ($mReturn == 'redirect')
		{
			Phpfox::getLib('url')->send('');
		}
	}
	
	public function getPeriodPhrase($sPeriod, $sRecurring, $sInitialFee, $sSymbol = '')
	{
		// recurring price = 0 then, no recurring!
		if(empty($sRecurring))
		{
			return null;
		}
		
		// $sRecurring = `recurring` 
		// $sInitialFee = `cost` = initial fee
		$aValues = array(
			'period' => $sPeriod,
			'recurring_fee' => $sRecurring,
			'cost' => $sInitialFee,
			'initial_fee' => $sInitialFee,
			'currency_symbol' => $sSymbol
		);
		switch ($sPeriod)
		{
			case '0': // no recurring
				if ($sInitialFee > 0)
				{
					$sPhrase = Phpfox::getPhrase('api.initial_fee_one_time', $aValues);
				}
				else
				{
					$sPhrase = Phpfox::getPhrase('subscribe.free');
				}				
				break;
			case '1': 
				// monthly				
				if ($sRecurring > 0 && $sInitialFee > 0)
				{
					$sPhrase = Phpfox::getPhrase('api.initial_fee_then_cost_per_month', $aValues);
				}
				else if ($sRecurring > 0 && $sInitialFee == 0)
				{
					$sPhrase = Phpfox::getPhrase('api.no_initial_then_cost_per_month', $aValues);
				}							
				break;
			case '2':
				// quarterly
				if ($sRecurring > 0 && $sInitialFee > 0)
				{
					$sPhrase = Phpfox::getPhrase('api.initial_fee_then_cost_per_quarter', $aValues);
				}
				else if ($sRecurring > 0 && $sInitialFee == 0)
				{
					$sPhrase = Phpfox::getPhrase('api.no_initial_then_cost_per_quarter', $aValues);
				}	
				//$sPhrase = ($sRecurring == $sInitialFee ? Phpfox::getPhrase('api.cost_per_quarter', array('cost' => $sRecurring)) : Phpfox::getPhrase('api.default_cost_and_then_cost_per_quarter', array('default_cost' => $sInitialFee, 'cost' => $sRecurring)));
				break;
			case '3':
				// biannually
				if ($sRecurring > 0 && $sInitialFee > 0)
				{
					$sPhrase = Phpfox::getPhrase('api.initial_fee_then_cost_biannually', $aValues);
				}
				else if ($sRecurring > 0 && $sInitialFee == 0)
				{
					$sPhrase = Phpfox::getPhrase('api.no_initial_then_cost_biannually', $aValues);
				}	
				//$sPhrase = ($sRecurring == $sInitialFee ? Phpfox::getPhrase('api.cost_biannualy', array('cost' => $sRecurring)) : Phpfox::getPhrase('api.default_cost_and_then_cost_biannualy', array('default_cost' => $sInitialFee, 'cost' => $sRecurring)));
				break;
			case '4':
				// yearly
				if ($sRecurring > 0 && $sInitialFee > 0)
				{
					$sPhrase = Phpfox::getPhrase('api.initial_fee_then_cost_yearly', $aValues);
				}
				else if ($sRecurring > 0 && $sInitialFee == 0)
				{
					$sPhrase = Phpfox::getPhrase('api.no_initial_then_cost_yearly', $aValues);
				}	
				
				//$sPhrase = ($sRecurring == $sInitialFee ? 						Phpfox::getPhrase('api.cost_annually', array('cost' => $sRecurring)) 						: Phpfox::getPhrase('api.initial_fee_recurring_fee_annually', array('initial_fee' => $sRecurring, 'recurring_fee' => $sInitialFee, 'currency_symbol' => $sSymbol)));
				break;				
		}
		
		return $sPhrase;
	}
	
	public function getForAdmin()
	{
		$aGateways = $this->database()->select('ag.*')
			->from($this->_sTable, 'ag')
			->order('ag.title ASC')
			->execute('getRows');	
			
		return $aGateways;		
	}	
	
	public function getForEdit($sGateway)
	{
		$aGateway = $this->database()->select('*')
			->from($this->_sTable)
			->where('gateway_id = \'' . $this->database()->escape($sGateway) . '\'')
			->execute('getSlaveRow');
			
		if (!isset($aGateway['gateway_id']))
		{
			return false;
		}
		
		$oGateway = Phpfox::getLib('gateway')->load($aGateway['gateway_id'], $aGateway);
		
		if ($oGateway === false)
		{
			return false;
		}
		
		$aGateway['custom'] = $oGateway->getEditForm();
			
		return $aGateway;
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
		if ($sPlugin = Phpfox_Plugin::get('api.service_gateway_gateway__call'))
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
