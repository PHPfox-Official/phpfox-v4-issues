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
 * @version 		$Id: search.class.php 4593 2012-08-13 09:32:05Z Raymond_Benc $
 */
class Friend_Component_Block_Search extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iPage = $this->getParam('page', 0);
		$iPageSize = 36;		
		$bIsOnline = false;		
		$oDb = Phpfox::getLib('database');
		$aParams = array();
		$aConditions = array();
		$iListId = 0;
		
		$aConditions[] = 'AND friend.is_page = 0';
		
		if ($this->getParam('type') != 'mail')
		{
			$aConditions[] = 'AND friend.user_id = ' . Phpfox::getUserId();
		}
		
		if (($sFind = $this->getParam('find')))
		{
			$aConditions[] = 'AND (u.full_name LIKE \'%' . $oDb->escape($sFind) . '%\' OR (u.email LIKE \'%' . $oDb->escape($sFind) . '@%\' OR u.email = \'' . $oDb->escape($sFind) . '\'))';	
		}		
		
		$aLetters = array(
			Phpfox::getPhrase('friend.all'), '#', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
		);			
		
		if (($sLetter = $this->getParam('letter')) && in_array($sLetter, $aLetters) && strtolower($sLetter) != 'all')
		{
			if ($sLetter == '#')
			{
				$sSubCondition = '';
				for ($i = 0; $i <= 9; $i++)
				{
					$sSubCondition .= "OR u.full_name LIKE '" . Phpfox::getLib('database')->escape($i) . "%' ";
				}
				$sSubCondition = ltrim($sSubCondition, 'OR ');
				$aConditions[] = 'AND (' . $sSubCondition . ')';
			}
			else 
			{
				$aConditions[] = "AND u.full_name LIKE '" . Phpfox::getLib('database')->escape($sLetter) . "%'";	
			}
			
			$aParams['letter'] = $sLetter;
		}		
		
		if ($sView = $this->getParam('view'))
		{
			switch ($sView)
			{
				case 'top':
					$aConditions[] = 'AND is_top_friend = 1';
					break;
				case 'online':
					$bIsOnline = true;
					break;
				case 'all':
					
					break;
				default:					
					if ((int) $sView > 0 && ($aList = Phpfox::getService('friend.list')->getList($sView, Phpfox::getUserId())) && isset($aList['list_id']))
					{
						$iListId = (int) $aList['list_id'];
					}
					break;
			}
		}
		
		if ($this->getParam('type') == 'mail')
		{
			$aConditions[] = 'AND u.user_id != ' . Phpfox::getUserId();
			list($iCnt, $aFriends) = Phpfox::getService('user.browse')->conditions($aConditions)
				->sort('u.full_name ASC')
				->page($iPage)
				->limit($iPageSize)			
				->get();
			if (Phpfox::getParam('mail.disallow_select_of_recipients'))
			{
				$oMail = Phpfox::getService('mail');
				foreach ($aFriends as $iKey => $aFriend)
				{
					if (!$oMail->canMessageUser($aFriend['user_id']))
					{
						$aFriends[$iKey]['canMessageUser'] = false;
					}
				}
			}
		}
		else 
		{		
			list($iCnt, $aFriends) = Phpfox::getService('friend')->get($aConditions, 'u.full_name ASC', $iPage, $iPageSize, true, true, $bIsOnline, null, false, $iListId);			
		}
		
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_search_get')) ? eval($sPlugin) : false);
		
		$aParams['input'] = $this->getParam('input');
		$aParams['friend_item_id'] = $this->getParam('friend_item_id');
		$aParams['friend_module_id'] = $this->getParam('friend_module_id');
		$aParams['type'] = $this->getParam('type');
			
		Phpfox::getLib('pager')->set(array('ajax' => 'friend.searchAjax', 'page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'aParams' => $aParams));
		
		$sFriendModuleId = $this->getParam('friend_module_id', '');

		$this->template()->assign(array(
				'aFriends' => $aFriends,
				'aLetters' => $aLetters,
				'sView' => $sView,
				'sActualLetter' => $sLetter,
				'sPrivacyInputName' => $this->getParam('input'),
				'aLists' => Phpfox::getService('friend.list')->get(),
				'bSearch' => $this->getParam('search'),
				'bIsForShare' => $this->getParam('friend_share', false),
				'sFriendItemId' => (int) $this->getParam('friend_item_id', '0'),
				'sFriendModuleId' => $sFriendModuleId,
				'sFriendType' => $this->getParam('type')
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_search_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_search_clean')) ? eval($sPlugin) : false);
	}
}

?>