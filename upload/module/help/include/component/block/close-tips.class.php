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
 * @package  		Module_Help
 * @version 		$Id: close-tips.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Help_Component_Block_Close_Tips extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
			'sTip' => $this->getParam('tip')
		));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('help.component_block_close_tips_clean')) ? eval($sPlugin) : false);
	}
}

?>