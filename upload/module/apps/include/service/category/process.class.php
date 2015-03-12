<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Service_Category_Process extends Phpfox_Service
{
	/**
	 * Adds a category, called from the adminCP
	 * @param string $sName 
	 * @return bool
	 */
	public function add($sName)
	{		
		Phpfox::isAdmin(true);
		$this->database()->insert(Phpfox::getT('app_category'), array(
			'name' => Phpfox::getLib('parse.input')->clean($sName),
			'is_active' => '1'
		));
		return true;
	}
	
	/**
	 * Changes the name of a category
	 * Most commonly executed from an ajax call in the admincp
	 * @param int $iId
	 * @param string $sName 
	 * @return bool
	 */
	public function updateCategory($iId, $sName)
	{
		Phpfox::isAdmin(true);
		$this->database()->update(Phpfox::getT('app_category'),array(
			'name' => Phpfox::getLib('parse.input')->clean($sName)
				), 'category_id = ' . (int)$iId);
		return true;
	}
	
	/**
	 * Deletes a category
	 * @param int $iId 
	 * @return bool
	 */
	public function deleteCategory($iId)
	{
		Phpfox::isAdmin(true);
		$this->database()->delete(Phpfox::getT('app_category'), 'category_id = ' . (int)$iId);
		$this->database()->delete(Phpfox::getT('app_category_data'), 'category_id = ' . (int)$iId);
		return true;
	}
}

?>