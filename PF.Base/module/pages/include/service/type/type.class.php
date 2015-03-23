<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: type.class.php 2818 2011-08-09 12:01:57Z Raymond_Benc $
 */
class Pages_Service_Type_Type extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('pages_type');
	}
	
	public function getById($iId)
	{
		static $aRows = array();
		
		if (isset($aRows[$iId]))
		{
			return $aRows[$iId];
		}
		
		$aRows[$iId] = $this->database()->select('*')
			->from(Phpfox::getT('pages_type'))
			->where('type_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aRows[$iId]['type_id']))
		{
			return false;
		}
		
		return $aRows[$iId];
	}
	
	public function get()
	{
		$sCacheId = $this->cache()->set('pages_types');
		
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from($this->_sTable)
				->where('is_active = 1')
				->order('ordering ASC')
				->execute('getSlaveRows');
			
			foreach ($aRows as $iKey => $aRow)
			{
				$aRows[$iKey]['categories'] = Phpfox::getService('pages.category')->getByTypeId($aRow['type_id']);
			}
			
			$this->cache()->save($sCacheId, $aRows);
		}
		
		return $aRows;
	}
	
	public function getForEdit($iId)
	{
		$aRow = $this->database()->select('*')
			->from(Phpfox::getT('pages_type'))
			->where('type_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aRow['type_id']))
		{
			return false;
		}
		
		return $aRow;
	}
	
	public function getForAdmin()
	{
		$aRows = $this->database()->select('*')
			->from($this->_sTable)
			->order('ordering ASC')
			->execute('getSlaveRows');
			
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['categories'] = Phpfox::getService('pages.category')->getForAdmin($aRow['type_id']);
		}
			
		return $aRows;
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
		if ($sPlugin = Phpfox_Plugin::get('pages.service_type_type__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>