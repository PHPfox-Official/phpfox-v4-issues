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
 * @package  		Module_Core
 * @version 		$Id: new.class.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
class Core_Component_Block_New extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{			
		list($aMenus, $sModuleBlock) = Phpfox::getService('core')->getNewMenu();
		
		if (!count($aMenus))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('core.what_s_new'),				
				'aMenu' => $aMenus,
				'sModuleBlock' => $sModuleBlock				
			)
		);
		
		if (Phpfox::isUser())
		{
			$this->template()->assign('sDeleteBlock', 'dashboard');
			$this->template()->assign(array(
					'aEditBar' => array(
						'ajax_call' => 'core.getEditBarNew'						
					),
					'bPassOverAjaxCall' => true
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
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>