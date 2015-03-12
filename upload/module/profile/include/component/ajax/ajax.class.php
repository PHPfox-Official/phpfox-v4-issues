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
 * @version 		$Id: ajax.class.php 4622 2012-09-12 07:18:24Z Miguel_Espinoza $
 */
class Profile_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function logo()
	{
		$this->setTitle(Phpfox::getPhrase('profile.cover_photo'));
		$aParams = array('page_id' => $this->get('page_id'));
		
		Phpfox::getBlock('profile.cover', $aParams);
	}
	
	public function loadProfileBlock()
	{
		exit();
		
		$sProfileUrl = str_replace('profile_', '', $this->get('url'));
		if ($this->get('url') == 'profile_info')
		{
			$sProfileUrl = 'profile';
		}
		
		if (!Phpfox::isModule($sProfileUrl))
		{
			Phpfox_Error::set('Trying to load an invalid module.');
		}
		else
		{
			if (!Phpfox::hasCallback($sProfileUrl, 'getAjaxProfileController'))
			{
				Phpfox_Error::set('Unable to load the section you are looking for.');
			}
		}
		
		if (Phpfox_Error::isPassed())
		{
			$oModule = Phpfox::getLib('module');
			$oTpl = Phpfox::getLib('template');
		
			$oTpl->assign(array('bIsAjaxLoader' => true));
			
			$aStyleInUse = $oTpl->getStyleInUse();
			
			$oModule->loadBlocks();
			
			$aUrlParams = array(
				$this->get('user_name')
			);
			if ($this->get('url') != 'profile')
			{
				$aUrlParams[] = str_replace('profile_', '', $this->get('url'));
			}
			Phpfox::getLib('url')->setParam($aUrlParams);
			
			$oModule->setController(Phpfox::callback($sProfileUrl . '.getAjaxProfileController'));
			
			if ($aStyleInUse['total_column'] == '3')
			{			
				$oTpl->assign(array(
						'aBlocks1' => ($oTpl->bIsSample ? true : Phpfox::getLib('module')->getModuleBlocks(1)),
						'aBlocks3' => ($oTpl->bIsSample ? true : Phpfox::getLib('module')->getModuleBlocks(3)),								
						'aAdBlocks1' => ($oTpl->bIsSample ? true : (Phpfox::isModule('ad') ? Phpfox::getService('ad')->getForBlock(1) : null)),
						'aAdBlocks3' => ($oTpl->bIsSample ? true : (Phpfox::isModule('ad') ? Phpfox::getService('ad')->getForBlock(3) : null))
					)
				);
			}
			else 
			{
				$oTpl->assign(array(
						'aBlocks1' => array(),
						'aBlocks3' => array(),								
						'aAdBlocks1' => array(),
						'aAdBlocks3' => array()
					)
				);				
			}
			
			$oTpl->assign(array(							
					'sPublicMessage' => Phpfox::getMessage(),
					'aErrors' => (Phpfox_Error::getDisplay() ? Phpfox_Error::get() : array()),
					'aStyleInUse' => $aStyleInUse
				)
			);
			
			list($aBreadCrumbs, $aBreadCrumbTitle) = $oTpl->getBreadCrumb();
			
			$this->remove('#js_temp_breadcrumb');
			if (count($aBreadCrumbs))
			{
				foreach ($aBreadCrumbs as $sLink => $sPhrase)
				{
					$this->append('h1', '<span id="js_temp_breadcrumb"><span class="profile_breadcrumb">&#187;</span><a href="' . $sLink . '">' . $sPhrase . '</a></span>');
					break;
				}
			}
			
			$oTpl->getLayout($oTpl->sDisplayLayout);			
			
			$this->html(($aStyleInUse['total_column'] == '3' ? '#content_load_data' : '#content'), $this->getContent(false));
			
			if ($this->get('url') == 'profile_info')
			{
				$this->call('$Core.loadProfileInfo();');	
			}
		}
		else 
		{
			$this->html('#js_profile_block_view_data_' . $this->get('url'), implode('', Phpfox_Error::get()));
		}
		
		$this->call('$Core.loadInit();');
	}
}

?>