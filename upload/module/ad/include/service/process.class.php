<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Ad Process Service
 * Handles all removal/insert/update of entries for ad database tables.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Module_Ad
 * @version 		$Id: process.class.php 7088 2014-02-04 15:37:30Z Fern $
 */
class Ad_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor.
	 */	
	public function __construct()
	{	
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_construct__start')) ? eval($sPlugin) : false);
		$this->_sTable = Phpfox::getT('ad');
	}

	/**
	 * Creates a record of the purchase into phpfox_ad_sponsor and returns the ID
	 * to be used as an invoice with the payment gateway.
	 * 
	 * @example if admin is adding, aVals looks like: array('module' => 'music', 'section' => 'album', 'item_id' => $this->get('album_id'))
	 * @param array $aVals
	 * @return int	 
	 */
	public function addSponsor($aVals)
	{
	    // check required fields
	    
	    $aForms = array(
		    'name' => array(
			    'message' => Phpfox::getPhrase('ad.provide_a_campaign_name'),
			    'type' => array('string:required')
		    ),
		    'total_view' => array(
			    'message' => Phpfox::getPhrase('ad.impressions_cant_be_less_than_a_thousand'),
			    'type' => 'int:required'
		    )
	    );
	    
	    $sParam = $aVals['module'] . '.can_sponsor_';
	    $sParam .= (isset($aVals['section']) && !empty($aVals['section'])) ? $aVals['section'] : $aVals['module'];
	    
	    if (Phpfox::getUserParam($sParam))
	    {
			$iCpm = $aVals['total_view'] = $aVals['age_to'] = $aVals['age_from'] = $aVals['gender'] = 0;
			$aVals['is_active'] = 1;
			// $aVals['is_custom'] = 3;
			$iIsCustom = 3;
			$aVals['country_iso_custom'] = '';
			$aVals['name'] = '{phrase var=\'ad.default_campaign_name\'}';
			$aVals['cpm'] = 0;
	    }
	    else
	    {
			// done here for extra safety
			$aPrices = unserialize(Phpfox::getUserParam($aVals['module'].'.'.$aVals['module'].(isset($aVals['section']) ? '_'.$aVals['section'] : '').'_sponsor_price'));
			if (!isset($aPrices[Phpfox::getService('core.currency')->getDefault()]))
			{
			    return Phpfox_Error::display('The default currency has no price');
			}
			$iCpm = $aPrices[Phpfox::getService('core.currency')->getDefault()];
	    }
	    
	    $this->validator()->process($aForms, $aVals);

	    if (!Phpfox_Error::isPassed())
	    {
			return false;
	    }
		
		$iAutoPublish = 0;
		if (isset($aVals['section']) && !empty($aVals['section']))
		{
			$iAutoPublish = Phpfox::getUserParam($aVals['module'] .'.auto_publish_sponsored_' . $aVals['section']);
		}
		else
		{
			$iAutoPublish = Phpfox::getUserParam($aVals['module'] .'.auto_publish_sponsored_item');
		}
		if (empty($iAutoPublish))
		{
			$iAutoPublish = '0';
		}
	    // if its an admin sponsoring something we dont need all the checks:
	    $aInsertSponsor = array(
		    'module_id' => $aVals['module'].(isset($aVals['section']) && !empty($aVals['section']) ? '-'.$aVals['section'] : ''),
		    'item_id' => $aVals['item_id'],
		    'user_id' => Phpfox::getUserId(),
		    'country_iso' => $aVals['country_iso_custom'],
		    'gender' => (empty($aVals['gender']) ? 0 : (int) $aVals['gender']),
			'age_from' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_from']),
			'age_to' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_to']),
			'campaign_name' => $aVals['name'],
		    'impressions' => $aVals['total_view'],
		    'cpm' => $iCpm,
		    'start_date' => Phpfox::getUserParam($sParam) ? PHPFOX_TIME : Phpfox::getLib('date')->mktime($aVals['start_hour'],$aVals['start_minute'],0,$aVals['start_month'],$aVals['start_day'],$aVals['start_year']),
		    'auto_publish' => $iAutoPublish,
			'is_custom' => (isset($iIsCustom) ? $iIsCustom : '1')
	    );
	    if (isset($aVals['is_active']))
	    {
		    $aInsertSponsor['is_active'] = $aVals['is_active'];
	    }
	    $iInsert = $this->database()->insert(Phpfox::getT('ad_sponsor'), $aInsertSponsor);
	    if (Phpfox::getUserParam($sParam))
	    {
			return $iInsert;
	    }
	    /**
	     * @param `phpfox_ad_invoice`.`status`:
	     *	    1 => Submitted but not paid or approved.
	     *	    2 => Paid but not approved,
	     *	    3 => Approved and should be displayed
	     */
	    $aInsertInvoice = array(
		    'ad_id' => $iInsert,
		    'price' => round($iCpm * $aVals['total_view'] / 1000 * 100) / 100, // round to 2 decimal numbers
		    'currency_id' => Phpfox::getService('core.currency')->getDefault(),
		    'status' => null,//Phpfox::getUserParam('photo.auto_publish_sponsored_item') == true ? 1 : 2,
		    'user_id' => Phpfox::getUserId(),
		    'is_sponsor' => 1,
		    'time_stamp' => Phpfox::getTime()
	    );
	    
	    $iInsertInvoice = $this->database()->insert(Phpfox::getT('ad_invoice'), $aInsertInvoice);
	    
	    return $iInsertInvoice;
	}

	/**
	 * Update an ad and set it to be active or inactive. Table "ad".
	 *
	 * @param array $aVals ARRAY of $_POST values.
	 * @return bool Always returns TRUE.
	 */
	public function updateActivity($aVals)
	{
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_updateactivity__start')) ? eval($sPlugin) : false);
		foreach ($aVals as $iId => $aVal)
		{
			$this->database()->update($this->_sTable, array('is_active' => (isset($aVal['is_active']) ? '1' : '0')), 'ad_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('ad', 'substr');
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_updateactivity__end')) ? eval($sPlugin) : false);
		return true;
	}
	
	/**
	 * Update an ad. Table "ad".
	 *
	 * @param int $iId Ad ID#.
	 * @param array $aVals ARRAY of $_POST values.
	 * @return bool Always returns TRUE.
	 */
	public function update($iId, $aVals)
	{
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_update__start')) ? eval($sPlugin) : false);
		
		$iStartTime = Phpfox::getLib('date')->mktime($aVals['start_hour'], $aVals['start_minute'], 0, $aVals['start_month'], $aVals['start_day'], $aVals['start_year']);
		
		if (!isset($aVals['country_iso_custom']))
		{
			$aVals['country_iso_custom'] = !empty($aVals['country_iso']) ? $aVals['country_iso'] : array();
		}
		
		if (is_array($aVals['country_iso_custom']) && !empty($aVals['country_iso_custom']))
		{
			foreach ($aVals['country_iso_custom'] as $iKey => $sCountry)
			{				
				if (empty($sCountry))
				{
					unset($aVals['country_iso_custom'][$iKey]);
				} 
			}
			
			if (count($aVals['country_iso_custom']) == 1)
			{
				$aVals['country_iso'] = $aVals['country_iso_custom'][0];
				//unset($aVals['country_iso_custom']);
			}
			else
			{
				$aVals['country_iso'] = null;
			}
		}

		if ($aVals['location'] == '50')
		{
			$aVals['html_code'] = json_encode(array(
				'body' => Phpfox::getLib('parse.input')->clean($aVals['c_ad_body']),
				'title' => Phpfox::getLib('parse.input')->clean($aVals['c_ad_title'])
			));
		}
		
		$aSql = array(
			'name' => $this->preParse()->clean($aVals['name'], 150),
			'url_link' => ($aVals['type_id'] == 1 ? $aVals['url_link'] : null),
			'start_date' => $iStartTime,
			'end_date' => ($aVals['end_option'] > 0 ? Phpfox::getLib('date')->mktime($aVals['end_hour'], $aVals['end_minute'], 0, $aVals['end_month'], $aVals['end_day'], $aVals['end_year']) : 0),
			'total_view' => (isset($aVals['total_view']) ? (int) $aVals['total_view'] : 0),
			'total_click' => (($aVals['type_id'] == 1 && isset($aVals['total_click'])) ? (int) $aVals['total_click'] : 0),
			'is_active' => (int) $aVals['is_active'],
			'module_access' => (empty($aVals['module_access']) ? null : $aVals['module_access']),
			'location' => $aVals['location'],
			'country_iso' => (isset($aVals['country_iso']) ? $aVals['country_iso'] : ''),
			'gender' => (empty($aVals['gender']) ? 0 : (int) $aVals['gender']),
			'age_from' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_from']),
			'age_to' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_to']),
			'html_code' => (empty($aVals['html_code']) ? null : $aVals['html_code']),
			'gmt_offset' => Phpfox::getLib('date')->getGmtOffset($iStartTime),
			'disallow_controller' => (empty($aVals['disallow_controller']) ? null : $aVals['disallow_controller'])
		);

		if (Phpfox::getParam('ad.advanced_ad_filters'))
		{
			$oParse = Phpfox::getLib('parse.input');
			$aVals['postal_code'] = str_replace('"', '', $aVals['postal_code']);
			if (empty($aVals['postal_code']))
			{
				$aSql['postal_code'] = null;
			}
			else
			{
				$aSql['postal_code'] = explode(',',$oParse->clean($aVals['postal_code']));
				$aSql['postal_code'] = json_encode($aSql['postal_code']);
			}

			if (empty($aVals['city_location']))
			{
				$aSql['city_location'] = null;
			}
			else
			{
				$aSql['city_location'] = explode(',',$oParse->clean($aVals['city_location']));
				$aSql['city_location'] = json_encode($aSql['city_location']);
			}
		}
		
		if (empty($aSql['url_link']))
		{
			unset($aSql['url_link']);
		}
		
		$this->_adCountries($aVals, $iId);		
		
		if (isset($aVals['approve']))
		{
			$aSql['is_custom'] = '3';	
			$aSql['is_active'] = '1';
		}
		
		if (isset($aVals['deny']))
		{
			$aSql['is_custom'] = '4';	
			$aSql['is_active'] = '0';
		}		
		
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
		}		
		$aSql['user_group'] = ((isset($aGroups) && count($aGroups)) ? serialize($aGroups) : null);
		
		if ($aVals['type_id'] == 1 && !empty($_FILES['image']['name']))
		{			
			$aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'));
			
			if ($aImage === false)
			{
				return false;
			}		
			
			$aAd = Phpfox::getService('ad')->getForEdit($iId);

			if (!empty($aAd['image_path']) && file_exists(Phpfox::getParam('ad.dir_image') . sprintf($aAd['image_path'], '')))
			{
				Phpfox::getLib('file')->unlink(Phpfox::getParam('ad.dir_image') . sprintf($aAd['image_path'], ''));
			}
			
			if ($sFileName = Phpfox::getLib('file')->upload('image', Phpfox::getParam('ad.dir_image'), $iId))
			{
				$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'ad_id = ' . (int) $iId);		
			}	
		}		
		
		$this->database()->update($this->_sTable, $aSql, 'ad_id =' . (int) $iId);
		
		$this->cache()->remove('ad', 'substr');
		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_update__end')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	/**
	 * Delete an ad from the table "ad".
	 *
	 * @param int $iId Ad ID#.
	 * @return bool TRUE if ad was deleted, FALSE if it was not.
	 */
	public function delete($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_delete__start')) ? eval($sPlugin) : false);
		$aAd = $this->database()->select('*')
			->from($this->_sTable)
			->where('ad_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aAd['ad_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('ad.unable_to_find_the_ad_you_want_to_delete'));
		}
		
		if (!empty($aAd['image_path']))
		{
			$sImagePath = Phpfox::getParam('ad.dir_image') . sprintf($aAd['image_path'], '');
			if (file_exists($sImagePath))
			{
				Phpfox::getLib('file')->unlink($sImagePath);
			}
		}
		
		$this->database()->delete($this->_sTable, 'ad_id = ' . $aAd['ad_id']);
		
		$this->cache()->remove('ad', 'substr');
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_delete__end')) ? eval($sPlugin) : false);
		return true;
	}

	/**
	 * Deletes an invoice alone
	 * @param integer $iId
	 */
	public function deleteInvoice($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_deleteinvoice__start')) ? eval($sPlugin) : false);
		return $this->database()->delete(Phpfox::getT('ad_invoice'), 'invoice_id = ' . (int)$iId);
	}

	/**
	 * Delete a sponsored ad from the table "ad_sponsor".
	 *
	 * @param int $iId Sponsor ad ID#.
	 * @return bool Always returns TRUE.
	 */
	public function deleteSponsor($iId)
	{
	    $this->database()->delete(Phpfox::getT('ad_sponsor'), 'sponsor_id = ' . (int)$iId);
	    return true;
	}

	/**
	 * Add a new ad to the table "ad".
	 *
	 * @param array $aVals ARRAY of $_POST form values.
	 * @return bool|int FALSE if ad was not added.|Ad ID# if ad was successfully created.
	 */
	public function add($aVals)
	{		
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_add__start')) ? eval($sPlugin) : false);
		
		$iStartTime = Phpfox::getLib('date')->convertToGmt(Phpfox::getLib('date')->mktime($aVals['start_hour'], $aVals['start_minute'], 0, $aVals['start_month'], $aVals['start_day'], $aVals['start_year']));
		$iEndTime = ($aVals['end_option'] > 0 ? Phpfox::getLib('date')->convertToGmt(Phpfox::getLib('date')->mktime($aVals['end_hour'], $aVals['end_minute'], 0, $aVals['end_month'], $aVals['end_day'], $aVals['end_year'])) : 0);
		
		if ($iEndTime > 0 && $iEndTime < $iStartTime)
		{
			return Phpfox_Error::set('End time cannot be earlier than start time');
		}		
		
		if (!isset($aVals['country_iso_custom']))
		{
			$aVals['country_iso_custom'] = !empty($aVals['country_iso']) ? $aVals['country_iso'] : array();
		}
		
		if (is_array($aVals['country_iso_custom']) && !empty($aVals['country_iso_custom']))
		{
			foreach ($aVals['country_iso_custom'] as $iKey => $sCountry)
			{				
				if (empty($sCountry))
				{
					unset($aVals['country_iso_custom'][$iKey]);
				} 
			}
			
			if (count($aVals['country_iso_custom']) == 1)
			{
				$aVals['country_iso'] = $aVals['country_iso_custom'][0];
				//unset($aVals['country_iso_custom']);
			}
			else
			{
				$aVals['country_iso'] = null;
			}
		}		
		$aVals['html_code'] = str_replace(Phpfox::getPhrase('ad_image_placement'), '', $aVals['html_code']);
		$aSql = array(
			'type_id' => (int) $aVals['type_id'],
			'name' => $this->preParse()->clean($aVals['name'], 150),
			'url_link' => ($aVals['type_id'] == 1 ? $aVals['url_link'] : null),
			'start_date' => $iStartTime,
			'end_date' => $iEndTime,
			'total_view' => (isset($aVals['total_view']) ? (int) $aVals['total_view'] : 0),
			'total_click' => (($aVals['type_id'] == 1 && isset($aVals['total_click'])) ? (int) $aVals['total_click'] : 0),
			'is_active' => (int) $aVals['is_active'],
			'module_access' => (empty($aVals['module_access']) ? null : $aVals['module_access']),
			'location' => $aVals['location'],
			'country_iso' => (empty($aVals['country_iso']) ? null : $aVals['country_iso']),
			'gender' => (empty($aVals['gender']) ? 0 : (int) $aVals['gender']),
			'age_from' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_from']),
			'age_to' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_to']),
			'html_code' => (empty($aVals['html_code']) ? null : $aVals['html_code']),
			'gmt_offset' => Phpfox::getLib('date')->getGmtOffset($iStartTime),
			'disallow_controller' => (empty($aVals['disallow_controller']) ? null : $aVals['disallow_controller'])
		);

		if (Phpfox::getParam('ad.advanced_ad_filters'))
		{
			$oParse = Phpfox::getLib('parse.input');
			if (empty($aVals['postal_code']))
			{
				$aSql['postal_code'] = null;
			}
			else
			{
				$aSql['postal_code'] = explode(',',$oParse->clean($aVals['postal_code']));
				$aSql['postal_code'] = json_encode($aSql['postal_code']);
			}

			if (empty($aVals['city_location']))
			{
				$aSql['city_location'] = null;
			}
			else
			{
				$aSql['city_location'] = explode(',',$oParse->clean($aVals['city_location']));
				$aSql['city_location'] = json_encode($aSql['city_location']);
			}
		}

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
			$aSql['user_group'] = (count($aGroups) ? serialize($aGroups) : null);
		}
		
		if ($aVals['type_id'] == 1)
		{
			$aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'));
			
			if ($aImage === false)
			{
				return false;
			}			
		}
		
		$iId = $this->database()->insert($this->_sTable, $aSql);
		
		$this->_adCountries($aVals, $iId);
		
		if ($aVals['type_id'] == 1)
		{
			if ($sFileName = Phpfox::getLib('file')->upload('image', Phpfox::getParam('ad.dir_image'), $iId))
			{
				$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'ad_id = ' . (int) $iId);		
			}		
		}
		
		$this->cache()->remove('ad', 'substr');
		(($sPlugin = Phpfox_Plugin::get('ad.service_ad_add__end')) ? eval($sPlugin) : false);
		
		return $iId;
	}
	
	/**
	 * This function increases the view count of an item and checks if its time to stop showing
	 * This function is called from a block.
	 * 
	 * @param int $aSponsorId
	 * @param string $sTable name of the DB table where is_sponsor would be updated to 0
	 * @param string $sPK Primary key to match ad_sponsor.item_id with $sTable.$sPK
	 */
	public function addSponsorViewsCount($iSponsorId, $sModule, $sFunction = 'sponsor')
	{
	    $aItem = $this->database()->select('sponsor_id, impressions, total_view, module_id, item_id, cpm')
		    ->from(Phpfox::getT('ad_sponsor'))
		    ->where('sponsor_id = ' . (int)$iSponsorId)
		    ->execute('getSlaveRow');
		
		if (empty($aItem))
		{
			return false;
		}
		   
	    if ((int) $aItem['impressions'] !== 0 && $aItem['impressions'] <= $aItem['total_view'])  
	    {
			// stop showing this sponsor by updating its table
			if (!defined('PHPFOX_API_CALLBACK')) // this overrides security checks
			{
				define('PHPFOX_API_CALLBACK', true);
			}
			// update in ad_sponsor to stop showing it
			$this->database()->update(Phpfox::getT('ad_sponsor'),array('is_active' => '4'), 'sponsor_id = ' . (int)$iSponsorId);
			return Phpfox::getService($sModule.'.process')->$sFunction($aItem['item_id'], 0);
	    }
	    
	    $this->database()->update(Phpfox::getT('ad_sponsor'),array('total_view' => $aItem['total_view']+1), 'sponsor_id = ' . (int)$iSponsorId);
	}
	
	/*
		Handles inserting and updating countries and states
	*/
	private function _adCountries(&$aVals, $iId)
	{
		if (Phpfox::getParam('ad.advanced_ad_filters') && isset($aVals['country_iso_custom']) && is_array($aVals['country_iso_custom']) && !empty($aVals['country_iso_custom']) && isset($aVals['child_country']) && is_array($aVals['child_country']) && !empty($aVals['child_country']))
		{
			// Check that the states are valid for the countries selected
			$aCountries = $aOptions = array();
			foreach ($aVals['child_country'] as $sCountry => $aChildren)
			{
				$aCountries[] = $sCountry;
				foreach ($aChildren as $iChild)
				{
					$aOptions[] = $iChild;
				}				
			}
			$sCountryIn = '"' .implode('","', $aCountries) .'"';
			$sOptionsIn = '' .implode(',', $aOptions) .'';
			
			$aValid = $this->database()->select('child_id, country_iso')
				->from(Phpfox::getT('country_child'))
				->where('country_iso IN ('. $sCountryIn .') AND child_id IN ('. $sOptionsIn .')')
				->execute('getSlaveRows');
			
			$aToInsert = array();
			// We need to take into account that the user may have chosen a Country but not a state, in this case we assume the user meant the entire country, so we leave the child_id empty
			$this->database()->delete(Phpfox::getT('ad_country'), 'ad_id = ' . (int)$iId);
			foreach ($aVals['country_iso_custom'] as $iKey => $sFullCountry)
			{
				if (!isset($aVals['child_country'][$sFullCountry]))
				{
					$aToInsert[$sFullCountry] = array('ad_id' => $iId, 'country_id' => $sCountry);
					$this->database()->insert(Phpfox::getT('ad_country'), $aToInsert[$sFullCountry]);
				}
			}
			
			foreach ($aValid as $aChecked)
			{				
				if (!isset($aToInsert[$aChecked['country_iso']]))
				{
					$aToInsert[$aChecked['child_id']] = array('ad_id' => $iId, 'country_id' => $aChecked['country_iso'], 'child_id' => $aChecked['child_id']);
					$this->database()->insert(Phpfox::getT('ad_country'), $aToInsert[$aChecked['child_id']]);
				}				
			}
			$aVals['country_iso_custom'] = '';
		}
		else if (isset($aVals['country_iso_custom']) && is_array($aVals['country_iso_custom']) && !empty($aVals['country_iso_custom']))
		{
			$this->database()->delete(Phpfox::getT('ad_country'), 'ad_id = ' . (int)$iId);
			foreach ($aVals['country_iso_custom'] as $sCountry)
			{
				$this->database()->insert(Phpfox::getT('ad_country'), array('ad_id' => $iId, 'country_id' => $sCountry)); 
			}
			$aVals['country_iso_custom'] = '';
		}
        /* http://www.phpfox.com/tracker/view/12665/ */
        else if(empty($aVals['country_iso_custom']))
        {
              $this->database()->delete(Phpfox::getT('ad_country'), 'ad_id = ' . (int) $iId);
        }
	}
	
	/**
	 * Add a custom ad, which are created by the end-users.
	 *
	 * @param array $aVals ARRAY of $_POST form values.
	 * @return bool|int FALSE if ad was not created.|Ad ID# if ad was successfully created.
	 */
	public function addCustom($aVals)
	{
		Phpfox::isUser(true);		
		
		if ((int) $aVals['total_view'] < 1000 && $aVals['is_cpm'])
		{
			return Phpfox_Error::set(Phpfox::getPhrase('ad.there_is_minimum_of_1000_impressions'));
		}
		
		if (Phpfox::getParam('ad.multi_ad'))
		{
			$aVals['type_id'] == 2;
		}
		// total_click does not exist at this point because it is one single input for the user.
		$fPrice = $aVals['is_cpm'] ? (($aVals['default_cost'] * $aVals['total_view']) / 1000) : $aVals['default_cost'] * $aVals['total_view'];
		if (isset($aVals['country_iso_custom']) && is_array($aVals['country_iso_custom']) && !empty($aVals['country_iso_custom']))
		{
			foreach ($aVals['country_iso_custom'] as $iKey => $sCountry)
			{
				if (empty($sCountry))
				{
					unset($aVals['country_iso_custom'][$iKey]);
				}
			}
			if (count($aVals['country_iso_custom']) == 1)
			{
				$aVals['country_iso'] = reset($aVals['country_iso_custom']);
			}
			else
			{
				$aVals['country_iso'] = null;
			}
		}
		
		
		$aSize = explode('x', $aVals['ad_size']);	
		
		if ($aVals['type_id'] == '1')
		{
			$aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'));
			
			if ($aImage === false)
			{
				return false;
			}		
			
			list($iWidth, $iHeight) = getimagesize($aImage['tmp_name']);			
			
			if ($iWidth > $aSize[0] || $iHeight > $aSize[1])
			{
				return Phpfox_Error::set(Phpfox::getPhrase('ad.the_file_dimensions_are_too_big'));
			}
		}
		
		$iStartTime = Phpfox::getLib('date')->convertToGmt(Phpfox::getLib('date')->mktime($aVals['start_hour'], $aVals['start_minute'], 0, $aVals['start_month'], $aVals['start_day'], $aVals['start_year']));

		/*
		* The field is_custom tells the state of the ad as follows:
			1: Pending Payment
			2: Pending Approval
			3: Approved?
			4: Denied
		*/
		
		$aInsert = array(
			'is_custom' => ($fPrice == 0 ? '3' : '1'), // if its free set it as approved
			'user_id' => Phpfox::getUserId(),
			'type_id' => $aVals['type_id'],
			'name' => $this->preParse()->clean($aVals['name']),
			'url_link' => $aVals['url_link'],
			'start_date' => $iStartTime,
			'end_date' => 0,
			'total_view' => (isset($aVals['total_view']) ? (int) $aVals['total_view'] : 0),
			'total_click' => ((int)$aVals['is_cpm'] == 1) ? '0' : (isset($aVals['total_view']) ? (int) $aVals['total_view'] : 0),
			'is_active' => ($fPrice == 0 ? '1' : '0'),
			'location' => $aVals['location'],
			'country_iso' => (empty($aVals['country_iso']) ? null : $aVals['country_iso']),
			'gender' => (empty($aVals['gender']) ? 0 : (int) $aVals['gender']),
			'age_from' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_from']),
			'age_to' => (empty($aVals['age_from']) ? 0 : (int) $aVals['age_to']),
			'gmt_offset' => ($iStartTime > 0 ? Phpfox::getLib('date')->getGmtOffset($iStartTime) : null),
			'image_path' => $aVals['image_path'],
			'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID'),
			'is_cpm' => (int)$aVals['is_cpm']
		);
		//if ($sPlugin = Phpfox_Plugin::get('ad.service_process_addcustom_before_insert_ad')){eval($sPlugin);}
		if (Phpfox::getParam('ad.advanced_ad_filters'))
		{
			$oParse = Phpfox::getLib('parse.input');			
			$aInsert['postal_code'] = explode(',',$oParse->clean($aVals['postal_code']));
			$aInsert['postal_code'] = json_encode($aInsert['postal_code']);
			$aInsert['city_location'] = explode(',',$oParse->clean($aVals['city_location']));
			$aInsert['city_location'] = json_encode($aInsert['city_location']);
		}
		
		$aVals['html_code'] = str_replace(Phpfox::getPhrase('ad.image_placement'), '', $aVals['html_code'], $iCount);
		
		if (Phpfox::getParam('ad.multi_ad') && isset($aVals['body_text']) && !empty($aVals['body_text']) && isset($aVals['title']) && !empty($aVals['title']))
		{
			$aInsert['html_code'] = json_encode(array(
				'body' => Phpfox::getLib('parse.input')->clean($aVals['body_text']),
				'title' => Phpfox::getLib('parse.input')->clean($aVals['title'])
			));
		}
				
		$iId = $this->database()->insert(Phpfox::getT('ad'), $aInsert);
		
		// Insert countries		
		$this->_adCountries($aVals, $iId);
		
		
		if ($aVals['type_id'] == '1')
		{
			if ($sFileName = Phpfox::getLib('file')->upload('image', Phpfox::getParam('ad.dir_image'), $iId))
			{
				$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'ad_id = ' . (int) $iId);		
			}		
		}
		else if (Phpfox::getParam('ad.multi_ad') != true)
		{		
			/*
			$aVals['html_code'] = '<div style="width:' . $aSize[0] . 'px; height:' . $aSize[1] . 'px; background:#' . $aVals['color_bg'] . '; border:1px #' . $aVals['color_border'] . ' solid;">' . $aVals['html_code'] . '</div>';
			if (preg_match('/js_image_place_holder/i', $aVals['html_code']))
			{
				$aVals['html_code'] = preg_replace('/<div class=\"js_ad_image\"(.*?)>(.*?)<\/div>/is', '', $aVals['html_code']);	
				$aVals['html_code'] = str_replace('margin-left: 130px;', '', $aVals['html_code']);
				$aVals['html_code'] = str_replace('margin-left:130px;', '', $aVals['html_code']);
			}			
			*/		
			$aVals['html_code'] = str_replace('#ad-link"', Phpfox::getLib('url')->makeUrl('ad', array('id' => $iId)) . '" target="_blank"', $aVals['html_code']);
			$aVals['html_code'] = preg_replace('/id="js_sample_ad_form_(.*)_(.*)" class="js_ad_holder"/i', '', $aVals['html_code']);
			
			$this->database()->update(Phpfox::getT('ad'), array(
					'html_code' => $aVals['html_code']
				), 'ad_id = ' . (int) $iId
			);
		}
		//if ($sPlugin = Phpfox_Plugin::get('ad.service_process_addcustom_before_insert_invoice')){eval($sPlugin);}
		$aPlan = Phpfox::getService('ad')->getPlan($aVals['location'], true);
		
		$this->database()->insert(Phpfox::getT('ad_invoice'), array(
				'ad_id' => $iId,
				'user_id' => Phpfox::getUserId(),
				'currency_id' => $aPlan['default_currency_id'],
				'price' => $fPrice,//(($aPlan['default_cost'] * $aVals['total_view']) / 1000),
				'time_stamp' => PHPFOX_TIME,
				'time_stamp_paid' => $fPrice == 0 ? PHPFOX_TIME : '0',
				'is_sponsor' => 0
			)
		);
		
		$this->cache()->remove('ad', 'substr');
		
		return $iId;
	}
	
	/**
	 * Update a custom ad created by end-users. Currently we only update the ads name.
	 * 
	 * 2nd argument $_POST form values support:
	 * - name (STRING)
	 *
	 * @param int $iId Custom ad ID#.
	 * @param array $aVals ARRAY of $_POST form values.
	 * @return unknown
	 */
	public function updateCustom($iId, $aVals)
	{
		Phpfox::isUser(true);
		$oParse = Phpfox::getLib('parse.input');
		if (!Phpfox::isAdmin())
		{
			// check that this user is the owner of the ad
			$iUserId = $this->database()->select('user_id')
				->from(Phpfox::getT('ad'))
				->where('ad_id = ' .(int)$aVals['id'])
				->execute('getSlaveField');
			if ($iUserId != Phpfox::getUserId())
			{
				return Phpfox_Error::set('You are not allowed to edit this ad.');
			}
		}
		
		$this->_adCountries($aVals, $iId);
		
		$this->database()->update(Phpfox::getT('ad'), array(
				'name' => $this->preParse()->clean($aVals['name']),
				'country_iso' => (isset($aVals['country_iso_custom']) ? $oParse->clean($aVals['country_iso_custom']) : null),
				'gender' => (int)$aVals['gender'],
				'age_from' => (int)$aVals['age_from'],
				'age_to' => (int)$aVals['age_to'],
			), 'ad_id = ' . (int) $iId
		);
		
		return true;
	}	
	
	/**
	 * Approve an ad created by an end-user.
	 *
	 * @param int $iId Ad ID#.
	 * @return bool Always returns TRUE.
	 */
	public function approve($iId)
	{
		$this->database()->update(Phpfox::getT('ad'), array(
				'is_custom' => '3',
				'is_active' => '1'
			), 'ad_id = ' . (int) $iId
		);			
		
		$this->sendApproveEmail($iId);
		
		$this->cache()->remove();
		
		return true;
	}

	/**
	 * Approve a sponsored ad campaign created by an end-user.
	 *
	 * @param int $iId Sponsorted ad ID#.
	 * @return bool FALSE if ad cannot be found, TRUE if ad was successfully approved.
	 */
	public function approveSponsor($iId)
	{
		$aItem = $this->database()->select('module_id, item_id')
			->from(Phpfox::getT('ad_sponsor'))
			->where('sponsor_id = ' . (int)$iId)
			->execute('getSlaveRow');
		if (empty($aItem))
		{
		    return false;
		}
		// parse the module to find if its a sub item
		// final fixing
		$sModule = $aItem['module_id'];

		$sSection = '';
		if (strpos($sModule, '-') !== false)
		{
		    $aModule = explode('-',$sModule);
		    $sModule = $aModule[0];
		    $sSection = $aModule[1];
		}
		
		// stop showing this sponsor by updating its table
		if (!defined('PHPFOX_API_CALLBACK')) // this overrides security checks
		{
			define('PHPFOX_API_CALLBACK', true);
		}		

		Phpfox::callback($sModule . '.enableSponsor', array('item_id' => $aItem['item_id'], 'section' => $sSection));

		$this->database()->update(Phpfox::getT('ad_sponsor'), array(
				'is_custom' => '3',
				'is_active' => '1'
			), 'sponsor_id = ' . (int) $iId
		);

		$this->sendApproveEmail($iId, true);

		return true;
	}
	
	/**
	 * Deny an ad from being displayed publicly on the site.
	 *
	 * @param int $iId Ad ID#.
	 * @return bool Always returns TRUE.
	 */
	public function deny($iId)
	{
		$this->database()->update(Phpfox::getT('ad'), array(
				'is_custom' => '4',
				'is_active' => '1'
			), 'ad_id = ' . (int) $iId
		);
		
		$this->sendDenyEmail($iId);
		
		$this->cache()->remove();
		
		return true;
	}

	/**
	 * Deny a sponsored ad.
	 *
	 * @param int $iId Sponsored ad ID#.
	 * @return bool Always returns TRUE.
	 */
	public function denySponsor($iId)
	{
		$this->database()->update(Phpfox::getT('ad_sponsor'), array(
				'is_custom' => '4',
				'is_active' => '1'
			), 'sponsor_id = ' . (int) $iId
		);

		$this->sendDenyEmail($iId);

		return true;
	}
	
	/**
	 * Send an email to the user if their ad has been approved.
	 *
	 * @param int $iId Ad ID#.
	 * @param bool $bSponsor TRUE if this is a sponsored ad.
	 * @return bool FALSE if ad was not found, TRUE if email was sent.
	 */
	public function sendApproveEmail($iId, $bSponsor = false)
	{
		$aAd = $this->database()->select(($bSponsor ? 'sponsor_id' : 'ad_id') .', user_id')
			->from(Phpfox::getT('ad' . ($bSponsor ? '_sponsor' : '')))
			->where( ($bSponsor ? 'sponsor_id = ' : 'ad_id = ') . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aAd))
		{
			return false;
		}

		if ($bSponsor === true)
		{
			$sSubject = array('ad.sponsor_ad_approved');
			$sMessage = array('ad.your_sponsor_ad_on_site_name_has_been_approved', array(
			    'site_name' => Phpfox::getParam('core.site_title'),
			    'link' => Phpfox::getLib('url')->makeUrl('ad.sponsor', array('view' => $aAd['sponsor_id']))
			));
		}
		else 
		{
			$sSubject = array('ad.ad_approved');
			$sMessage = array('ad.your_ad_on_site_name_has_been_approved', array(
					'site_name' => Phpfox::getParam('core.site_title'),
					'link' => Phpfox::getLib('url')->makeUrl('ad.add', array('id' => $aAd['ad_id']))
				)
			);
		}
		
		Phpfox::getLib('mail')->to($aAd['user_id'])						
			->subject($sSubject)
			->message($sMessage)
			->send();				
		
		return true;
	}
	
	/**
	 * Send a denied email when an ad was not approved by an admin.
	 *
	 * @param int $iId Ad ID#.
	 * @param bool $bSponsor TRUE if this is a sponsored ad.
	 * @return false|null FALSE if ad was not found.|NULL if ad was found and email was sent.
	 */
	public function sendDenyEmail($iId, $bSponsor = false)
	{
		$aAd = $this->database()->select(($bSponsor ? 'sponsor_id' : 'ad_id') .', user_id')
			->from(Phpfox::getT('ad' . ($bSponsor ? '_sponsor' : '')))
			->where( ($bSponsor ? 'sponsor_id = ' : 'ad_id = ') . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aAd))
		{
			return false;
		}
		
		if ($bSponsor === true)
		{
			$sSubject = array('ad.sponsor_ad_denied');
			$sMessage = array('ad.your_sponsor_ad_on_site_name_has_been_denied', array(
			    'site_name' => Phpfox::getParam('core.site_title'),
			    'link' => Phpfox::getLib('url')->makeUrl('ad.sponsor', array('view' => $aAd['sponsor_id']))));
		}
		else 
		{
			$sSubject = array('ad.ad_denied');
			$sMessage = array('ad.your_ad_on_site_name_has_been_denied', array(
					'site_name' => Phpfox::getParam('core.site_title'),
					'link' => Phpfox::getLib('url')->makeUrl('ad.add', array('id' => $aAd['ad_id']))
				)
			);
		}
		
		Phpfox::getLib('mail')->to($aAd['user_id'])						
			->subject($sSubject)
			->message($sMessage)
			->send();			
	}	
	
	/**
	 * Update the activity of an ad via AJAX from the table "ad".
	 *
	 * @param int $iId Ad ID#.
	 * @param int $iType Activity ID. 1 = active, 0 = inactive.
	 * @param int $iUserId (Optional) Pass a user ID if we need to check on the user ID of the ad.
	 */
	public function updateActivityAjax($iId, $iType, $iUserId = null)
	{
		Phpfox::isUser(true);
		
		if ($iUserId === null)
		{
			Phpfox::getUserParam('admincp.has_admin_access', true);			
			$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'ad_id = ' . (int) $iId);
		}
		else
		{
			$aAd = $this->database()->select('is_cpm, is_active, total_view, count_view, total_click, count_click, user_id')
				->from(Phpfox::getT('ad'))
				->where('ad_id = ' . (int)$iId)
				->execute('getSlaveRow');
			if ($aAd['user_id'] != $iUserId)
			{
				return Phpfox_Error::set(Phpfox::getPhrase('ad.you_are_not_the_owner_of_this_ad'));
			}
			if ($iType == 1 && $aAd['is_cpm'] == 1 && $aAd['count_view'] >= $aAd['total_view'] )
			{
				if($aAd['total_view'] != 0)
				{
					return Phpfox_Error::set(Phpfox::getPhrase('ad.this_ad_has_used_all_its_views'));
				}
			}
			if ($iType == 1 && $aAd['is_cpm'] != 1 && $aAd['count_click'] >= $aAd['total_click'])
			{
				if($aAd['total_click'] != 0)
				{
					return Phpfox_Error::set(Phpfox::getPhrase('ad.this_ad_has_used_all_its_clicks'));
				}
			}
			if ($aAd['is_active'] != $iType)
			{
				$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'ad_id = ' . (int) $iId . ' AND user_id = ' . (int) $iUserId);
			}
		}
		
		$this->cache()->remove('ad', 'substr');
	}

	/**
	 * This function is called from an ajax function in the AdminCP to dis/enabling a sponsored campaign.
	 * 
	 * @param int $iId
	 * @param int $iType
	 * @return bool TRUE on success, FALSE on failure.
	 */
	public function updateSponsorActivity($iId, $iType)
	{
	    Phpfox::isUser(true);
	    // get the item to check for ownership
	    $aAd = $this->database()->select('user_id, item_id, module_id')
		    ->from(Phpfox::getT('ad_sponsor'))
		    ->where('sponsor_id = ' . (int)$iId)
		    ->execute('getSlaveRow');
		$iUser = $aAd['user_id'];
	    $bIsOwner = $iUser == Phpfox::getUserId();
	    
	    if ($bIsOwner || Phpfox::isAdmin())
	    {
			if ($iType == '1')
			{
				if (!defined('PHPFOX_API_CALLBACK'))
				{
					define('PHPFOX_API_CALLBACK', true);
				}
				$sModule = $aAd['module_id'];
		
				$sSection = '';
				if (strpos($sModule, '-') !== false)
				{
				    $aModule = explode('-',$sModule);
				    $sModule = $aModule[0];
				    $sSection = $aModule[1];
				}				
				
				Phpfox::callback($sModule . '.enableSponsor', array('item_id' => $aAd['item_id'], 'section' => $sSection));			
			}
			
			$this->database()->update(Phpfox::getT('ad_sponsor'), array('is_custom' => ($iType == 1 ? '3' : '2'), 'is_active' => (int) ($iType == '1' ? 1 : 0)), 'sponsor_id = ' . (int) $iId);
			
			$this->cache()->remove('ad', 'substr');
			
			return true;
	    }
	    else
	    {
			return Phpfox_Error::set('You cant do that... ');
	    }
	}
	
	/**
	 * Updates the ad placement activity.
	 *
	 * @param int $iId Ad placement ID#.
	 * @param int $iType Activity ID, 1 = active, 0 = inactive.
	 */
	public function updateAdPlacementActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);			
		$this->database()->update(Phpfox::getT('ad_plan'), array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'plan_id = ' . (int) $iId);		
		$this->cache()->remove('ad', 'substr');
	}		
	
	/**
	 * Adds an ad placement plan into the table "ad_plan".
	 * 
	 * Valid $_POST data for the 1st argument:
	 * - title (STRING)
	 * - block_id (INT)
	 * - cost (STRING)
	 * - is_active (INT)
	 *
	 * @param array $aVals ARRAY of $_POST values.
	 * @param int $iId (Optional) If we are editing this ad we pass the ad ID here.
	 * @return bool|int FALSE if errors were found when creating the ad placement.|Ad ID# when ad placement has successfully been created.
	 */
	public function addPlacement($aVals, $iId = null)
	{
		
		$aForms = array(
			'title' => array(
				'message' => Phpfox::getPhrase('ad.provide_a_title'),
				'type' => array('string:required')
			),
			'block_id' => array(
				'message' => Phpfox::getPhrase('ad.select_a_placement'),
				'type' => array('int:required')
			),			
			'cost' => array(
				'message' => Phpfox::getPhrase('ad.provide_a_cost'),
				'type' => 'currency:required'
			),			
			'is_active' => array(
				'message' => Phpfox::getPhrase('ad.select_if_this_ad_placement_is_active_or_not'),
				'type' => 'int:required'
			),
			'is_cpm' => array(
				'message' => 'You need to define if this placement is for CPM or PPC',
				'type' => 'int:required'
			),
			'd_width' => array(
				'message' => 'Provide a width for this ad placement.',
				'type' => 'int:required'
			),
			'd_height' => array(
				'message' => 'Provide a height for this ad placement.',
				'type' => 'int:required'
			)			
		);			
		
		$aVals = $this->validator()->process($aForms, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}	

		$aVals['cost'] = serialize($aVals['cost']);
		$aVals['title'] = $this->preParse()->convert($aVals['title']);
		
		if ($iId === null)
		{
			$iId = $this->database()->insert(Phpfox::getT('ad_plan'), $aVals);	
		}
		else 
		{
			$this->database()->update(Phpfox::getT('ad_plan'), $aVals, 'plan_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('ad', 'substr');
		
		return $iId;
	}
	
	/**
	 * Update ad placement.
	 *
	 * @see self::addPlacement()
	 * @param int $iId
	 * @param array $aVals
	 * @return mixed
	 */
	public function updatePlacement($iId, $aVals)
	{
		return $this->addPlacement($aVals, $iId);
	}
	
	/**
	 * Deletes an ad placement plan from the table "ad_plan".
	 *
	 * @param int $iId Plan ID#.
	 * @return bool Always returns TRUE.
	 */
	public function deletePlacement($iId)
	{
		$this->database()->delete(Phpfox::getT('ad_plan'), 'plan_id = ' . (int) $iId);
		
		$this->cache()->remove('ad', 'substr');
		
		return true;
	}

	/**
	 * Deletes sponsor entries added by an administrator from the ad.sponsor table.
	 * If more than one campaign was created by an admin for the same item, they will be deleted
	 * This function is called from the ajax functions addSponsor, triggered when an admin sponsors
	 * an item.
	 * 
	 * @param string $sModule
	 * @param int $iItem
	 */
	public function deleteAdminSponsor($sModule,$iItem)
	{
	    $sModule = Phpfox::getLib('parse.input')->clean($sModule);
	    $this->database()->delete(Phpfox::getT('ad_sponsor'), 'module_id = "' . $sModule . '" AND item_id = ' . (int)$iItem . ' AND cpm = 0.00');
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
		if ($sPlugin = Phpfox_Plugin::get('ad.service_process__call'))
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
