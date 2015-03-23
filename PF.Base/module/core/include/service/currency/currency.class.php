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
 * @version 		$Id: currency.class.php 6621 2013-09-11 12:45:56Z Miguel_Espinoza $
 */
class Core_Service_Currency_Currency extends Phpfox_Service 
{
	/**
	 * ARRAY of all the currencies
	 *
	 * @var array
	 */
	private $_aCurrencies = array();
	
	private $_sDefault = null;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('currency');
		
		if ($sPlugin = Phpfox_Plugin::get('core.service_currency_contruct__1')){eval($sPlugin); if (isset($mReturnFromPlugin)){ return $mReturnFromPlugin; }}
		
		$sCacheId = $this->cache()->set('currency');
		if (!($this->_aCurrencies = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from(Phpfox::getT('currency'))
				->where('is_active = 1')
				->order('ordering ASC')
				->execute('getRows');
				
			foreach ($aRows as $aRow)
			{
				$this->_aCurrencies[$aRow['currency_id']] = array(
					'symbol' => $aRow['symbol'],
					'name' => $aRow['phrase_var'],
					'is_default' => $aRow['is_default']
				);
			}
			
			$this->cache()->save($sCacheId, $this->_aCurrencies);
		}
		
		if ($sPlugin = Phpfox_Plugin::get('core.service_currency__construct'))
		{
			eval($sPlugin);
		}		
	}
	
	public function getSymbol($sCurrency)
	{
		return (isset($this->_aCurrencies[$sCurrency]['symbol']) ? $this->_aCurrencies[$sCurrency]['symbol'] : '');
	}
	
	public function getDefault()
	{
		static $sUserDefault = null;
		
		if ($this->_sDefault === null)
		{
			foreach ($this->_aCurrencies as $sKey => $aCurrency)
			{
				if ($aCurrency['is_default'] == '1')
				{
					$this->_sDefault = $sKey;
					break;
				}
			}
		}
		
		if ($sUserDefault === null && Phpfox::isUser())
		{
			$sCurrency = Phpfox::getService('user')->getCurrency();
			if (!empty($sCurrency))
			{
				$this->_sDefault = $sCurrency;	
			}			
		}
		
		return $this->_sDefault;
	}
	
	public function getForEdit($sId)
	{
		if ($sPlugin = Phpfox_Plugin::get('core.service_currency_getforedit__1')){eval($sPlugin); if (isset($mReturnFromPlugin)){ return $mReturnFromPlugin; }}
		$aCurrency = $this->database()->select('*')
			->from($this->_sTable)
			->where('currency_id = \'' . $this->database()->escape($sId) . '\'')
			->execute('getSlaveRow');
			
		return (isset($aCurrency['currency_id']) ? $aCurrency : false);
	}
	
	public function get()
	{
		return $this->_aCurrencies;
	}
	
	public function getForBrowse()
	{
		if ($sPlugin = Phpfox_Plugin::get('core.service_currency_getforbrowse__1')){eval($sPlugin); if (isset($mReturnFromPlugin)){ return $mReturnFromPlugin; }}
		$aCurrencies = $this->database()->select('*')	
			->from(Phpfox::getT('currency'))
			->order('ordering ASC')
			->execute('getSlaveRows');
			
		return $aCurrencies;
	}
	
	public function getCurrency($sPrice, $sCurrency = null)
	{		
		$sPriceWithCurrency = $this->getSymbol(($sCurrency ? $sCurrency : $this->getDefault())) . $sPrice . ' ' . ($sCurrency ? $sCurrency : $this->getDefault());	
		
		(($sPlugin = Phpfox_Plugin::get('core.service_currency_getcurrency')) ? eval($sPlugin) : false);
		
		return $sPriceWithCurrency;
	}
	
	public function getXrate($sCurrency, $iPrice)
	{
		$sKey = Phpfox::getParam('core.exchange_rate_api_key');
		
		if (empty($sKey))
		{
			return false;
		}
		
		$sAmount = file_get_contents('http://www.exchangerate-api.com/' . $sCurrency . '/' . $this->getDefault() . '/' . $iPrice . '?k='.$sKey);
		
		return ($sAmount > 0 ? $sAmount : false);
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
		if ($sPlugin = Phpfox_Plugin::get('core.service_currency__call'))
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