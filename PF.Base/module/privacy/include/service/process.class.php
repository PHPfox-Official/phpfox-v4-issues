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
 * @package  		Module_Privacy
 * @version 		$Id: process.class.php 2278 2011-01-21 16:01:52Z Raymond_Benc $
 */
class Privacy_Service_Process extends Phpfox_Service  
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('privacy');
	}
	
	public function add($sModuleId, $iItemId, $aLists)
	{		
		if (count($aLists))
		{
			foreach ($aLists as $iListId)
			{
				$this->database()->insert($this->_sTable, array(
						'module_id' => $sModuleId,
						'item_id' => $iItemId,
						'user_id' => Phpfox::getUserId(),
						'friend_list_id' => (int) $iListId,
						'added' => PHPFOX_TIME
					)
				);
			}
		}
		
		return true;
	}	
	
	public function update($sModuleId, $iItemId, $aLists)
	{
		$this->database()->delete($this->_sTable, "module_id = '" . $this->database()->escape($sModuleId) . "' AND item_id = " . (int) $iItemId . "");
		
		return $this->add($sModuleId, $iItemId, $aLists);
	}
	
	public function delete($sModuleId, $iItemId)
	{
		$this->database()->delete($this->_sTable, "module_id = '" . $this->database()->escape($sModuleId) . "' AND item_id = " . (int) $iItemId . "");
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
		if ($sPlugin = Phpfox_Plugin::get('privacy.service_process__call'))
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