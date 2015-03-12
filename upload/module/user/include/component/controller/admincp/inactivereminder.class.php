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
 * @version 		$Id: index.class.php 1068 2009-09-24 09:27:36Z Miguel_Espinoza $
 */
class User_Component_Controller_Admincp_Inactivereminder extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->setHeader(array(
			'inactivereminder.js' => 'module_user',
			'inactivereminder.css' => 'module_user'
		))
			->setPhrase(array(
				'core.stopped',
				'user.enter_a_number_of_days',
				'user.enter_a_number_to_size_each_batch',
				'user.not_enough_users_to_mail'
			))
			->setBreadCrumb(Phpfox::getPhrase('admincp.inactive_member_reminder'));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>