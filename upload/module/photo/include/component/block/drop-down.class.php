<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Drop-down block for photo categories.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: drop-down.class.php 423 2009-04-20 19:57:37Z Raymond_Benc $
 */
class Photo_Component_Block_Drop_Down extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(		
				'sCategories' => Phpfox::getService('photo.category')->get(false, true),
				'bMultiple' => $this->getParam('multiple', true)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_drop_down_clean')) ? eval($sPlugin) : false);
	}
}

?>