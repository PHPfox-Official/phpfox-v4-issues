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
 * @version 		$Id: purchase.class.php 6750 2013-10-08 13:58:53Z Miguel_Espinoza $
 */
class Subscribe_Service_Purchase_Purchase extends Phpfox_Service 
{
	private static $_iRedirectId = null;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('subscribe_purchase');	
	}
	
	public function setRedirectId($iRedirectId)
	{
		self::$_iRedirectId = $iRedirectId;
	}
	
	public function getRedirectId()
	{
		return self::$_iRedirectId;
	}
	
	public function getSearch($aConditions, $sSort = null, $iPage = null, $iPageSize)
	{
		$aPurchases = array();
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'sp')
			->where($aConditions)
			->execute('getSlaveField');
		
		if ($iCnt)
		{
			$aPurchases = $this->database()->select('sp.*, spack.*, ' . Phpfox::getUserField())
				->from($this->_sTable, 'sp')
				->join(Phpfox::getT('subscribe_package'), 'spack', 'spack.package_id = sp.package_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = sp.user_id')
				->where($aConditions)
				->limit($iPage, $iPageSize, $iCnt)			
				->order($sSort)
				->execute('getSlaveRows');		
				
			$this->_build($aPurchases);						
		}
		
		return array($iCnt, $aPurchases);
	}
	
	public function get($iUserId, $iLimit = null)
	{
		$aPurchases = $this->database()->select('sp.*, spack.*')
			->from($this->_sTable, 'sp')
			->join(Phpfox::getT('subscribe_package'), 'spack', 'spack.package_id = sp.package_id')
			->where('sp.user_id = ' . $iUserId)
			->limit($iLimit)
			->order('sp.time_stamp DESC')
			->execute('getRows');		
			
		$this->_build($aPurchases);
		
		return $aPurchases;
	}
	
	public function getPurchase($iId)
	{
		$aPurchase = $this->database()->select('sp.*, spack.user_group_id, spack.fail_user_group')
			->from($this->_sTable, 'sp')
			->join(Phpfox::getT('subscribe_package'), 'spack', 'spack.package_id = sp.package_id')
			->where('sp.purchase_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aPurchase['purchase_id']))
		{
			return false;
		}
			
		return $aPurchase;
	}	
	
	public function getInvoice($iId, $bIsOrder = false, $sCacheUserId = null)
	{
		$aPurchase = $this->database()->select('sp.*, spack.*')
			->from($this->_sTable, 'sp')
			->join(Phpfox::getT('subscribe_package'), 'spack', 'spack.package_id = sp.package_id')
			->where('sp.purchase_id = ' . (int) $iId . ' AND sp.user_id = ' . ($sCacheUserId === null ? Phpfox::getUserId() : $sCacheUserId))
			->execute('getRow');
			
		if (!isset($aPurchase['purchase_id']))
		{
			return false;
		}
		
		if (!empty($aPurchase['cost']) && Phpfox::getLib('parse.format')->isSerialized($aPurchase['cost']))
		{
			$aCosts = unserialize($aPurchase['cost']);	
			foreach ($aCosts as $sKey => $iCost)
			{
				if (Phpfox::getService('core.currency')->getDefault() == $sKey)
				{
					$aPurchase['default_cost'] = $iCost;
					$aPurchase['default_currency_id'] = $sKey;
				}
			}
		}		
		
		if ($aPurchase['recurring_period'] > 0 && Phpfox::getLib('parse.format')->isSerialized($aPurchase['recurring_cost']))
		{
			$aRecurringCosts = unserialize($aPurchase['recurring_cost']);	
			foreach ($aRecurringCosts as $sKey => $iCost)
			{
				if (Phpfox::getService('core.currency')->getDefault() == $sKey)
				{
					$aPurchase['default_recurring_cost'] = ($bIsOrder ? $iCost : Phpfox::getService('api.gateway')->getPeriodPhrase($aPurchase['recurring_period'], $iCost, $aPurchase['default_cost']));
					$aPurchase['default_recurring_currency_id'] = $sKey;
				}
			}					
		}		
			
		return $aPurchase;		
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
		if ($sPlugin = Phpfox_Plugin::get('subscribe.service_purchase_purchase__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function &_build(&$aPurchases)
	{
		foreach ($aPurchases as $iKey => $aPurchase)
		{			
			if (!empty($aPurchase['cost']) && Phpfox::getLib('parse.format')->isSerialized($aPurchase['cost']))
			{
				$aCosts = unserialize($aPurchase['cost']);	
				foreach ($aCosts as $sKey => $iCost)
				{
					if (Phpfox::getService('core.currency')->getDefault() == $sKey)
					{
						$aPurchases[$iKey]['default_cost'] = $iCost;
						$aPurchases[$iKey]['default_currency_id'] = $sKey;
					}
				}
			}		
			
			if ($aPurchase['recurring_period'] > 0 && Phpfox::getLib('parse.format')->isSerialized($aPurchase['recurring_cost']))
			{
				$aRecurringCosts = unserialize($aPurchase['recurring_cost']);	
				foreach ($aRecurringCosts as $sKey => $iCost)
				{
					if (Phpfox::getService('core.currency')->getDefault() == $sKey)
					{
						$aPurchases[$iKey]['default_recurring_cost'] = Phpfox::getService('api.gateway')->getPeriodPhrase($aPurchase['recurring_period'], $iCost, $aPurchases[$iKey]['default_cost']);
						$aPurchases[$iKey]['default_recurring_currency_id'] = $sKey;
					}
				}					
			}		
		}		
		
		return $aPurchases;
	}
	
	/* This function tells when will a purchased subscription expire */
	public function getExpireTime($iPurchaseId)
	{
		$aPurchase = $this->database()->select('sp.time_stamp as time_of_purchase, sk.recurring_period')
			->from(Phpfox::getT('subscribe_purchase'), 'sp')
			->join(Phpfox::getT('subscribe_package'), 'sk', 'sk.package_id = sp.package_id')
			->where('sp.purchase_id = ' . (int)$iPurchaseId . ' AND sp.status = "completed"')
			->order('sp.purchase_id DESC')
			->execute('getSlaveRow');
			
		if (empty($aPurchase))
		{
			return false;
		}
		
		// recurring period 1 : 1 month  2= 3 months. 3: 6 months 4: 12 months
		$oneMonth = 60 * 60 * 24 * 30;
		switch ($aPurchase['recurring_period'])
		{
			case 1:
				return $aPurchase['time_stamp'] + $oneMonth;
			case 2:
				return $aPurchase['time_stamp'] + (3 * $oneMonth);
			case 3: 
				return $aPurchase['time_stamp'] + (6 * $oneMonth);
			case 4:
				return $aPurchase['time_stamp'] + (12 * $oneMonth);
		}
		
		return false;
	}
}

?>