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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class User_Component_Block_Tooltip extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$oUser = Phpfox::getService('user');
		
		$aUser = $oUser->getByUserName($this->request()->get('user_name'));

		$bIsPage = ($aUser['profile_page_id'] > 0 ? true : false);
		if ($bIsPage)
		{
			$aUser['page'] = Phpfox::getService('pages')->getPage($aUser['profile_page_id']);
			
			// list($iTotalMembers, $aMembers) = Phpfox::getService('pages')->getMembers($aUser['page']['page_id']);			
			// $aUser['page_members'] = $aMembers;
		}
		
		
		$aUser['birthday_time_stamp'] = $aUser['birthday'];
		$aUser['birthday'] = $oUser->age($aUser['birthday']);
		$aUser['gender_name'] = $oUser->gender($aUser['gender']);
		$aUser['birthdate_display'] = $oUser->getProfileBirthDate($aUser);
		$aUser['location'] = Phpfox::getPhraseT(Phpfox::getService('core.country')->getCountry($aUser['country_iso']), 'country');
		if (isset($aUser['country_child_id']) && $aUser['country_child_id'] > 0)
		{
			$aUser['location_child'] = Phpfox::getService('core.country')->getChild($aUser['country_child_id']);
		}		
		
		$aUser['is_friend'] = false;
		$iTotal = 0;
		$aMutual = array();
		if ($aUser['user_id'] != Phpfox::getUserId() && !$bIsPage)
		{
			if (Phpfox::isUser() && Phpfox::isModule('friend'))
			{
				$aUser['is_friend'] = Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aUser['user_id']);						
				if (!$aUser['is_friend'])
				{
					$aUser['is_friend'] = (Phpfox::getService('friend.request')->isRequested(Phpfox::getUserId(), $aUser['user_id']) ? 2 : false);
				}			
			}
			
			list($iTotal, $aMutual) = Phpfox::getService('friend')->getMutualFriends($aUser['user_id'], 4);
		}
	
		$bShowBDayInput = false;
		if (!empty($aUser['birthday']))
                {
                    $iDays = Phpfox::getLib('date')->daysToDate($aUser['birthday'], null, false);
                }
                else
                {
                    $iDays = 999;
                }

		if ($iDays < 1 && $iDays > 0)
		{
			$bShowBDayInput = true;
		}
		
		if (empty($aUser['dob_setting']))
		{
			switch (Phpfox::getParam('user.default_privacy_brithdate'))
			{
				case 'month_day':
					$aUser['dob_setting'] =  '1';
					break;
				case 'show_age':
					$aUser['dob_setting'] =  '2';
					break;
				case 'hide':
					$aUser['dob_setting'] =  '3';
					break;
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.component_block_tooltip_1')) ? eval($sPlugin) : false);
		$this->template()->assign(array(
				'bIsPage' => $bIsPage,
				'aUser' => $aUser,
				'iMutualTotal' => $iTotal,
				'aMutualFriends' => $aMutual,
				'bShowBDay' => $bShowBDayInput
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_tooltip_clean')) ? eval($sPlugin) : false);
	}
}

?>
