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
 * @package  		Module_User
 * @version 		$Id: register.class.php 3382 2011-10-31 11:53:10Z Raymond_Benc $
 */
class User_Component_Block_Register extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::getParam('user.allow_user_registration'))
		{
			//return false;
		}
		
		if (Phpfox::isUser())
		{
			return false;
		}
		
		$this->template()->assign(array(
				// 'sHeader' => 'Sign Up<div class="extra_info">Start connecting with your friends today.</div>',
				'sSiteUrl' => Phpfox::getParam('core.path'),
				'aTimeZones' => Phpfox::getService('core')->getTimeZones(),
				'aPackages' => (Phpfox::isModule('subscribe') ? Phpfox::getService('subscribe')->getPackages(true) : null),
				'sDobStart' => Phpfox::getParam('user.date_of_birth_start'),
				'sDobEnd' => Phpfox::getParam('user.date_of_birth_end'),
				'sSiteTitle' => Phpfox::getParam('core.site_title')
			)
		);
		
		// return 'block';
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