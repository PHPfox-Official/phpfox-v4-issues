<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Profile Block Header
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: header.class.php 6987 2013-12-11 12:18:29Z Miguel_Espinoza $
 */
class Profile_Component_Block_Header extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_header_process')) ? eval($sPlugin) : false);
		if (defined('PHPFOX_IS_PAGES_ADD'))
		{
		    return false;
		}
		$aUser = $this->getParam('aUser');
		
		if ($aUser === null)
		{
			$aUser = $this->getParam('aPage');
		}
		else if (!isset($aUser['is_featured']))
		{
			// If for some reason this is happening too often check the caching in /file/cache/profile
			// and the user service, function get
			$aUser['is_featured'] = false;
		}
		if (!Phpfox::isModule('friend'))
		{
			$aUser['is_friend'] = false;
		}
		
		$aUser['is_header'] = true;
		$aUser['is_liked'] = (!isset($aUser['is_liked']) || $aUser['is_liked'] === null || ($aUser['is_liked'] < 1) ) ? false : true;
		if (!isset($aUser['user_id']))
		{
		    return false;
		}
		
		
		if (!defined('PAGE_TIME_LINE') && !defined('PHPFOX_IS_PAGES_VIEW'))
		{
			if (Phpfox::getParam('user.enable_relationship_status'))
            {
                $sRelationship = Phpfox::getService('custom')->getRelationshipPhrase($aUser);
                $this->template()->assign(array(
                    'sRelationship' => $sRelationship
                ));
            }
            
			$bCanSendPoke = Phpfox::isModule('poke') && Phpfox::getService('poke')->canSendPoke($aUser['user_id']);
			$this->template()->assign(array(
				'bCanPoke' => $bCanSendPoke				
				)
			);
		}
		else if ((isset($aUser['use_timeline']) && $aUser['use_timeline']) || defined('PHPFOX_IS_PAGES_VIEW'))
		{
			$sPagesSection = Phpfox::getNonRewritten('pages');
		    $sModule = ($this->request()->get('req1') == $sPagesSection ? $this->request()->get('req3') : $this->request()->get('req2'));
		    $sModule = Phpfox::getLib('url')->reverseRewrite($sModule);
		    if (Phpfox::isModule($sModule) && Phpfox::hasCallback($sModule, 'getPageSubMenu'))
		    {
		    	if (defined('PHPFOX_IS_PAGES_VIEW'))
		    	{
		    		$aPage = $this->getParam('aPage');		    		
		    	}
		    	
				$aMenu = Phpfox::callback($sModule .'.getPageSubmenu', (defined('PHPFOX_IS_PAGES_VIEW') ? $aPage : $aUser));
				if (is_array($aMenu))
				{
					foreach ($aMenu as $iKey => $aSubMenu)
					{
					    $aMenu[$iKey]['module'] = $sModule;
					    if (isset($aSubMenu['phrase']))
					    {
							if (Phpfox::getLib('locale')->isPhrase($sModule . '.' . $aSubMenu['phrase']) )
							{
								$aMenu[$iKey]['var_name'] = $aSubMenu['phrase'];
							}
							else
							{
								$aMenu[$iKey]['text'] = $aSubMenu['phrase'];
							}
							continue;
						}
					    switch ($sModule)
					    {
							case 'event': 
								$aMenu[$iKey]['var_name'] = 'menu_create_new_'.$sModule;
								break;
							case 'forum':
								$aMenu[$iKey]['var_name'] = 'post_a_new_thread';
								break;
							case 'music':
								$aMenu[$iKey]['var_name'] = 'menu_upload_a_song';
								break;
							case 'photo':
								$aMenu[$iKey]['var_name'] = 'upload_a_new_image';
								break;
							case 'video':
								$aMenu[$iKey]['var_name'] = 'menu_upload_a_new_video';
								break;
							default:
								$aMenu[$iKey]['var_name'] = 'menu_add_new_'.$sModule;
					    }					    
					}
				}
				
				$this->template()->assign(array(
				    'aSubMenus' => $aMenu
				));
		    }
		    
		}

		
		$this->template()->assign(array(
			'aUser' => $aUser
		));
		if (isset($bHideProfileBlockHeader))
		{
			return false;
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_header_clean')) ? eval($sPlugin) : false);
	}
}

?>