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
 * @version 		$Id: featured.class.php 6585 2013-09-05 10:01:48Z Miguel_Espinoza $
 */
class User_Service_Featured_Featured extends Phpfox_Service
{	
	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('user_featured');
	}

	/**
	 * Gets the featured members according to Phpfox::getParam('user.how_many_featured_members').
	 * Uses cache to save a query (stores a cache if none found)
	 * @return array( array of users, int total featured users )
	 */
	public function get()
	{
		if ($sPlugin = Phpfox_Plugin::get('user.service_featured_get_1'))
		{
			eval($sPlugin);
			if (isset($mPluginReturn)){ return $mPluginReturn; }
		}
		$iTotal = Phpfox::getParam('user.how_many_featured_members');
		// the random will be done with php logic
		$sCacheId = $this->cache()->set('featured_users');
		if (!($aUsers = $this->cache()->get($sCacheId)))
		{
			$aUsers = $this->database()->select(Phpfox::getUserField() . ', uf.ordering')
			->from(Phpfox::getT('user'), 'u')
			->join($this->_sTable, 'uf', 'uf.user_id = u.user_id')
			->order('ordering DESC')
			->execute('getSlaveRows');
			
			if (Phpfox::getParam('user.cache_featured_users'))
			{
				$this->cache()->save($sCacheId, $aUsers);
			}
		}

		if (!is_array($aUsers)) return array(array(), 0);		
		$aOut = array();
		if (Phpfox::getParam('user.randomize_featured_members'))		
			shuffle($aUsers);			
		
		$iCount = count($aUsers); // using count instead of $this->database()->limit to measure the real value
		for ($i = 0; $i <= $iTotal; $i++)
		{
			if (!isset($aUsers[$iCount -$i])) continue; // availability check
			$aOut[] = $aUsers[$iCount - $i];
		}
		
		return array($aOut, count($aUsers));
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_featured__call'))
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