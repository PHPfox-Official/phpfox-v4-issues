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
 * @version 		$Id: list.class.php 5485 2013-03-11 09:44:15Z Miguel_Espinoza $
 */
class Subscribe_Component_Block_List extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::isUser())
		{
			$aGroup = Phpfox::getService('user.group')->getGroup(Phpfox::getUserBy('user_group_id'));
		}
		
		$this->template()->assign(array(
				'aPurchases' => (Phpfox::isUser() ? Phpfox::getService('subscribe.purchase')->get(Phpfox::getUserId(), 5) : array()),
				'aPackages' => Phpfox::getService('subscribe')->getPackages((Phpfox::isUser() ? false : true), (Phpfox::isUser() ? true: false)),
				'aGroup' => (Phpfox::isUser() ? $aGroup : array()),
				'bIsOnSignup' => ($this->getParam('on_signup') ? true : false)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('subscribe.component_block_list_clean')) ? eval($sPlugin) : false);
	}
}

?>