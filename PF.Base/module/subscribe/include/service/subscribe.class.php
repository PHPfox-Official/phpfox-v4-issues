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
 * @version 		$Id: subscribe.class.php 6889 2013-11-14 09:35:03Z Miguel_Espinoza $
 */
class Subscribe_Service_Subscribe extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('subscribe_package');	
	}
	
	public function getPackages($bIsForSignUp = false, $bShowAllSubscriptions = false)
	{		
		$aPackages = $this->database()->select('sp.*')
			->from($this->_sTable, 'sp')
			->where('sp.is_active = 1' . ($bIsForSignUp ? ' AND sp.is_registration = 1' : ''))
			->order('sp.ordering ASC')
			->execute('getRows');			
		
		foreach ($aPackages as $iKey => $aPackage)
		{			
			if (Phpfox::getUserBy('user_group_id') == $aPackage['user_group_id'] && $bShowAllSubscriptions == false)
			{				
				unset($aPackages[$iKey]);
				
				continue;
			}
			
			if (!empty($aPackage['cost']) && Phpfox::getLib('parse.format')->isSerialized($aPackage['cost']))
			{
				$aCosts = unserialize($aPackage['cost']);

				foreach ($aCosts as $sKey => $iCost)
				{
					if (Phpfox::getService('core.currency')->getDefault() == $sKey)
					{
						$aPackages[$iKey]['default_cost'] = $iCost;
						$aPackages[$iKey]['default_currency_id'] = $sKey;
						$aPackages[$iKey]['currency_symbol'] = Phpfox::getService('core.currency')->getSymbol($sKey);
					}
					else
					{
						if ((int) $iCost === 0)
						{
							continue;
						}
						
					    $aPackages[$iKey]['price'][$sKey]['cost'] = $iCost;
					    $aPackages[$iKey]['price'][$sKey]['currency_id'] = $sKey;
						$aPackages[$iKey]['price'][$sKey]['currency_symbol'] = Phpfox::getService('core.currency')->getSymbol($sKey);
					}
				}
				$aPackage = $aPackages[$iKey];
				if ($aPackage['recurring_period'] > 0 && Phpfox::getLib('parse.format')->isSerialized($aPackage['recurring_cost']))
				{
					$aRecurringCosts = unserialize($aPackage['recurring_cost']);	
					foreach ($aRecurringCosts as $sKey => $iCost)
					{
						if (Phpfox::getService('core.currency')->getDefault() == $sKey)
						{
							$aPackages[$iKey]['default_recurring_cost'] = Phpfox::getService('api.gateway')->getPeriodPhrase($aPackage['recurring_period'], $iCost, $aPackages[$iKey]['default_cost'], $aPackage['currency_symbol']);
							$aPackages[$iKey]['default_recurring_currency_id'] = $sKey;
						}
					}					
				}
			}
		}		

		return $aPackages;
	}
	
	public function getPackagesForCompare($bIsAdminCP = false)
	{		
		$aPackages = $this->getPackages(false, true);
		$aCompare = $this->database()->select('*')->from(Phpfox::getT('subscribe_compare'))->execute('getSlaveRows');
		
		$aForCompare = array('packages' => array(), 'features' => array());
		
		// We store here the packages that have at least one feature assigned, others will be removed
		$aUsedPackages = array();
		// figure out the cost, recurring cost and symbol based on my currency
		foreach ($aPackages as $iKey => $aPackage)
		{
			$aPackage['aCosts'] = unserialize($aPackage['cost']);
			
			// Assign the initial fee
			foreach ($aPackage['aCosts'] as $sCurrency => $iAmount)
			{
				if ($sCurrency == Phpfox::getService('core.currency')->getDefault())
				{
					$aPackages[$iKey]['initial_fee'] = $iAmount;
					break;
				}
			}
			
			// Assign the recurring fee
			if (empty($aPackage['recurring_cost']) || !Phpfox::getLib('parse.format')->isSerialized($aPackage['recurring_cost']) || $aPackage['recurring_period'] == 0)
			{
				$aPackages[$iKey]['recurring_fee'] = (int)$aPackage['recurring_cost'];
			}
			else
			{
				$aPackage['aRecurring'] = unserialize($aPackage['recurring_cost']);
				foreach ($aPackage['aRecurring'] as $sCurrency => $iAmount)
				{
					if ($sCurrency == Phpfox::getService('core.currency')->getDefault())
					{
						$aPackages[$iKey]['recurring_fee'] = $iAmount;
						break;
					}
				}
			}			
		}
		
		// Shape the final array
		foreach ($aCompare as $aRow)
		{
			$aRow['feature_value'] = json_decode($aRow['feature_value'], true);
			$aForCompare['features'][$aRow['feature_title']] = array();
			foreach ($aPackages as $aPackage)
			{				
				foreach ($aRow['feature_value'] as $iKey => $aFeatureValue)
				{
					if ($aFeatureValue['package_id'] == $aPackage['package_id'])
					{
						if ($bIsAdminCP)
						{
							$aForCompare['features'][$aRow['feature_title']][$aPackage['package_id']] = $aFeatureValue['value'];
						}
						else
						{
							$aForCompare['features'][$aRow['feature_title']][$aPackage['package_id']] = array('feature_value' => $aFeatureValue['value'], 'background_color' => $aPackage['background_color']);
						}
						
						$aUsedPackages[$aPackage['package_id']] = 1;
					}
					
				}
				
			}
		}
		
		
		foreach ($aPackages as $aPackage)
		{			
			if (!isset($aPackage['default_recurring_cost']) && 
				(!isset($aPackage['recurring_period']) || !isset($aPackage['recurring_fee']) || !isset($aPackage['initial_fee']) || !isset($aPackage['currency_symbol'])))			
			{
				continue;	
			}
			$aForCompare['packages'][$aPackage['package_id']] = array(
					'title' => $aPackage['title'],
					'package_id' => $aPackage['package_id'],
					'description' => $aPackage['description'],
					'background_color' => $aPackage['background_color'],
					'price_phrase' => isset($aPackage['default_recurring_cost']) ? 
								$aPackage['default_recurring_cost'] 
								: Phpfox::getService('api.gateway')->getPeriodPhrase($aPackage['recurring_period'], $aPackage['recurring_fee'], $aPackage['initial_fee'], $aPackage['currency_symbol'])
					);			
		}
		
		if ($bIsAdminCP == false)
		{
			// Remove unused packages
			foreach ($aForCompare['packages'] as $iPackageId => $sTitle)
			{
				if (!isset($aUsedPackages[$iPackageId]))
				{
					unset($aForCompare['packages'][$iPackageId]);
				}
			}
			// Add empty cells
			foreach ($aForCompare['features'] as $iFeatureId => $aFeature)
			{
				foreach ($aForCompare['packages'] as $iPackageId => $aPackage)
				{
					if (!isset($aForCompare['features'][$iFeatureId][$iPackageId]))
					{
						if ($bIsAdminCP)
						{
							$aForCompare['features'][$iFeatureId][$iPackageId] = '';
						}
						else
						{
							$aForCompare['features'][$iFeatureId][$iPackageId] = array('feature_value' => '', 'background_color' => $aPackage['background_color']);
						}
						
					}
				}
			}
		}
		
		/*
		foreach ($aForCompare['features'] as $iKey => $aFeature)
		{
			ksort($aForCompare['features'][$iKey]);
		}
		*/	
		
		return $aForCompare;
		
	}
	
	
	public function getPackage($iPackageId, $bIsAdminEdit = false)
	{
		$aPackage = $this->database()->select('sp.*')
			->from($this->_sTable, 'sp')
			->where('sp.package_id = ' . (int) $iPackageId . ' ' . ($bIsAdminEdit ? '' : 'AND sp.is_active = 1'))
			->order('sp.ordering ASC')
			->execute('getRow');	
			
		if (!isset($aPackage['package_id']))
		{
			return false;
		}
		
		if (!empty($aPackage['cost']) && Phpfox::getLib('parse.format')->isSerialized($aPackage['cost']))
		{
			$aCosts = unserialize($aPackage['cost']);	
			foreach ($aCosts as $sKey => $iCost)
			{
				if (Phpfox::getService('core.currency')->getDefault() == $sKey)
				{
					$aPackage['default_cost'] = $iCost;
					$aPackage['default_currency_id'] = $sKey;
				}
				else
				{
				    $aPackage['price'][]= array($sKey => $iCost); //'alternative_cost' => $iCost, 'alternative_currency_id' => $sKey);
				}
			}
		}		
		
		if ($aPackage['recurring_period'] > 0 && Phpfox::getLib('parse.format')->isSerialized($aPackage['recurring_cost']))
		{
			$aRecurringCosts = unserialize($aPackage['recurring_cost']);	
			foreach ($aRecurringCosts as $sKey => $iCost)
			{
				if (Phpfox::getService('core.currency')->getDefault() == $sKey)
				{
					$aPackage['default_recurring_cost'] = $iCost;
					$aPackage['default_recurring_currency_id'] = $sKey;
				}
				else
				{
				    $aPackage['recurring_price'][]= array($sKey => $iCost);
				}
			}					
		}
		
		if ($aPackage['recurring_period'] > 0)
		{
			$aPackage['is_recurring'] = '1';
		}
			
		return $aPackage;
	}	
	
	public function getForEdit($iPackageId)
	{
		return $this->getPackage($iPackageId, true);
	}
	
	public function getForAdmin()
	{
		$aPackages = $this->database()->select('sp.*')
			->from($this->_sTable, 'sp')
			->order('sp.ordering ASC')
			->execute('getRows');	
			
		return $aPackages;		
	}
		
		
	public function getCompareArray()
	{
		$aRows = $this->database()->select('*')->from(Phpfox::getT('subscribe_compare'))->execute('getSlaveRows');
		$aCompare = array();
		foreach ($aRows as $aRow)
		{
			$aCompare[] = array(
				'feature_title' => $aRow['feature_title'],//preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',array(), false, null, '" . Phpfox::getUserBy('language_id') . "') . ''", $aRow['feature_title']),
				'feature_value' => json_decode($aRow['feature_value'], true)
			);			
		}
		return $aCompare;
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
		if ($sPlugin = Phpfox_Plugin::get('subscribe.service_subscribe__call'))
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
