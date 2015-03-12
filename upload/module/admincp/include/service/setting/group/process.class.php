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
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Admincp_Service_Setting_Group_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('setting_group');
	}
	
	public function add($aVals)
	{
		$sVarName = strtolower(preg_replace('/ +/', '_', preg_replace('/[^0-9a-zA-Z ]+/', '', trim($aVals['var_name']))));		
				
		$iId = $this->database()->insert($this->_sTable, array(
				'group_id' => $sVarName,
				'module_id' => $aVals['module_id'],
				'product_id' => $aVals['product_id'],
				'version_id' => Phpfox::getId(),
				'var_name' => 'setting_group_' . $sVarName
			)
		);
		
		$sPhrase = Phpfox::getService('language.phrase.process')->add(array(
				'var_name' => 'setting_group_' . $sVarName,
				'product_id' => $aVals['product_id'],
				'module' => $aVals['module_id'] . '|' . $aVals['module_id'],
				'text' => array(
					'en' => '<title>' . $aVals['var_name'] . '</title><info>' . $aVals['info'] . '</info>'
				)
			)
		);	
		
		return $sVarName;	
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		if (!$iProductId)
		{
			$iProductId = 1;
		}
		
		if ($bMissingOnly)
		{
			$aCache = array();
			$aRows = $this->database()->select('var_name')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['var_name']] = $aRow['var_name'];
			}	
			
			$aSql = array();
			foreach ($aVals['name'] as $aValue)
			{
				if (in_array($aValue['value'], $aCache))
				{
					continue;
				}				
				
				$aSql[] = array(
					$iProductId,
					$aValue['version_id'],
					$aValue['value']
				);
			}
			
			if ($aSql)
			{
				$this->database()->multiInsert($this->_sTable, array(
					'product_id',
					'version_id',
					'var_name'
				), $aSql);			
			}
		}
		else 
		{		
			$aSql = array();
			foreach ($aVals['name'] as $aValue)
			{
				$aSql[] = array(
					$iProductId,
					$aValue['version_id'],
					$aValue['value']
				);
			}
			
			$this->database()->multiInsert($this->_sTable, array(
				'product_id',
				'version_id',
				'var_name'
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_setting_group_process__call'))
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