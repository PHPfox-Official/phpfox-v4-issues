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
 * @version 		$Id: supported.class.php 4252 2012-06-12 13:13:36Z Miguel_Espinoza $
 */
class Video_Component_Block_Supported extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aSupportedSites = Phpfox::getService('video.grab')->getSites(true);
		
		(($sPlugin = Phpfox_Plugin::get('video.component_block_supported_1')) ? eval($sPlugin) : false);
		
		$this->template()->assign(array(
				'aSites' => $aSupportedSites
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_block_supported_clean')) ? eval($sPlugin) : false);
	}
}

?>