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
 * @package  		Module_Profile
 * @version 		$Id: info.class.php 6905 2013-11-19 11:36:20Z Miguel_Espinoza $
 */
class Profile_Component_Block_Info extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		// $aUser = (PHPFOX_IS_AJAX ? Phpfox::getService('user')->get(Phpfox::getUserId(), true) : $this->getParam('aUser'));
		$aUser = $this->getParam('aUser');
		/*
		if (PHPFOX_IS_AJAX)
		{
			$aUser['gender_name'] = Phpfox::getService('user')->gender($aUser['gender']);
			$aUser['birthday_time_stamp'] = $aUser['birthday'];
			$aUser['birthday'] = Phpfox::getService('user')->age($aUser['birthday']);
			$aUser['location'] = Phpfox::getService('core.country')->getCountry($aUser['country_iso']);	
			$this->template()->assign('aUser', $aUser);
		}
		*/
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'profile.basic_info'))
		{
			return false;
		}
		$aUser['bRelationshipHeader'] = true;
		$sRelationship = Phpfox::getService('custom')->getRelationshipPhrase($aUser);
		$aUserDetails = array();
		if (!empty($aUser['gender']))
		{
			$aUserDetails[Phpfox::getPhrase('profile.gender')] = '<a href="' . $this->url()->makeUrl('user.browse', array('gender' => $aUser['gender'])) . '">' . $aUser['gender_name'] . '</a>';
		}
		
		$aUserDetails = array_merge($aUserDetails, $aUser['birthdate_display']);
		
		$sExtraLocation = '';
		
		if (!empty($aUser['city_location']))
		{
			$sExtraLocation .= '<div class="p_2"><a href="' . $this->url()->makeUrl('user.browse', array('location' => $aUser['country_iso'], 'state' => $aUser['country_child_id'], 'city-name' => $aUser['city_location'])) . '">' . Phpfox::getLib('parse.output')->clean($aUser['city_location']) . '</a> &raquo;</div>';
		}		
		
		if ($aUser['country_child_id'] > 0)
		{
			$sExtraLocation .= '<div class="p_2"><a href="' . $this->url()->makeUrl('user.browse', array('location' => $aUser['country_iso'], 'state' => $aUser['country_child_id'])) . '">' . Phpfox::getService('core.country')->getChild($aUser['country_child_id']) . '</a> &raquo;</div>';
		}		
		
		if (!empty($aUser['country_iso']))
		{
			$aUserDetails[Phpfox::getPhrase('profile.location')] = $sExtraLocation . '<a href="' . $this->url()->makeUrl('user.browse', array('location' => $aUser['country_iso'])) . '">' . Phpfox::getPhraseT($aUser['location'], 'country') . '</a>';
		}
		
		if ((int) $aUser['last_login'] > 0 && ((!$aUser['is_invisible']) || (Phpfox::getUserParam('user.can_view_if_a_user_is_invisible') && $aUser['is_invisible'])))
		{
			$aUserDetails[Phpfox::getPhrase('profile.last_login')] = Phpfox::getLib('date')->convertTime($aUser['last_login'], 'core.profile_time_stamps');
		}
		
		if ((int) $aUser['joined'] > 0)
		{
			$aUserDetails[Phpfox::getPhrase('profile.member_since')] = Phpfox::getLib('date')->convertTime($aUser['joined'], 'core.profile_time_stamps');
		}
		
		if (Phpfox::getUserGroupParam($aUser['user_group_id'], 'profile.display_membership_info'))
		{
			$aUserDetails[Phpfox::getPhrase('profile.membership')] = (empty($aUser['icon_ext']) ? '' : '<img src="' . Phpfox::getParam('core.url_icon') . $aUser['icon_ext'] . '" class="v_middle" alt="' . Phpfox::getLib('locale')->convert($aUser['title']) . '" title="' . Phpfox::getLib('locale')->convert($aUser['title']) . '" /> ') . $aUser['prefix'] . Phpfox::getLib('locale')->convert($aUser['title']) . $aUser['suffix'];
		}
		
		$aUserDetails[Phpfox::getPhrase('profile.profile_views')] = $aUser['total_view'];
		
		if (Phpfox::isModule('rss') && Phpfox::getParam('rss.display_rss_count_on_profile') && Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'rss.display_on_profile'))
		{
			$aUserDetails[Phpfox::getPhrase('profile.rss_subscribers')] = $aUser['rss_count'];
		}		
		
		$sEditLink = '';
		if ($aUser['user_id'] == Phpfox::getUserId())
		{
			$sEditLink = '<div class="js_edit_header_bar">';
			$sEditLink .= '<span id="js_user_basic_info" style="display:none;"><img src="' . $this->template()->getStyle('image', 'ajax/small.gif') . '" alt="" class="v_middle" /></span>';
			$sEditLink .= '<a href="' . Phpfox::getLib('url')->makeUrl('user.profile') . '" id="js_user_basic_edit_link">';
			$sEditLink .= '<img src="' . $this->template()->getStyle('image', 'misc/page_white_edit.png') . '" alt="" class="v_middle" />';
			$sEditLink .= '</a>';			
			$sEditLink .= '</div>';
		}	
		// Get the Smoker and Drinker details
		$aUserPanel = Phpfox::getService('custom')->getUserPanelForUser($aUser['user_id']);
                
		foreach ($aUserPanel as $sName => $aField)
		{
			//$aUserDetails[Phpfox::getPhrase($aField['phrase_var_name'])] = Phpfox::getPhrase($aField['phrase_chosen']);
		}
		$this->template()->assign(array(				
				'aUserDetails' => $aUserDetails,
				'sBlockJsId' => 'profile_basic_info',
				'sRelationship' => $sRelationship
			)
		);
		
		$this->setParam('aRatingCallback', array(
				'type' => 'user',
				'total_rating' => Phpfox::getPhrase('profile.total_rating_ratings', array('total_rating' => $aUser['total_rating'])),
				'default_rating' => $aUser['total_score'],
				'item_id' => $aUser['user_id'],
				'stars' => range(1, 10)
			)
		);		
		
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_info')) ? eval($sPlugin) : false);
		
		if (!Phpfox::isMobile())
		{
			$this->template()->assign(array(
					'sHeader' => $sEditLink . Phpfox::getPhrase('profile.basic_info'),					
					'sEditLink' => $sEditLink
				)
			);
			return 'block';
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_info_clean')) ? eval($sPlugin) : false);
	}	
}

?>