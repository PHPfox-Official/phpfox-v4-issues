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
 * @version 		$Id: process.class.php 5582 2013-03-28 08:33:43Z Raymond_Benc $
 */
class Core_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}

	public function addGender($aVals)
	{
	    (($sPlugin = Phpfox_Plugin::get('core.service_process_addGender_start')) ? eval($sPlugin) : false);

	    (($sPlugin = Phpfox_Plugin::get('core.service_process_addGender_end')) ? eval($sPlugin) : false);
	}
	
	public function updateComponentSetting($aVals)
	{
		Phpfox::isUser(true);
		
		if (isset($aVals['var_name']))
		{
			$aParts = explode('.', $aVals['var_name']);
			
			if (!Phpfox::isModule($aParts[0]))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('core.module_is_not_a_valid_module', array('module' => $aParts[0])));
			}
			$aParts[1] = str_replace(' ', '', ucwords(str_replace('_', ' ', $aParts[1])));			
			
			$oObject = Phpfox::getService($aParts[0] . '.block');
			
			if (!isset($aVals['user_value']))
			{
				$sPrepare = 'prepare' . $aParts[1];
				$aVals['user_value'] = $oObject->$sPrepare($aVals);
			}
			
			if ($oObject->$aParts[1]($aVals['user_value']))
			{			
				Phpfox::getLib('cache')->remove(array('csetting', Phpfox::getUserId()));
				
				$this->database()->delete(Phpfox::getT('component_setting'), 'user_id = ' . Phpfox::getUserId() . ' AND var_name = \'' . $this->database()->escape($aVals['var_name']) . '\'');			
				$this->database()->insert(Phpfox::getT('component_setting'), array('user_id' => Phpfox::getUserId(), 'var_name' => $aVals['var_name'], 'user_value' => $aVals['user_value']));
				
				return true;
			}			
		}
		
		return false;
	}
	
	/**
	 * Hides blocks by issuing a callback
	 * @param type $sBlockId
	 * @param type $sTypeId
	 * @return type 
	 */
	public function hideBlock($sBlockId, $sTypeId, $sController)
	{
		$sBlockId = str_replace('clone_', '', $sBlockId);
		$sBlockId = str_replace('js_block_border_', '', $sBlockId);
		$aParts = explode('_', $sBlockId);
		
		if (!Phpfox::isModule($aParts[0]))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.module_is_not_a_valid_module', array('module' => $aParts[0])));
		}
		
		$sModule = $aParts[0];
		
		unset($aParts[0]);
		
		$sTable = 'user_design_order';
		if ($sController == 'core.index-member')
		{
			$sTable = 'user_dashboard';
		}
		
		$iHasEntry = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT($sTable))
			->where('user_id = ' . Phpfox::getUserId())// . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'')
			->execute('getSlaveField');
			
			
			
		if (!$iHasEntry)
		{
			$aBlocks = $this->database()->select('module_id, component, location, ordering')
			->from(Phpfox::getT('block'))
			->where('is_active = 1 && m_connection = "'.$sController.'" AND location IN (1,2,3)')
			->execute('getSlaveRows');
			
			foreach ($aBlocks as $aBlock)
			{
				$this->database()->insert(Phpfox::getT($sTable), array(
					'user_id' => Phpfox::getUserId(), 
					'cache_id' => 'js_block_border_' . $aBlock['module_id'] . '_' . $aBlock['component'], 
					'block_id' => $aBlock['location'], 
					'ordering' => $aBlock['ordering'], 
					'is_hidden' => 0));
			}
		}
		else
		{
			$iCount = $this->database()->select('COUNT(*)')	
				->from(Phpfox::getT($sTable))
				->where('user_id = ' . Phpfox::getUserId() . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'')
				->execute('getSlaveField');
			
			if (!$iCount)
			{
				$this->database()->insert(Phpfox::getT($sTable), array(
					'user_id' => Phpfox::getUserId(), 
					'cache_id' => 'js_block_border_' . $sBlockId, 
					'block_id' => null					
					));
			}
		}
		
		$this->database()->update(Phpfox::getT($sTable), array('is_hidden' => '1'), 
			'user_id = ' . Phpfox::getUserId() . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'');
		
	}
	
	public function updateOrdering($aParams)
	{
		$iCnt = 0;
		foreach ($aParams['values'] as $mKey => $mOrdering)
		{
			$iCnt++;
			
			$this->database()->update(Phpfox::getT($aParams['table']), array('ordering' => $iCnt), $aParams['key'] . ' = \'' . $this->database()->escape($mKey) . '\'');
		}
		
		return true;
	}
	
	public function updateActivity($aParams)
	{
		$this->database()->update(Phpfox::getT($aParams['table']), array('is_active' => ($aParams['active'] ? '1' : '0')), $aParams['key'] . ' = \'' . $this->database()->escape($aParams['value']) . '\'');
		
		return true;
	}

	/**
	 * This function inserts into phpfox_upload_track to identify a user when uploading via the massuploader
	 */
	public function trackUpload($sFile, $bInsert = true)
	{
		Phpfox::isUser();
		$this->database()->delete(Phpfox::getT('upload_track'),'user_id = ' . Phpfox::getUserId());
		if ($bInsert == true)
		{
			$this->database()->insert(Phpfox::getT('upload_track'),array(
				'user_id' => Phpfox::getUserId(),
				'user_hash' => Phpfox::getCookie('user_hash'),
				'file_hash' => md5($sFile)
				));
		}
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
		if ($sPlugin = Phpfox_Plugin::get('core.service_process__call'))
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