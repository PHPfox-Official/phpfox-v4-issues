<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Process class for photo categories.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: process.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Photo_Service_Category_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo_category');	
	}
	
	/**
	 * Add a new public photo category
	 *
	 * @param array $aVals Post data which holds category information
	 * 
	 * @return int ID# of the new category inserted
	 */
	public function add($aVals)
	{
		$oParseInput = Phpfox::getLib('parse.input');

		Phpfox::getService('ban')->checkAutomaticBan($aVals['name']);

		// Insert the new category
		$iCategory = $this->database()->insert($this->_sTable, array(
				'parent_id' => (isset($aVals['category_id']) ? (int) $aVals['category_id'] : 0),
				'name' => $oParseInput->clean($aVals['name'], 255),
				'name_url' => $oParseInput->prepareTitle('photo', $aVals['name'], 'name_url', null, $this->_sTable),
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		// Remove from cache
		$this->cache()->remove('photo_category', 'substr');
		
		// Return the new category ID#
		return $iCategory;
	}
	
	public function update($aVals)
	{		
		$this->database()->update($this->_sTable, array(
				'parent_id' => (int)$aVals['category_id'],
				'name' => Phpfox::getLib('parse.input')->clean($aVals['name'], 255)				
			), 'category_id = ' . $aVals['edit_id']
		);
		
		// Remove from cache
		$this->cache()->remove('photo_category', 'substr');
		
		return true;
	}
	
	public function updateOrder($aOrders)
	{
		foreach ($aOrders as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => $iOrder), 'category_id = ' . (int) $iId);
		}
		
		// Remove from cache
		$this->cache()->remove('photo_category', 'substr');		
		
		return true;
	}
	
	public function delete($iId)
	{		
		$this->database()->delete($this->_sTable, 'category_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('photo_category_data'), 'category_id = ' . (int) $iId);
		$this->database()->update($this->_sTable, array('parent_id' => 0), 'parent_id = ' . (int) $iId);
		
		// Remove from cache
		$this->cache()->remove('photo_category', 'substr');				
		
		return true;
	}
	
	/**
	 * Update categories based on the item id.
	 *
	 * @param int $iPhoto ID of the photo.
	 * @param int $iCategory ID of the category.
	 *
	 * @return boolean ID of the new item we added.
	 */
	public function updateForItem($iPhoto, $iCategory)
	{
		static $bCache = false;
		
		if ($bCache === false)
		{
			$aCategories = $this->database()->select('photo_id, category_id')
				->from(Phpfox::getT('photo_category_data'))
				->where('photo_id = ' . (int) $iPhoto)
				->execute('getSlaveRow');
			
			foreach ($aCategories as $aCategory)
			{
				$this->database()->updateCounter('photo_category', 'used', 'category_id', $aCategories['category_id'], true);
			}
			
			$this->database()->delete(Phpfox::getT('photo_category_data'), 'photo_id = ' . (int) $iPhoto);
		}
		
		$bCache = true;
		
		// Lets add it again
		return $this->addForItem($iPhoto, $iCategory);
	}
	
	/**
	 * Add a new category for an item.
	 *
	 * @param int $iPhoto ID of the photo.
	 * @param int $iCategory ID of the category.
	 *
	 * @return boolean ID of the new item we added.
	 */
	public function addForItem($iPhoto, $iCategory)
	{
		$this->database()->update($this->_sTable, array('used' => array('= used +', 1)), 'category_id = ' . (int) $iCategory);		
		
		// Add the category data
		return $this->database()->insert(Phpfox::getT('photo_category_data'), array(
				'photo_id' => (int) $iPhoto,
				'category_id' => (int) $iCategory
			)
		);		
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_category_process__call'))
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