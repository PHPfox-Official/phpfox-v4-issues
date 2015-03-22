<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('No dice!');
/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Service_Category_Category extends Phpfox_Service
{

	// Gets a category given its id
	public function getCategoryById($iId)
	{
		$aRow = $this->database()->select('ac.*')
				->from(Phpfox::getT('app_category'), 'ac')
				->where('ac.category_id = ' . (int) $iId . ' AND ac.is_active = 1')
				->execute('getSlaveRow');

		if (!isset($aRow['category_id']))
		{
			return false;
		}

		return $aRow;
	}
	
	public function getAllCategories()
	{
		$aCategories = $this->database()->select('ac.name as category_name, ac.category_id, ac.is_active')
				->from(Phpfox::getT('app_category'), 'ac')
				->execute('getSlaveRows');
		
		return $aCategories;
	}

}
?>