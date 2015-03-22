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
 * @version 		$Id: process.class.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
class User_Service_Promotion_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user_promotion');	
	}
	
	public function add($aVals)
	{
		$this->database()->insert(Phpfox::getT('user_promotion'), array(
				'user_group_id' => (int) $aVals['user_group_id'],
				'upgrade_user_group_id' => (int) $aVals['upgrade_user_group_id'],
				'total_activity' => (int) $aVals['total_activity'],
				'total_day' => (int) $aVals['total_day'],
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		$this->cache()->remove('promotion', 'substr');
		
		return true;
	}
	
	public function update($iId, $aVals)
	{
		$this->database()->update(Phpfox::getT('user_promotion'), array(
				'user_group_id' => (int) $aVals['user_group_id'],
				'upgrade_user_group_id' => (int) $aVals['upgrade_user_group_id'],
				'total_activity' => (int) $aVals['total_activity'],
				'total_day' => (int) $aVals['total_day'],				
			), 'promotion_id = ' . (int) $iId
		);
		
		$this->cache()->remove('promotion', 'substr');
		
		return true;
	}	
	
	public function delete($iId)
	{
		$this->database()->delete($this->_sTable, 'promotion_id = ' . (int) $iId);
		
		$this->cache()->remove('promotion', 'substr');
		
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_promotion_process__call'))
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