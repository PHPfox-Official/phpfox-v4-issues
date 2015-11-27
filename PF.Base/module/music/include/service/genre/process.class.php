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
 * @version 		$Id: process.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Music_Service_Genre_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('music_genre');
	}
	
	/**
	 * @todo Protect me, anyone can edit this...
	 *
	 * @param unknown_type $iUserId
	 * @param unknown_type $iEditUserId
	 * @param unknown_type $aVals
	 * @return unknown
	 */
	public function updateUser($iUserId, $iEditUserId, $aVals)
	{
		$this->database()->delete(Phpfox::getT('music_genre_user'), 'user_id = ' . (int) $iUserId);
		
		foreach ($aVals as $iKey => $iId)
		{
			if (empty($iId))
			{
				continue;
			}
			
			$this->database()->insert(Phpfox::getT('music_genre_user'), array(
					'user_id' => $iUserId,
					'genre_id' => (int) $iId,
					'order_id' => (int) $iKey
				)
			);		
		}
		
		return true;
	}
	
	public function add($aVals)
	{
		$oParseInput = Phpfox::getLib('parse.input');
		Phpfox::getService('ban')->checkAutomaticBan($aVals['name']);
		$this->database()->insert($this->_sTable, array(
				'name' => $oParseInput->clean($aVals['name'], 255),
				'name_url' => $oParseInput->cleanTitle($aVals['name'])
			)
		);
		
		$this->cache()->remove('music_genre');
		
		return true;
	}
	
	public function update($iId, $sName)
	{
		$oParseInput = Phpfox::getLib('parse.input');
		Phpfox::getService('ban')->checkAutomaticBan($sName);
		$this->database()->update($this->_sTable, array(
				'name' => $oParseInput->clean($sName, 255)
			), 'genre_id = ' . (int) $iId
		);
		
		$this->cache()->remove('music_genre');
		
		return true;
	}
	
	public function delete($iId)
	{
		$this->database()->delete($this->_sTable, 'genre_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('music_genre_user'), 'genre_id = ' . (int) $iId);
		
		$this->cache()->remove('music_genre');
		
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
		if ($sPlugin = Phpfox_Plugin::get('music.service_genre_process__call'))
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