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
 * @version 		$Id: promotion.class.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
class User_Component_Controller_Promotion extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		$aUserGroup = Phpfox::getService('user.group')->getGroup(Phpfox::getUserBy('user_group_id'));
		$this->template()->setTitle(Phpfox::getPhrase('user.promotions'))
			->setBreadcrumb(Phpfox::getPhrase('user.promotions'))
			->assign(array(
				'aUserGroup' => $aUserGroup
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_promotion_clean')) ? eval($sPlugin) : false);
	}
}

?>