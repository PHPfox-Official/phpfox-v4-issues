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
 * @version 		$Id: entry.class.php 625 2009-06-01 20:22:15Z Raymond_Benc $
 */
class Favorite_Component_Block_Entry extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
				'sHeader' => $this->getParam('favorite_title'),
				'bPassOverAjaxCall' => true
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
		(($sPlugin = Phpfox_Plugin::get('favorite.component_block_entry_clean')) ? eval($sPlugin) : false);
	}
}

?>