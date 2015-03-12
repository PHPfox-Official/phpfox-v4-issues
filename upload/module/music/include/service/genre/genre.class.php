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
 * @version 		$Id: genre.class.php 2556 2011-04-21 20:02:54Z Raymond_Benc $
 */
class Music_Service_Genre_Genre extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('music_genre');	
	}
	
	public function getList()
	{		
		$sCacheId = $this->cache()->set('music_genre');
		
		if (!($aRows = $this->cache()->get($sCacheId)))
		{		
			$aRows = $this->database()->select('genre_id, name, name_url')
				->from($this->_sTable)
				->order('name ASC')
				->execute('getRows');
				
			$this->cache()->save($sCacheId, $aRows);
		}
		
		foreach ($aRows as $iKey => $aRow)
		{
			if (($sView = Phpfox::getLib('request')->get('view')))
			{
				$aRows[$iKey]['link'] = Phpfox::permalink('music.genre', $aRow['genre_id'], $aRow['name'], false, null, array('view' => $sView));
			}
			else 
			{
				$aRows[$iKey]['link'] = Phpfox::permalink('music.genre', $aRow['genre_id'], $aRow['name']);	
			}			
		}		
			
		return $aRows;
	}
	
	public function getUserGenre($iUserId)
	{
		return $this->database()->select('mg.genre_id, mg.name, mg.name_url, mgu.order_id')
			->from(Phpfox::getT('music_genre_user'), 'mgu')
			->join(Phpfox::getT('music_genre'), 'mg', 'mg.genre_id = mgu.genre_id')
			->where('mgu.user_id = ' . (int) $iUserId)
			->execute('getSlaveRows');
	}
	
	public function getGenre($iGenreId)
	{
		$aRow = $this->database()->select('*')
			->from($this->_sTable)
			->where('genre_id = ' . (int) $iGenreId)
			->execute('getSlaveRow');
			
		return (isset($aRow['genre_id']) ? $aRow : false);
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
		if ($sPlugin = Phpfox_Plugin::get('music.service_genre_genre__call'))
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