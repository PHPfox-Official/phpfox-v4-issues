<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: remove.class.php 3827 2011-12-16 12:47:44Z Miguel_Espinoza $
 */
class User_Component_Controller_Remove extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		if (!Phpfox::getUserParam('user.can_delete_own_account'))
		{
			Phpfox::getLib('url')->send('');
		}
		if (Phpfox::isModule('friend'))
		{
			list($iCnt, $aShowFriends) = Phpfox::getService('friend')->get('friend.is_page = 0 AND friend.user_id = ' . Phpfox::getUserId() . ' AND ' . Phpfox::getLib('database')->isNotNull('user_image'), 'RAND()', 0, 3);
		
			$this->template()->assign(array(
				'aFriends' => $aShowFriends,
				'aReasons' => Phpfox::getService('user')->getReasons()
				)
			);
		} // is not confirming
		if ($this->request()->get('req3') == 'confirm')
		{			
			if (($aVals = $this->request()->getArray('val')))
			{				
				// user inputted password, no turning back now...
				if (Phpfox::getService('user.cancellations.process')->cancelAccount($aVals))
				{
					// redirect is in the cancelAccoutn because of the logout
				}
				else
				{
					// an error occured (??)					
				}
			}
		}
		$this->template()->setTitle(Phpfox::getPhrase('user.cancel_account'))
			->setBreadcrumb(Phpfox::getPhrase('user.cancel_account'));
		
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_register_clean')) ? eval($sPlugin) : false);
	}
}

?>