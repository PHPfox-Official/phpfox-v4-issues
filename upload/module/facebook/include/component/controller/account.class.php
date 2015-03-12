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
 * @version 		$Id: account.class.php 2100 2010-11-09 14:58:35Z Raymond_Benc $
 */
class Facebook_Component_Controller_Account extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (($sProcess = $this->request()->get('process')))
		{
			switch ($sProcess)
			{
				case 'email':
					header('Location: https://graph.facebook.com/oauth/authorize?client_id=' . Phpfox::getParam('facebook.facebook_app_id') . '&redirect_uri=' . Phpfox::getParam('core.path') . 'index.php?facebook-process-login=sync-email');	
					exit;
					break;
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('facebook.facebook_connect_account_issues'))
			->setBreadcrumb(Phpfox::getPhrase('facebook.facebook_connect_account_issues'))
			->setFullSite()
			->assign(array(
					'sErrorType' => $this->request()->get('type'),
					'sFacebookAppId' => Phpfox::getParam('facebook.facebook_app_id')
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('facebook.component_controller_account_clean')) ? eval($sPlugin) : false);
	}
}

?>