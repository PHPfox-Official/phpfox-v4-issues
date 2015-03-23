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
 * @version 		$Id: process.class.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
class Custom_Service_Group_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('custom_group');
	}
	
	public function add($aVals)
	{
		Phpfox::getUserParam('custom.can_add_custom_fields_group', true);
		
		if (!isset($aVals['module_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('custom.provide_a_module_for_this_group_to_belong_to'));
		}
		
		foreach ($aVals['group'] as $sPhrase)
		{
			if (empty($sPhrase))
			{
				continue;
			}
			
			$sVarName = Phpfox::getService('language.phrase.process')->prepare($sPhrase);
			
			break;
		}
		
		if (empty($sVarName))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('custom.provide_a_name_for_this_group'));
		}
		
		$sVarName = 'custom_group_' . $sVarName;
		
		if ($this->database()->select('COUNT(*)')->from($this->_sTable)->where('phrase_var_name = \'' . $this->database()->escape($aVals['module_id'] . '.' . $sVarName) . '\'')->execute('getField'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('custom.there_is_already_a_group_with_the_same_name'));
		}
		
		$iId = $this->database()->insert($this->_sTable, array(
				'module_id' => $aVals['module_id'],
				'product_id' => $aVals['product_id'],
				'user_group_id' => (int) (isset($aVals['user_group_id']) ? $aVals['user_group_id'] : 0),
				'type_id' => $aVals['type_id'],
				'phrase_var_name' => $aVals['module_id'] . '.' . $sVarName,
				'ordering' => 0
			)
		);
		
		// Add the new phrase
		Phpfox::getService('language.phrase.process')->add(array(
				'var_name' => $sVarName,
				'module' => $aVals['module_id'] . '|' . $aVals['module_id'],
				'product_id' => $aVals['product_id'],
				'text' => $aVals['group']
			), true
		);		
		
		return $iId;
	}
	
	public function update($iId, $aVals)
	{
		Phpfox::getUserParam('custom.can_manage_custom_fields', true);
		
		foreach ($aVals['group'] as $sKey => $aPhrases)
		{
			foreach ($aPhrases as $sLang => $sValue)
			{						
				if (Phpfox::getService('language.phrase')->isValid($sKey, $sLang))
				{
					Phpfox::getService('language.phrase.process')->updateVarName($sLang, $sKey, $sValue);					
				}
				else 
				{
					list($sModule, $sVarName) = explode('.', $sKey);
					
					// Add the new phrase
					Phpfox::getService('language.phrase.process')->add(array(
							'var_name' => $sVarName,
							'module' => $sModule . '|' . $sModule,
							'product_id' => $aVals['product_id'],
							'text' => array($sLang => $sValue)
						), true
					);						
				}
			}
		}	
		
		return true;
	}
	
	public function toggleActivity($iId)
	{
		Phpfox::getUserParam('custom.can_manage_custom_fields', true);
		
		$aField = $this->database()->select('group_id, is_active')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aField['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('custom.unable_to_find_the_custom_group'));
		}
		
		$this->database()->update($this->_sTable, array('is_active' => ($aField['is_active'] ? 0 : 1)), 'group_id = ' . $aField['group_id']);
		
		$this->cache()->remove('custom_field', 'substr');
		$this->cache()->remove('custom_public_', 'substr');
		
		return true;
	}	
	
	public function updateOrder($aVals)
	{
		Phpfox::getUserParam('custom.can_manage_custom_fields', true);	
		
		foreach ($aVals as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => (int) $iOrder), 'group_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('custom_field', 'substr');
		
		return true;
	}	
	
	public function delete($iId)
	{
		Phpfox::getUserParam('custom.can_manage_custom_fields', true);	
		
		$aGroup = $this->database()->select('*')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('custom.unable_to_find_the_group_you_plan_on_deleting'));
		}
		
		list($sModule, $sPhrase) = explode('.', $aGroup['phrase_var_name']);
		
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'' . $sModule . '\' AND var_name = \'' . $sPhrase . '\'');				
				
		$this->database()->update(Phpfox::getT('custom_field'), array('group_id' => 0), 'group_id = ' . $aGroup['group_id']);
		
		$this->database()->delete($this->_sTable, 'group_id = ' . $aGroup['group_id']);
		
		$this->cache()->remove('custom_field', 'substr');
				
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
		if ($sPlugin = Phpfox_Plugin::get('custom.service_group_process__call'))
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