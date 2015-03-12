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
 * @version 		$Id: frame.class.php 2096 2010-11-09 10:35:56Z Raymond_Benc $
 */
class Facebook_Component_Controller_Frame extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		header('Location: https://graph.facebook.com/oauth/authorize?client_id=' . Phpfox::getParam('facebook.facebook_app_id') . '&redirect_uri=' . Phpfox::getParam('core.path') . 'index.php?facebook-process-login=true&scope=publish_stream,email,user_birthday');		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('facebook.component_controller_frame_clean')) ? eval($sPlugin) : false);
	}
}

?>