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
 * @version 		$Id: browse.class.php 6927 2013-11-22 12:32:11Z Raymond_Benc $
 */
class Photo_Service_Album_Browse extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function processRows(&$aRows)
	{
		foreach ($aRows as $iKey => $aRow)
		{	
			if ($aRow['profile_id'] > 0)
			{
				$aRows[$iKey]['name'] = Phpfox::getPhrase('photo.profile_pictures');
				$aRows[$iKey]['link'] = Phpfox::permalink('photo.album.profile', $aRow['user_id'], $aRow['user_name']);
			}
			else
			{
				$aRows[$iKey]['link'] = Phpfox::permalink('photo.album', $aRow['album_id'], $aRow['name']);
			}
		}	
	}
	
	public function query()
	{
		// http://www.phpfox.com/tracker/view/14733/
		/*
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id as is_liked, ');
		}
		*/
		// END
		
		$this->database()->select('p.destination, p.server_id, ')->leftJoin(Phpfox::getT('photo'), 'p', 'p.album_id = pa.album_id AND pa.view_id = 0 AND p.is_cover = 1');
	}
	
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		if (Phpfox::isModule('friend') && Phpfox::getService('friend')->queryJoin($bNoQueryFriend))
		{
			$this->database()->join(Phpfox::getT('friend'), 'friends', 'friends.user_id = pa.user_id AND friends.friend_user_id = ' . Phpfox::getUserId());	
		}
		
		// http://www.phpfox.com/tracker/view/14733/
		if (Phpfox::isModule('like'))
		{
			$this->database()->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = "photo_album" AND l.item_id = pa.album_id AND l.user_id = ' . Phpfox::getUserId() . '');				
		}
		// END
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_album_browse__call'))
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
