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
 * @version 		$Id: process.class.php 1495 2010-03-05 15:45:57Z Raymond_Benc $
 */
class Favorite_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('favorite');
	}
	
	public function add($sTypeId, $iItemId)
	{
		if (!$this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('type_id = \'' . $this->database()->escape($sTypeId) . '\' AND item_id = ' . (int) $iItemId . ' AND user_id = ' . Phpfox::getUserId())
			->execute('getSlaveField')
		)
		{
			$sModule = $sTypeId;
			if (strpos($sModule, '_'))
			{
				$aParts = explode('_', $sModule);
				$sModule = $aParts[0];
			}
			
			if (!Phpfox::isModule($sModule))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('favorite.not_a_valid_module'));
			}			
			
			if (!Phpfox::callback($sTypeId . '.verifyFavorite', $iItemId))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('favorite.unable_to_add_this_item_as_a_favorite_due_to_privacy'));
			}
			
			$this->database()->insert($this->_sTable, array(
					'type_id' => $sTypeId,
					'item_id' => (int) $iItemId,
					'user_id' => Phpfox::getUserId(),
					'time_stamp' => PHPFOX_TIME
				)
			);
			
			return true;
		}
		
		return Phpfox_Error::set(Phpfox::getPhrase('favorite.this_item_is_already_in_your_favorites_list'));
	}
	
	public function delete($iId)
	{
		$this->database()->delete($this->_sTable, 'favorite_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
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
		if ($sPlugin = Phpfox_Plugin::get('favorite.service_process__call'))
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