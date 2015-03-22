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
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Report_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('report');		
	}
	
	public function update($iId, $aVals)
	{
		if (!isset($aVals['message']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('report.provide_a_category_name'));
		}
		
		if (empty($aVals['module_id']))
		{
			$aVals['module_id'] = 'core';
		}		
		
		$this->database()->update($this->_sTable, array(
				'module_id' => $aVals['module_id'],
				'product_id' => $aVals['product_id'],
				'message' => $this->preParse()->clean($aVals['message'], 255)		
			), 'report_id = ' . (int) $iId
		);		
		
		$this->cache()->remove('report');
		
		return true;
	}
	
	public function add($aVals)
	{
		if (!isset($aVals['message']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('report.provide_a_category_name'));
		}
		
		if (empty($aVals['module_id']))
		{
			$aVals['module_id'] = 'core';
		}
		
		$iId = $this->database()->insert($this->_sTable, array(
				'module_id' => $aVals['module_id'],
				'product_id' => $aVals['product_id'],
				'message' => $this->preParse()->clean($aVals['message'], 255)
			)
		);
		
		$this->cache()->remove('report');
		
		return $iId;
	}
	
	public function delete($iId)
	{
		$this->database()->delete($this->_sTable, 'report_id = ' . (int) $iId);
		
		$this->cache()->remove('report');
		
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
		if ($sPlugin = Phpfox_Plugin::get('report.service_process__call'))
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