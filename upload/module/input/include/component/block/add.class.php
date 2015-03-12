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
 * @version 		$Id: block.class.php 3325 2011-10-20 08:33:09Z Miguel_Espinoza $
 */
class Input_Component_Block_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 * This block is used to enter information in an Input
	 */
	public function process()
	{
		$aInputs = Phpfox::getService('input')->get(array(
			'action' => $this->getParam('action'), 
			'module' => $this->getParam('module')
		), ($this->getParam('bAjaxSearch') != true));
		
		
		if (!empty($aInputs))
		{
			foreach ($aInputs as $iKey => $aInput)
			{
				$aInputs[$iKey]['template_id'] = 'input_' . $aInput['field_id'];
			}
		}
		
		
		$this->template()->assign(array(
			'aInputs' => $aInputs,
			'sModule' => $this->getParam('module'),
			'bAjaxSearch' => $this->getParam('bAjaxSearch') == true
		));		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('custom.component_block_block_clean')) ? eval($sPlugin) : false);
	}
}

?>