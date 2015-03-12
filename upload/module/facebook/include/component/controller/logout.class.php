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
 * @version 		$Id: logout.class.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
class Facebook_Component_Controller_Logout extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getService('user.auth')->logout();				
				
		$sHttp = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http');
		$this->template()->setFullSite();		
		$this->template()->setHeader(array(
			'<script src="' . $sHttp. '://connect.facebook.net/en_US/all.js" type="text/javascript"></script>',							
			'<script type="text/javascript">
				$Behavior.facebook_init = function()
				{
					FB.init(
					{
					    appId  : \'' . Phpfox::getParam('facebook.facebook_app_id') . '\',
					    status : true,
					    cookie : true,
						oauth  : true,
					    xfbml  : true
				   });
		   
				   FB.getLoginStatus(function(response) 
				   {
						if (response.authResponse)
						{ 
		  					FB.logout(function(response) 
		  					{  
				   				window.location.href = \'' . $this->url()->makeUrl('') . '\';
				   			});
		  				}
				   		else
				   		{
				   			window.location.href = \'' . $this->url()->makeUrl('') . '\';
				   		}
				   });		   
		   
		   		};
		   </script>')
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('facebook.component_controller_logout_clean')) ? eval($sPlugin) : false);
	}
}

?>