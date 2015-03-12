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
class Marketplace_Service_Category_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('marketplace_category');
	}
	
	public function add($aVals)
	{
		if (empty($aVals['name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('marketplace.provide_a_category_name'));
		}
		
		$oParseInput = Phpfox::getLib('parse.input');
		
		$iCheck = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('parent_id = ' . (!empty($aVals['parent_id']) ? (int) $aVals['parent_id'] : 0) . ' AND name_url = \'' . $this->database()->escape($oParseInput->cleanTitle($aVals['name'])) . '\'')
			->execute('getField');
			
		if ($iCheck)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('marketplace.this_category_name_cannot_be_used_due_to_that_there_is_already_another_category_with_the_same_name_being_used'));
		}		
		
		$iId = $this->database()->insert($this->_sTable, array(
				'parent_id' => (!empty($aVals['parent_id']) ? (int) $aVals['parent_id'] : 0),
				'is_active' => 1,
				'name' => $oParseInput->clean($aVals['name'], 255),
				'name_url' => $oParseInput->cleanTitle($aVals['name']),
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		$this->cache()->remove('marketplace', 'substr');
		
		return $iId;
	}
	
	public function update($iId, $aVals)
	{
		$this->database()->update($this->_sTable, array('name' => Phpfox::getLib('parse.input')->clean($aVals['name'], 255), 'parent_id' => $aVals['parent_id']), 'category_id = ' . (int) $iId);
		
		$this->cache()->remove('marketplace', 'substr');
		
		return true;
	}
	
	public function delete($iId)
	{
		$this->database()->update($this->_sTable, array('parent_id' => 0), 'parent_id = ' . (int) $iId);
		
		$aListings = $this->database()->select('m.listing_id, m.user_id, m.image_path')
			->from(Phpfox::getT('marketplace_category_data'), 'mcd')
			->join(Phpfox::getT('marketplace'), 'm', 'm.listing_id = mcd.listing_id')
			->where('mcd.category_id = ' . (int) $iId)
			->execute('getRows');		
			
		foreach ($aListings as $aListing)
		{
			Phpfox::getService('marketplace.process')->delete($aListing['listing_id'], $aListing);
		}
		
		$this->database()->delete($this->_sTable, 'category_id = ' . (int) $iId);
		
		$this->cache()->remove('marketplace', 'substr');
		
		return true;
	}
	
	public function updateOrder($aVals)
	{
		foreach ($aVals as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => $iOrder), 'category_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('marketplace', 'substr');
		
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
		if ($sPlugin = Phpfox_Plugin::get('marketplace.service_category_process__call'))
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