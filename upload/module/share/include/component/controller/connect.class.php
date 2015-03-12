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
 * @version 		$Id: connect.class.php 5074 2012-12-06 10:37:26Z Raymond_Benc $
 */
class Share_Component_Controller_Connect extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		if (isset($_GET['connect-id']) && $_GET['connect-id'] == 'facebook')
		{
			$aReturn = (array) Phpfox::getService('facebook')->get('/me', urlencode(Phpfox::getParam('core.path') . '?share-connect=1&connect-id=facebook'));
			if (isset($aReturn['id']))
			{
				Phpfox::getService('share.process')->addConnect('facebook');
			}
		}
		else
		{
			$aReturn = Phpfox::getLib('twitter')->getUser($_GET['oauth_token']);
			
			if (isset($aReturn['id']))
			{
				Phpfox::getService('share.process')->addConnect('twitter', Phpfox::getLib('twitter')->getToken(), Phpfox::getLib('twitter')->getSecret());
			}
		}
		
		$this->url()->send('');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_controller_connect_clean')) ? eval($sPlugin) : false);
	}
}

?>