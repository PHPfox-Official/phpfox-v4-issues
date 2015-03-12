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
 * @version 		$Id: process.class.php 2228 2010-12-02 21:02:59Z Raymond_Benc $
 */
class Admincp_Service_Block_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('block');
	}
	
	public function add($aVals, $bIsUpdate = false)
	{			
		if (!$aVals['type_id'] && empty($aVals['component']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.select_component'));
		}
		
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
		
		if (!$aVals['type_id'])
		{
			$aParts = explode('|', $aVals['component']);
			$aVals['component'] = $aParts[1];
			// $aVals['module_id'] = Phpfox::getLib('module')->getModuleId($aParts[0]);
		}
		else 
		{
			$aParts = explode('|', $aVals['m_connection']);
			$aVals['component'] = null;
			// $aVals['module_id'] = Phpfox::getLib('module')->getModuleId($aParts[0]);	
		}
		
		if (empty($aVals['module_id']))
		{
			$aVals['module_id'] = 'core';
		}
		
		$aVals['disallow_access'] = (count($aDisallow) ? serialize($aDisallow) : null);
		$aVals['title'] = (empty($aVals['title']) ? null : $this->preParse()->clean($aVals['title']));
		
		if (isset($aVals['style_id']) && is_array($aVals['style_id']))
		{
			$aPostInfo = array();
			foreach ($aVals['style_id'] as $iStyleId => $iLocation)
			{
				if (empty($iLocation))
				{
					continue;
				}
				
				$aPostInfo[$iStyleId] = $iLocation;
			}
			
			if (count($aPostInfo))
			{
				$aVals['location'] = serialize(array('g' => $aVals['location'], 's' => $aPostInfo));	
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('admincp.service_block_process_add')) ? eval($sPlugin) : false);
		
		if ($bIsUpdate)
		{
			$iId = $aVals['block_id'];
			$this->database()->process(array(			
				'type_id' => 'int',
				'title',
				'm_connection',
				'module_id',
				'product_id',		
				'component',	
				'location',
				'is_active' => 'int',
				'disallow_access',
				'can_move' => 'int'
			), $aVals)->update($this->_sTable, 'block_id = ' . (int) $aVals['block_id']);			
			
			if (!$aVals['can_move'])
			{
				if ($aVals['m_connection'] == 'core.index-member')
				{
					$this->database()->delete(Phpfox::getT('user_dashboard'), 'cache_id = \'js_block_border_' . $aVals['module_id'] . '_' . $aVals['component'] . '\'');
				}
				
				if ($aVals['m_connection'] == 'profile.index')
				{
					$this->database()->delete(Phpfox::getT('user_design_order'), 'cache_id = \'js_block_border_' . $aVals['module_id'] . '_' . $aVals['component'] . '\'');
				}				
			}
		}
		else 
		{
			$iCount = $this->database()->select('ordering')
				->from($this->_sTable)
				->where("m_connection = '" . $this->database()->escape($aVals['m_connection']) . "'")
				->order('ordering DESC')
				->execute('getField');				
			
			$aVals['ordering'] = ($iCount + 1);
			$aVals['version_id'] = PhpFox::getId();		
			
			$iId = $this->database()->process(array(	
				'type_id' => 'int',
				'title',
				'm_connection',
				'module_id',
				'product_id',		
				'component',	
				'location' => 'int',
				'is_active' => 'int',
				'ordering' => 'int',
				'disallow_access',
				'can_move' => 'int',
				'version_id' => 'int'
			), $aVals)->insert($this->_sTable);
		}
		
		$this->cache()->remove('block', 'substr');
		
		if ($aVals['type_id'] > 0 && isset($aVals['source_code']))
		{
			$aVals['source_parsed'] = $aVals['source_code'];
			if (!empty($aVals['source_code']) && $aVals['type_id'] == '2')
			{
				$aVals['source_parsed'] = Phpfox::getLib('template.cache')->parse($aVals['source_code']);
			}
						
			$this->database()->delete(Phpfox::getT('block_source'), 'block_id = ' . (int) $iId);
			$this->database()->insert(Phpfox::getT('block_source'), array(
					'block_id' => $iId,
					'source_code' => (empty($aVals['source_code']) ? null : $aVals['source_code']),
					'source_parsed' => (empty($aVals['source_parsed']) ? null : $aVals['source_parsed'])
				)
			);	
		}
		
		return true;
	}
	
	public function update($iId, $aVals)
	{
		$aVals['block_id'] = $iId;
		
		$this->add($aVals, true);
		
		return true;
	}
	
	public function updateOrder($aVals, $iStyleId = null)
	{		
		$iCnt = 0;		
		foreach ($aVals as $iId => $aValue)
		{
			$iCnt++;
			
			if ($iStyleId !== null)
			{
				$iCheck = (int) $this->database()->select('order_id')
					->from(Phpfox::getT('block_order'))
					->where('style_id = ' . (int) $iStyleId . ' AND block_id = ' . (int) $iId . '')
					->execute('getField');
					
				if ($iCheck)
				{
					$this->database()->update(Phpfox::getT('block_order'), array('style_id' => (int) $iStyleId, 'block_id' => (int) $iId, 'ordering' => (int) $iCnt), 'order_id =' . $iCheck);
				}
				else 
				{
					$this->database()->insert(Phpfox::getT('block_order'), array('style_id' => (int) $iStyleId, 'block_id' => (int) $iId, 'ordering' => (int) $iCnt));
				}
			}
			else 
			{
				$this->database()->update($this->_sTable, array('ordering' => $iCnt), 'block_id = ' . (int) $iId);	
			}			
		}
		
		$this->cache()->remove('block', 'substr');
		
		return true;
	}
	
	public function delete($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.service_block_process_delete')) ? eval($sPlugin) : false);
		
		$this->database()->delete($this->_sTable, 'block_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('block_source'), 'block_id = ' . (int) $iId);
		
		$this->cache()->remove('block', 'substr');
				
		return true;
	}
	
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
	
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'block_id = ' . (int) $iId);
		
		$this->cache()->remove('block', 'substr');
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_block_process___call'))
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