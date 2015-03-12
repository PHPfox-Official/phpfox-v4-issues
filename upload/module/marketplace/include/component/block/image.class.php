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
 * @version 		$Id: image.class.php 2595 2011-05-09 14:01:09Z Raymond_Benc $
 */
class Marketplace_Component_Block_Image extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!($aListing = $this->getParam('aListing')))
		{
			return false;
		}
		
		if (empty($aListing['image_path']))
		{
			// return false;
		}
		
		$this->template()->assign(array(
				'aImages' => Phpfox::getService('marketplace')->getImages($aListing['listing_id'])
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_image_clean')) ? eval($sPlugin) : false);
	}
}

?>