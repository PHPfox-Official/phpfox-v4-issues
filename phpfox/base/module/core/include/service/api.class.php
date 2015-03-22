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
 * @package 		Phpfox_Service
 * @version 		$Id: api.class.php 5112 2013-01-11 06:56:25Z Raymond_Benc $
 */
class Core_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_oApi = Phpfox::getService('api');
	}
	
	public function getCountries()
	{	
		/*
		@title 
		@info Get the full list of countries.
		@method GET
		@extra
		@return name=#{Country name|string}&=country_iso=#{Country ID|string}&=children=#{List of states/provinces|array}
		*/		
		return Phpfox::getService('core.country')->getCountriesAndChildren();
	}
	
	public function getCurrencies()
	{
		/*
		@title 
		@info Get the full list of currencies.
		@method GET		
		@extra
		@return id=#{Currency ID|string}&symbol=#{Currency symbol|string}&name=#{Currency name|string}
		*/		
		$aCurrencies = Phpfox::getService('core.currency')->get();
		foreach ($aCurrencies as $iKey => $aCurrency)
		{
			unset($aCurrencies[$iKey]['is_default']);
			$aCurrencies[$iKey]['id'] = $iKey;
			$aCurrencies[$iKey]['name'] = Phpfox::getPhrase($aCurrency['name']);
		}
		
		return $aCurrencies;
	}
}

?>