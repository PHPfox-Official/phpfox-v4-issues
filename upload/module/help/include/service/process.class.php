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
 * @package  		Module_Help
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Help_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('help');
	}
	
	public function add($aVals)
	{
		$this->database()->insert($this->_sTable, array(
			'var_name' => $aVals['var_name'],
			'added' => PHPFOX_TIME,
			'user_id' => Phpfox::getUserId()
		));
		
		return true;
	}
	
	public function toggleTips($bClose = false)
	{
		$this->database()->update(Phpfox::getT('user'), array(
			'hide_tip' => ($bClose ? 1 : 0)
		), 'user_id = ' . Phpfox::getUserId());

		return true;	
	}
	
	public function import($aVals, $bMissingOnly = false)
	{
		$iProductId = Phpfox::getService('admincp.product')->getId($aVals['product']);
		if (!$iProductId)
		{
			$iProductId = 1;
		}
		
		$aCache = array();
		if ($bMissingOnly)
		{
			$aRows = $this->database()->select('var_name')
				->from($this->_sTable)
				->execute('getRows', array(
					'free_result' => true
				));			
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['var_name']] = $aRow['var_name'];
			}	
		}
		
		$aSql = array();		
		$aVals = (isset($aVals['info'][0]) ? $aVals['info'] : array($aVals['info']));		
		foreach ($aVals as $aVal)
		{
			if ($bMissingOnly && in_array($aVal['var_name'], $aCache))
			{
				continue;
			}			
			
			$aSql[] = array(	
				$iProductId,
				$aVal['var_name'],
				$aVal['added']
			);
		}
		
		if ($aSql)
		{
			$this->database()->multiInsert($this->_sTable, array(
				'product_id',
				'var_name',
				'added'
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
		if ($sPlugin = Phpfox_Plugin::get('help.service_process__call'))
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