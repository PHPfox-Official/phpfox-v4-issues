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
 * @version 		$Id: process.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class User_Service_Group_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user_group');
	}
	
	public function add($aVals)
	{		
		$iId = ($this->database()->select('user_group_id')
			->from($this->_sTable)
			->order('user_group_id DESC')
			->execute('getField') + 1);			
		
		$aForm = array(
			'title' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('user.provide_a_name_for_the_user_group')
			),
			'prefix' => array(
				'type' => 'string'
			),
			'suffix' => array(
				'type' => 'string'
			),
			'inherit_id' => array(
				'type' => 'int:required',
				'message' => Phpfox::getPhrase('user.select_an_inherit_user_group')
			)
		);
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		
		$aVals['user_group_id'] = $iId;
		$aVals['title'] = $this->preParse()->clean($aVals['title'], 255);
		
		if (($aVals['icon_ext'] = $this->_uploadImage($iId)) === false)
		{
			return false;
		}				
		
		if (is_bool($aVals['icon_ext']))
		{
			$aVals['icon_ext'] = null;
		}
		
		$this->database()->insert($this->_sTable, $aVals);
		
		// Add the language phrase for this new user group
		$aLanguages = Phpfox::getService('language')->getAll();
		$sPhraseVar = 'user.' . str_replace(' ', '_', strtolower($aVals['title']));
		$aToAdd = array('module' => 'user|user', 'product_id' => 'phpfox', 'text' => array(), 'var_name' => $sPhraseVar);
		foreach ($aLanguages as $aLang)
		{
			$aToAdd['text'][$aLang['language_id']] = $aVals['title'];
		}
		Phpfox::getService('language.phrase.process')->add($aToAdd);
		
		$aMenus = $this->database()->select('menu_id, disallow_access')
			->from(Phpfox::getT('menu'))
			->execute('getRows');
			
		$aCache = array();
		$aGroupRows = $this->database()->select('user_group_id')
			->from($this->_sTable)
			->execute('getRows');
		foreach ($aGroupRows as $aGroupRow)
		{
			$aCache[] = $aGroupRow['user_group_id'];
		}
		
		switch($aVals['inherit_id'])
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
		
		if (empty($sVar))
		{
			$aGroupSettings = $this->database()->select('ugs.setting_id, ugc.module_id, ugc.name, ugc.default_value')
				->from(Phpfox::getT('user_group_custom'), 'ugc')
				->join(Phpfox::getT('user_group_setting'), 'ugs', 'ugc.name = ugs.name AND ugc.module_id = ugs.module_id')
				->where('ugc.user_group_id = ' . (int) $aVals['inherit_id'])
				->execute('getRows');  				
		}
		else 
		{
			$aGroupSettings = $this->database()->select('setting_id, module_id, name, ' . $sVar)	
				->from(Phpfox::getT('user_group_setting'))
				->execute('getRows');
		}

		$aActualSettings = $this->database()->select('setting_id, value_actual')
			->from(Phpfox::getT('user_setting'))
			->where('user_group_id = ' . (int) $aVals['inherit_id'])
			->execute('getRows');
			
		$aCacheSettings = array();
		foreach ($aActualSettings as $aActualSetting)
		{
			$aCacheSettings[$aActualSetting['setting_id']] = $aActualSetting['value_actual'];			
		}
		
		foreach ($aGroupSettings as $aGroupSetting)
		{	
			$sDefaultValue = (isset($aCacheSettings[$aGroupSetting['setting_id']]) ? $aCacheSettings[$aGroupSetting['setting_id']] : $aGroupSetting[(empty($sVar) ? 'default_value' : $sVar)]);
			if ($aGroupSetting['name'] == 'has_special_custom_fields')
			{
				$sDefaultValue = 0;
			}
			
			$this->database()->insert(Phpfox::getT('user_group_custom'), array(
					'user_group_id' => $iId,
					'module_id' => $aGroupSetting['module_id'],
					'name' => $aGroupSetting['name'],
					'default_value' => $sDefaultValue
				)
			);
		}		
		
		foreach ($aMenus as $aMenu)
		{
			if (empty($aMenu['disallow_access']))
			{
				continue;
			}
			
			$aGroups = unserialize($aMenu['disallow_access']);
			
			foreach ($aGroups as $iKey => $iGroup)
			{
				if (!in_array($iGroup, $aCache))
				{
					unset($aGroups[$iKey]);
				}
			}
			
			if (in_array($aVals['inherit_id'], $aGroups))
			{			
				array_push($aGroups, $iId);
				
				$this->database()->update(Phpfox::getT('menu'), array('disallow_access' => serialize($aGroups)), 'menu_id = ' . $aMenu['menu_id']);
			}
		}		
		
		$this->cache()->remove();
		
		return $iId;
	}
	
	public function delete($aVals)
	{
		$aGroup = Phpfox::getService('user.group')->getGroup($aVals['delete_id']);
		
		if (!isset($aGroup['user_group_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('user.unable_to_find_the_user_group_you_want_to_delete'));
		}
		
		if ($aGroup['is_special'])
		{
			return Phpfox_Error::display(Phpfox::getPhrase('user.not_allowed_to_delete_this_user_group'));
		}		
		
		$aMenus = $this->database()->select('menu_id, disallow_access')
			->from(Phpfox::getT('menu'))
			->execute('getRows');				
		
		foreach ($aMenus as $aMenu)
		{
			if (empty($aMenu['disallow_access']))
			{
				continue;
			}
			
			$aGroups = unserialize($aMenu['disallow_access']);
			
			foreach ($aGroups as $iKey => $iGroup)
			{
				if ($iGroup == $aGroup['user_group_id'])
				{
					unset($aGroups[$iKey]);
				}
			}
			
			$this->database()->update(Phpfox::getT('menu'), array('disallow_access' => serialize($aGroups)), 'menu_id = ' . $aMenu['menu_id']);
		}		
		$bHasCustom = $this->database()->select('s.value_actual')
				->from(Phpfox::getT('user_setting'), 's')
				->join(Phpfox::getT('user_group_custom'), 'v', 'v.setting_id = s.setting_id')
				->where('s.user_group_id = ' . $aGroup['user_group_id'] . ' AND v.name= "has_special_custom_fields"')
				->execute('getSlaveField');
		if ($bHasCustom)
		{
			$sTableName = Phpfox::getParam(array('db','prefix')) . 'user_group_custom_' . str_replace(' ', '_', strtolower($aGroup['title']));
			if ($this->database()->tableExists($sTableName) != false)
			{
				$this->database()->dropTables($sTableName);
			}
			if ($this->database()->tableExists($sTableName .'_value') != false)
			{
				$this->database()->dropTables($sTableName.'_value');
			}
		}
		$this->deleteIcon($aGroup['user_group_id']);
		
		$this->database()->delete(Phpfox::getT('user_group_custom'), 'user_group_id = ' . $aGroup['user_group_id']);
		$this->database()->delete(Phpfox::getT('user_setting'), 'user_group_id = ' . $aGroup['user_group_id']);
		$this->database()->delete(Phpfox::getT('user_group'), 'user_group_id = ' . $aGroup['user_group_id']);		
		$this->database()->update(Phpfox::getT('user'), array('user_group_id' => $aVals['user_group_id']), 'user_group_id = ' . $aGroup['user_group_id']);
		
		$this->database()->update(Phpfox::getT('subscribe_package'), array('is_active' => 0), 'user_group_id = ' . $aGroup['user_group_id']);
		$this->cache()->remove();
		
		return true;
	}
	
	public function update($iGroupId, $aVals)
	{
		$aForm = array(
			'title' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('user.provide_a_name_for_the_user_group')
			),
			'prefix' => array(
				'type' => 'string'
			),
			'suffix' => array(
				'type' => 'string'
			)
		);
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		
		$aVals['title'] = $this->preParse()->clean($aVals['title'], 255);
		
		if (($aVals['icon_ext'] = $this->_uploadImage($iGroupId)) === false)
		{
			return false;
		}		
		
		if (is_bool($aVals['icon_ext']))
		{
			$aVals['icon_ext'] = null;
		}		
		
		$this->database()->update(Phpfox::getT('user_group'), $aVals, 'user_group_id = ' . (int) $iGroupId);		
		
		$this->cache()->remove();
		
		return true;
	}	
	
	public function deleteIcon($iId)
	{
		$aGroup = Phpfox::getService('user.group')->getGroup($iId);
		if (!empty($aGroup['icon_ext']))
		{
			if (file_exists(Phpfox::getParam('core.dir_icon') . $aGroup['icon_ext']))
			{
				unlink(Phpfox::getParam('core.dir_icon') . $aGroup['icon_ext']);
			}
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_group_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _uploadImage($iId)
	{
		if (!empty($_FILES['icon']['name']))
		{
			$aImage = Phpfox::getLib('file')->load('icon', array('jpg', 'gif', 'png'));
			if ($aImage === false)
			{
				return false;
			}
			
			$aGroup = Phpfox::getService('user.group')->getGroup($iId);
			if (!empty($aGroup['icon_ext']))
			{
				if (file_exists(Phpfox::getParam('core.dir_icon') . $aGroup['icon_ext']))
				{
					unlink(Phpfox::getParam('core.dir_icon') . $aGroup['icon_ext']);
				}
			}
			
			return Phpfox::getLib('file')->upload('icon', Phpfox::getParam('core.dir_icon'), $iId, false, 0644, false);
		}		
		
		return true;
	}
}

?>