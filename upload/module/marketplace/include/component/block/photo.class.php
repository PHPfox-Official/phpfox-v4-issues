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
 * @version 		$Id: photo.class.php 416 2009-04-19 18:25:22Z Raymond_Benc $
 */
class Marketplace_Component_Block_Photo extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aListing = $this->getParam('aListing');
		
		if (!($aImages = Phpfox::getService('marketplace')->getImages($aListing['listing_id'])))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aImages' => $aImages
			)
		);
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