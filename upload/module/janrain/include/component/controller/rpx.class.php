<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

define('PHPFOX_SKIP_POST_PROTECTION', true);

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: rpx.class.php 6578 2013-09-05 09:27:59Z Miguel_Espinoza $
 */
class Janrain_Component_Controller_Rpx extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if(isset($_POST['token']) && strlen($_POST['token']) == 40) 
		{		
		  	$aPost = array(
		  		'token'  => $_POST['token'],
		        'apiKey' => Phpfox::getParam('janrain.janrain_api_key'),
		        'format' => 'json',
		        'extended' => 'true'
			);

		  	$sResult = Phpfox::getLib('request')->send('https://rpxnow.com/api/v2/auth_info', $aPost);
		
		  	$aInfo = json_decode($sResult, true);		  	
		
		  	if ($aInfo['stat'] == 'ok') 
		  	{
				$aUserInfo = $aInfo['profile'];
				
				if (($aUser = Phpfox::getService('janrain')->getUser($aUserInfo)))
				{
					list($bIsLoggedIn, $aPostUserInfo) = Phpfox::getService('user.auth')->login($aUser['user_name'], null, false, 'user_name', true);
					if ($bIsLoggedIn)
					{
						$this->url()->send(Phpfox::getParam('user.redirect_after_login'));
					}
				}
				else 
				{		  		
					if (Phpfox::getService('janrain.process')->add($aUserInfo))					
					{						
						$aUser = Phpfox::getService('janrain')->getUser($aUserInfo);
						if (($sPlugin = Phpfox_Plugin::get('janrain.component_controller_rpx_1')))
						{
							eval($sPlugin);
							if (isset($mReturnFromPlugin))
							{
								return $mReturnFromPlugin;
							}
						}
						list($bIsLoggedIn, $aPostUserInfo) = Phpfox::getService('user.auth')->login($aUser['user_name'], null, false, 'user_name', true);
						if ($bIsLoggedIn)
						{							
							$this->url()->send('user.setting', null, Phpfox::getPhrase('janrain.your_account_has_successfully_been_created_please_enter_your_account_details_below'));	
						}										
					}						    	
				}
		    } 
		    else 
		    {
		      	Phpfox_Error::set($aInfo['err']['msg']);
		    }
		}
		else
		{
		  	Phpfox_Error::set('Authentication canceled.');
		}				
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('janrain.component_controller_rpx_clean')) ? eval($sPlugin) : false);
	}
}

?>