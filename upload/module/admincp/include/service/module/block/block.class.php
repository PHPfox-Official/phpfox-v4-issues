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
 * @version 		$Id: block.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Admincp_Service_Module_Block_Block extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('block');
	}
	
	public function export($sProductId, $sModuleId = null)
	{
		$aWhere = array();
		$aWhere[] = "block.product_id = '" . $sProductId . "'";
		if ($sModuleId !== null)
		{
			$aWhere[] = " AND block.module_id = '" . $sModuleId . "'";
		}
		
		$aRows = $this->database()->select('block.*, product.title AS product_name, m.module_id AS module_name, bs.source_code, bs.source_parsed')
			->from($this->_sTable, 'block')
			->leftJoin(Phpfox::getT('block_source'), 'bs', 'bs.block_id = block.block_id')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = block.product_id')
			->leftJoin(Phpfox::getT('module'), 'm', "m.module_id = block.module_id")
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
		$oXmlBuilder->addGroup('blocks');
			
		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addGroup('block', array(					
					'type_id' => $aRow['type_id'],
					'm_connection' => $aRow['m_connection'],
					'module_id' => $aRow['module_name'],
					'component' => $aRow['component'],
					'location' => $aRow['location'],
					'is_active' => $aRow['is_active'],
					'ordering' => $aRow['ordering'],
					'disallow_access' => $aRow['disallow_access'],
					'can_move' => $aRow['can_move']
				)
			);			
			
			$oXmlBuilder->addTag('title', $aRow['title']);
			$oXmlBuilder->addTag('source_code', (empty($aRow['source_code']) ? '' : $aRow['source_code']));
			$oXmlBuilder->addTag('source_parsed', (empty($aRow['source_parsed']) ? '' : $aRow['source_parsed']));
			$oXmlBuilder->closeGroup();
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_module_block_block___call'))
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