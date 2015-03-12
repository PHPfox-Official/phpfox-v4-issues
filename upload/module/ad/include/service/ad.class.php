<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Ad Service
 * Handles all requests to the ad database tables.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Module_Ad
 * @version 		$Id: ad.class.php 7269 2014-04-14 16:20:22Z Fern $
 */
class Ad_Service_Ad extends Phpfox_Service 
{
	/**
	 * Class constructor.
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('ad');	
	}
	
	public function getSectionMenu()
	{
		$oUrl = Phpfox::getLib('url');
		
		$aFilterMenu = array(
			Phpfox::getPhrase('ad.manage_ads') => 'ad.manage',
			Phpfox::getPhrase('ad.manage_invoices') => 'ad.invoice',
			Phpfox::getPhrase('ad.manage_sponsorships') => 'ad.manage-sponsor',
		);		
		
		Phpfox::getLib('template')->buildSectionMenu('ad', $aFilterMenu);			
	}
	
	/**
	 * Receives a list of items and returns an array with the items to show depending on the viewer.
	 * 
	 * @param array $aAds Ads to filter.
	 * @return array ARRAY of ads.
	 */
	public function filterSponsor(&$aAds)
	{
		if (empty($aAds) || !is_array($aAds))
		{
			return array();
		}
		$aOut = array();
		foreach ($aAds as $iKey => $aAd)
		{
			if ($aAd['impressions'] > 0 && $aAd['total_view'] > 0 && $aAd['impressions'] < $aAd['total_view'])
			{
				unset($aAds[$iKey]);
				continue;
			}
			
			if (!empty($aAd['sponsor_country_iso']))
			{
				$aAd['country_iso'] = $aAd['sponsor_country_iso'];
			}

			if (!empty($aAd['country_iso']) && Phpfox::isUser() && $aAd['country_iso'] != Phpfox::getUserBy('country_iso'))
			{
				unset($aAds[$iKey]);

				continue;
			}

			if (!empty($aAd['gender']) && Phpfox::isUser() && $aAd['gender'] != Phpfox::getUserBy('gender'))
			{
				unset($aAds[$iKey]);

				continue;
			}

			if (!empty($aAd['age_from'])
				&& !empty($aAd['age_to'])
				&& Phpfox::isUser()
				&& ($aAd['age_from'] > Phpfox::getUserBy('age') || $aAd['age_to'] < Phpfox::getUserBy('age'))
			)
			{
				unset($aAds[$iKey]);

				continue;
			}			

			if ($aAd['start_date'] > PHPFOX_TIME)
			{
				unset($aAds[$iKey]);

				continue;
			}
			$aOut[] = $aAd;
		}
		return $aOut;
	}

	/**
	 * Get ads for a specific user.
	 *
	 * @param array $aCond SQL conditions.
	 * @return array ARRAY of ads for the user.
	 */
	public function getForUser($aCond)
	{
		$aAds = $this->database()->select('a.*')	
			->from(Phpfox::getT('ad'), 'a')
			->where($aCond)
			->order('ad_id DESC')
			->execute('getSlaveRows');
			
		foreach ($aAds as $iKey => $aAd)
		{
			$this->_build($aAds, $iKey, $aAd);		
		}
			
		return $aAds;
	}

	/**
	 * Get sponsored ads for a specific user.
	 *
	 * @param array $aCond SQL condition.
	 * @return array ARRAY of ads.
	 */
	public function getSponsorForUser($aCond)
	{
		$aAds = $this->database()->select('s.*')
			->from(Phpfox::getT('ad_sponsor'), 's')
			->where($aCond)
			->order('sponsor_id DESC')
			->execute('getSlaveRows');

		foreach ($aAds as $iKey => &$aAd)
		{
		    $aAd['count_view'] = $aAd['total_view'];
		    $aAd['count_click'] = $aAd['total_click'];
		    $this->_build($aAds, $iKey, $aAd);
		}
		
		return $aAds;
	}

	/**
	 * Get ads from the main table based on SQL conditions.
	 *
	 * @param array $aConds SQL conditions.
	 * @param string $sSort SQL sorting.
	 * @param int $iPage Current page we are on.
	 * @param int $iLimit Limit of ads to display per page.
	 * @return array 1st value is the total ads found, 2nd value is an ARRAY of all the ads we found.
	 */
	public function get($aConds, $sSort = 'ad_id DESC', $iPage = '', $iLimit = '')
	{
	    (($sPlugin = Phpfox_Plugin::get('ad.service_ad_get__start')) ? eval($sPlugin) : false);
	    
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where($aConds)
			->execute('getField');	    
	    
		$aAds = $this->database()->select('*')
			->from($this->_sTable)
			->where($aConds)
			->order($sSort)
			->limit($iPage, $iLimit, $iCnt)
			->execute('getRows');
			
		foreach ($aAds as $iKey => $aAd)
		{
			$this->_build($aAds, $iKey, $aAd);
		}
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_get__end')) ? eval($sPlugin) : false);
		
		return array($iCnt, $aAds);
	}

	/**
	 * Get sponsored ads from the main table based on SQL conditions.
	 *
	 * @param array $aConds SQL conditions.
	 * @param string $sSort SQL sorting.
	 * @param int $iPage Current page we are on.
	 * @param int $iLimit Limit of ads to display per page.
	 * @return array 1st value is the total ads found, 2nd value is an ARRAY of all the ads we found.
	 */	
	public function getAdSponsor($aConds, $sSort = 'sponsor_id DESC', $iPage = '', $iLimit = '')
	{
	    (($sPlugin = Phpfox_Plugin::get('ad.service_ad_getadsponsor__start')) ? eval($sPlugin) : false);

		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('ad_sponsor'), 's')
			->where($aConds)
			->execute('getField');

		$aAds = $this->database()->select('s.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('ad_sponsor'), 's')
			->leftjoin(Phpfox::getT('user'), 'u', 'u.user_id = s.user_id')
			->where($aConds)
			->order($sSort)
			->limit($iPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aAds as $iKey => &$aAd)
		{
			$aAd['count_view'] = $aAd['total_view'];
			$aAd['total_view'] = $aAd['impressions'];
			$aAd['count_click'] = $aAd['total_click'];
			$this->_build($aAds, $iKey, $aAd);			
		}
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_get__end')) ? eval($sPlugin) : false);

		return array($iCnt, $aAds);
	}

	/**
	 * Gets ads based on the location (not the block id but the identifier -string-)
	 *
	 * @param string $sPosition
	 * @return array 
	 */
	public function getForLocation($sPosition)
	{
		if (empty($sPosition))
		{
			return false;
		}
		
		$sCacheId = $this->cache()->set('ad_' . md5($sPosition));
		if (!($aAds = $this->cache()->get($sCacheId, Phpfox::getParam('ad.ad_cache_limit'))))
		{
			$aAds = $this->database()->select('*')
					->from($this->_sTable)
					->where('location = "' . Phpfox::getLib('parse.input')->clean(str_replace('.','|',$sPosition)) . '"')
					->execute('getSlaveRows');

			$this->cache()->save($sCacheId, $aAds);
		}
		
		if (is_array($aAds) != true || empty($aAds))
		{
			return array();
		}
		$aAd = $aAds[rand(0, count($aAds)-1)];
		return $aAd;
	}
	
	/**
	 * Get ads based on the block positioning.
	 *
	 * @param int $iId Block ID#.
	 * @return mixed NULL returned if ads cannot be viewed by the user. FALSE is returned if no ads exists. An ARRAY of ads are returned of ads exist for the specific block.
	 */
	public function getForBlock($iId, $bAll = false, $bUpdateCounter = true)
	{			
	    static $aCacheAd = array();
	    
	    if (Phpfox::getParam('ad.multi_ad'))
	    {
			if ($iId != 3 && $iId != 50)
			{
				return false;				
			}
			$iId = 50;
		}
	    
	    if (isset($aCacheAd[$iId]))
	    {			
			return $aCacheAd[$iId];	
	    }	    
		
		if (Phpfox::getService('profile')->timeline() && $iId == '1')
		{
			$aCacheAd[$iId] = array();
			
			return $aCacheAd[$iId];
		}		
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_getforblock__start')) ? eval($sPlugin) : false);
		
		$sCacheId = $this->cache()->set('ad_' . (int) $iId);

		if (Phpfox::getUserGroupParam(Phpfox::getUserBy('user_group_id'), 'ad.show_ads') == false)
		{
			$aCacheAd[$iId] = array();
			
			return array();
		}
		
		if (!($aAds = $this->cache()->get($sCacheId, Phpfox::getParam('ad.ad_cache_limit'))))
		{
			$aRows = $this->database()->select('a.*, ac.child_id, ac.country_id')
				->from($this->_sTable, 'a')
				->leftjoin(Phpfox::getT('ad_country'), 'ac', 'ac.ad_id = a.ad_id')
				->where('a.is_active = 1 AND a.location = \'' . $this->database()->escape($iId) . '\'')
				->execute('getRows');			
			$aAds = array();
			
			$aIn = array();
			foreach ($aRows as $iKey => $aAd)
			{
				if (!isset($aAds[$aAd['ad_id']]))
				{
					$aAds[$aAd['ad_id']] = $aAd;
					$aAds[$aAd['ad_id']]['country_child_id'] = array();
					$aAds[$aAd['ad_id']]['countries_list'] = array();
					unset($aAds[$aAd['ad_id']]['country_id']);
				}
				if (isset($aAd['child_id']) && !empty($aAd['child_id']))
				{
					$aAds[$aAd['ad_id']]['country_child_id'][] = $aAd['child_id'];
					unset($aAds[$aAd['ad_id']]['child_id']);
				}
				if (isset($aAd['country_id']) && !empty($aAd['country_id']))
				{
					$aAds[$aAd['ad_id']]['countries_list'][$aAd['country_id']] = $aAd['country_id'];
				}
				if ($aAd['location'] == 50)
				{
					$aContent = json_decode($aAd['html_code'], true);
					$aAds[$aAd['ad_id']]['body'] = $aContent['body'];
					$aAds[$aAd['ad_id']]['title'] = $aContent['title'];
					$aAds[$aAd['ad_id']]['trimmed_url'] = str_replace('http://', '', $aAd['url_link']);
				}
				
				// http://www.phpfox.com/tracker/view/15397/
				if (!empty($aAd['disallow_controller']))
				{
					$sControllerName = Phpfox::getLib('module')->getFullControllerName();
					$aParts = explode(',', $aAd['disallow_controller']);
					foreach ($aParts as $sPart)
					{
						$sPart = trim($sPart);
						// str_replace for marketplace.invoice/index
						// str_replace for music.browse/album 
						if ($sControllerName == $sPart || (str_replace('/index','', $sControllerName) == $sPart) || (str_replace('/','.', $sControllerName) == $sPart))
						{
							unset($aAds[$aAd['ad_id']]);
						}
					}
				}
			}

			$this->cache()->save($sCacheId, $aAds);
		}		

        if ($sPlugin = Phpfox_Plugin::get('ad.service_ad_getforblock__1')){eval($sPlugin);}
        
		if (!is_array($aAds) || (is_array($aAds) && !count($aAds)))
		{
			$aCacheAd[$iId] = array();
			
			return array();
		}
		
		foreach ($aAds as $iKey => $aAd)
		{
			// Check for Postal Code and for City
			if (Phpfox::getParam('ad.advanced_ad_filters') && Phpfox::getUserBy('postal_code') != '' && !empty($aAd['postal_code']) && strpos($aAd['postal_code'], Phpfox::getUserBy('postal_code')) === false)
			{
				unset($aAds[$iKey]);
			}

			if (Phpfox::getParam('ad.advanced_ad_filters') && !empty($aAd['postal_code']) && Phpfox::getUserBy('postal_code') == '')
			{
				unset($aAds[$iKey]);
			}

			if (Phpfox::getParam('ad.advanced_ad_filters') && !empty($aAd['country_iso']) &&
				(
					(isset($aAd['city_location']) && !empty($aAd['city_location']) && Phpfox::getUserBy('city_location') != false && strpos($aAd['city_location'], Phpfox::getUserBy('city_location')) === false) ||
					(isset($aAd['postal_code']) && !empty($aAd['postal_code']) && Phpfox::getUserBy('postal_code') != false && strpos($aAd['postal_code'], Phpfox::getUserBy('postal_code')) === false) 
				)
			)
			{
				unset($aAds[$iKey]);
			}
			else if (Phpfox::getParam('ad.advanced_ad_filters') && isset($aAd['city_location']) && !empty($aAd['city_location']) && Phpfox::getUserBy('city_location') == false)
			{
				unset($aAds[$iKey]);
			}
			
			if ($aAd['is_cpm'] == 1 && $aAd['total_view'] > 0 && $aAd['count_view'] >= $aAd['total_view'])
			{
				unset($aAds[$iKey]);
			}		
			if ($aAd['is_cpm'] != 1 && $aAd['total_click'] > 0 && $aAd['count_click'] >= $aAd['total_click'])
			{
				unset($aAds[$iKey]);
			}

			if (!empty($aAd['country_iso']) && Phpfox::isUser() && $aAd['country_iso'] != Phpfox::getUserBy('country_iso') && Phpfox::getUserBy('country_iso') != '')
			{
				unset($aAds[$iKey]);
			}
			
			if (isset($aAd['countries_list']) && !empty($aAd['countries_list']) && Phpfox::isUser())
			{				
				$bKeep = false;
				$iCountryChildId = Phpfox::getUserBy('country_child_id');
				foreach ($aAd['countries_list'] as $sCountry)
				{
					if (
						($sCountry == Phpfox::getUserBy('country_iso')) &&
						(empty($aAd['country_child_id']))
					)
					{
						$bKeep = true;
						break;
					}

					if (
						($sCountry == Phpfox::getUserBy('country_iso')) &&
						(!empty($aAd['country_child_id']) && Phpfox::getParam('ad.advanced_ad_filters') && in_array($iCountryChildId, $aAd['country_child_id']))
					)
					{
						$bKeep = true;
						break;
					}
				}
				
				if ($bKeep != true)
				{
					unset($aAds[$iKey]);
				}
			}
			
			if (!empty($aAd['gender']) && Phpfox::isUser() && $aAd['gender'] != Phpfox::getUserBy('gender'))
			{
				unset($aAds[$iKey]);
			}			
			
			if (!empty($aAd['age_from']) 
				&& !empty($aAd['age_to']) 
				&& Phpfox::isUser()
				&& ($aAd['age_from'] > Phpfox::getUserBy('age') || $aAd['age_to'] < Phpfox::getUserBy('age'))
			)
			{
				unset($aAds[$iKey]);
			}
			
			if (!empty($aAd['user_group']) && Phpfox::getLib('parse.format')->isSerialized($aAd['user_group']))
			{
				if (!in_array(Phpfox::getUserBy('user_group_id'), unserialize($aAd['user_group'])))
				{
					unset($aAds[$iKey]);
				}
			}
			
			if (!empty($aAd['module_access']) && $aAd['module_access'] != Phpfox::getLib('module')->getModuleName())
			{
				unset($aAds[$iKey]);
			}			
			
			if ($aAd['start_date'] > PHPFOX_TIME)
			{				
				unset($aAds[$iKey]);
			}
			
			if (!empty($aAd['end_date']) && $aAd['end_date'] < PHPFOX_TIME)
			{				
				unset($aAds[$iKey]);
			}
			
			// This requires more code so its best to be put at the end
			$sCityInDB = strtolower($aAd['city_location']);
			$sCityUser = strtolower(Phpfox::getUserBy('city_location'));
			if (Phpfox::getParam('ad.advanced_ad_filters') && !empty($aAd['country_iso']) && !empty($sCityInDB) && !empty($sCityUser) && strpos($sCityInDB, $sCityUser) === false)
			{
				unset($aAds[$iKey]);
			}

			if (Phpfox::getParam('ad.advanced_ad_filters') && !empty($aAd['country_iso']) && !empty($sCityInDB) && empty($sCityUser))
			{
				unset($aAds[$iKey]);
			}
		}
		
		
		if (!count($aAds))
		{
			$aCacheAd[$iId] = array();
			
			return array();
		}
		
		$iTotal = (Phpfox::getParam('ad.how_many_ads_per_location') > count($aAds) ? count($aAds) : Phpfox::getParam('ad.how_many_ads_per_location'));
		
		if (Phpfox::getParam('ad.multi_ad') != true && $iTotal < count($aAds) && Phpfox::getParam('ad.how_many_ads_per_location') > 0)
		{
			shuffle($aAds);
			$aAds = array_slice($aAds,0,$iTotal);
		}
		else if (Phpfox::getParam('ad.multi_ad') && count($aAds) > Phpfox::getParam('ad.ad_multi_ad_count'))
		{
			shuffle($aAds);
			$aAds = array_slice($aAds, 0, Phpfox::getParam('ad.ad_multi_ad_count'));
		}
		
		if ($bAll)
		{
			foreach ($aAds as $aAd)
			{
				if ($bUpdateCounter)
				{
					$this->database()->updateCounter('ad', 'count_view', 'ad_id', $aAd['ad_id']);
					if ( ($aAd['is_cpm'] == 1 && $aAd['count_view'] >= $aAd['total_view'] && $aAd['total_view'] != 0) ||
						($aAd['is_cpm'] != 1 && $aAd['count_click'] >= $aAd['total_click'] && $aAd['total_click'] != 0))
					{
						
						$this->database()->update(Phpfox::getT('ad'), array('is_active' => '0'), 'ad_id = ' . (int)$aAd['ad_id']);
						
					}
				}
			}			
			$aCacheAd[$iId] = $aAds;
			return $aAds;
		}
		sort($aAds);
		shuffle($aAds);	
		
		$aAd = $aAds[mt_rand(0, (count($aAds) - 1))];
		if ($bUpdateCounter)
		{
			$this->database()->updateCounter('ad', 'count_view', 'ad_id', $aAd['ad_id']);
		}
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_getforblock__end')) ? eval($sPlugin) : false);
				
		return $aAd;
	}	
	
	/**
	 * Get an ads redirection URL and update the "click" count for the ad.
	 *
	 * @param int $iId ID# for the ad.
	 * @return string URL of the ad, which can be used to send the user to that page.
	 */
	public function getAdRedirect($iId)
	{
	    (($sPlugin = Phpfox_Plugin::get('ad.service_ad_getadredirect__start')) ? eval($sPlugin) : false);
	    
		$aAd = $this->database()->select('ad_id, location, url_link, is_cpm, total_click, count_click')
			->from($this->_sTable)
			->where('ad_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aAd['ad_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('ad.the_ad_you_are_looking_for_does_not_exist'));
		}
		$this->cache()->remove('ad_' . $aAd['location']);
		if ( ($aAd['is_cpm'] != 1 && $aAd['count_click'] >= $aAd['total_click']))
		{			
			$this->database()->update(Phpfox::getT('ad'), array('is_active' => '0'), 'ad_id =' . $aAd['ad_id']);
			return Phpfox_Error::set(Phpfox::getPhrase('ad.the_ad_you_are_looking_for_does_not_exist'));
		}
		
		$aTrack = $this->database()->select('track_id')
			->from(Phpfox::getT('ad_track'))
			->where((Phpfox::isUser() ? 'ad_id = ' . $aAd['ad_id'] . ' AND user_id = ' . Phpfox::getUserId() : 'ad_id = ' . $aAd['ad_id'] . ' AND ip_address = \'' . $this->database()->escape(Phpfox::getIp()) . '\''))
			->execute('getRow');
			
		if (!isset($aTrack['track_id']))
		{		
			$this->database()->updateCounter('ad', 'count_click', 'ad_id', $aAd['ad_id']);
			
			$this->database()->insert(Phpfox::getT('ad_track'), array(
					'ad_id' => $aAd['ad_id'],
					'user_id' => Phpfox::getUserId(),
					'ip_address' => Phpfox::getIp(),
					'time_stamp' => PHPFOX_TIME
				)
			);
		}
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_getadredirect__end')) ? eval($sPlugin) : false);
		
		return $aAd['url_link'];
	}
	
	/**
	 * Get an ad for editing.
	 *
	 * @param int $iId Ad ID#.
	 * @return mixed FALSE if ad does not exist, ARRAY if ad exists.
	 */
	public function getForEdit($iId)
	{		
		static $aAd = null;
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_getforedit__start')) ? eval($sPlugin) : false);
		
		if (isset($aAd['ad_id']))
		{
			return $aAd;
		}
		
		$aAd = $this->database()->select('*')
			->from($this->_sTable)
			->where('ad_id = ' . (int) $iId)
			->execute('getRow');
		
		if (!isset($aAd['ad_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('ad.unable_to_find_this_ad'));
		}	
		
		$aTemp = $this->database()->select('cc.child_id')
			->from(Phpfox::getT('country_child'), 'cc')
			->join(Phpfox::getT('ad_country'), 'a', 'a.child_id = cc.child_id')
			->where('a.ad_id = ' . $aAd['ad_id'])
			->execute('getSlaveRows');
		foreach ($aTemp as $aState)
		{
			$aAd['province'][] = $aState['child_id'];
		}
		
		if (empty($aAd['country_iso']))
		{
			$aCountries = $this->database()->select('country_id')->from(Phpfox::getT('ad_country'))->where('ad_id = ' . $aAd['ad_id'])->execute('getSlaveRows');
			if (!empty($aCountries))
			{
				$aAd['countries_list'] = array();
				foreach ($aCountries as $aCountry)
				{
					$aAd['countries_list'][] = $aCountry['country_id'];
				}
			}
		}
		else
		{
			$aAd['countries_list'] = array($aAd['country_iso']);
		}
		
		$aAd['start_date'] = Phpfox::getLib('date')->convertFromGmt($aAd['start_date'], $aAd['gmt_offset']);		
				
		$aAd['start_month'] = date('n', $aAd['start_date']);
		$aAd['start_day'] = date('j', $aAd['start_date']);
		$aAd['start_year'] = date('Y', $aAd['start_date']);
		$aAd['start_hour'] = date('H', $aAd['start_date']);
		$aAd['start_minute'] = date('i', $aAd['start_date']);
		
		if (!empty($aAd['end_date']))
		{
			$aAd['end_month'] = date('n', $aAd['end_date']);
			$aAd['end_day'] = date('j', $aAd['end_date']);
			$aAd['end_year'] = date('Y', $aAd['end_date']);
			$aAd['end_hour'] = date('H', $aAd['end_date']);
			$aAd['end_minute'] = date('i', $aAd['end_date']);
			
			$aAd['end_option'] = true;	
		}
		
		if (empty($aAd['total_view']))
		{
			$aAd['view_unlimited'] = true;
		}
		
		if (empty($aAd['total_click']))
		{
			$aAd['click_unlimited'] = true;
		}		
		
		if (!empty($aAd['user_group']))
		{
			$aAd['user_group'] = unserialize($aAd['user_group']);
			$aAd['is_user_group'] = 2;
		}
		
		if ((int) $aAd['total_view'] === 0)
		{
			$aAd['total_view'] = '';
		}
		
		if ((int) $aAd['total_click'] === 0)
		{
			$aAd['total_click'] = '';
		}		
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_getforedit__end')) ? eval($sPlugin) : false);
        
		if (!empty($aAd['postal_code']))
		{
			$aAd['postal_code'] = implode(',',json_decode($aAd['postal_code']));
		}
                    
		if (!empty($aAd['city_location']))
		{
			$aAd['city_location'] = implode(',',json_decode($aAd['city_location']));
		}
							
		return $aAd;	
	}
	
	/**
	 * Get the default supported ad sizes for a specific block.
	 *
	 * @param int $iBlockId Block ID#.
	 * @return string Comma seperated list of supported ad sizes in pixels.
	 */
	public function getSizes($iBlockId)
	{
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_getsizes__start')) ? eval($sPlugin) : false);

		static $aSizes = null;
		
		$sSizes = '';
		if ($aSizes === null)
		{			
			$aSizes = Phpfox::getLib('xml.parser')->parse(file_get_contents(str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, Phpfox::getLib('template')->getStyle('xml', 'ad.xml'))));
		}
		
		if (is_array($aSizes['block' . (int) $iBlockId]))
		{
			foreach ($aSizes['block' . (int) $iBlockId] as $sDimension)
			{
				$sSizes .= trim($sDimension). ', ';
			}
			$sSizes = trim(rtrim($sSizes, ', '));
		}
		else
		{
			$sSizes = trim($aSizes['block' . (int) $iBlockId]);
		}		
			
		if (defined('PHPFOX_NO_WINDOW_CLICK'))
		{
			$aPlan = $this->getPlan($iBlockId);
			
			if ($aPlan === false)
			{
				return false;
			}
			
			$aParts = explode(',', $sSizes);
			$sSizes = '';
			foreach ($aParts as $sSize)
			{
				$sSizes .= '<a href="#" onclick="window.parent.$(\'#location\').val(' . $iBlockId . '); window.parent.$Core.Ad.blockPlacementCallback(\'' . $sSize . '\', \'' . $iBlockId . '\'); window.parent.tb_remove();">' . $sSize . '</a>, ';
			}
			$sSizes = trim($sSizes);
			$sSizes = rtrim($sSizes, ',');
		}
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_getsizes__end')) ? eval($sPlugin) : false);
		
		return $sSizes;
	}
	
	public function getSizeForBlock($iBlock)
	{
		static $aSizes = null;
		
		$sSizes = '';
		if ($aSizes === null)
		{			
			$aSizes = Phpfox::getLib('xml.parser')->parse(file_get_contents(str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, Phpfox::getLib('template')->getStyle('xml', 'ad.xml'))));
		}		
		
		if (isset($aSizes['block' . $iBlock]))
		{
			return ' (' . $aSizes['block' . $iBlock] . ')';
		}
	}

	/**
	 * Gets a record from the ad_sponsor table.
	 * 
	 * @param int $iId
	 * @param int|null $iUser 
	 * @return array|bool Information about the ad.|FALSE if the ad is not found.
	 */
	public function getSponsor($iId, $iUser = null)
	{
		$aSponsor = $this->database()->select('*')
		    ->from(Phpfox::getT('ad_sponsor'),'s')
		    ->leftjoin(Phpfox::getT('ad_invoice'),'ai', 'ai.ad_id = s.sponsor_id')
		    ->where( (($iUser !== null) ? ('s.user_id = ' . (int)$iUser . ' AND ') : '') . 'sponsor_id = ' . (int)$iId)
		    ->execute('getSlaveRow');

		if (empty($aSponsor))
		{
			return false;
		}
		
		$sModule = $aSponsor['module_id'];
		$sFunction = 'getToSponsorInfo';
		if (strpos($sModule, '-') !== false)
		{
		    $aModule = explode('-',$sModule);
		    $sModule = $aModule[0];
		    $sFunction = 'getToSponsor' . ucwords($aModule[1]) . 'Info';
		}
		
		$aItem = Phpfox::callback($sModule. '.'.$sFunction, $aSponsor['item_id']);
		
		$aSponsor['paypal_msg'] = $aItem['paypal_msg'];
		
		return $aSponsor;

	}

	/**
	 * Get a payment plan based on a blocks position from the table "ad_plan".
	 *
	 * @param string $sBlockId Block ID#.
	 * @return bool|array FALSE if the plan does not exist.|Information about the plan.
	 */
	public function getPlan($sBlockId, $bIsBlock = true)
	{
		static $aPlan = array();

		if (!isset($aPlan[$sBlockId]))
		{		
			$aPlan[$sBlockId] = $this->database()->select('*')
				->from(Phpfox::getT('ad_plan'))
				->where( ($bIsBlock ? 'block_id' : 'plan_id') . ' = ' . (int) $sBlockId . ' AND is_active = 1')
				->execute('getSlaveRow');

			if (!isset($aPlan[$sBlockId]['plan_id']))
			{
				$aPlan[$sBlockId] = false;
			}
			else 
			{
				if (!empty($aPlan[$sBlockId]['cost']) && Phpfox::getLib('parse.format')->isSerialized($aPlan[$sBlockId]['cost']))
				{
					$aCosts = unserialize($aPlan[$sBlockId]['cost']);	
					$iLastCost = 0;
					$iLastCurrency = null;
					foreach ($aCosts as $sKey => $iCost)
					{
						if (Phpfox::getService('core.currency')->getDefault() == $sKey)
						{
							$aPlan[$sBlockId]['default_cost'] = $iCost;
							$aPlan[$sBlockId]['default_currency_id'] = $sKey;
						}						
					}					
				}					
			}
		}				
		
		return $aPlan[$sBlockId];
	}
	
	/**
	 * Get all the plans from the table "ad_plan".
	 *
	 * @param bool $bKey TRUE to create a key for each row based on the block ID the plan is assigned to.
	 * @return array List of all the plans.
	 */
	public function getPlans($bKey = false)
	{
		$aPlans = $this->database()->select('*')
			->from(Phpfox::getT('ad_plan'))
			->execute('getRows');
			
		if ($bKey === true)
		{
			$aCache = $aPlans;
			$aPlans = array();
			foreach ($aCache as $aPlan)
			{
				$aPlans[$aPlan['block_id']] = $aPlan;	
			}
			unset($aCache);
		}
			
		return $aPlans;
	}
	
	/**
	 * Get an invoice based on the ad ID# from the table "ad_invoice".
	 *
	 * @param int $iAdId Ad ID#.
	 * @return array|bool Information about the invoice.|FALSE if we are unable to find the invoice.
	 */
	public function getInvoice($iAdId)
	{
		$aInvoice = $this->database()->select('*')
			->from(Phpfox::getT('ad_invoice'))
			->where('ad_id = ' . (int) $iAdId . ' AND is_sponsor = 0')
			->execute('getSlaveRow');
			
		return (isset($aInvoice['invoice_id']) ? $aInvoice : false);	
	}
	
	/**
	 * Get invoices based on SQL conditions from the table "ad_invoice".
	 *
	 * @param string $aConds SQL conditions.
	 * @param string $sSort SQL sorting.
	 * @param int $iPage Page we are on.
	 * @param int $iLimit Total invoices to display per page.
	 * @return array 1st value is the total invoices, 2nd value is the ARRAY of invoices.
	 */
	public function getInvoices($aConds, $sSort = 'time_stamp DESC', $iPage = '', $iLimit = '')
	{	    
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('ad_invoice'), 'ai')
			->where($aConds)
			->execute('getSlaveField');	    
	    
		$aAds = $this->database()->select('ai.*')
			->from(Phpfox::getT('ad_invoice'), 'ai')
			->leftJoin(Phpfox::getT('ad'), 'a', 'a.ad_id = ai.ad_id')
			->where($aConds)
			->order($sSort)
			->limit($iPage, $iLimit, $iCnt)
			->execute('getSlaveRows');	
			
		foreach ($aAds as $iKey => $aAd)
		{
			switch ($aAd['status'])
			{
				case 'completed':
					$aAds[$iKey]['status_phrase'] = Phpfox::getPhrase('ad.paid');	
					break;
				case 'cancel':
					$aAds[$iKey]['status_phrase'] = Phpfox::getPhrase('ad.cancelled');	
					break;
				case 'pending':
					$aAds[$iKey]['status_phrase'] = Phpfox::getPhrase('ad.pending_payment');	
					break;					
				default:
					$aAds[$iKey]['status_phrase'] = Phpfox::getPhrase('ad.pending_payment');	
					break;
			}			
		}
		
		return array($iCnt, $aAds);
	}
	
	/**
	 * Get all the pending ads from the table "ad".
	 *
	 * @return int
	 */
	public function getPendingCount()
	{
		return $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('ad'))
			->where('is_custom = 2')
			->execute('getSlaveField');
	}
	
	/**
	 * Get all the plans from the table "ad_plan".
	 *
	 * @return array
	 */
	public function getPlacements()
	{
		return $this->database()->select('ap.*, COUNT(DISTINCT a.ad_id) AS total_campaigns')
			->from(Phpfox::getT('ad_plan'), 'ap')
			->leftJoin(Phpfox::getT('ad'), 'a', 'a.is_custom = 3 AND a.location = ap.block_id')
			->group('ap.plan_id')
			->execute('getSlaveRows');
	}
	
	/**
	 * Get a specific ad placement plan.
	 *
	 * @param int $iId Plan ID#.
	 * @return array|bool Information about the plan.|FALSE if we cannot find the plan.
	 */
	public function getPlacement($iId)
	{
		$aRow = $this->database()->select('*')
			->from(Phpfox::getT('ad_plan'))
			->where('plan_id = ' . (int) $iId)
			->execute('getSlaveRow');
						
		return (isset($aRow['plan_id']) ? $aRow : false);
	}	
	
	/**
	 * Builds an ad campaign and removes any ads that do not match the
	 * current enviroment (eg. gender, status, date etc...).
	 *
	 * @param array $aAds ARRAY of all the ads.
	 * @param int $iKey Key of the ARRAY.
	 * @param array $aAd ARRAY of the current ad we are building.
	 * @return array ARRAY of all the ads.
	 */
	private function &_build(&$aAds, &$iKey, &$aAd)
	{
			$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.live');
			if (!empty($aAd['total_view']) && $aAd['count_view'] > $aAd['total_view'] && $aAd['total_view'] > 0 && $aAd['is_cpm'] == 1)
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.inactive');
			}	
					
			if (!empty($aAd['total_click']) && $aAd['total_click'] < $aAd['count_click'] && $aAd['total_click'] > 0 && $aAd['is_cpm'] != 1)
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.inactive');
			}
			
			if ($aAd['start_date'] > PHPFOX_TIME)
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.pending');
			}
			
			if (!empty($aAd['end_date']) && $aAd['end_date'] < PHPFOX_TIME)
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.inactive');
			}			
			
			if (!$aAd['is_active'])
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.inactive');
			}
			
			if ($aAd['is_custom'] == '2')
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.pending_approval');
			}
			
			if ($aAd['is_custom'] == '4')
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.denied');
			}				
			
			if ($aAd['is_custom'] == '1')
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.pending_payment');
			}	
			
			if (isset($aAd['is_cpm']) && (
				($aAd['is_cpm'] != 1 && $aAd['count_click'] >= $aAd['total_click'] && $aAd['total_click'] > 0) ||
				($aAd['is_cpm'] == 1 && $aAd['count_view'] >= $aAd['total_view'] && $aAd['total_view'] > 0))
				)
			{
				$aAds[$iKey]['status'] = Phpfox::getPhrase('ad.completed');
				$aAds[$iKey]['is_active'] = 0; // This overrides the database value as a fail safe
			}
			
		return $aAds;		
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
		if ($sPlugin = Phpfox_Plugin::get('ad.service_ad__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	

	
	/** Returns the id of a record in the feed table, this feed is a sponsored one.
	 * 	This function is called from the feed service in the function get as part of the show-sponsored-stories feature */
	public function getSponsoredFeed()
	{
		$aSponsoredAds = $this->database()->select('item_id')
			->from(Phpfox::getT('ad_sponsor'))
			->where('module_id = "feed" AND is_custom IN (0,3)') // 0 => free, 1 => pending payment, 2 => pending approval, 3 => approved, 4 => denied
			->execute('getSlaveRows');
		
		if (count($aSponsoredAds) < 1) 
		{
			return false;
		}
		else if (count($aSponsoredAds) == 1)
		{
			return $aSponsoredAds[0]['item_id'];
		}
		
		return $aSponsoredAds[ array_rand($aSponsoredAds) ]['item_id'];
	}
}

?>
