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
 * @package  		Module_Music
 * @version 		$Id: music.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Music_Service_Music extends Phpfox_Service 
{
	private $_aMimeTypes = array('audio/mpeg', 'application/octet-stream');

	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('music_song');
	}

	public function getMimeTypes()
	{
		return $this->_aMimeTypes;
	}
	
	public function getSongs($iUserId, $iAlbumId = null, $iLimit = null, $bCanViewAll = false)
	{
		$aSongs = $this->database()->select('ms.song_id, ms.user_id, ms.album_id, ms.title, ms.total_play, ms.song_path, ms.is_featured, ms.view_id, ms.server_id, ms.explicit, ms.duration, ms.time_stamp, ma.name AS album_url, u.user_name, mp.play_id AS is_on_profile, mp.user_id AS profile_user_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'ms')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
			->leftJoin(Phpfox::getT('music_album'), 'ma', 'ma.album_id = ms.album_id')
			->leftJoin(Phpfox::getT('music_profile'), 'mp', 'mp.song_id = ms.song_id AND mp.user_id = ' . Phpfox::getUserId())
			->where(($bCanViewAll === false ? 'ms.view_id = 0 AND' : '') . ($iAlbumId === null ? '' : ' ms.album_id = ' . (int) $iAlbumId . ' AND') . ' ms.user_id = ' . (int) $iUserId)
			->order('ms.ordering ASC, ms.time_stamp DESC')
			->limit($iLimit)
			->execute('getSlaveRows');
			
		foreach ($aSongs as $iKey => $aSong)
		{
			$aSongs[$iKey]['song_path'] = $this->getSongPath($aSong['song_path'], $aSong['server_id']);
		}
		
		return $aSongs;
	}
	
	public function getForProfile($iUserId, $iLimit = null)
	{
		$aSongs = $this->database()->select('ms.song_id, ms.user_id, ms.album_id, ms.title, ms.total_play, ms.song_path, ms.is_featured, ms.view_id, ms.server_id, ms.explicit, ms.duration, ms.time_stamp, ma.name AS album_url, u.user_name, mp.play_id AS is_on_profile, mp.user_id AS profile_user_id, ' . Phpfox::getUserField())
			->from(Phpfox::getT('music_profile'), 'mp')
			->join($this->_sTable, 'ms', 'ms.song_id = mp.song_id AND ms.view_id = 0 AND ms.privacy = 0')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
			->leftJoin(Phpfox::getT('music_album'), 'ma', 'ma.album_id = ms.album_id')
			->where('mp.user_id = ' . (int) $iUserId)
			->order('ms.time_stamp DESC')
			->limit($iLimit)
			->execute('getSlaveRows');

		foreach ($aSongs as $iKey => $aSong)
		{
			$aSongs[$iKey]['song_path'] = $this->getSongPath($aSong['song_path'], $aSong['server_id']);
		}		
		
		return $aSongs;		
	}
	
	public function getForEdit($iId, $bForce = false)
	{
		$aRow = $this->database()->select('*')
			->from($this->_sTable)
			->where('song_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['song_id']))
		{
			return Phpfox_Error::set('Unable to find the song you are looking for.');
		}
		
		if ((($aRow['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('music.can_edit_own_song')) || Phpfox::getUserParam('music.can_edit_other_song')) || $bForce === true)
		{
			return $aRow;
		}
			
		return Phpfox_Error::set('Unable to edit this song.');
	}
	
	public function getSong($iSongId)
	{
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'music_song\' AND lik.item_id = ms.song_id AND lik.user_id = ' . Phpfox::getUserId());
		}	
			
		$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = ms.user_id AND f.friend_user_id = " . Phpfox::getUserId());					
		
		$aSong = $this->database()->select('ms.*, ms.total_comment as song_total_comment, ms.total_play as song_total_play, ms.time_stamp as song_time_stamp, ms.is_sponsor AS song_is_sponsor, ma.name AS album_url, mp.play_id AS is_on_profile, mp.user_id AS profile_user_id, vr.rate_id AS has_rated, ' . Phpfox::getUserField())
			->from($this->_sTable, 'ms')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
			->leftJoin(Phpfox::getT('music_album'), 'ma', 'ma.album_id = ms.album_id')
			->leftJoin(Phpfox::getT('music_profile'), 'mp', 'mp.song_id = ms.song_id AND mp.user_id = ' . Phpfox::getUserId())
			->leftJoin(Phpfox::getT('music_song_rating'), 'vr', 'vr.item_id = ms.song_id AND vr.user_id = ' . Phpfox::getUserId())
			->where('ms.song_id = ' . (int) $iSongId)
			->execute('getSlaveRow');		
		
		if (!isset($aSong['song_id']))
		{
			return false;
		}		
			
		$aSong['song_path'] = $this->getSongPath($aSong['song_path'], $aSong['server_id']);
		$aSong['bookmark'] = Phpfox::getLib('url')->permalink('music', $aSong['song_id'], $aSong['title']);
		if (!isset($aSong['song_total_comment']))
		{
		    $aSong['song_total_comment'] = 0;
		}
		if (!isset($aSong['is_liked']))
		{
			$aSong['is_liked'] = false;
		}
		return $aSong;	
	}

	public function getSongPath($sSong, $iServerId = null)
	{
		if (preg_match("/\{file\/music_folder\/(.*)\.mp3\}/i", $sSong, $aMatches))
		{
			return Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);
		}
		$sSong = Phpfox::getParam('music.url') . sprintf($sSong, '');	
		
		if (Phpfox::getParam('core.allow_cdn') && !empty($iServerId))
		{
			//$sSong = Phpfox::getLib('cdn')->getUrl($sSong);
			$sTempSong = Phpfox::getLib('cdn')->getUrl($sSong, $iServerId);
			if (!empty($sTempSong))
			{
				$sSong = $sTempSong;
			}
		}
		
		return $sSong;
	}
	
	public function getLatestSongs()
	{
		$aSongs = $this->database()->select('ms.song_id, ms.user_id, ms.album_id, ms.title, ms.song_path, ms.server_id, ms.explicit, ms.duration, ms.time_stamp, ma.name AS album_url, u.user_name, mp.play_id AS is_on_profile, mp.user_id AS profile_user_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'ms')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
			->leftJoin(Phpfox::getT('music_album'), 'ma', 'ma.album_id = ms.album_id')
			->leftJoin(Phpfox::getT('music_profile'), 'mp', 'mp.song_id = ms.song_id AND mp.user_id = ' . Phpfox::getUserId())
			->where('ms.view_id = 0')
			->order('ms.time_stamp DESC')
			->limit(10)
			->execute('getSlaveRows');
			
		foreach ($aSongs as $iKey => $aSong)
		{
			$aSongs[$iKey]['song_path'] = $this->getSongPath($aSong['song_path'], $aSong['server_id']);
		}		
		
		return $aSongs;
	}
	
	public function getFeaturedSongs()
	{		
		$sCacheId = $this->cache()->set('music_song_featured');
		
		if (!($aSongs = $this->cache()->get($sCacheId)))
		{		
			$aSongs = $this->database()->select('ms.song_id, ms.user_id, ms.album_id, ms.title, ms.total_play, ms.song_path, ms.server_id, ms.explicit, ms.duration, ms.time_stamp, ' . Phpfox::getUserField())
				->from($this->_sTable, 'ms')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
				->leftJoin(Phpfox::getT('music_album'), 'ma', 'ma.album_id = ms.album_id')
				->where('ms.view_id = 0 AND ms.privacy = 0 AND ms.is_featured = 1')
				->order('ms.time_stamp DESC')
				->execute('getSlaveRows');
				
			foreach ($aSongs as $iKey => $aSong)
			{
				$aSongs[$iKey]['url'] = Phpfox::getLib('url')->permalink('music', $aSong['song_id'], $aSong['title']);
			}
			
			$this->cache()->save($sCacheId, $aSongs);
		}		
		
		if (!is_array($aSongs))
		{
			return array();
		}
		
		shuffle($aSongs);
		
		$aReturn = array();
		$iCnt = 0;
		foreach ($aSongs as $aSongs)
		{
			$iCnt++;
			
			if ($iCnt > 5)
			{
				break;
			}
			
			$aReturn[] = $aSongs;
		}
		
		return $aReturn;
	}

	/** @deprecated 3.6.0 */
	public function getRandomSponsoredSongs()
	{
		return false;
	    $sCacheId = $this->cache()->set('music_song_sponsored');
	    if (!($aSongs = $this->cache()->get($sCacheId)))
	    {
			$aSongs = $this->database()->select('ms.*, ma.*, u.user_name, s.*')
				->from($this->_sTable, 'ms')
				->leftjoin(Phpfox::getT('music_album'), 'ma', 'ma.album_id = ms.album_id')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
				->join(Phpfox::getT('ad_sponsor'), 's', 's.item_id = ms.song_id')
				->where('ms.view_id = 0 AND ms.is_sponsor = 1 AND s.module_id = "music-song"')
				->execute('getSlaveRows');

			$this->cache()->save($sCacheId, $aSongs);
	    }
	    
	    if (!isset($aSongs[0]) || empty($aSongs[0]))
	    {
			return array();
	    }
	    
	    $aOut = array();
	    shuffle($aSongs);
	    for ($i = 0; ($i < Phpfox::getParam('music.sponsored_songs_to_show')) && !empty($aSongs); ++$i)
	    {
			$aOut[] = array_pop($aSongs);
	    }
	    return $aOut;
	}

	public function getRandomSponsoredAlbum()
	{
	    $sCacheId = $this->cache()->set('music_album_sponsored');
	    if (!($aAlbums = $this->cache()->get($sCacheId)))
	    {
		$aAlbums = $this->database()->select('s.sponsor_id, m.name, m.year, m.total_track, m.server_id, m.image_path, m.user_id,' . Phpfox::getUserField())
			->from(Phpfox::getT('music_album'), 'm')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
			->join(Phpfox::getT('ad_sponsor'), 's', 's.item_id = m.album_id')
			->where('m.view_id = 0 AND m.is_sponsor = 1 AND s.module_id = "music-album"')
			->execute('getSlaveRows');
			
		$this->cache()->save($sCacheId, $aAlbums);
	    }
	    
	    if (empty($aAlbums) || !is_array($aAlbums))
	    {
		return array();
	    }

	    shuffle($aAlbums);
	    return array_pop($aAlbums);
	}

	public function getPendingTotal()
	{
		return (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('view_id = 1')
			->execute('getSlaveField');
	}	
	
	public function getSectionMenu()
	{
		$aFilterMenu = array();
		if (!defined('PHPFOX_IS_USER_PROFILE'))
		{
			$aFilterMenu = array(
				Phpfox::getPhrase('music.all_songs') => '',
				Phpfox::getPhrase('music.my_songs') => 'my'							
			);
			
			if (Phpfox::isModule('friend') && !Phpfox::getParam('core.friends_only_community'))
			{
				$aFilterMenu[Phpfox::getPhrase('music.friends_songs')] = 'friend';	
			}			
			
			if (Phpfox::getUserParam('music.can_approve_songs'))
			{
				$iPendingTotal = Phpfox::getService('music')->getPendingTotal();
				
				if ($iPendingTotal)
				{
					$aFilterMenu[Phpfox::getPhrase('music.pending_songs') . '<span class="pending">' . $iPendingTotal . '</span>'] = 'pending';
				}
			}
			
			$aFilterMenu[] = true;	
			
			$aFilterMenu[Phpfox::getPhrase('music.all_albums')] = 'music.browse.album';
			$aFilterMenu[Phpfox::getPhrase('music.my_albums')] = 'music.browse.album.view_my-album';
		}		
		
		Phpfox::getLib('template')->buildSectionMenu('music', $aFilterMenu);					
	}
	
	public function getInfoForAction($aItem)
	{		
		// now we check if its a music-album or a music-song
		if ($aItem['item_type_id'] == 'music-song')
		{			
			$aRow = $this->database()->select('ms.song_id, ms.title, ms.user_id, u.gender, u.full_name')	
				->from(PHpfox::getT('music_song'), 'ms')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = ms.user_id')
				->where('ms.song_id = ' . (int) $aItem['item_id'])
				->execute('getSlaveRow');
			$aRow['link'] = Phpfox::getLib('url')->permalink('music', $aRow['song_id'], $aRow['title']);
			return $aRow;
		}
		
		// else its a music-album
		$aRow = $this->database()->select('ma.album_id, ma.name as title, ma.user_id, u.gender, u.full_name')	
			->from(PHpfox::getT('music_album'), 'ma')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ma.user_id')
			->where('ma.album_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
		$aRow['link'] = Phpfox::getLib('url')->permalink('music.album', $aRow['album_id'], $aRow['title']);
		return $aRow;
			
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
		if ($sPlugin = Phpfox_Plugin::get('music.service_music__call'))
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
