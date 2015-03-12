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
 * @version 		$Id: announcement.class.php 6220 2013-07-09 06:55:41Z Miguel_Espinoza $
 */
class Announcement_Service_Announcement extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('language_phrase');
	}

	/**
	 * Gets an array of announcements for the current default language
	 * @deprecated
	 * @todo confirm this function is not used
	 * @return <type>
	 */
	public function get()
	{
		$aAnnouncements = $this->database()->select('a.*, ah.announcement_id AS is_seen')
		->from(Phpfox::getT('announcement'), 'a')
		->leftJoin(Phpfox::getT('announcement_hide'), 'ah', 'ah.announcement_id = a.announcement_id AND ah.user_id = ' . Phpfox::getUserId())
		->order('a.time_stamp DESC')
		->execute('getSlaveRows');

		if (empty($aAnnouncements))
		{
			return false;
		}

		foreach ($aAnnouncements as $iKey => $aAnnouncement)
		{
			// $aAnnouncements[$iKey]['posted_on'] = ((isset($aAnnouncement['user_id']) && $aAnnouncement['user_id'] > 0) ? Phpfox::getPhrase('announcement.posted_on_time_stamp_by_user') : Phpfox::getPhrase('announcement.posted_on_time_stamp'));
		}

		return $aAnnouncements;
	}

	/**
 * This function needs to get all the available announcements (is_active = 1) from database/cache
 *	Given that array, filter out based on the criteria given
 * @todo Think there was another cache file called 'announcement', check for duplicity
 * @param <type> $iId
 * @param <type> $bShowInDashboard
 * @param <type> $iDate
 * @return <type>
 */
	public function getLatest($iId = null, $bShowInDashboard = null, $iDate = null)
	{
		//if (is_int($iId) && $iId > 0) $sWhere .= ' AND a.announcement_id = ' . $iId;
		//if ($bShowInDashboard === true) $sWhere .= ' AND a.show_in_dashboard = 1';
		//if ($iDate !== null && is_int($iDate)) $sWhere .= ' AND a.start_date <= ' . (int)$iDate;
		$sCacheId = $this->cache()->set('announcements');

		if (!($aAnnouncements = $this->cache()->get($sCacheId)))
		{
			// for the isseen we'll need to query the database so we can take the leftjoin out of here.
			$aAnnouncements = $this->database()->select(Phpfox::getUserField() . ', a.*')
				->from(Phpfox::getT('announcement'), 'a')
				->leftjoin(Phpfox::getT('user'), 'u', 'a.user_id = u.user_id')
				->where('a.is_active = 1')
				->execute('getSlaveRows');

			$this->cache()->save($sCacheId, $aAnnouncements);
		}

		// get the announcements this user has decided to close
		$aHidden = array();
		$sCacheIdHide = $this->cache()->set(array('announcement', Phpfox::getUserId()));
		if (!($aHidden = $this->cache()->get($sCacheIdHide)))
		{
			$aHide = $this->database()->select('announcement_id')
				->from(Phpfox::getT('announcement_hide'))
				->where('user_id = ' . Phpfox::getUserId())
				->execute('getSlaveRows');			
			
			foreach ($aHide as $aH) 
			{
				$aHidden[] = $aH['announcement_id'];
			}
			
			$this->cache()->save($sCacheIdHide, $aHidden);
		}
		if (!is_array($aHidden))
		{
			$aHidden = array();
		}
		if (!is_array($aAnnouncements))
		{
		    return false;//$aAnnouncements = array($aAnnouncements);
		}
		
		foreach ($aAnnouncements as $iKey => $aAnnounce)
		{
			// we filter out the ones that do not apply to this user
			// get users age
			$iUsersAge = Phpfox::getService('user')->age(Phpfox::getUserBy('birthday'));
			// get the allowed user groups
			$aAllowedUsergroups = (false === unserialize($aAnnounce['user_group'])) ? array() : unserialize($aAnnounce['user_group']);
			
			$aAnnounce['start_date'] = Phpfox::getLib('date')->convertFromGmt($aAnnounce['start_date'], $aAnnounce['gmt_offset']);
			
			$aAnnounce['posted_on'] = ((isset($aAnnounce['user_id']) && $aAnnounce['user_id'] > 0) ? Phpfox::getPhrase('announcement.posted_on_time_stamp_by_user', array('item_time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aAnnounce['time_stamp']), 'user' => $aAnnounce)) : Phpfox::getPhrase('announcement.posted_on_time_stamp', array('item_time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time')))));			

			$bCheck1 = ($aAnnounce['country_iso'] == '' || $aAnnounce['country_iso'] == Phpfox::getUserBy('country_iso'));
			$bCheck2 = ($aAnnounce['age_from'] == 0 || ($aAnnounce['age_from'] <= $iUsersAge));
			$bCheck3 = ($aAnnounce['age_to'] == 0 || ($aAnnounce['age_to'] >= $iUsersAge));
			$bCheck4 = ($aAnnounce['gender'] == 0 || ($aAnnounce['gender'] == Phpfox::getUserBy('gender')));
			$bCheck5 = (sizeof($aAllowedUsergroups) == 0 || in_array(Phpfox::getUserBy('user_group_id'), $aAllowedUsergroups));
			$bCheck6 = ($iId === null || $aAnnounce['announcement_id'] == (int)$iId);
			$bCheck7 = ($bShowInDashboard === null || $aAnnounce['show_in_dashboard'] == 1);
			$bCheck8 = ($iDate === null || $aAnnounce['start_date'] <= $iDate);
			$bCheck9 = (empty($aHidden) || !in_array($aAnnounce['announcement_id'], $aHidden));
			
			//d($bCheck1, true);d($bCheck2, true);d($bCheck3, true);d($bCheck4, true);d($bCheck5, true);d($bCheck6, true);d($bCheck7, true);d($bCheck8, true);d($bCheck9, true);
			if ( $bCheck1
				&& $bCheck2
				&& $bCheck3
				&& $bCheck4
				&& $bCheck5
				&& $bCheck6
				&& $bCheck7
				&& $bCheck8
				&& $bCheck9
			)
			{
				if (is_int($iId) && $iId > 0) $aAnnounce['is_specific'] = 1;
				
				while (isset($aAnnouncements[$aAnnounce['start_date']]))
				{
					$aAnnounce['start_date']++;
				}
				$aAnnouncements[$aAnnounce['start_date']] = $aAnnounce; // add and sort by their start_date
				
			}			
			
			unset($aAnnouncements[$iKey]);
		}
		
		if (empty($aAnnouncements) || !is_array($aAnnouncements)) return false;
		krsort($aAnnouncements); // sorting by key, high to low
		//d(count($aAnnouncements), true);
		return ($aAnnouncements);
	}

	/**
	 *
	 * Gets the latest $iLatest announcements
	 * @param Integer $iLatest How many to show
	 * @param String $sLanguage language_id => 'en'
	 */
	public function getAnnouncementsByLanguage($iId = 0)
	{
		static $aAnnouncements = null;

		if ($aAnnouncements !== null)
		{
			return $aAnnouncements;
		}
		if ($iId > 0) $this->database()->where('a.announcement_id = ' . (int)$iId);
		$aAnnouncements = $this->database()->select('a.*')
		->from(Phpfox::getT('announcement'), 'a')
		->order('a.time_stamp DESC')
		->execute('getSlaveRows');

		$aOut = array();
		foreach ($aAnnouncements as $aAnnounce)
		{
			$aOut[$aAnnounce['announcement_id']]['subject_var'] = ($aAnnounce['subject_var']);
			$aOut[$aAnnounce['announcement_id']]['intro_var'] = ($aAnnounce['intro_var']);
			$aOut[$aAnnounce['announcement_id']]['content_var'] = ($aAnnounce['content_var']);
			$aOut[$aAnnounce['announcement_id']]['time_stamp'] = (int)$aAnnounce['time_stamp'];
			$aOut[$aAnnounce['announcement_id']]['announcement_id'] = $aAnnounce['announcement_id'];
		}
		return $aOut;
	}

	public function getAnnouncementById($iId)
	{
		
		$aAnnouncement = $this->database()->select(Phpfox::getUserField() . ', a.*, lf.phrase_id, lf.language_id, lf.text, lf.var_name, l.title, l.is_default')
		    ->from(Phpfox::getT('language_phrase'), 'lf')
		    ->join(Phpfox::getT('language'), 'l', 'l.language_id = lf.language_id')
		    ->join(Phpfox::getT('announcement'), 'a', 'a.announcement_id = ' . (int)$iId)
		    ->leftjoin(Phpfox::getT('user'), 'u', 'u.user_id = a.user_id')
		    ->where('var_name = \'announcement_subject_' . $iId .'\' OR var_name = \'announcement_content_' . $iId .'\' OR var_name = \'announcement_intro_' . $iId .'\'')
		    //->group('l')
		    ->execute('getSlaveRows');

		if (!count($aAnnouncement) || !is_array($aAnnouncement))
		{
			return false;
		}	
		

		$aOut = reset($aAnnouncement);
		
		$aOut['start_date'] = Phpfox::getLib('date')->convertFromGmt($aOut['start_date'], $aOut['gmt_offset']);
		
		$aOut = array_merge($aOut,array(
				'announcement_id' => $iId,
				'start_month' => date('n', $aOut['start_date']),
				'start_day' => date('j', $aOut['start_date']),
				'start_hour' => date('H', $aOut['start_date']),
				'start_year' => date('Y', $aOut['start_date']),
				'start_minute' => date('i', $aOut['start_date'])			
			)
		);

		if (!empty($aOut['user_group']))
		{
			$aOut['user_group'] = unserialize($aOut['user_group']);
			if (count($aOut['user_group']))
			{
				$aOut['is_user_group'] = 2;
			}
		}

		foreach ($aAnnouncement as $aAnn)
		{
		    $aOut['language'][$aAnn['language_id']]['title'] = $aAnn['title'];
		    $aOut['language'][$aAnn['language_id']]['language_id'] = $aAnn['language_id'];
		    $aOut['language'][$aAnn['language_id']]['is_default'] = $aAnn['is_default'];
		    
		    if (strpos($aAnn['var_name'], 'announcement_content_') !== false)
		    {
		        $aOut['language'][$aAnn['language_id']]['content'] = $aAnn['text'];
		        
			/*$aOut['content'][$aAnn['announcement_id']]['text'] = $aAnn['text'];
				$aOut['content'][$aAnn['announcement_id']]['title'] = $aAnn['title'];
				$aOut['content'][$aAnn['announcement_id']]['language_id'] = $aAnn['language_id'];
			 * */
			 
		    }
		    elseif(strpos($aAnn['var_name'], 'announcement_intro_') !== false)
		    {
			 $aOut['language'][$aAnn['language_id']]['intro'] = $aAnn['text'];
				
		    }
		    elseif(strpos($aAnn['var_name'], 'announcement_subject_') !== false)
		    {
			 $aOut['language'][$aAnn['language_id']]['subject'] = $aAnn['text'];
				
		    }
		}		

		return $aOut;
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
		if ($sPlugin = Phpfox_Plugin::get('announcement.service_announcement__call'))
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