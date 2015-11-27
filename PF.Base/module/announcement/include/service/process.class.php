<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Service
 * @version 		$Id: process.class.php 6436 2013-08-12 08:19:48Z Miguel_Espinoza $
 */
class Announcement_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('announcement');
	}

	/**
	 * Deletes an announcement
	 * @param int $iId
	 */
	public function delete($iId)
	{
		// how to check if user is an admin ?

		$iId = (int)$iId;
		if ($iId < 1) return false;

		$this->database()->delete($this->_sTable, 'announcement_id = ' . $iId);
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'announcement\' AND var_name = \'announcement_subject_' . $iId . '\'');
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'announcement\' AND var_name = \'announcement_content_' . $iId . '\'');
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'announcement\' AND var_name = \'announcement_intro_' . $iId . '\'');
		$this->cache()->remove('announcements');
		
		return true;
	}

	/**
	 *	Adds an announcement. The process is to add a dummy entry in the announcements table, then add the values in the
	 *		phrase manager for each of the languages available (and passed in the array) according to the announcement_id
	 *		that we got from the first entry.
	 * @param array $aVals
	 */
	public function add($aVals)
	{
		// check its not an empty announcement
		$sSubjectPred = '';
		$aSubjects = array();
		foreach ($aVals['subject'] as $sKey => $aSubject)
		{
			if (empty($aSubject['text']) && $aSubject['is_default'] == 1)
			{
			    return Phpfox_Error::set(Phpfox::getPhrase('announcement.subject_cannot_be_empty'));
			}
			if ($aSubject['is_default'] == 1)
			{
			    $sSubjectPred = $aSubject['text'];
			}
			if (empty($aSubject['text']))
			{
			    $aSubject['text'] = $sSubjectPred;
			}
			$aSubjects[$sKey] = $aSubject['text'];
		}
		$sContentPred = '';
		$aContents = array();
		foreach ($aVals['content'] as $sKey => $aContent)
		{
			if (empty($aContent['text']) && $aContent['is_default'] == 1)
			{
			    return Phpfox_Error::set(Phpfox::getPhrase('announcement.content_cannot_be_empty'));
			}
			if ($aContent['is_default'] == 1)
			{
			    $sContentPred = $aContent['text'];
			}
			if (empty($aContent['text']))
			{
			    $aContent['text'] = $sContentPred;
			}
			$aContents[$sKey] = $aContent['text'];
		}

		$aIntros = array();
		$sIntroPred = '';
		foreach ($aVals['intro'] as $sKey => $aIntro)
		{
			if (empty($aIntro['text']) && $aIntro['is_default'] == 1)
			{
			//    return Phpfox_Error::set(Phpfox::getPhrase('announcement.content_cannot_be_empty'));
			}
			if ($aIntro['is_default'] == 1)
			{
			    $sIntroPred = $aIntro['text'];
			}
			if (empty($aIntro['text']))
			{
			    $aIntro['text'] = $sIntroPred;
			}
			$aIntros[$sKey] = $aIntro['text'];
		}
		
		// convert input start_date to database start_date
		$iStartDate = Phpfox::getLib('date')->convertToGmt(Phpfox::getLib('date')->mktime($aVals['start_hour'], $aVals['start_minute'], 0, $aVals['start_month'], $aVals['start_day'], $aVals['start_year']));		
		
		$aInsertAnnouncement = array(
			'time_stamp' => PHPFOX_TIME,
			'is_active' => (int)$aVals['is_active'],
			'start_date' => (int)$iStartDate,
			'age_from' => (int)$aVals['age_from'],
			'age_to' => (int)$aVals['age_to'],
			'country_iso' => $aVals['country_iso'],
			'gender' => (int)$aVals['gender'],
			'user_id' => (int)$aVals['user_id'],
			'user_group' => serialize(array()),
			'show_in_dashboard' => (int)$aVals['show_in_dashboard'],
			'gmt_offset' => Phpfox::getLib('date')->getGmtOffset($iStartDate)
		);
		
		if (isset($aVals['is_user_group']) && $aVals['is_user_group'] == 2)
		{
			$aGroups = array();
			$aUserGroups = Phpfox::getService('user.group')->get();
			if (isset($aVals['user_group']))
			{
				foreach ($aUserGroups as $aUserGroup)
				{
					if (in_array($aUserGroup['user_group_id'], $aVals['user_group']))
					{
						$aGroups[] = $aUserGroup['user_group_id'];
					}
				}
			}
			$aInsertAnnouncement['user_group'] = (count($aGroups) ? serialize($aGroups) : null);
		}

		$iId = $this->database()->insert($this->_sTable, $aInsertAnnouncement);
		
		$aSubjectInsert = array(
				'var_name' => 'announcement_subject_' . $iId,
				'product_id' => 'phpfox',
				'module' => 'announcement|announcement',
				'text' => $aSubjects
			);

		    $sSubject = Phpfox::getService('language.phrase.process')->add($aSubjectInsert);


		$sIntro = Phpfox::getService('language.phrase.process')->add(array(
				'var_name' => 'announcement_intro_' . $iId,
				'product_id' => 'phpfox',
				'module' => 'announcement|announcement',
				'text' => $aIntros
			)
		);

		$sContent = Phpfox::getService('language.phrase.process')->add(array(
				'var_name' => 'announcement_content_' . $iId,
				'product_id' => 'phpfox',
				'module' => 'announcement|announcement',
				'text' => $aContents
			)
		);
	
		$this->database()->update($this->_sTable, array('subject_var' => $sSubject, 'intro_var' => $sIntro, 'content_var' => $sContent), 'announcement_id = ' . $iId);
		
		$this->cache()->remove('announcements');
		$this->cache()->remove('locale', 'substr');
		return true;
	}

	public function editAnnouncement($iId, $aVal)
	{
	   
		if (!is_int($iId) || $iId < 1) return false;
		
		foreach ($aVal['subject'] as $sLanguage => $aSubject)
		{
			if ($aSubject['is_default'] == 1 && empty($aSubject['text']))
			{
			    return Phpfox_Error::set(Phpfox::getPhrase('announcement.subject_cannot_be_empty'));
			}
			Phpfox::getService('language.phrase.process')->updateVarName($sLanguage, 'announcement.announcement_subject_'.$iId, $aSubject['text']);
		}
		foreach ($aVal['intro'] as $sLanguage => $aIntro)
		{
			Phpfox::getService('language.phrase.process')->updateVarName($sLanguage, 'announcement.announcement_intro_'.$iId, $aIntro['text']);
		}
		foreach ($aVal['content'] as $sLanguage => $aContent)
		{
			if ($aContent['is_default'] == 1 && empty($aContent['text']))
			{
			    return Phpfox_Error::set(Phpfox::getPhrase('announcement.content_cannot_be_empty'));
			}
			Phpfox::getService('language.phrase.process')->updateVarName($sLanguage, 'announcement.announcement_content_'.$iId, $aContent['text']);
		}
		// update the active/inactive state
		$iStartDate = Phpfox::getLib('date')->convertToGmt(Phpfox::getLib('date')->mktime($aVal['start_hour'], $aVal['start_minute'], 0, $aVal['start_month'], $aVal['start_day'], $aVal['start_year']));
		$aUpdate = array(
			'is_active' => (int)$aVal['is_active'],
			'can_be_closed' => (int)$aVal['can_be_closed'],
			'show_in_dashboard' => (int)$aVal['show_in_dashboard'],
			'start_date' => $iStartDate,
			'age_from' => (int)$aVal['age_from'],
			'age_to' => (int)$aVal['age_to'],
			'country_iso' => $aVal['country_iso'],
			'gender' => (int)$aVal['gender'],
			'user_id' => (int) $aVal['user_id'],
			'user_group' => serialize(array()),
			'gmt_offset' => Phpfox::getLib('date')->getGmtOffset($iStartDate)
		);
		if (isset($aVal['is_user_group']) && $aVal['is_user_group'] == 2)
		{
			$aGroups = array();
			$aUserGroups = Phpfox::getService('user.group')->get();
			if (isset($aVal['user_group']))
			{
				foreach ($aUserGroups as $aUserGroup)
				{
					if (in_array($aUserGroup['user_group_id'], $aVal['user_group']))
					{
						$aGroups[] = $aUserGroup['user_group_id'];
					}
				}
			}
			$aUpdate['user_group'] = (count($aGroups) ? serialize($aGroups) : serialize(array()));
		}
		$iOldCanBeClosed = $this->database()
		    ->select('can_be_closed')
		    ->from($this->_sTable)
		    ->where('announcement_id = ' . $iId)
		    ->execute('getSlaveField');
		if ($iOldCanBeClosed != $aVal['can_be_closed'])
		{
		    $this->database()->delete(Phpfox::getT('announcement_hide'), 'announcement_id = ' . (int)$iId);
		}
		$this->database()->update($this->_sTable, $aUpdate, 'announcement_id = ' . $iId);
		$this->cache()->remove('announcements');
		$this->cache()->remove('locale', 'substr');
		return true;
	}

	/**
	 * Changes status of an announcement (active/inactive)
	 * @param <type> $iId
	 * @param <type> $NewiState
	 */
	public function setStatus($iId, $iNewState)
	{		
		$this->cache()->remove('announcements');
		if (intval($iNewState) == 0)
		{
			return $this->database()->update($this->_sTable, array(
					'is_active' => 0),
				'announcement_id = ' . (int)$iId);
		}
		elseif(intval($iNewState) == 1)
		{
			return $this->database()->update($this->_sTable, array(
					'is_active' => 1),
				'announcement_id = ' . (int)$iId);
		}
		return 'Problem: iId = ' . $iId . ' and iNewState: ' . $iNewState;
	}

	/**
	 * Hides an announcement for the current user
	 * @param <type> $iId
	 * @return <type>
	 */
	public function hide($iId)
	{
		Phpfox::isUser(true);
		
		$aAnnouncement = $this->database()->select('a.announcement_id, a.can_be_closed, ah.announcement_id AS is_seen')
			->from($this->_sTable, 'a')
			->leftJoin(Phpfox::getT('announcement_hide'), 'ah', 'ah.announcement_id = a.announcement_id AND ah.user_id = ' . Phpfox::getUserId())
			->where('a.announcement_id = ' . (int) $iId)
			->execute('getRow');
		
		if ($aAnnouncement['can_be_closed'] == 0)
		{
			return false;
		}
		if (!isset($aAnnouncement['announcement_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('announcement.announcement_not_found'));
		}
		
		if ($aAnnouncement['is_seen'])
		{
			return Phpfox_Error::set(Phpfox::getPhrase('announcement.announcement_is_already_hidden'));
		}
		
		$this->database()->insert(Phpfox::getT('announcement_hide'), array('announcement_id' => $aAnnouncement['announcement_id'], 'user_id' => Phpfox::getUserId()));
		//if (Phpfox::getParam('core.super_cache_system'))
        {
            $this->cache()->remove(array('announcement', Phpfox::getUserId()));
        }
		return true;
	}

	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('announcement.service_process__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>