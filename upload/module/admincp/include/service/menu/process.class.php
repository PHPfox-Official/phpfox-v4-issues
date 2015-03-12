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
 * @package  		Module_Admincp
 * @version 		$Id: process.class.php 4335 2012-06-25 14:51:10Z Miguel_Espinoza $
 */
class Admincp_Service_Menu_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('menu');
	}
	
	public function add($aVals, $bIsUpdate = false)
	{
		if (empty($aVals['module_id']))
		{
			$aVals['module_id'] = 'core|core';
		}
		
		$aModule = explode('|', $aVals['module_id']);
		
		// Find the user groups we disallowed
		$aDisallow = array();
		$aUserGroups = Phpfox::getService('user.group')->get();
		if (isset($aVals['allow_access']))
		{			
			foreach ($aUserGroups as $aUserGroup)
			{
				if (!in_array($aUserGroup['user_group_id'], $aVals['allow_access']))
				{
					$aDisallow[] = $aUserGroup['user_group_id'];
				}
			}			
		}
		else 
		{
			foreach ($aUserGroups as $aUserGroup)
			{
				$aDisallow[] = $aUserGroup['user_group_id'];
			}				
		}	

		foreach ($aVals['text'] as $iId => $sText)
		{
			$sVarName =  $aModule[0] . '_' . Phpfox::getService('language.phrase.process')->prepare($sText);
			break;
		}	
	
		$sVarName = 'menu_' . $sVarName . '_' . md5($aVals['m_connection']);		
	
		$aInsert = array(
			'page_id' => (isset($aVals['page_id']) ? (int) $aVals['page_id'] : 0),
			'm_connection' => strtolower($aVals['m_connection']),
			'module_id' => $aModule[0],
			'product_id' => $aVals['product_id'],			
			'is_active' => 1,
			'url_value' => $aVals['url_value'],
			'disallow_access' => (count($aDisallow) ? serialize($aDisallow) : null),
			'mobile_icon' => (empty($aVals['mobile_icon']) ? null : $aVals['mobile_icon'])
		);
		
		if (preg_match('/child\|(.*)/i', $aVals['m_connection'], $aMatches))
		{
			if (isset($aMatches[1]))
			{
				$aInsert['m_connection'] = null;
				$aInsert['parent_id'] = $aMatches[1];
			}
		}
		else if ($aVals['m_connection'] == 'explore' || $aVals['m_connection'] == 'main')
		{
			$aInsert['parent_id'] = 0;
		}
		
		if ($bIsUpdate)
		{			
			$this->database()->update($this->_sTable, $aInsert, 'menu_id = ' . (int) $aVals['menu_id']);
			foreach ($aVals['text'] as $iId => $sText)
			{
				Phpfox::getService('language.phrase.process')->update($iId, $sText, array(
						'module_id' => $aModule[0]
					)
				);
			}			
		}
		else 
		{
			// Get the last order number
			$iLastCount = $this->database()->select('ordering')
				->from($this->_sTable)
				->order('ordering DESC')
				->execute('getField');				
			
			// Define some remaining vars we plan to insert
			$aInsert['ordering'] = ($iLastCount + 1);
			$aInsert['version_id'] = PhpFox::getId();
			$aInsert['var_name'] = $sVarName;			
			
			// Insert into DB
			$this->database()->insert($this->_sTable, $aInsert);
			
			// Add the new phrase
			Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => $sVarName,
					'module' => $aVals['module_id'],
					'product_id' => $aVals['product_id'],
					'text' => $aVals['text']
				)
			);			
		}	
		
		// Clear the menu cache using the substr method, which will clear anything that has a "menu" prefix
		$this->cache()->remove();
		
		return true;
	}
	
	public function update($iId, $aVals)
	{
		$aVals['menu_id'] = $iId;
		
		return $this->add($aVals, true);
	}
	
	public function updateOrder($aVals)
	{
		foreach ($aVals as $iId => $aValue)
		{
			$this->database()->update($this->_sTable, array(
				'is_active' => (isset($aValue['is_active']) ? 1 : 0),
				'ordering' => (int) $aValue['ordering'],				
			), 'menu_id = ' . (int) $iId);
		}
		
		$this->cache()->remove(array('theme', 'menu'), 'substr');
		
		return true;
	}
	
	public function delete($iDeleteId, $bIsVar = false)
	{
		$aVar = $this->database()->select('menu_id, module_id, var_name')
			->from($this->_sTable)
			->where(($bIsVar ? "url_value = '" . $this->database()->escape($iDeleteId) . "'" : 'menu_id = ' . (int) $iDeleteId))
			->execute('getRow');
			
		if (!isset($aVar['module_id']))
		{
			return false;
		}
		
		$this->database()->delete($this->_sTable, ($bIsVar ? "url_value = '" . $this->database()->escape($iDeleteId) . "'" : 'menu_id = ' . (int) $iDeleteId));
		$this->database()->delete($this->_sTable, 'parent_id = ' . $aVar['menu_id']);
		
		Phpfox::getService('language.phrase.process')->delete($aVar['module_id'] . '.' . $aVar['var_name'], true);
		
		// Clear menu and language cache
		$this->cache()->remove(array('theme', 'menu'), 'substr');
		$this->cache()->remove(array('locale', 'language'), 'substr');	
		
		return true;
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		
		$aCache = array();
		if ($bMissingOnly)
		{
			$aRows = $this->database()->select('var_name')
				->from($this->_sTable)
				->execute('getRows', array(
						'free_result' => true
					)
				);
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['var_name']] = $aRow['var_name'];
			}
		}
		
		$aSql = array();
		$aVals = (isset($aVals['menu'][0]) ? $aVals['menu'] : array($aVals['menu']));
		foreach ($aVals as $aVal)
		{
			if ($bMissingOnly && in_array($aVal['var_name'], $aCache))
			{
				continue;
			}			
			
			$iModuleId = Phpfox::getLib('module')->getModuleId($aVal['module']);
			$aSql[] = array(	
				$aVal['parent_id'],
				$aVal['m_connection'],
				$iModuleId,
				$iProductId,
				$aVal['var_name'],
				1,
				$aVal['ordering'],
				$aVal['url_value'],
				(empty($aVal['disallow_access']) ? null : $aVal['disallow_access']),
				$aVal['version_id']
			);
		}
		
		if ($aSql)
		{
			$this->database()->multiInsert($this->_sTable, array(
				'parent_id',
				'm_connection',
				'module_id',
				'product_id',
				'var_name',
				'is_active',
				'ordering',
				'url_value',
				'disallow_access',
				'version_id'
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_menu_process__call'))
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