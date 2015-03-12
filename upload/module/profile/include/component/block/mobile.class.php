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
 * @version 		$Id: mobile.class.php 6720 2013-10-03 10:51:20Z Fern $
 */
class Profile_Component_Block_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW'))
		{
			return false;
		}
		
		if(defined('PHPFOX_IS_PAGES_VIEW'))
		{
			$aUser = $this->getParam('aPage');
			$aUser['user_image'] = $aUser['image_path'];
			$aUser['profile_page_id'] = $aUser['page_id'];
			$aUser['server_id'] = $aUser['image_server_id'];
		}
		else
		{
			$aUser = $this->getParam('aUser');
		}

		$aUserInfo = array(
			'title' => $aUser['full_name'],
			'path' => 'core.url_user',
			'file' => $aUser['user_image'],
			'suffix' => '_50_square',
			'max_width' => 75,
			'max_height' => 75,
			'no_default' => (Phpfox::getUserId() == $aUser['user_id'] ? false : true),
			'thickbox' => true,
        	'class' => 'profile_user_image'
		);			
		
		if(defined('PHPFOX_IS_PAGES_VIEW'))
		{
			$sImage = Phpfox::getLib('image.helper')->display(array_merge(array('user' => $aUser), $aUserInfo));
		}
		else
		{
			$sImage = Phpfox::getLib('image.helper')->display(array_merge(array('user' => Phpfox::getService('user')->getUserFields(true, $aUser)), $aUserInfo));
		}

		$bIsInfo = false;
		if((isset($aUser['landing_page']) && ($aUser['landing_page'] == 'info') && Phpfox::getLib('request')->get('req2') != 'wall')
			|| (Phpfox::getLib('request')->get('req2') == 'info' )
		)
		{
			$bIsInfo = true;
		}
		
		if(defined('PHPFOX_IS_PAGES_VIEW') && empty($aUser['vanity_url']))
		{
			if((isset($aUser['landing_page']) && ($aUser['landing_page'] == 'info') && Phpfox::getLib('request')->get('req3') != 'wall')
			|| (Phpfox::getLib('request')->get('req3') == 'info' ))
			{
				$bIsInfo = true;
			}
		}

		$this->template()->assign(array(
				'aUser' => $aUser,
				'sProfileImage' => $sImage,
				'bIsInfo' => $bIsInfo,
				'bCanPoke' => Phpfox::isModule('poke') && Phpfox::getService('poke')->canSendPoke($aUser['user_id'])
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>
