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
 * @version 		$Id: profile.class.php 5491 2013-03-12 08:12:07Z Miguel_Espinoza $
 */
class User_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		$bIsEdit = false;
		
		$iUserId = Phpfox::getUserId();
		$iUserGroupId = Phpfox::getUserBy('user_group_id');
		if (($iId = $this->request()->getInt('id')) && Phpfox::getUserParam('custom.can_edit_other_custom_fields') && $iId != Phpfox::getUserId())
		{
			if (($aUser = Phpfox::getService('user')->getUser($iId, 'u.user_id, u.user_name, u.full_name')) && isset($aUser['user_id']))
			{
				$iUserId = $aUser['user_id'];
				$iUserGroupId = $aUser['user_group_id'];
				$this->template()->assign('iUserId', $iUserId);
				$bIsEdit = true;
										
				if ($aVals = $this->request()->getArray('custom'))
				{
					if (Phpfox::getService('custom.process')->updateFields($iUserId, $iUserId, $aVals))
					{
						$this->url()->send($aUser['user_name'], null, Phpfox::getPhrase('user.successfully_updated_full_name_profile', array('full_name' => $aUser['full_name'])));
					}
				}
			}
		}
		else 
		{
			Phpfox::getUserParam('custom.can_edit_own_custom_field', true);
		}		
		
		$aCustomGroups = Phpfox::getService('custom.group')->getGroups('user_profile', $iUserGroupId);
		$aCustomFields = Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), $iUserId, $iUserGroupId, false, Phpfox::getUserId());
        
		$aGroupCache = array();
		foreach ($aCustomFields as $aFields)
		{			
			$aGroupCache[$aFields['group_id']] = true;
		}	
        
		if ($sPlugin = Phpfox_Plugin::get('user.component_controller_profile__1')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
		foreach ($aCustomGroups as $iKey => $aCustomGroup)
		{
            if ($sPlugin = Phpfox_Plugin::get('user.component_controller_profile__2')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
			if (!isset($aGroupCache[$aCustomGroup['group_id']]))
			{
				unset($aCustomGroups[$iKey]);
			}
		}
		
		$aRebuildKeys = $aCustomGroups;
		$aCustomGroups = array();
		$iCnt = 0;
		foreach ($aRebuildKeys as $aCustomGroup)
		{
			$aCustomGroups[$iCnt] = $aCustomGroup;
			$iCnt++;
		}		
		
		
		$aTimeZones = Phpfox::getService('core')->getTimeZones();
		if (count($aTimeZones) > 100) // we are using the php 5.3 way
		{
			$this->template()->setHeader('cache', array('setting.js' => 'module_user'))
				->setHeader('cache', array(
					'<script type="text/javascript">sSetTimeZone = "' . Phpfox::getUserBy('time_zone') . '";</script>'
				)
			);
		}
		$aForms = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
		/* we could put this part inside get but I fear its being wrongly used */
		$aRelation = Phpfox::getService('custom.relation')->getLatestForUser(Phpfox::getUserId(), null, true);		
		if (isset($aRelation['status_id']))
		{
			$aForms = array_merge($aForms, $aRelation);					
		}
		
		$sJsArray = '{';
		$aRelations = Phpfox::getService('custom.relation')->getAll();
		foreach ($aRelations as $aItem)
		{
			if ($aItem['confirmation'] == 1)
			{
				$sJsArray .= $aItem['relation_id'] . ':' . $aItem['confirmation'] .',';
			}
		}
		$sJsArray = rtrim($sJsArray, ',') .'}';
		
		
		
		
		$aForms['month'] = substr($aForms['birthday'], 0, 2);
		$aForms['day'] = substr($aForms['birthday'],2,2);
		$aForms['year'] = substr($aForms['birthday'],4);

		if (Phpfox::isModule('friend'))
		{
			$this->template()->setPhrase(array('friend.show_more_results_for_search_term'));
		}
        
        if ($sPlugin = Phpfox_Plugin::get('user.component_controller_profile__3')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
        
		$this->template()->setTitle(Phpfox::getPhrase('user.edit_profile'))
			->setBreadcrumb(Phpfox::getPhrase('user.edit_profile'))
			->setFullSite()
			->setHeader(array(
					'country.js' => 'module_core',
					'custom.js' => 'module_custom',
					'search.js' => 'module_friend',
					'edit-profile.css' => 'module_user'
				)
			)			
		 	->assign(array(
		 			'aGroups' => $aCustomGroups,
		 			'aSettings' => $aCustomFields,
		 			'bIsEdit' => $bIsEdit,
					'sDobStart' => Phpfox::getParam('user.date_of_birth_start'),
					'sDobEnd' => Phpfox::getParam('user.date_of_birth_end'),
					'aTimeZones' => $aTimeZones,
					'aForms' => $aForms,
					'sJsArray' => $sJsArray,
					'aRelations' => Phpfox::getService('custom')->getRelations()
		 		)
		 	);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>
