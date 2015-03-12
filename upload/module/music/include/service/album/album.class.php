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
 * @version 		$Id: album.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Music_Service_Album_Album extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('music_album');
	}
	
	/**
	 * @todo Add perms.
	 *
	 * @param unknown_type $iId
	 * @return unknown
	 */
	public function getForEdit($iId)
	{
		$aAlbum = $this->database()->select('ma.*, mat.text, u.user_name')
			->from($this->_sTable, 'ma')			
			->join(Phpfox::getT('music_album_text'), 'mat', 'mat.album_id = ma.album_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ma.user_id')
			->where('ma.album_id = ' . (int) $iId)
			->execute('getRow');

		if (!isset($aAlbum['album_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('music.unable_to_find_the_album_you_want_to_edit'));
		}
		
		if (($aAlbum['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('music.can_edit_own_albums')) || Phpfox::getUserParam('music.can_edit_other_music_albums'))
		{
			return $aAlbum;	
		}
		
		return Phpfox_Error::set(Phpfox::getPhrase('music.unable_to_edit_this_album'));
	}
	
	public function getTracks($iUserId, $iId, $bCanViewAll = false)
	{				
		static $aSongs = null;
		
		if ($aSongs === null)
		{
			$aSongs = Phpfox::getService('music')->getSongs($iUserId, $iId, null, $bCanViewAll);
		}
		
		return $aSongs;
	}
	
	public function getForUpload($aCallback = null)
	{
		$aCond = array();
		$sWhere = 'ma.view_id = 0 AND ma.user_id = ' . Phpfox::getUserId();
		if (isset($aCallback['module_id']))
		{
			$sWhere .= ' AND ma.module_id = "' . $this->database()->escape($aCallback['module_id']) . '"';
		}
		if (isset($aCallback['item_id']))
		{
			$sWhere .= ' AND ma.item_id = ' . (int)$aCallback['item_id'];
		}
		
		return $this->database()->select('ma.album_id, ma.name')
			->from($this->_sTable, 'ma')
			->where($sWhere)
			->order('ma.name ASC')
			->execute('getSlaveRows');		
	}
	
	public function getForProfile($iUserId, $iLimit = 4)
	{
		return $this->database()->select('ma.name, ma.name_url, ma.year, ma.image_path, ma.server_id, ma.total_track, ma.total_play, ma.time_stamp')
			->from($this->_sTable, 'ma')
			->where('ma.view_id = 0 AND ma.user_id = ' . (int) $iUserId)
			->order('ma.time_stamp DESC')
			->limit($iLimit)
			->execute('getSlaveRows');
	}
	
	public function getAlbum($iAlbum)
	{
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'music_album\' AND lik.item_id = ma.album_id AND lik.user_id = ' . Phpfox::getUserId());
		}	
			
		$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = ma.user_id AND f.friend_user_id = " . Phpfox::getUserId());			
		
		$aAlbum = $this->database()->select('ma.*, ' . (Phpfox::getParam('core.allow_html') ? 'mat.text_parsed' : 'mat.text') . ' AS text, u.user_name, vr.rate_id AS has_rated, ' . Phpfox::getUserField())
			->from($this->_sTable, 'ma')
			->join(Phpfox::getT('music_album_text'), 'mat', 'mat.album_id = ma.album_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ma.user_id')
			->leftJoin(Phpfox::getT('music_album_rating'), 'vr', 'vr.item_id = ma.album_id AND vr.user_id = ' . Phpfox::getUserId())
			->where('ma.album_id = ' . (int) $iAlbum)
			->execute('getSlaveRow');
			
		if (!isset($aAlbum['album_id']))
		{
			return false;
		}
		
		$aAlbum['bookmark'] = Phpfox::getLib('url')->permalink('music.album', $aAlbum['album_id'], $aAlbum['name']);
			
		return $aAlbum;
	}
	
	public function getForPlayer($iId)
	{
		return $this->database()->select('ma.*, ' . (Phpfox::getParam('core.allow_html') ? 'mat.text_parsed' : 'mat.text') . ' AS text')
			->from($this->_sTable, 'ma')
			->join(Phpfox::getT('music_album_text'), 'mat', 'mat.album_id = ma.album_id')
			->where('ma.album_id = ' . (int) $iId . ' AND ma.view_id = 0')
			->execute('getSlaveRow');		
	}
	
	public function getNextSong($iAlbumId, $iLastSongId)
	{
		$aSongs = $this->database()->select('ms.song_id, ms.song_path')
			->from(Phpfox::getT('music_song'), 'ms')
			->where('ms.album_id = ' . (int) $iAlbumId)
			->order('ms.ordering ASC, ms.time_stamp DESC')
			->execute('getSlaveRows');
			
		$iNextSong = 0;
		foreach ($aSongs as $iKey => $aSong)
		{
			if ($aSong['song_id'] == $iLastSongId)
			{
				$iNextSong = ($iKey + 1);	
			}
		}
				
		return (isset($aSongs[$iNextSong]) ? $aSongs[$iNextSong] : false);
	}
	
	public function getLatestAlbums($aParentModule = null)
	{		
		$aCond = array();
		$aCond[] = 'AND ma.view_id = 0 AND ma.privacy = 0 AND ma.total_track > 0';
		if (is_array($aParentModule))
		{
			$aCond[] = 'AND ma.module_id = \'' . $this->database()->escape($aParentModule['module_id']) . '\' AND ma.item_id = ' . (int) $aParentModule['item_id'];
		}	
		else
		{
			$aCond[] = 'AND ma.item_id = 0';
		}
		
		$aAlbums = $this->database()->select('ma.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'ma')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ma.user_id')
			->where($aCond)
			->limit(5)
			->order('ma.time_stamp DESC')
			->execute('getSlaveRows');
			
		return $aAlbums;
	}
	
	public function getFeaturedAlbums()
	{
		$sCacheId = $this->cache()->set('music_album_featured');
		
		if (!($aAlbums = $this->cache()->get($sCacheId)))
		{			
			$aAlbums = $this->database()->select('ma.*, ' . Phpfox::getUserField())
				->from($this->_sTable, 'ma')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = ma.user_id')
				->where('ma.view_id = 0 AND ma.privacy = 0 AND ma.is_featured = 1')
				->order('ma.time_stamp DESC')
				->execute('getSlaveRows');
				
			$this->cache()->save($sCacheId, $aAlbums);
		}
					
		if (!is_array($aAlbums))
		{
			return array();
		}
		
		shuffle($aAlbums);
		
		$aReturn = array();
		$iCnt = 0;
		foreach ($aAlbums as $aAlbum)
		{
			$iCnt++;
			
			if ($iCnt > 5)
			{
				break;
			}
			
			$aReturn[] = $aAlbum;
		}
		
		return $aReturn;
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
		if ($sPlugin = Phpfox_Plugin::get('music.service_album_album__call'))
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
