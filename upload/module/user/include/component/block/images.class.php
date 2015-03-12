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
 * @version 		$Id: images.class.php 5531 2013-03-21 13:57:33Z Raymond_Benc $
 */
class User_Component_Block_Images extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aUserImages = Phpfox::getService('user')->getUserImages();
		
		if (!is_array($aUserImages) || (is_array($aUserImages) && !count($aUserImages)))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aUserImages' => $aUserImages
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_images_clean')) ? eval($sPlugin) : false);
	}
}

?>