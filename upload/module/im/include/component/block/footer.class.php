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
 * @package 		Phpfox_Component
 * @version 		$Id: footer.class.php 6520 2013-08-29 06:45:24Z Miguel_Espinoza $
 */
class Im_Component_Block_Footer extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (defined('PHPFOX_IS_AD_PREVIEW'))
		{
			return false;
		}
		
		if (Phpfox::getUserBy('profile_page_id') > 0)
		{
			return false;
		}
		
		$oRequest = Phpfox::getLib('request');
		
		if ($this->template()->bIsSample 
				|| ($oRequest->get('req2') == 'designer')
				|| ($oRequest->get('req2') == 'index-member' && $oRequest->get('req3') == 'customize'))
		{
			return false;
		}
		
		if (!Phpfox::isModule('friend'))
		{
			return false;
		}
		
		$sLastOpenWindow = null;
		$sLastWindowParam = null;
		if (($sLastOpenWindow = Phpfox::getCookie('im_last_open_window')))
		{			
			if (preg_match("/chat_(.*)/i", $sLastOpenWindow, $aMatches))
			{
				$sLastOpenWindow = 'chat';
				$sLastWindowParam = (int) $aMatches[1];				
			}
			elseif ($sLastOpenWindow == 'messenger')
			{
				$sLastOpenWindow = 'messenger';
			}			
			
			Phpfox::setCookie('im_last_open_window', '', -1);
		}
		$iCnt = 0;
		if (Phpfox::getUserBy('im_hide') != '1')
		{
			$aCond = array('AND f.user_id = ' . Phpfox::getUserId() . ' AND u.im_hide != 1');			
			list($iCnt, $aFriends) = Phpfox::getService('im')->getOnlineFriends(Phpfox::getUserId(), $aCond);
		}
		
		
		$this->template()->assign(array(
				'iTotalFriendsOnline' => $iCnt,
				'sLastOpenWindow' => $sLastOpenWindow,
				'sLastWindowParam' => $sLastWindowParam
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('im.component_block_footer_clean')) ? eval($sPlugin) : false);
	}
}

?>