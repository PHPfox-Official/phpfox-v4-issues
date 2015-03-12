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
 * @version 		$Id: display.class.php 2689 2011-06-23 12:10:46Z Raymond_Benc $
 */
class Input_Component_Block_Display extends Phpfox_Component
{
	private $_sTemplate = null;
	
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aInputs = Phpfox::getService('input')->getToDisplay($this->getParam('module'), $this->getParam('action'), $this->getParam('item_id'));
			
		
		$this->template()->assign(array(
				'aInputs' => $aInputs
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{		
		$this->template()->clean(array(
				'aCustomMain'
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('custom.component_block_display_clean')) ? eval($sPlugin) : false);
	}
}

?>