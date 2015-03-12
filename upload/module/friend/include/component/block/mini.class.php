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
 * @package  		Module_Friend
 * @version 		$Id: mini.class.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
class Friend_Component_Block_Mini extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_mini_process')) ? eval($sPlugin) : false);
		
		if (isset($bHideThisBlock))
		{
			return false;
		}
		
		if (Phpfox::getUserBy('profile_page_id'))
		{
			return false;
		}
		
		if (!Phpfox::isUser())
		{
			return false;
		}

		$iTotal = 20;		
		if (Phpfox::getParam('friend.load_friends_online_ajax') && !PHPFOX_IS_AJAX)
		{
			$aRows = array();
			$iCnt = 0;
		}
		else
		{
			list($iCnt, $aRows) = Phpfox::getService('friend')->get('friend.is_page = 0 AND friend.user_id = ' . Phpfox::getUserId(), 'ls.last_activity DESC', 0, $iTotal, true, false, true);
		}

		$this->template()->assign(array(
				'sHeader' => '' . Phpfox::getPhrase('friend.friends_online') . ' (<span id="js_total_block_friends_onlin">' . $iCnt . '</span>)',
				'aFriends' => $aRows,
				'iTotalFriendsOnline' => $iCnt		
			)
		);
		
		if (Phpfox::getUserParam('friend.can_remove_friends_from_dashboard'))
		{
			//$this->template()->assign('sDeleteBlock', 'dashboard');
		}

		return 'block';	
	}	
}

?>