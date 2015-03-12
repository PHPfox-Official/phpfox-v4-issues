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
 * @version 		$Id: index-visitor-mobile.class.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
class Core_Component_Controller_Index_Visitor_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		define('PHPFOX_DONT_SAVE_PAGE', true);
		
		if (Phpfox::isUser())
		{
			$this->url()->send('profile');
		}
		
		switch (Phpfox::getParam('user.login_type'))
		{
			case 'user_name':
				$aValidation['login'] = Phpfox::getPhrase('user.provide_your_user_name');
				break;
			case 'email':
				$aValidation['login'] = Phpfox::getPhrase('user.provide_your_email');
				break;				
			default:
				$aValidation['login'] = Phpfox::getPhrase('user.provide_your_user_name_email');
		}
		$aValidation['password'] = Phpfox::getPhrase('user.provide_your_password');		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_login_form', 'aParams' => $aValidation));
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($oValid->isValid($aVals))
			{
				list($bLogged, $aUser) = (Phpfox::getService('user.auth')->login($aVals['login'], $aVals['password'], (isset($aVals['remember_me']) ? true : false), Phpfox::getParam('user.login_type')));
				if ($bLogged)
				{
					$this->url()->send('');
				}
			}
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_index_visitor_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>