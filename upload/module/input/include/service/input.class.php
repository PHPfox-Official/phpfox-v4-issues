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
 * @package 		Phpfox_Service
 * @version 		$Id: custom.class.php 4546 2012-07-20 10:51:18Z Miguel_Espinoza $
 */
class Input_Service_Input extends Phpfox_Service
{
	private $_sAlias = 'cf_';

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('custom_field');
	}

	public function getAlias()
	{
		return $this->_sAlias;
	}

	public function getAll()
	{
		$aInputs = $this->database()->select('i.*')
			->from(Phpfox::getT('input_field'), 'i')
			->order('i.ordering ASC')
			->execute('getSlaveRows');
		$aOut = array();
		
		$aCallbacks = Phpfox::massCallback('getEnabledInputField');
		
		foreach ($aInputs as $aInput)
		{
			$sName = '';
			foreach ($aCallbacks as $sModule => $aVals)
			{
				foreach ($aVals as $aVal)
				{
					if ($aVal['action'] == $aInput['action'])
					{
						$sName = $aVal['module_phrase'];
						break 2;
					}
				}				
			}
			
			if (empty($sName))
			{
				continue;
			}
			
			if (!isset($aOut[$sName]))
			{
				$aOut[$sName] = array();
			}
			if (!isset($aOut[$sName][$aInput['action']]))
			{
				$aOut[$sName][$aInput['action']] = array();
			}
			// we need to add the phrase to this 
			$aOut[$sName][$aInput['action']][] = $aInput;
		}
		return $aOut;
	}
	
	public function getToDisplay($sModule, $sAction, $iItemId)
	{
		
		$oInput = Phpfox::getLib('parse.input');
		// get the fields id
		$aFields = $this->database()->select('i.field_id, i.phrase_var, i.type_id, ist.full_value as short_value, ilt.long_value')
			->from(Phpfox::getT('input_field'), 'i')
			->leftjoin(Phpfox::getT('input_value_shorttext'), 'ist', 'ist.field_id = i.field_id AND ist.item_id = ' . (int)$iItemId)
			->leftjoin(Phpfox::getT('input_value_longtext'), 'ilt', 'ilt.field_id = i.field_id AND ilt.item_id = ' . (int)$iItemId)
			->where('i.module_id = "' . $oInput->clean($sModule) . '" AND i.action = "' . $oInput->clean($sAction) . '"')
			->order('i.ordering ASC')
			->execute('getSlaveRows');
		
		$aOut = array();
		foreach ($aFields as $aField)
		{
			if (!isset($aOut[$aField['field_id']]))
			{
				$aOut[$aField['field_id']] = array('field_id' => $aField['field_id'], 'phrase_var' => $aField['phrase_var']);
			}
			if ($aField['type_id'] == 'shorttext')
			{
				$aOut[$aField['field_id']]['value'] = $aField['short_value'];
			}
			else if ($aField['type_id'] == 'longtext')
			{
				$aOut[$aField['field_id']]['value'] = $aField['long_value'];
			}
			else if ($aField['type_id'] == 'select' || $aField['type_id'] == 'radio')
			{
				$sOption = $this->database()->select('io.phrase_var')
					->from(Phpfox::getT('input_option'), 'io')
					->join(Phpfox::getT('input_value_option'), 'ivo', 'ivo.option_id = io.option_id')
					->where('ivo.field_id = '. $aField['field_id'] .' AND ivo.item_id = ' . (int)$iItemId)
					->execute('getSlaveField');
				
				$aOut[$aField['field_id']]['value'] = Phpfox::getPhrase($sOption);
			}
			else if ($aField['type_id'] == 'multiselect' || $aField['type_id'] == 'checkbox')
			{
				
				$aOptions = $this->database()->select('io.phrase_var')
					->from(Phpfox::getT('input_value_option'), 'ivo')
					->join(Phpfox::getT('input_option'), 'io', 'ivo.field_id = io.field_id AND io.option_id = ivo.option_id')
					->where('ivo.item_id = ' . (int)$iItemId . ' AND ivo.field_id = ' . $aField['field_id'])
					->execute('getSlaveRows');
				
				foreach ($aOptions as $iKey => $aOption)
				{
					$aOptions[$iKey] = Phpfox::getPhrase($aOption['phrase_var']);
				}
				$aOut[$aField['field_id']]['value'] = implode(',', $aOptions);
				
			}
			
			if (empty($aOut[$aField['field_id']]['value'] ))
			{
				unset($aOut[$aField['field_id']] );
			}
		}
		return $aOut;
	}
	
	public function get($aParams, $bCheckPermissions = true)
	{			
		if (/*empty($aParams['action']) || */empty($aParams['module']))
		{			
			return Phpfox_Error::set('Insufficient params');
		}
		$oInput = Phpfox::getLib('parse.input');
		$aInputs = $this->database()->select('i.*,i.phrase_var as input_name_var, io.option_id, io.phrase_var, ifc.access_id, ifc.table_name, ifc.column_name, ifc.operand, ifc.full_value')
			->from(Phpfox::getT('input_field'), 'i')
			->leftjoin(Phpfox::getT('input_option'), 'io', 'io.field_id = i.field_id')
			->leftjoin(Phpfox::getT('input_field_condition'),' ifc', 'ifc.field_id = i.field_id')
			->where('i.module_id = "'. $oInput->clean($aParams['module']) .'"' . (!empty($aParams['action']) ? ' AND i.action = "'. $oInput->clean($aParams['action']).'"': '') )
			->order('i.ordering ASC, io.ordering ASC')
			->execute('getSlaveRows');		
		
		
		$aOut = array();
		foreach ($aInputs as $aInput)
		{
			if (!isset($aOut[$aInput['field_id']]))
			{
				$aOut[$aInput['field_id']] = $aInput;
				$aOut[$aInput['field_id']]['condition'] = array();
				if (strpos($aInput['type_id'], 'text') === false)
				{
					$aOut[$aInput['field_id']]['option'] = array();
				}
			}
			
			if (isset($aInput['table_name']) && !empty($aInput['table_name']) && isset($aInput['access_id']) && !empty($aInput['access_id']))
			{
				$aOut[$aInput['field_id']]['condition'][$aInput['access_id']] = array(
					'table_name' => $aInput['table_name'],
					'column_name' => $aInput['column_name'],
					'operand' => $aInput['operand'],
					'full_value' => $aInput['full_value'],
					'access_id' => $aInput['access_id']);
				
				// Check on Conditions to filter displaying				
				if ($bCheckPermissions && $this->canEnterInfo($aInput) == false)
				{
					unset($aOut[$aInput['field_id']]);					
					continue;
				}
				unset($aOut[$aInput['field_id']]['table_name']);
				unset($aOut[$aInput['field_id']]['column_name']);
				unset($aOut[$aInput['field_id']]['operand']);
				unset($aOut[$aInput['field_id']]['full_value']);
				unset($aOut[$aInput['field_id']]['access_id']);
			}
			
			if (isset($aInput['option_id']) && !empty($aInput['option_id']))
			{
				$aOut[$aInput['field_id']]['option'][$aInput['option_id']] = array(
					'option_id' => $aInput['option_id'],
					'phrase_var' => $aInput['phrase_var'],
					'phrase_text' => Phpfox::getPhrase($aInput['phrase_var'])
				);
				
			}
			unset($aOut[$aInput['field_id']]['option_id']);
			unset($aOut[$aInput['field_id']]['phrase_var']);
		}
		
		return $aOut;
	}
	
	
	public function getForEdit($iId)
	{
		$aInput = $this->database()->select('i.*, ifc.table_name, ifc.column_name, ifc.operand, ifc.full_value')
			->from(Phpfox::getT('input_field'),'i')
			->leftjoin(Phpfox::getT('input_field_condition'), 'ifc', 'ifc.field_id = i.field_id')
			->where('i.field_id = ' . (int)$iId)
			->execute('getSlaveRows');
		
		$aOut = array('condition' => array());
		// merge conditions
		foreach ($aInput as $iKey => $aVal)
		{
			if (!isset($aOut['module_id']))
			{
				$aOut['module_id'] = $aVal['module_id'];
				$aOut['type_id'] = $aVal['type_id'];
				$aOut['phrase_var'] = $aVal['phrase_var'];
				$aOut['action'] = $aVal['action'];
				$aOut['is_required'] = $aVal['is_required'];
			}
			
			if (!empty($aVal['table_name']))
			{
				$aOut['condition'][] = array(
					'table_name' => $aVal['table_name'],
					'column_name' => $aVal['column_name'],
					'operand' => $aVal['operand'],
					'full_value' => $aVal['full_value']
				);
			}
			
			if (strpos($aVal['type_id'], 'text') === false)
			{
				$aOptions = $this->database()->select('io.option_id, io.phrase_var')
					->from(Phpfox::getT('input_option'), 'io')		
					->order('io.ordering ASC, io.option_id ASC')
					->where('io.field_id = ' . (int)$iId)
					->execute('getSlaveRows');
				
				$aOut['option'] = array();
				$aIn = array();
				foreach ($aOptions as $aOption)
				{
					$aIn[] = str_replace('input.','', $aOption['phrase_var']);
				}
				$sIn = implode('","', $aIn); 
				$aPhrases = $this->database()->select('language_id, phrase_id, text, var_name')
					->from(Phpfox::getT('language_phrase'))
					->where('var_name IN ("'. $sIn .'")')
					->execute('getSlaveRows');
					
				foreach ($aOptions as $iKey => $aOption)
				{
					foreach ($aPhrases as $aPhrase)
					{
						if ($aOption['phrase_var'] == 'input.' . $aPhrase['var_name'])
						{
							$aOptions[$iKey]['language_id'] = $aPhrase['language_id'];
							$aOptions[$iKey]['phrase_id'] = $aPhrase['phrase_id'];
							$aOptions[$iKey]['text'] = $aPhrase['text'];
							break;
						}
					}
				}
				$aOut['option'] = $aOptions;
			}
			unset($aInput[$iKey]['table_name']);
			unset($aInput[$iKey]['column_name']);
			unset($aInput[$iKey]['operand']);
			unset($aInput[$iKey]['full_value']);
		}
		
		
		
		list($sModule, $sPhraseVar) = explode('.', $aOut['phrase_var']);
		$aOut['name'] = Phpfox::getService('language')->getPhraseInEveryLanguage($sModule, $sPhraseVar);
		
		
		return $aOut;
	}
	/*
	* This function checks if a user can enter information into an Input by checking on the conditions for this field
	*/
	public function canEnterInfo($aVals)
	{		
		if ($aVals['table_name'] == 'user' && ($aVals['operand'] == 'has' || $aVals['operand'] == '=') && strpos($aVals['full_value'], Phpfox::getUserBy($aVals['column_name'])) !== false)
		{
			// we should be able to use getUserBy
			return true;
		}
		
		return false;
	}
	
	/* This function populates $aVals with inputs taken from sAction that match $iItemId*/
	public function getInputsFor(&$aVals, $sAction, $iId)
	{
		list($sModule,$sAction) = explode('.', $sAction);
		$aInputs = $this->get(array('module' => $sModule, 'action' => $sAction));
		if (empty($aInputs))
		{
			return;
		}
		// now we have the ids, lets get the values
		$aIdsShortText = array();
		
		foreach ($aInputs as $aInput)
		{
			$aIds[] = $aInput['field_id'];
		}
		$aValues = $this->database()->select('i.field_id, i.type_id, ist.full_value, ilt.long_value')
			->from(Phpfox::getT('input_field'), 'i')
			->leftjoin(Phpfox::getT('input_value_longtext'), 'ilt', 'ilt.field_id = i.field_id AND ilt.item_id = ' . (int)$iId)
			->leftjoin(Phpfox::getT('input_value_shorttext'), 'ist', 'ist.field_id = i.field_id AND ist.item_id = ' . (int)$iId)			
			// ->leftjoin() the other tables
			->where('i.field_id IN (' . implode(',',$aIds) .')')
			->execute('getSlaveRows');
		
		// If there are any select/multiselect/checkbox/radio input we need to get the options available and flatten them
		
		
		$aIn = array();
		foreach ($aValues as $aValue)
		{
			if ($aValue['type_id'] == 'shorttext')
			{
				$aVals['input_' . $aValue['field_id']] = $aValue['full_value'];
			}
			else if ($aValue['type_id'] == 'longtext')
			{
				$aVals['input_' . $aValue['field_id']] = $aValue['long_value'];
			}
			else
			{				
				$aIn[] = $aValue['field_id'];
			}
		}
		
		if (!empty($aIn))
		{
			$aOptions = $this->database()->select('io.field_id, io.option_id, i.type_id')
				->from(Phpfox::getT('input_value_option'), 'ivo')				
				->join(Phpfox::getT('input_option'), 'io', 'io.option_id = ivo.option_id')
				->join(Phpfox::getT('input_field'), 'i', 'i.field_id = io.field_id')
				->where('io.field_id IN (' . implode(',', $aIn) .')')
				->execute('getSlaveRows');
			//d($aOptions);
			if (!empty($aOptions))
			{
				foreach ($aOptions as $aOption)
				{
					if ( in_array($aOption['type_id'], array('checkbox', 'multiselect')) == true)
					{
						if (!isset($aVals['input_' . $aOption['field_id']] ))
						{
							$aVals['input_' . $aOption['field_id']]  = array();
						}
						$aVals['input_' . $aOption['field_id']][] = $aOption['option_id'];
						$aVals['input_multi_' . $aOption['option_id']] = $aOption['option_id'];
					}
					else
					{
						$aVals['input_' . $aOption['field_id']] = $aOption['option_id'];
					}
					
					/*if (!isset($aVals['input_' . $aOption['field_id']]))
					{
						$aVals['input_' . $aOption['field_id']] = array();
					}
					$aVals['input_' . $aOption['field_id']][$aOption['option_id']] = $aOption['phrase_var'];*/
				}
			}			
		}
		
		// d($aVals);				die();
	}
	
	/*
		This function gets all the inputs based on the module. It is used in the Search library to 
		populate search fields
	*/
	public function getInputsForSearch($sModule)
	{
		if (!Phpfox::isModule($sModule))
		{
			return array();
		}
		
		$sCacheId = $this->cache()->set(array('inputs', $sModule));
		if (!($aInputsPerModule = $this->cache()->get($sCacheId)))
		{
			$aInputsPerModule = $this->database()->select('i.*, io.phrase_var as option_phrase_var')
				->from(Phpfox::getT('input_field'), 'i')
				->leftjoin(Phpfox::getT('input_option'),' io', 'io.field_id = i.field_id')
				->where('module_id = "'. $this->database()->escape($sModule) .'"')// AND type_id NOT IN ("shorttext", "longtext")')
				->execute('getSlaveRows');

			$this->cache()->save($sCacheId, $aInputsPerModule);
		}
		
		$aOut = array();
		foreach ((array) $aInputsPerModule as $aInput)
		{
			if (empty($aInput['phrase_var']))
			{
				continue;
			}
			$sPhrase = Phpfox::getPhrase($aInput['phrase_var']);
			if (!isset($aOut[$sPhrase]))
			{
				$aOut[$sPhrase] = array(
					'param' => strtolower(str_replace(' ','-',Phpfox::getPhrase($aInput['phrase_var']))),
					'default_phrase' => Phpfox::getPhrase($aInput['phrase_var']),
					'input_var_name' => $aInput['phrase_var'],
					'data' => array(),
					'is_input' => true,
					'type_id' => $aInput['type_id'],
					'module' => $aInput['module_id']
				);
			}
			
				
			if (!empty($aInput['option_phrase_var']))
			{
				$aOut[$sPhrase]['data'][] = array(
					'link' => strtolower(str_replace(' ','-',Phpfox::getPhrase($aInput['option_phrase_var']))),
					'phrase' => Phpfox::getPhrase($aInput['option_phrase_var'])
				);
				$aOut[$sPhrase]['height'] = '300px';
				$aOut[$sPhrase]['width'] = '150px';
			}
		}
				
		return $aOut;
	}
	
	/**
		@param $aInputs Match an input_id to a value(<int> => <mixed>)
	*/
	public function getJoinsForSearch($aPassedInputs, $sModule)
	{
		$aIds = array_keys($aPassedInputs);
		foreach ($aIds as $iIndex => $iId)
		{
			if (!is_int($iId) || $iId < 1)
			{
				unset($aIds[$iIndex]);
			}
		}
		$aCallback = Phpfox::callback($sModule .'.getEnabledInputField');
		
		// At this point there is only one level 
		$aCallback = array_pop($aCallback);
		
		$aInputs = $this->database()->select('i.field_id, i.type_id')
			->from(Phpfox::getT('input_field'), 'i')
			->where('i.module_id = "'.$sModule .'" AND field_id IN ('. implode(',', $aIds) .')')
			->execute('getSlaveRows');
						
		$this->database()->select('ct.' . $aCallback['item_column'])
			->from($aCallback['table'], 'ct');
			
		$oInput = Phpfox::getLib('parse.input');
		foreach ($aInputs as $aInput)
		{
			if ($aInput['type_id'] == 'shorttext')
			{
				$sInput = $oInput->clean($aPassedInputs[$aInput['field_id']]);
				$this->database()->join(Phpfox::getT('input_value_shorttext'), 'st', 'st.item_id = ct.'. $aCallback['item_column'] . ' AND st.full_value LIKE "%'. $sInput .'%"');
			}
			else if ($aInput['type_id'] == 'longtext')
			{
				$sInput = $oInput->clean($aPassedInputs[$aInput['field_id']]);
				$this->database()->join(Phpfox::getT('input_value_longtext'), 'st', 'st.item_id = ct.'. $aCallback['item_column'] . ' AND st.long_value LIKE "%'. $sInput .'%"');
			}
			else if ( ($aInput['type_id'] == 'checkbox') || ($aInput['type_id'] == 'radio') || (strpos($aInput['type_id'], 'select')))
			{
				
			}
		}
		
		$aValidIds = $this->database()->execute('getSlaveRows');
		$aOut = array();
		
		foreach ($aValidIds as $aRow)
		{
			$aOut[] = $aRow[$aCallback['item_column']];
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
		if ($sPlugin = Phpfox_Plugin::get('custom.service_custom__call'))
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
