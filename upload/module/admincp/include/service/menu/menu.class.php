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
 * @version 		$Id: menu.class.php 6739 2013-10-07 14:14:51Z Fern $
 */
class Admincp_Service_Menu_Menu extends Phpfox_Service 
{
	private $_aTypes = array(
		'main',
		'main_right',
		'footer',
		'explore',
		'mobile'
		// 'profile'
	);	
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('menu');
		
		(($sPlugin = Phpfox_Plugin::get('admincp.service_menu_menu___construct')) ? eval($sPlugin) : false);
	}
	
	public function getTypes()
	{
		return $this->_aTypes;
	}
	
	public function get($aConds = array(), $bAll = true)
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.service_menu_menu_get_start')) ? eval($sPlugin) : false);
		if ($bAll && !Phpfox::getParam('core.is_auto_hosted'))
		{
			$this->database()->leftJoin(Phpfox::getT('module'), 'm', 'm.module_id = menu.module_id AND m.is_active = 1');
		}
		else
		{
			$this->database()->join(Phpfox::getT('module'), 'm', 'm.module_id = menu.module_id AND m.is_active = 1');
		}
		
		$aRows = $this->database()->select('menu.*, m.module_id AS module_name, COUNT(mchild.menu_id) AS total_children')
			->from($this->_sTable, 'menu')			
			->leftJoin($this->_sTable, 'mchild', 'mchild.parent_id = menu.menu_id')
			->where($aConds)			
			->order('ordering ASC')
			->group('menu.menu_id')
			->execute('getSlaveRows');
		
		foreach ($aRows as $iKey => $aRow)
		{
			if(Phpfox::isModule($aRow['module_id']))
			{
				$aRows[$iKey]['name'] = Phpfox::getPhrase($aRow['module_name'] . '.' . $aRow['var_name']);
			}
		}		
		
		(($sPlugin = Phpfox_Plugin::get('admincp.service_menu_menu_get_end')) ? eval($sPlugin) : false);
		
		return $aRows;
	}
	
	public function getForEdit($iId)
	{		
		(($sPlugin = Phpfox_Plugin::get('admincp.service_menu_menu_getforedit')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('m.*')
			->from($this->_sTable, 'm')
			->where('m.menu_id = ' . (int) $iId)
			->execute('getRow');
			
		if ($aRow['parent_id'] > 0)
		{
			$aRow['m_connection'] = $aRow['parent_id'];
		}
			
		return $aRow;
	}
	
	public function export($sProduct, $sModuleId = null)
	{		
		$aCond = array();
		$aCond[] = "me.product_id = '" . $this->database()->escape($sProduct) . "'";
		if ($sModuleId !== null)
		{
			$aCond[] = "AND me.module_id = '" . $sModuleId . "'";
		}
		
		$aRows = $this->database()->select('me.*, m.module_id AS module_name, p.title AS product_name, pm.var_name as parent_var_name')
			->from($this->_sTable, 'me')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = me.module_id')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = me.product_id')
			->leftjoin(Phpfox::getT('menu'), 'pm', 'pm.menu_id = me.parent_id')
			->where($aCond)
			->execute('getRows');
			
		if (!count($aRows))
		{
			return false;
		}			
			
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('menus');
		foreach ($aRows as $aRow)
		{			
			if (!empty($aRow['disallow_access']))
			{
				$aGroups = unserialize($aRow['disallow_access']);
				$aRow['disallow_access'] = array();
				foreach ($aGroups as $iGroup)
				{
					if (!in_array($iGroup, array(1, 2, 3, 4)))
					{
						continue;
					}
					
					$aRow['disallow_access'][] = $iGroup;
				}
				$aRow['disallow_access'] = serialize($aRow['disallow_access']);				
			}		
			
			$aTag = array(
				'module_id' => $aRow['module_id'],
				'parent_var_name' => $aRow['parent_var_name'],
				'm_connection' => $aRow['m_connection'],
				'var_name' => $aRow['var_name'],
				'ordering' => $aRow['ordering'],
				'url_value' => $aRow['url_value'],
				'version_id' => $aRow['version_id'],
				'disallow_access' => $aRow['disallow_access'],
				'module' => $aRow['module_name']				
			);

			if (!empty($aRow['mobile_icon']))
			{
				$aTag['mobile_icon'] = $aRow['mobile_icon'];
			}
			
			$oXmlBuilder->addTag('menu', '', $aTag);				
		}
		$oXmlBuilder->closeGroup();
		
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_menu_menu__call'))
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
