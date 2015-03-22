<?php

defined('PHPFOX') or exit('No dice!');

class Custom_Service_Relation_Relation extends Phpfox_Service
{

	public function __construct()
	{
		$this->_sTable = Phpfox::getT('custom_relation');
	}

	/**
	 * Gets all the status including their id and the phrase variable
	 * @return array 
	 */
	public function getAll()
	{
		$aStatuses = $this->database()->select('*')
				->from($this->_sTable)
				->order('relation_id ASC')
				->execute('getSlaveRows');		
		
		/* We need to get these phrases (new, feed_with, feed_new) for every language available*/
		/* so lets prepare the query */
		$sWhere = 'module_id = "custom" AND (';
		foreach ($aStatuses as $aStatus)
		{
			$aStatus['phrase_var_name'] = substr($aStatus['phrase_var_name'], strpos($aStatus['phrase_var_name'],'.')+1);
			$sWhere .= 'var_name = "' . $aStatus['phrase_var_name'] . '" OR ';
			$sWhere .= 'var_name = "' . $aStatus['phrase_var_name'] . '_new" OR ';
			$sWhere .= 'var_name = "' . $aStatus['phrase_var_name'] . '_with" OR ';
		}
		$sWhere = rtrim($sWhere, ' OR ') . ')';
		
		$aPhrases = $this->database()->select('language_id, text, var_name')
				->from(Phpfox::getT('language_phrase'))
				->where($sWhere)
				->execute('getSlaveRows');
		
		/* Glue them together */
		foreach ($aStatuses as $iKey => $aStatus)
		{
			$aStatuses[$iKey]['phrase']['feed_new'] = '';
			$aStatuses[$iKey]['phrase']['feed_with'] = '';
			$aStatuses[$iKey]['phrase']['new'] = '';
			foreach ($aPhrases as $aPhrase)
			{				
				if ( $aStatus['phrase_var_name'] . '_new' == 'custom.'.$aPhrase['var_name'])
				{
					$aStatuses[$iKey]['phrase']['feed_new'] = 'custom.'. $aPhrase['var_name'];
				}
				elseif ( $aStatus['phrase_var_name'] . '_with' == 'custom.'.$aPhrase['var_name'])
				{
					$aStatuses[$iKey]['phrase']['feed_with'] = 'custom.'. $aPhrase['var_name'];
				}
				elseif ($aStatus['phrase_var_name'] == 'custom.'.$aPhrase['var_name'])
				{
					$aStatuses[$iKey]['phrase']['new'] = 'custom.'. $aPhrase['var_name'];
				}				
			}
		}
		return $aStatuses;
	}

	/**
	 * Gets the Latest relation status of $iUser
	 * @param int $iUserId user_id
	 * @param int $iBeforeId Used to get the second to newest. relation_data_id
	 * @return array 
	 */
	public function getLatestForUser($iUserId, $iBeforeId = null, $bStarted = false)
	{
		$sWhere ='';
		if ($iBeforeId != null)
		{
			$sWhere .= 'crd.relation_data_id < ' . (int)$iBeforeId;
		}
		if ($bStarted == true)
		{
			$sWhere .= '(crd.user_id = ' . (int) $iUserId . ')';
		}
		else
		{
			$sWhere = '(crd.user_id = ' . (int) $iUserId . ') OR crd.with_user_id = ' . (int) $iUserId .'';
		}
		
		$aRelation = $this->database()->select('*')
				->from(Phpfox::getT('custom_relation_data'), 'crd')
				->where($sWhere)
				->join(Phpfox::getT('custom_relation'), 'cr', 'cr.relation_id = crd.relation_id')
				->order('crd.relation_data_id DESC')
				->limit(1)
				->execute('getSlaveRow');

		/* we dont need the phrase or do we...? */
		if (empty($aRelation))
		{
			return array();
		}
		/* get the other user's full_name and image */
		$this->database()->select(Phpfox::getUserField())
				->from(Phpfox::getT('user'), 'u');
		if ($aRelation['with_user_id'] == $iUserId)
		{
			$this->database()->where('user_id = ' . $aRelation['user_id']);
		}
		else
		{
			$this->database()->where('user_id = ' . $aRelation['with_user_id']);
		}
		
		$aWith = $this->database()->execute('getSlaveRow');
		$aRelation['with_user'] = array_merge($aRelation, $aWith);
					
		return $aRelation;
	}

	/**
	 * Returns one relationship status given its id from the 
	 * custom_relation_data table
	 * @param int $iId
	 * @return array
	 */
	public function getDataById($iId)
	{
		$aRequest = $this->database()->select('*')
				->from(Phpfox::getT('custom_relation_data'))
				->where('relation_data_id = ' . (int)$iId)
				->limit(1)
				->execute('getSlaveRow');
		
		/* plug in maybe? not very used now though */
		return $aRequest;
	}
}

?>
