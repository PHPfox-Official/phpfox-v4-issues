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
 * @package  		Module_User
 * @version 		$Id: process.class.php 6547 2013-08-30 09:59:50Z Fern $
 */
class User_Service_Group_Setting_Process extends Phpfox_Service 
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user_group_setting');
	}
	
	public function addSetting($aVals)
	{		
		$aModules = explode('|', $aVals['module']);
		
		$aVals['name'] = strtolower(preg_replace("/\W/i", "_", $aVals['name']));
		
		// Look thru all the values in case we need to do some work
		foreach ($aVals['user_group'] as $iGroupId => $sValue)
		{
			// Switch thur all the types
			switch ($aVals['type'])
			{
				// Fix arrays
				case 'array':
					// Make sure it is an array
					if (preg_match("/^array\((.*)\);$/i", $sValue))
					{			
						// Yes it is, lets serialize
						$aVals['user_group'][$iGroupId] = serialize($sValue);
					}
					else 
					{
						return Phpfox_Error::set(Phpfox::getPhrase('admincp.not_valid_array'));
					}
					break;
			}
		}	
		
		$this->database()->insert($this->_sTable, array(
				'module_id' => $aModules[0],
				'product_id' => $aVals['product_id'],
				'name' => $aVals['name'],
				'type_id' => $aVals['type'],
				'default_admin' => $aVals['user_group'][ADMIN_USER_ID],
				'default_user' => $aVals['user_group'][NORMAL_USER_ID],
				'default_guest' => $aVals['user_group'][GUEST_USER_ID],
				'default_staff' => $aVals['user_group'][STAFF_USER_ID]
			)
		);
		
		Phpfox::getService('language.phrase.process')->add(array(
				'var_name' => 'user_setting_' . $aVals['name'],
				'product_id' => $aVals['product_id'],
				'module' => $aVals['module'],
				'text' => $aVals['text']
			)
		);
		
		Phpfox::getLib('session')->set('cache_new_user_setting', $aModules[0] . '.' . $aVals['name']);
		
		$this->cache()->remove('user_group_setting', 'substr');
		
		return true;
	}
	
	public function updateSetting($aVals)
	{
		$aModules = explode('|', $aVals['module']);
		
		$aVals['name'] = strtolower(preg_replace("/\W/i", "_", $aVals['name']));	
		
		$this->database()->update($this->_sTable, array(
			'module_id' => $aModules[0],
			'product_id' => $aVals['product_id'],
			'name' => $aVals['name'],
			'type_id' => $aVals['type'],
			'default_admin' => $aVals['user_group'][ADMIN_USER_ID],
			'default_user' => $aVals['user_group'][NORMAL_USER_ID],
			'default_guest' => $aVals['user_group'][GUEST_USER_ID],
			'default_staff' => $aVals['user_group'][STAFF_USER_ID]
		), 'setting_id = ' . (int) $aVals['setting_id']);
		
		if (Phpfox::getLib('locale')->isPhrase('admincp.user_setting_' . $aVals['name']))
		{
			foreach ($aVals['text'] as $sLang => $sValue)
			{
				Phpfox::getService('language.phrase.process')->updateVarName($sLang, 'admincp.user_setting_' . $aVals['name'], $sValue);
			}			
		}
		else 
		{
			Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'user_setting_' . $aVals['name'],
					'product_id' => $aVals['product_id'],
					'module' => $aVals['module'],
					'text' => $aVals['text']
				)
			);
		}
		
		$this->cache()->remove('user_group_setting', 'substr');
		
		return true;
	}	

	/**
	 * Updates the table phpfox_user_group_setting
	 * @param int $iGroupId
	 * @param array $aVals array(value_actual => array(setting_id => #))
	 * @return true
	 */
	public function update($iGroupId, $aVals)
	{		
		if (isset($aVals['order']))
		{
			foreach ($aVals['order'] as $iId => $iOrder)
			{	
				$this->database()->update($this->_sTable, array('ordering' => $iOrder), 'setting_id = ' . (int) $iId);	
			}
		}			
				
		$aSettings = array();
		$aRows = $this->database()->select('setting_id, type_id')
			->from($this->_sTable)
			->execute('getRows');
		foreach ($aRows as $aRow)
		{
			$aSettings[$aRow['setting_id']] = $aRow['type_id'];
		}			
		/*
		if (!isset($aSql['value_actual']))
        {
			return false;
		}
		*/	
		
		$aSql = array();
		foreach ($aVals['value_actual'] as $iId => $sValue)
		{
			if (!isset($aSettings[$iId]))
			{
				continue;
			}
			
			// Check on callbacks to verify values
			if (isset($aVals['param']) && isset($aVals['param'][$iId]))
			{				
				if (preg_match('/(?P<module>[a-z]+)\.(?P<variable>[a-z0-9\_\-]+)/i', $aVals['param'][$iId], $aMatches) > 0 && isset($aMatches['module']) && isset($aMatches['variable']) && Phpfox::hasCallback($aMatches['module'], 'isValidUserGroupSetting'))
				{				
					$bValid = Phpfox::callback($aMatches['module'] . '.isValidUserGroupSetting', array('user_group_id' => $iGroupId, 'variable' => $aMatches['variable'], 'value' => $sValue));
					if ($bValid == false)
					{						
						Phpfox_Error::set('Invalid value "'. $sValue . '" for setting "'. $aMatches['module'] .'.' . $aMatches['variable'] .'"');
						continue;
					}
				}
			}
			
			$this->database()->delete(Phpfox::getT('user_setting'), "user_group_id = " . (int) $iGroupId . " AND setting_id = " . (int) $iId);
			
			// Make sure the values are correct and if not fix them
			switch ($aSettings[$iId])
			{
				case 'array':
					$aArrayParts = explode(',', $sValue);
					$sNewValue = 'array(';
					foreach ($aArrayParts as $sArrayPart)
					{
						$sNewValue .= '\'' . trim($sArrayPart) . '\',';
					}
					$sValue = serialize(rtrim($sNewValue, ',') . ');');					
					break;
				case 'boolean':
					if ($sValue != '1' && $sValue != '0')
					{
						$sValue = '0';
					}
					break;
                                case 'integer':					
					$sValue = strtolower($sValue);
					if (!is_numeric($sValue) && $sValue != 'null')
					{
						$sValue = 0;
					}
					break;
                                case 'string' && !is_array($sValue):
                                        $sValue = Phpfox::getLib('parse.input')->clean($sValue);
                                        $sValue = Phpfox::getLib('parse.output')->shorten($sValue, 255);
                                        break;
			}

			if (isset($aVals['sponsor_setting_id_'.$iId]) && $iId == $aVals['sponsor_setting_id_'.$iId])
			{
				
			    $iEmpty = 0;
			    foreach($aVals['value_actual'][$iId] as $sCurrency => $iValue)
			    {
					if (preg_match('/[^\d\.]/',$iValue))
					{
						return Phpfox_Error::set(mysql_real_escape_string(Phpfox::getPhrase('core.money_field_only_accepts_numbers_and_point')));
					}
					if (empty($iValue))
					{
						$iEmpty++;
					}
					if (substr_count($iValue, '.') > 1)
					{
						return Phpfox_Error::set(Phpfox::getPhrase('core.only_one_point_is_allowed'));
					}
			    }
			    if ($iEmpty > 0 && count($aVals['value_actual'][$iId]) > $iEmpty)
			    {
					return Phpfox_Error::set(Phpfox::getPhrase('core.money_fields_are_required'));
			    }
			    $sValue = serialize($aVals['value_actual'][$iId]);
			    $bDeb = true;
			}

			$aSql[] = array(
				$iGroupId,
				$iId,
				$sValue
			);
			
		}		
		//d('Final:');
		//d($aSql);die();
		
		foreach ($aSql as $aRow)
		{
			$this->database()->delete(Phpfox::getT('user_setting'), 'user_group_id = ' . $aRow[0] . ' AND setting_id = ' . $aRow[1]);
			$this->database()->insert(Phpfox::getT('user_setting'), array( 'user_group_id' => $aRow[0], 'setting_id' => $aRow[1], 'value_actual' => $aRow[2]));
		}
		/*
		$this->database()->multiInsert(Phpfox::getT('user_setting'), array(
			'user_group_id',
			'setting_id',
			'value_actual'
		), $aSql);			
		*/
		if (!isset($aVals['bDontClearCache']))
		{
			$this->cache()->remove('user_group_setting_' . $iGroupId);
		}		
		
		return true;
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		if (!$iProductId)
		{
			$iProductId = 1;
		}
		
		if ($bMissingOnly)
		{
			$aCache = array();
			$aRows = $this->database()->select('name')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));				
			foreach ($aRows as $aRow)
			{
				$aCache[] = $aRow['name'];
			}								
				
			$aSql = array();
			foreach ($aVals['setting'] as $aVal)
			{
				if (!in_array($aVal['value'], $aCache))
				{
					$iModuleId = Phpfox::getLib('module')->getModuleId($aVal['module']);
					$aSql[] = array(
						$iModuleId,
						$iProductId,
						$aVal['value'],
						$aVal['type'],
						$aVal['admin'],
						$aVal['user'],
						$aVal['guest'],
						$aVal['staff'],
						$aVal['ordering']
					);
				}
			}			
				
			if ($aSql)
			{
				$this->database()->multiInsert($this->_sTable, array(
					'module_id',
					'product_id',
					'name',
					'type',
					'default_admin',
					'default_user',
					'default_guest',
					'default_staff',
					'ordering'
				), $aSql);
				
				$this->cache()->remove('user_group_setting', 'substr');
			}
		}
		else 
		{
			$aSql = array();		
			foreach ($aVals['setting'] as $aVal)
			{
				$iModuleId = (int) Phpfox::getLib('module')->getModuleId($aVal['module']);
				$aSql[] = array(
					$iModuleId,
					$iProductId,
					$aVal['value'],
					$aVal['type'],
					$aVal['admin'],
					$aVal['user'],
					$aVal['guest'],
					$aVal['staff'],
					$aVal['ordering']					
				);
			}	
			
			$this->database()->multiInsert($this->_sTable, array(
				'module_id',
				'product_id',
				'name',
				'type',
				'default_admin',
				'default_user',
				'default_guest',
				'default_staff',
				'ordering'
			), $aSql);	
			
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_group_setting_process__call'))
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