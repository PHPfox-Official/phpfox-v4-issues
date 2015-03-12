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
 * @version 		$Id: login-ajax.class.php 3621 2011-11-30 12:30:44Z Raymond_Benc $
 */
class User_Component_Block_Login_Ajax extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aCheckArray = $this->request()->getArray('phpfox');
		$this->template()->assign(array(
				'sSiteName' => Phpfox::getParam('core.site_title'),
				'sSignUpPage' => $this->url()->makeUrl('user.register'),
				'bIsAJaxAdminCp' => ((PHPFOX_IS_AJAX && isset($aCheckArray['is_admincp'])) ? true : false),
				'sJanrainUrl' => (Phpfox::isModule('janrain') ? Phpfox::getService('janrain')->getUrl() : '')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_login_ajax_clean')) ? eval($sPlugin) : false);
	}
}

?>