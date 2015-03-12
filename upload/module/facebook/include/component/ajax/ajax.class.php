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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 1649 2010-06-13 11:42:55Z Raymond_Benc $
 */
class Facebook_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function login()
	{
		if (Phpfox::getService('facebook.api')->isUser())
		{
			$aUser = Phpfox::getService('facebook')->getUser(Phpfox::getService('facebook.api')->getUserId());
			if (isset($aUser['user_id']))
			{
				Phpfox::getService('user.auth')->login($aUser['user_name'], md5($aUser['fb_user_id']), false, 'user_name');
				
				$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('') . '\'');
			}
		}
	}
	
	public function shareFeed()
	{
		Phpfox::isUser(true);
		Phpfox::getService('facebook.process')->shareFeed($this->get('type'));
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('facebook.sync') . '\';');
	}
	
	public function sendEmail()
	{
		Phpfox::isUser(true);
		Phpfox::getService('facebook.process')->sendEmail($this->get('type'));
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('facebook.sync') . '\';');
	}

	public function check()
	{
		$sType = $this->get('type');
		
		echo '<iframe src="https://graph.facebook.com/oauth/authorize?client_id=' . Phpfox::getParam('facebook.facebook_app_id') . '&redirect_uri=' . Phpfox::getParam('core.path') . 'index.php?facebook-check=' . $sType . '&scope=' . $sType . '&display=popup" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>';
	}
}

?>