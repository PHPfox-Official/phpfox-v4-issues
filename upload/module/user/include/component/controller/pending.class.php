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
 * @version 		$Id: pending.class.php 1581 2010-05-07 10:16:40Z Miguel_Espinoza $
 */
class User_Component_Controller_Pending extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		
		$this->template()->assign(array('iStatus' => Phpfox::getUserBy('status_id')));
		if (Phpfox::isUser())
		{
			$this->url()->send($this->url()->makeUrl(''));
		}
		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_pending_clean')) ? eval($sPlugin) : false);
	}
}

?>