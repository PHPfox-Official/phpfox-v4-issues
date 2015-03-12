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
 * @version 		$Id: category.class.php 5099 2013-01-07 19:01:38Z Raymond_Benc $
 */
class Pages_Service_Category_Category extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('pages_category');
	}
	
	public function getCategories()
	{
		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('pages_type'))
			->where('is_active = 1')
			->order('time_stamp DESC')			
			->execute('getSlaveRows');
		
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['sub_categories'] = $this->database()->select('*')
				->from(Phpfox::getT('pages_category'))
				->where('type_id = ' . $aRow['type_id'] . ' AND is_active = 1')
				->execute('getSlaveRows');
		}
		
		return $aRows;
	}
	
	public function getByTypeId($iTypeId)
	{
		$sCacheId = $this->cache()->set('pages_category_type_' . (int) $iTypeId);
		
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from($this->_sTable)
				->where('type_id = ' . (int) $iTypeId . ' AND is_active = 1')
				->order('ordering ASC')
				->execute('getSlaveRows');	
			
			$this->cache()->save($sCacheId, $aRows);
		}
		
		return $aRows;
	}	
	
	public function getById($iId)
	{
		$aRow = $this->database()->select('pc.*, pt.name AS type_name, pt.type_id')
			->from($this->_sTable, 'pc')
			->join(Phpfox::getT('pages_type'), 'pt', 'pt.type_id = pc.type_id')
			->where('pc.category_id = ' . (int) $iId . ' AND pc.is_active = 1')
			->execute('getSlaveRow');
		
		if (!isset($aRow['category_id']))
		{
			return false;
		}
		
		return $aRow;
	}
	
	public function getForBrowse($iCategoryId = null)
	{		
		// $sCacheId = $this->cache()->set('pages_category_browse' . ($iCategoryId === null ? '' : '_' . $iCategoryId));
		$aCategories = array();
		if ($iCategoryId > 0)
		{
			$aCategories = $this->database()->select('pc.*')
				->from($this->_sTable, 'pc')
				->where('pc.type_id = ' . (int) $iCategoryId . ' AND pc.is_active = 1')
				->order('pc.ordering ASC')
				->execute('getSlaveRows');

			foreach ($aCategories as $iKey => $aCategory)
			{
				$aCategories[$iKey]['link'] = Phpfox::permalink('pages.sub-category', $aCategory['category_id'], $aCategory['name']);
			}			
			
			return $aCategories;
		}
		
		$aCategories = $this->database()->select('pt.*')
			->from(Phpfox::getT('pages_type'), 'pt')
			->where('pt.is_active = 1')
			->order('pt.ordering ASC')
			->execute('getSlaveRows');		
		
		foreach ($aCategories as $iKey => $aCategory)
		{
			$aCategories[$iKey]['link'] = Phpfox::permalink('pages.category', $aCategory['type_id'], $aCategory['name']);
		}
		
		return $aCategories;
	}	
	
	public function getForAdmin($iTypeId)
	{
		$aRows = $this->database()->select('*')
			->from($this->_sTable)
			->where('type_id = ' . (int) $iTypeId)
			->order('ordering ASC')
			->execute('getSlaveRows');	
		
		return $aRows;
	}	
	
	public function getForEdit($iId)
	{
		$aRow = $this->database()->select('*')
			->from(Phpfox::getT('pages_category'))
			->where('category_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aRow['category_id']))
		{
			return false;
		}
		
		return $aRow;
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
		if ($sPlugin = Phpfox_Plugin::get('pages.service_category_category__call'))
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