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
 * @package  		Module_Track
 * @version 		$Id: track.class.php 5914 2013-05-13 08:38:15Z Raymond_Benc $
 */
class Track_Service_Track extends Phpfox_Service 
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		(($sPlugin = Phpfox_Plugin::get('track.service_track___construct')) ? eval($sPlugin) : false);	
	}	
	
	public function getLatestUsers($sType, $iId, $iUserId)
	{			
		if (Phpfox::getParam('track.cache_recently_viewed_by_timeout') > 0)
		{
			$sCacheId = $this->cache()->set(array('track', $sType . '_' . $iId));
			
			if (!($aTracks = $this->cache()->get($sCacheId, Phpfox::getParam('track.cache_recently_viewed_by_timeout') * 60))) // Cache is in minutes 
			{
				$aTracks = Phpfox::callback($sType . '.getLatestTrackUsers', $iId, $iUserId);
				
				$this->cache()->save($sCacheId, $aTracks);				
			}

			if (is_bool($aTracks))
			{
				$aTracks = array();
			}
			
			return $aTracks;
		}
		
		return Phpfox::callback($sType . '.getLatestTrackUsers', $iId, $iUserId);
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
		if ($sPlugin = Phpfox_Plugin::get('track.service_track___call'))
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