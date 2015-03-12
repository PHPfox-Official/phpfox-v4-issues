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
 * @version 		$Id: price.class.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
class Marketplace_Component_Block_Price extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aListing = $this->getParam('aListing');		
		
		$sExchangeRate = '';
		if ($aListing['currency_id'] != Phpfox::getService('core.currency')->getDefault())
		{
			if (($sAmount = Phpfox::getService('core.currency')->getXrate($aListing['currency_id'], $aListing['price'])))
			{
				$sExchangeRate .= ' (' . Phpfox::getService('core.currency')->getCurrency($sAmount) . ')';
			}
		}
		
		$this->template()->assign(array(
				'sListingPrice' => ($aListing['price'] == '0.00' ? Phpfox::getPhrase('marketplace.free') : Phpfox::getService('core.currency')->getCurrency(number_format($aListing['price'], 2), $aListing['currency_id'])) . $sExchangeRate . ($aListing['view_id'] == '2' ? ' (' . Phpfox::getPhrase('marketplace.sold') . ')' : '')
			)
		);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_price_clean')) ? eval($sPlugin) : false);
	}
}

?>