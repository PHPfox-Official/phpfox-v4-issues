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
 * @version 		$Id: register-top.class.php 2817 2011-08-08 16:59:43Z Raymond_Benc $
 */
class User_Component_Block_Register_Top extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$bPass = false;
		if (!Phpfox::isUser() && (Phpfox_Module::instance()->getFullControllerName() != 'user.register' && Phpfox_Module::instance()->getFullControllerName() != 'core.index-visitor'))
		{
			$bPass = true;
		}
		
		if ($bPass === false)
		{
			return false;
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_register_top_clean')) ? eval($sPlugin) : false);
	}
}

?>