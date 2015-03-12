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
 * @version 		$Id: sponsored.class.php 6935 2013-11-22 15:49:21Z Fern $
 */
class Ad_Component_Block_Sponsored extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('ad.sponsored'),
			)
		);
		
		if(Phpfox::getUserParam('ad.can_create_ad_campaigns'))
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('ad.create_an_ad') => $this->url()->makeUrl('ad.add')
					)
				)
			);
		}
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_block_sponsored_clean')) ? eval($sPlugin) : false);
	}
}

?>
