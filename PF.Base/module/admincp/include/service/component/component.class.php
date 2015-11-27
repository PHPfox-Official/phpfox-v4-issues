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
 * @version 		$Id: component.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Admincp_Service_Component_Component extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('component');
	}
	
	public function get($bController = false)
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.service_component_component_get')) ? eval($sPlugin) : false);
		
		$aRows = $this->database()->select('c.*, m.module_id')
			->from($this->_sTable, 'c')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = c.module_id AND m.is_active = 1')
			->where(($bController ? 'c.is_controller = 1 AND c.is_active = 1' : 'c.is_block = 1 AND c.is_active = 1'))
			->order('m.module_id ASC')
			->execute('getRows');		
			
		$aCache = array();
		foreach ($aRows as $aRow)
		{
			$aCache[$aRow['module_id']][] = $aRow;
		}				

		return $aCache;
	}	
	
	public function getCache()
	{
		$aCache = array();
		$sCacheId = $this->cache()->set('component');
		if (!($aCache = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('c.component, m.module_id')
				->from($this->_sTable, 'c')
				->join(Phpfox::getT('product'), 'p', 'p.product_id = c.product_id AND p.is_active = 1')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = c.module_id AND m.is_active = 1')
				->where('c.is_active = 1')
				->execute('getRows');				
			
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['module_id'] . '.' . $aRow['component']] = true;
			}
			$this->cache()->save($sCacheId, $aCache);
		}
		
		return $aCache;
	}
	
	public function export($sProductId, $sModuleId = null)
	{
		$aWhere = array();
		$aWhere[] = "c.product_id = '" . $sProductId . "'";
		if ($sModuleId !== null)
		{
			$aWhere[] = " AND c.module_id = '" . $sModuleId . "'";	
		}		
		
		$aRows = $this->database()->select('c.*, product.title AS product_name, m.module_id AS module_name')
			->from($this->_sTable, 'c')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = c.product_id')
			->leftJoin(Phpfox::getT('module'), 'm', 'm.module_id = c.module_id')
			->where($aWhere)
			->execute('getRows');
		
		if (!isset($aRows[0]['product_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.product_does_not_have_any_settings'));
		}	
		
		if (!count($aRows))
		{
			return false;
		}
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('components');
			
		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addTag('component', '', array(
				'module_id' => $aRow['module_id'],
				'component' => $aRow['component'],
				'm_connection' => $aRow['m_connection'],
				'module' => $aRow['module_name'],
				'is_controller' => $aRow['is_controller'],
				'is_block' => $aRow['is_block'],
				'is_active' => $aRow['is_active']
			));			
		}	
		$oXmlBuilder->closeGroup();
				
		return true;
	}	
	
	public function getForManagement()
	{
		$aRows = $this->database()->select('c.*')
			->from($this->_sTable, 'c')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = c.module_id AND m.is_active = 1')
			->execute('getRows');
			
		$aComponents = array();
		foreach ($aRows as $aRow)
		{
			$aComponents[$aRow['module_id']][] = $aRow;
		}
		
		ksort($aComponents);
						
		return $aComponents;
	}
	
	public function getForEdit($iId)
	{
		$aComponent = $this->database()->select('*')
			->from($this->_sTable)
			->where('component_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aComponent['component_id']))
		{
			return false;
		}
		
		$aComponent['type'] = ($aComponent['is_controller'] ? '1' : ($aComponent['is_block'] ? '2' : ''));
		
		return $aComponent;
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_component_component__call'))
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