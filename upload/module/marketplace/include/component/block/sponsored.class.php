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
 * @version 		$Id: sponsored.class.php 1723 2010-08-16 08:18:35Z Raymond_Benc $
 */
class Marketplace_Component_Block_Sponsored extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::isModule('ad'))
		{
			return false;
		}		
		
		$aItems = Phpfox::getService('marketplace')->getSponsorListings();
		if (empty($aItems))
		{
		    return false;
		}
		
		foreach ($aItems as $aItem)
		{
		    Phpfox::getService('ad.process')->addSponsorViewsCount($aItem['sponsor_id'], 'marketplace');
		}
		
		$this->template()->assign(array(
			'sHeader' => Phpfox::getPhrase('marketplace.sponsored_listing'),
			'aFooter' => array(Phpfox::getPhrase('marketplace.encourage_sponsor') => $this->url()->makeUrl('marketplace', array('view' => 'my', 'sponsor' => 'help'))),
			'aSponsorListings' => $aItems
			)
		);

		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_photo_clean')) ? eval($sPlugin) : false);
	}
}

?>