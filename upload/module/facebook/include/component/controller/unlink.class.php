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
 * @version 		$Id: unlink.class.php 4854 2012-10-09 05:20:40Z Raymond_Benc $
 */
class Facebook_Component_Controller_Unlink extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (!Phpfox::getUserBy('fb_user_id') && !$this->request()->get('completed'))
		{
			$this->url()->send('');
		}
		
		$sEmail = Phpfox::getUserBy('email');
		
		if (($aVals = $this->request()->getArray('val')) && Phpfox::getService('facebook.process')->updateUserPassword($aVals))
		{
			Phpfox::getService('user.auth')->logout();
			
			list($bLogged, $aUser) = Phpfox::getService('user.auth')->login($sEmail, $aVals['password'], false, 'email');
			
			$this->url()->send('facebook.unlink', array('completed' => '1'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('facebook.unlink_facebook_connect'))
			->setBreadcrumb(Phpfox::getPhrase('facebook.unlink_facebook_connect'))
			->assign(array(
					'sCurrentEmail' => $sEmail,
					'bPass' => ($this->request()->get('completed') ? true : false),
					'bNoApp' => ($this->request()->get('noapp') ? true : false)
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('facebook.component_controller_unlink_clean')) ? eval($sPlugin) : false);
	}
}

?>