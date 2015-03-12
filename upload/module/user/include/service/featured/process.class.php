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
 * @package  		Module_User
 * @version 		$Id: process.class.php 5612 2013-04-05 07:46:26Z Miguel_Espinoza $
 */
class User_Service_Featured_Process extends Phpfox_Service
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user_featured');
	}

	/**
	 * This function features a member and clears the cache
	 * @return bool for success
	 */
	public function feature($iUser)
	{
		// check for permissions on featuring
		if (!Phpfox::getUserParam('user.can_feature'))	return false;
		
		(($sPlugin = Phpfox_Plugin::get('user.service_featured_feature_start')) ? eval($sPlugin) : false);
		$iUser = (int)$iUser;
		
		$bAlready = $this->database()
				->select('count(user_id)')
				->from($this->_sTable)
				->where('user_id = '.$iUser) //using primary key
				->limit(1)
				->execute('getSlaveField');
		
		if ($bAlready > 0) return true;

		(($sPlugin = Phpfox_Plugin::get('user.service_featured_feature_end')) ? eval($sPlugin) : false);
		
		$this->database()->insert($this->_sTable, array('user_id' => $iUser));
		// clear the cache
		$this->cacheFeaturedUsers();
		
		return true;
	}

	public function cacheFeaturedUsers()
	{
		if (Phpfox::getParam('user.cache_featured_users') != true) return;
				
		$this->cache()->remove('featured_users');
		
		// This function does the caching for us
		$aUsers = Phpfox::getService('user.featured')->get();
		
			
	}
	/**
	 * Updates the order of a featured member and clears the cache
	 * @param INT $iUser `user_featured`.`user_id`
	 * @param INT $iPos `user_featured`.`ordering`
	 * @return boolean
	 */
	public function updateOrder($aVals)
	{
		$aPositions = $aVals['ordering'];
		
		foreach ($aPositions as $iUser => $iPos)
		{			
			$this->database()->update($this->_sTable, array('ordering' => (int)$iPos), 'user_id = ' . (int)$iUser);
		}
		$this->cacheFeaturedUsers();
		return true;
	}

	/**
	 * Unfeatures a member and clears the cache
	 * @param INT $iUser user_id
	 * @return bool
	 */
	public function unfeature($iUser)
	{
		if (!Phpfox::getUserParam('user.can_feature'))	return false;
		$this->database()->delete($this->_sTable, 'user_id = ' . (int)$iUser);
		$this->cacheFeaturedUsers();
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_activity__call'))
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