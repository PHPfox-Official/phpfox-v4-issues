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
 * @version 		$Id: process.class.php 5594 2013-03-28 14:36:07Z Miguel_Espinoza $
 */
class Track_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor 2
	 */	
	public function __construct()
	{	

	}
	
	public function add($sType, $iId, $iUserId = null)
	{		
		if (Phpfox::getUserBy('is_invisible'))
		{
			return false;
		}
		
		return Phpfox::callback($sType . '.addTrack', $iId, $iUserId);
	}
	
	public function update($sTable, $iId, $iUserId = null)
	{
		
		if (Phpfox::getParam('track.cache_allow_recurrent_visit') > 0)
		{
			// Get the cache!
			$sType = '';
			switch($sTable)
			{
				case 'user_track':
					// This type is defined in the service track->getLatestUsers. It is also used in track.callback->addTrack
					$sType = 'profile';
					break;
			}
			$sCacheId = $this->cache()->set(array('track',$sType .'_' . $iId));
			
			if (!($aTracks = $this->cache()->get($sCacheId)))
			{
				 
			}
			else
			{
				// Check every track record in cache
				foreach ($aTracks as $aTrack)
				{
					// If its the user visiting this profile and it was added recently we dont add it anymore.
					if ($aTrack['user_id'] == Phpfox::getUserId() && 
						($aTrack['time_stamp'] >= (PHPFOX_TIME - (Phpfox::getParam('track.cache_allow_recurrent_visit') * 60)))
						)
					{
						return true;
					}
				}
			}
		}
		
		$this->database()->update(Phpfox::getT($sTable), array(
				'time_stamp' => PHPFOX_TIME
			), 'item_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId()
		);
	}
	
	public function remove($sType, $iId, $iUserId = null)
	{		
		return Phpfox::callback($sType . '.removeTrack', $iId, $iUserId);
	}	
	
	public function __call($sMethod, $aArguments)
	{
		if ($sPlugin = Phpfox_Plugin::get('track.service_process__call'))
		{
			return eval($sPlugin);
		}
			
		Phpfox_Error::throwException('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>