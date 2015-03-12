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
 * @version 		$Id: setting.class.php 5237 2013-01-29 09:53:06Z Raymond_Benc $
 */
class User_Service_Group_Setting_Setting extends Phpfox_Service 
{
	private $_aParam = array();
	
	private $_iLastUserGroupId = 0;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('user_group_setting');
		
		$this->_aParam = $this->_setParam(Phpfox::getUserBy('user_group_id'));
		
		$this->_iLastUserGroupId = Phpfox::getUserBy('user_group_id');
	}		
	
	public function getParam($sName)
	{
		if (defined('PHPFOX_APP_USER_GROUP_ID'))
		{
			$this->_aParam = $this->_setParam(PHPFOX_APP_USER_GROUP_ID);
			$this->_iLastUserGroupId = PHPFOX_APP_USER_GROUP_ID;
		}
		else if (Phpfox::getUserBy('user_group_id') != $this->_iLastUserGroupId)
		{
			$this->_aParam = $this->_setParam(Phpfox::getUserBy('user_group_id'));
			
			$this->_iLastUserGroupId = Phpfox::getUserBy('user_group_id');			
		}
		
		return (isset($this->_aParam[$sName]) ? $this->_aParam[$sName] : Phpfox_Error::trigger('Invalid user group setting param: ' . $sName, E_USER_WARNING));
	}
	
	public function getGroupParam($iGroupId, $sName)
	{
		static $aGroup = array();
		
		if (!isset($aGroup[$iGroupId]))
		{
			$aGroup[$iGroupId] = $this->_setParam($iGroupId);
		}		
		
		return (isset($aGroup[$iGroupId][$sName]) ? $aGroup[$iGroupId][$sName] : Phpfox_Error::trigger('Invalid user group setting param: ' . $sName, E_USER_WARNING));
	}
	
	public function getModules($iGroupId)
	{
		$aModules = $this->database()->select('m.module_id, COUNT(ugs.module_id) AS total_setting')
			->from(Phpfox::getT('module'), 'm')
			->join(Phpfox::getT('user_group_setting'), 'ugs', 'ugs.module_id = m.module_id')
			->where('m.is_active = 1')
			->group('m.module_id')
			->execute('getRows');
			
		return $aModules;
	}
	
	public function get($iGroupId, $iModuleId = null)
	{
		$oLocale = Phpfox::getLib('locale');
		
		switch($iGroupId)
		{
			case ADMIN_USER_ID:
				$sVar = 'default_admin';
				break;
			case GUEST_USER_ID:
				$sVar = 'default_guest';
				break;
			case STAFF_USER_ID:
				$sVar = 'default_staff';
				break;			
			case NORMAL_USER_ID:
				$sVar = 'default_user';
				break;
			default:
					
				break;
		}	
		
		if (!isset($sVar))
		{
			$sVar = 'default_value';
			
			$this->database()->select('ugc.default_value, inherit_id, ')
				->leftJoin(Phpfox::getT('user_group_custom'), 'ugc', 'ugc.user_group_id = ' . (int) $iGroupId . ' AND ugc.module_id = user_group_setting.module_id AND ugc.name = user_group_setting.name')
				->join(Phpfox::getT('user_group'), 'ug', 'ug.user_group_id = ' . (int) $iGroupId);
		}

		$aRows = $this->database()->select('user_group_setting.*, user_setting.value_actual, m.module_id AS module_name')
			->from($this->_sTable, 'user_group_setting')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = user_group_setting.module_id')
			->join(Phpfox::getT('product'), 'product', 'product.product_id = user_group_setting.product_id AND product.is_active = 1')
			->leftJoin(Phpfox::getT('user_setting'), 'user_setting', "user_setting.user_group_id = '" . $iGroupId . "' AND user_setting.setting_id = user_group_setting.setting_id")
			->order('m.module_id ASC, user_group_setting.ordering ASC')
			->where('user_group_setting.is_hidden = 0' . ($iModuleId === null ? '' : ' AND user_group_setting.module_id = \'' . $iModuleId . '\''))
			->execute('getSlaveRows');			
		
		$aSettings = array();
		foreach ($aRows as $aRow)
		{
			$aRow['setting_name'] = ($oLocale->isPhrase($aRow['module_name'] . '.user_setting_' . $aRow['name']) ? Phpfox::getPhrase($aRow['module_name'] . '.user_setting_' . $aRow['name']) : $aRow['name']);
			$aRow['setting_name'] = str_replace("\n", "<br />", $aRow['setting_name']);
			$aRow['user_group_id'] = $sVar;
			$sModuleName = $aRow['module_name'];
			
			unset($aRow['module_name']);
			
			$this->_setType($aRow, $sVar);
			
			$aSettings[$aRow['product_id']][$sModuleName][] = $aRow;			
		}		
		
		return $aSettings;
	}
	
	public function getSetting($iId)
	{
		$aRow = $this->database()->select('user_group_setting.*, m.module_id AS module_name')
			->from($this->_sTable, 'user_group_setting')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = user_group_setting.module_id')
			->where('user_group_setting.setting_id = ' . (int) $iId)			
			->execute('getSlaveRow');

		$aRow['info'] = (Phpfox::getLib('locale')->isPhrase('admincp.user_setting_' . $aRow['name']) ? Phpfox::getPhrase('admincp.user_setting_' . $aRow['name']) : $aRow['name']);
		$aRow['module'] = $aRow['module_id'] . '|' . $aRow['module_name'];		
			
		return $aRow;
	}
	
	public function export($sProductId, $sModuleId = null)
	{
		$aWhere = array();
		$aWhere[] = "user_group_setting.product_id = '" . $sProductId . "'";
		if ($sModuleId !== null)
		{
			$aWhere[] = "AND user_group_setting.module_id = '" . $sModuleId . "'";
		}
		
		$aRows = $this->database()->select('user_group_setting.*, m.module_id AS module_name, product.title AS product_name')
			->from($this->_sTable, 'user_group_setting')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = user_group_setting.module_id')
			->join(Phpfox::getT('product'), 'product', 'product.product_id = user_group_setting.product_id')
			->where($aWhere)
			->execute('getRows');		
			
		if (!count($aRows))
		{
			return false;
		}

		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('user_group_settings');
		$aCache = array();
		foreach ($aRows as $aRow)
		{			
			if (isset($aCache[$aRow['name']]))
			{
				continue;
			}
			
			$aCache[$aRow['name']] = $aRow['name'];
			$oXmlBuilder->addTag('setting', $aRow['name'], array(
					'is_admin_setting' => $aRow['is_admin_setting'],
					'module_id' => $aRow['module_id'],
					'type' => $aRow['type_id'],
					'admin' => $aRow['default_admin'],
					'user' => $aRow['default_user'],
					'guest' => $aRow['default_guest'],
					'staff' => $aRow['default_staff'],
					'module' => $aRow['module_name'],		
					'ordering' => $aRow['ordering']
				)
			);				
		}
		$oXmlBuilder->closeGroup();
		
		return true;
	}	

	/* This function gets the user groups that have enabled a setting.
	 * Used to filter users in the user.browse service
	 */ 
	public function getUserGroupsBySetting($sParam, $mValue = true)
	{
		// Get all user groups
		$aGroups = Phpfox::getService('user.group')->get();
		$aOut = array();
		foreach ($aGroups as $aGroup)
		{
			if ($this->getGroupParam($aGroup['user_group_id'], $sParam) == $mValue)
			{
				$aOut[$aGroup['user_group_id']]= $aGroup;
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_group_setting_setting__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function &_setType(&$aRow, $sVar)
	{

				if (empty($aRow['value_actual']) && $aRow['value_actual'] != '0')
				{
					if (is_null($aRow[$sVar]) && $aRow['inherit_id'] > 0)
					{
						switch($aRow['inherit_id'])
						{
							case ADMIN_USER_ID:
								$sVar = 'default_admin';
								break;
							case GUEST_USER_ID:
								$sVar = 'default_guest';
								break;
							case STAFF_USER_ID:
								$sVar = 'default_staff';
								break;			
							case NORMAL_USER_ID:
								$sVar = 'default_user';
								break;
							default:
									
								break;
						}						
						
						$aRow['value_actual'] = $aRow[$sVar];						
					}
					else 
					{
						$aRow['value_actual'] = $aRow[$sVar];
					}
				}				

				switch ($aRow['type_id'])
				{
					case 'boolean':
						if (strtolower($aRow['value_actual']) == 'true' || strtolower($aRow['value_actual']) == 'false')
						{
							$aRow['value_actual'] = (strtolower($aRow['value_actual']) == 'true' ? '1' : '0');
						}						
						settype($aRow['value_actual'], 'boolean');
						break;
					case 'integer':
						settype($aRow['value_actual'], 'integer');
						break;
					case 'array':
						// Fix unserialize sting length depending on the database driver
						// $aRow['value_actual'] = preg_replace("/s:(.*):\"(.*?)\";/ise", "'s:'.strlen('$2').':\"$2\";'", (isset($aRow['user_group_id']) && isset($aRow[$aRow['user_group_id']])) ? $aRow[$aRow['user_group_id']] : $aRow['value_actual']);
						$aRow['value_actual'] = preg_replace("/s:(.*):\"(.*?)\";/ise", "'s:'.strlen('$2').':\"$2\";'", (isset($aRow['user_group_id2']) && isset($aRow[$aRow['user_group_id']])) ? $aRow[$aRow['user_group_id']] : $aRow['value_actual']);
						if (!empty($aRow['value_actual']))
						{
							//eval("\$aRow['value_actual'] = ". unserialize(trim($aRow['value_actual'])) . "");
							if (Phpfox::getLib('parse.format')->isSerialized($aRow['value_actual']))
							{
								eval("\$aRow['value_actual'] = ". unserialize(trim($aRow['value_actual'])) .';');
							}
							else
							{
								eval("\$aRow['value_actual'] = ".trim($aRow['value_actual']) .';');
							}
						}
						break;
				}		
				
		return $aRow;
	}
	
	private function _setParam($iUserId)
	{		
		$sCacheId = $this->cache()->set('user_group_setting_' . $iUserId);
		
		if (!($aParams = $this->cache()->get($sCacheId)))
		{
			switch($iUserId)
			{
				case ADMIN_USER_ID:
					$sVar = 'default_admin';
					break;
				case GUEST_USER_ID:
					$sVar = 'default_guest';
					break;
				case STAFF_USER_ID:
					$sVar = 'default_staff';
					break;
				case NORMAL_USER_ID:
					$sVar = 'default_user';
					break;
				default:
						
					break;
			}			
			
			if (!isset($sVar))
			{
				$sVar = 'default_value';
				
				$this->database()->select('ugc.default_value, inherit_id, ')
					->leftJoin(Phpfox::getT('user_group_custom'), 'ugc', 'ugc.user_group_id = ' . (int) $iUserId . ' AND ugc.module_id = user_group_setting.module_id AND ugc.name = user_group_setting.name')
					->join(Phpfox::getT('user_group'), 'ug', 'ug.user_group_id = ' . (int) $iUserId);
			}			

			$aRows = $this->database()->select('m.module_id, user_group_setting.name, user_group_setting.type_id, user_group_setting.default_admin, user_group_setting.default_user, user_group_setting.default_guest, user_group_setting.default_staff, user_setting.value_actual AS value_actual')
				->from($this->_sTable, 'user_group_setting')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = user_group_setting.module_id')
				->leftJoin(Phpfox::getT('user_setting'), 'user_setting', "user_setting.user_group_id = '" . $iUserId . "' AND user_setting.setting_id = user_group_setting.setting_id")
				->execute('getSlaveRows');				

			$aParams = array();
			foreach ($aRows as $aRow)
			{				
				$this->_setType($aRow, $sVar);
				
				$aParams[$aRow['module_id'] . '.' . $aRow['name']] = $aRow['value_actual'];
			}			

			$this->cache()->save($sCacheId, $aParams);
		}		
		
		return $aParams;
	}

	/**
	 * Gets a list of activity points for editing.
	 * Things to consider:
	 *		There are default values (phpfox_user_group_setting)
	 *		Changes to the default values are stored in phpfox_user_setting
	 *		For custom user groups there may not be current values as they inherit from another user group
	 * This function works like this:
	 *		Get a list of the default activity points to use their setting_id to find any override values
	 *		if an override value is found then update the $aOut array
	 *		return $aOut
	 * @param int $iUserGroup
	 * @return array
	 */
	public function getActivityPoints($iUserGroup)
	{
		$mValid = Phpfox::getService('user.group')->get(array('user_group_id = ' . (int)$iUserGroup));		
		if (empty($mValid))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.invalid_user_group'));
		}
		$mValid = $mValid[0];
		$aModules = Phpfox::massCallback('getDashboardActivity');
		
		$sGroup = '';

		/* if this user group inherits then take the default value of the parent user group*/
		switch($mValid['inherit_id'] != 0 ? $mValid['inherit_id'] : $iUserGroup)
		{
			case 1:
				$sGroup = 'default_admin';
				break;
			case 2:
				$sGroup = 'default_user';
				break;
			case 3:
				$sGroup = 'default_guest';
				break;
			case 4:
				$sGroup = 'default_staff';
				break;
		}

		$aOut = array();
		/* get default values */
		$sIn = '';
		foreach ($aModules as $sModule => $aModule)
		{
			$sIn .= '"points_' . $sModule . '",';
		}
		$sIn = rtrim($sIn, ',');
		$aDefaultSettings = $this->database()->select('*')
						->from(Phpfox::getT('user_group_setting'), 'ugs')
						->where('ugs.name IN (' . $sIn . ')')
						->execute('getSlaveRows');
		
		/* get the current values */
		$sIn = '';
		foreach ($aDefaultSettings as $iKey => $aSetting)
		{
			$sIn .= $aSetting['setting_id'] . ',';
		}
		$sIn = rtrim($sIn, ',');
		$aCurrentSettings = $this->database()->select('*')
						->from(Phpfox::getT('user_setting'))
						->where('setting_id IN (' . $sIn . ') AND user_group_id = ' . ((int) $iUserGroup))
						->execute('getSlaveRows');
		/* Merge arrays */
		foreach ($aDefaultSettings as $iKey => $aDefault)
		{
			$aOut[$iKey] = array(
				'setting_id' => $aDefault['setting_id'],
				'name' => $aDefault['name'],
				'module' => $aDefault['module_id'],
				'value_actual' => $aDefault[$sGroup]);
			
			/* if theres a current setting, override the default value*/
			foreach ($aCurrentSettings as $aCurrent)
			{
				if ($aCurrent['setting_id'] == $aDefault['setting_id'])
				{
					$aOut[$iKey]['value_actual'] = $aCurrent['value_actual'];
				}
			}
		}
		return $aOut;
	}

}

?>