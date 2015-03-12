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
 * @version 		$Id: process.class.php 6506 2013-08-26 08:42:59Z Miguel_Espinoza $
 */
class Music_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('music_song');	
	}
	
	public function upload($aVals, $iAlbumId = 0)
	{
		if (!isset($_FILES['mp3']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('music.select_an_mp3'));
		}
		
		$aSong = Phpfox::getLib('file')->load('mp3', 'mp3', Phpfox::getUserParam('music.music_max_file_size'));

		if (function_exists('finfo_open'))
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			if (!in_array(finfo_file($finfo, $_FILES['mp3']['tmp_name']), Phpfox::getService('music')->getMimeTypes()))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('core.uploaded_file_is_not_valid'));
			}
			finfo_close($finfo);
		}

		if ($aSong === false)
		{
			return false;
		}
		
		if (empty($aVals['title']))
		{
			$aVals['title'] = $aSong['name'];
		}
		
		if (!isset($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		
		if (!isset($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}
		
		if ($iAlbumId < 1 && isset($aVals['album_id']))
		{
			$iAlbumId = (int)$aVals['album_id'];
		}
		
		
		if ($iAlbumId > 0)
		{
			$aAlbum = $this->database()->select('*')
				->from(Phpfox::getT('music_album'))
				->where('album_id = ' . (int) $iAlbumId)
				->execute('getSlaveRow');		
				
			$aVals['privacy'] = $aAlbum['privacy'];
			$aVals['privacy_comment'] = $aAlbum['privacy_comment'];
			
			if (!empty($aAlbum['module_id']))
			{
				$aVals['callback_module'] = $aAlbum['module_id'];
			}
			if (!empty($aAlbum['item_id']))
			{
				$aVals['callback_item_id'] = $aAlbum['item_id'];
			}
		}
		
		if (!empty($aVals['new_album_title']))
		{
			$iAlbumId = $this->database()->insert(Phpfox::getT('music_album'), array(
					'user_id' => Phpfox::getUserId(),
					'name' => $this->preParse()->clean($aVals['new_album_title']),
					'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
					'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),
					'time_stamp' => PHPFOX_TIME,
					'module_id' => (isset($aVals['callback_module']) ? $aVals['callback_module'] : null),
					'item_id' => (isset($aVals['callback_item_id']) ? (int) $aVals['callback_item_id'] : '0')				
				)
			);
			
			$aAlbum = $this->database()->select('*')
				->from(Phpfox::getT('music_album'))
				->where('album_id = ' . (int) $iAlbumId)
				->execute('getSlaveRow');				
			
			$this->database()->insert(Phpfox::getT('music_album_text'), array(
					'album_id' => $iAlbumId
				)
			);			
			
			if ($aVals['privacy'] == '4')
			{
				// Phpfox::getService('privacy.process')->add('music_album', $iAlbumId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
			}				
		}
		
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title']);
		
		$aInsert = array(
			'view_id' => (Phpfox::getUserParam('music.music_song_approval') ? '1' : '0'),
			'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
			'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),		
			'album_id' => $iAlbumId,
			'genre_id' => (isset($aVals['genre_id']) ? (int) $aVals['genre_id'] : '0'),
			'user_id' => Phpfox::getUserId(),
			'title' => Phpfox::getLib('parse.input')->clean($aVals['title'], 255),
			'description' => (isset($aVals['status_info']) ? Phpfox::getLib('parse.input')->clean($aVals['status_info'], 255) : null),
			'explicit' => ((isset($aVals['explicit']) && $aVals['explicit']) ? 1 : 0),
			'time_stamp' => PHPFOX_TIME,
			'module_id' => (isset($aVals['callback_module']) ? $aVals['callback_module'] : null),
			'item_id' => (isset($aVals['callback_item_id']) ? (int) $aVals['callback_item_id'] : '0')
		);
		
		$iId = $this->database()->insert($this->_sTable, $aInsert);
		
		if (!$iId)
		{
			return false;
		}
		
		$sFileName = Phpfox::getLib('file')->upload('mp3', Phpfox::getParam('music.dir'), $iId);		
		
		$sDuration = null;
		if (file_exists(PHPFOX_DIR_LIB . 'getid3' . PHPFOX_DS . 'getid3' . PHPFOX_DS . 'getid3.php'))
		{
			// Temp. disable error reporting
			Phpfox_Error::skip(true);	
			
			require_once(PHPFOX_DIR_LIB . 'getid3' . PHPFOX_DS . 'getid3' . PHPFOX_DS . 'getid3.php');
			
			$oGetId3 = new getID3;
			
			$aMetaData = $oGetId3->analyze(Phpfox::getParam('music.dir') . sprintf($sFileName, ''));
			
			if (isset($aMetaData['playtime_string']))
			{
				$sDuration = $aMetaData['playtime_string'];
			}
		}
		
		$aInsert['song_id'] = $iId;
		$aInsert['duration'] = $sDuration;
		$aInsert['song_path'] = $sFileName;
		$aInsert['full_name'] = $sFileName;
		$aInsert['is_featured'] = 0;
		$aInsert['user_name'] = Phpfox::getUserBy('user_name');
		// Return back error reporting
		Phpfox_Error::skip(false);		
		
		$this->database()->update($this->_sTable, array('song_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID'), 'duration' => $sDuration), 'song_id = ' . (int) $iId);		
		
		// Update user space usage
		if (!Phpfox::getUserParam('music.music_song_approval'))
		{
			Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'music', filesize(Phpfox::getParam('music.dir') . sprintf($sFileName, '')));
		}
		
		if ($aVals['privacy'] == '4')
		{
			Phpfox::getService('privacy.process')->add('music_song', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
		}		
		
		$aCallback = null;
		if (!empty($aVals['callback_module']) && Phpfox::hasCallback($aVals['callback_module'], 'uploadSong'))
		{
			$aCallback = Phpfox::callback($aVals['callback_module'] . '.uploadSong', $aVals['callback_item_id']);	
		}		
		
		if ($iAlbumId > 0)
		{			
			if (!Phpfox::getUserParam('music.music_song_approval'))
			{					
				$this->database()->updateCounter('music_album', 'total_track', 'album_id', $iAlbumId);
			
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->callback($aCallback)->add('music_album', $iId, $aAlbum['privacy'], (isset($aAlbum['privacy_comment']) ? (int) $aAlbum['privacy_comment'] : 0), (isset($aVals['callback_item_id']) ? (int) $aVals['callback_item_id'] : '0')) : null);
			}			
		}
		else 
		{
			if (!Phpfox::getUserParam('music.music_song_approval'))
			{	
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->callback($aCallback)->add('music_song', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0), (isset($aVals['callback_item_id']) ? (int) $aVals['callback_item_id'] : '0')) : null);
			}
		}
		
		if (!Phpfox::getUserParam('music.music_song_approval'))
		{
			Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'music_song');
		}
		
        // plugin call
		if ($sPlugin = Phpfox_Plugin::get('music.service_process_upload__end')){eval($sPlugin);}
		
		return $aInsert;
	}
	
	public function delete($iId, &$aSong = null)
	{
		$bSkip = true;
		$mReturn = true;
		if ($aSong === null)
		{
			$bSkip = false;
			$aSong = $this->database()->select('song_id, album_id, module_id, item_id, user_id, song_path, is_sponsor, server_id')
				->from($this->_sTable)
				->where('song_id = ' . (int) $iId)
				->execute('getRow');
			
			if (!isset($aSong['song_id']))
			{
				return false;
			}				
			
			if ($aSong['module_id'] == 'pages' && Phpfox::getService('pages')->isAdmin($aSong['item_id']))
			{
				$bSkip = true;
				$mReturn = Phpfox::getService('pages')->getUrl($aSong['item_id']) . 'music/';
			}
		}
		
		if ($bSkip || (($aSong['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('music.can_delete_own_track')) || Phpfox::getUserParam('music.can_delete_other_tracks')))
		{		
			// Update user space usage
			if(Phpfox::getParam('core.allow_cdn') && $aSong['server_id'] > 0)
			{
				// Get the file size stored when the photo was uploaded
				$sTempUrl = Phpfox::getLib('cdn')->getUrl(Phpfox::getParam('music.url') . sprintf($aSong['song_path'], ''));
				
				$aHeaders = get_headers($sTempUrl, true);
				if(preg_match('/200 OK/i', $aHeaders[0]))
				{
					Phpfox::getService('user.space')->update($aSong['user_id'], 'music', (int) $aHeaders["Content-Length"], '-');
				}
			}
			else
			{
				Phpfox::getService('user.space')->update($aSong['user_id'], 'music', filesize(Phpfox::getParam('music.dir') . sprintf($aSong['song_path'], '')), '-');	
			}
			
			(($sPlugin = Phpfox_Plugin::get('music.service_process_delete__1')) ? eval($sPlugin) : false);
			
			Phpfox::getLib('file')->unlink(Phpfox::getParam('music.dir') . sprintf($aSong['song_path'], ''));
			
			$this->database()->delete($this->_sTable, 'song_id = ' . $aSong['song_id']);
			$this->database()->delete(Phpfox::getT('music_song_rating'), 'item_id = ' . $aSong['song_id']);
			if ($aSong['album_id'] > 0)
			{
				$this->database()->updateCounter('music_album', 'total_track', 'album_id', $aSong['album_id'], true);
			}
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('music_song', $iId) : null);
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('music_album', $iId) : null);
			
			(($sPlugin = Phpfox_Plugin::get('music.service_process_delete__2')) ? eval($sPlugin) : false);
			
			Phpfox::getService('user.activity')->update($aSong['user_id'], 'music_song', '-');
		}

		if (isset($aSong['is_sponsor']) && $aSong['is_sponsor'] == 1)
		{
			$this->cache()->remove('music_song_sponsored');
		}
		
		return $mReturn;
	}
	
	public function convertMember($aVals, $aCustomFields)
	{	
		$this->database()->update(Phpfox::getT('user'), array(
			'user_group_id' => Phpfox::getParam('music.music_user_group_id'),
			'full_name' => Phpfox::getLib('parse.input')->clean($aVals['full_name'], 255)
		), 'user_id = ' . Phpfox::getUserId());
		
		Phpfox::getService('custom.process')->updateFields(Phpfox::getUserId(), Phpfox::getUserId(), $aCustomFields);
				
		return true;
	}
	
	public function update($iId, $aVals)
	{
		$aSong = $this->database()->select('song_id, user_id, album_id')
			->from($this->_sTable)
			->where('song_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aSong['song_id']))
		{
			return false;	
		}		
		
		if ((isset($aVals['album_id']) && $aVals['album_id'] > 0) || $aSong['album_id'])
		{
			$aAlbum = $this->database()->select('*')
				->from(Phpfox::getT('music_album'))
				->where('album_id = ' . (int) (isset($aVals['album_id']) ? $aVals['album_id'] : $aSong['album_id']))
				->execute('getSlaveRow');
			
			if (isset($aAlbum['album_id']))
			{
				$aVals['album_id'] = $aAlbum['album_id'];
				$aVals['privacy'] = $aAlbum['privacy'];	
				$aVals['privacy_comment'] = $aAlbum['privacy_comment'];
			}
		}
		
		$aUpdate = array(					
			'album_id' => (isset($aVals['album_id']) ? (int) $aVals['album_id'] : 0),
			'genre_id' => (isset($aVals['genre_id']) ? (int) $aVals['genre_id'] : '0'),
			'title' => Phpfox::getLib('parse.input')->clean($aVals['title'], 255)
		);		
		
		if (empty($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		if (empty($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}		
		
		$aUpdate['privacy'] = (isset($aVals['privacy']) ? $aVals['privacy'] : '0');
		$aUpdate['privacy_comment'] = (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0');

		// Decrease the count for the old album
		$this->database()->updateCounter('music_album', 'total_track', 'album_id', $aSong['album_id'], true);		
		
		$this->database()->update($this->_sTable, $aUpdate, 'song_id = ' . (int) $iId);

		if (isset($aVals['album_id']))
		{
			// Decrease the count for the old album
			$this->database()->updateCounter('music_album', 'total_track', 'album_id', $aVals['album_id'], false);
		}
		
		if (Phpfox::isModule('privacy'))
		{
			if ($aVals['privacy'] == '4')
			{
				Phpfox::getService('privacy.process')->update('music_song', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));
			}
			else 
			{
				Phpfox::getService('privacy.process')->delete('music_song', $iId);
			}				
		}
		/*
		if (isset($aAlbum['album_id']))
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('music_album', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0), 0, $aSong['user_id']) : null);
		}
		else 
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('music_song', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0), 0, $aSong['user_id']) : null);
		}
		*/
		(($sPlugin = Phpfox_Plugin::get('music.service_process_update__1')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function play($iId)
	{	
		$aSong = $this->database()->select('song_id, album_id')
			->from($this->_sTable)
			->where('song_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aSong['song_id']))
		{
			return false;	
		}
		
		$this->database()->updateCounter('music_song', 'total_play', 'song_id', $aSong['song_id']);
		
		if ($aSong['album_id'])
		{
			$this->database()->updateCounter('music_album', 'total_play', 'album_id', $aSong['album_id']);
		}
	}
	
	public function addForProfile($iId, $iType)
	{
		Phpfox::isUser(true);
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('music_profile'))
			->where('user_id = ' . Phpfox::getUserId())
			->execute('getField');
			
		if ($iCnt >= Phpfox::getUserParam('music.total_song_on_profile'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('music.you_have_reached_your_limit_max_songs_allowed_total', array('total' => Phpfox::getUserParam('music.total_song_on_profile'))));
		}
		
		$this->database()->delete(Phpfox::getT('music_profile'), 'song_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
		
		if ($iType)
		{
			$this->database()->insert(Phpfox::getT('music_profile'), array(
					'song_id' => (int) $iId,
					'user_id' => Phpfox::getUserId()
				)
			);
			
			$this->database()->updateCounter('user_field', 'total_profile_song', 'user_id', Phpfox::getUserId());
		}	
		else 
		{
			$this->database()->updateCounter('user_field', 'total_profile_song', 'user_id', Phpfox::getUserId(), true);
		}
		
		return true;
	}
	
	public function feature($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('music.can_feature_songs', true);
		
		$this->database()->update($this->_sTable, array('is_featured' => ($iType ? '1' : '0')), 'song_id = ' . (int) $iId);
		
		$this->cache()->remove('music_song_featured');
		
		return true;
	}	

	public function sponsorSong($iId, $iType)
	{
	    if (!Phpfox::getUserParam('music.can_sponsor_song') && !Phpfox::getUserParam('music.can_purchase_sponsor_song') && !defined('PHPFOX_API_CALLBACK'))
	    {
		return Phpfox_Error::set('Hack attempt?');
	    }
	    $iType = (int)$iType;

	    if ($iType != 1 && $iType != 0)
	    {
		return false;
	    }
	    $this->database()->update($this->_sTable, array('is_featured' => 0, 'is_sponsor' => $iType),
		    'song_id = ' . (int)$iId);

	    $this->cache()->remove('music_song_sponsored');
	    if ($sPlugin = Phpfox_Plugin::get('music.service_process_sponsorsong__end')){return eval($sPlugin);}
	    return true;
	}

	public function sponsorAlbum($iId, $iType)
	{
	    if (!Phpfox::getUserParam('music.can_sponsor_album') && !Phpfox::getUserParam('music.can_purchase_sponsor_album') && !defined('PHPFOX_API_CALLBACK'))
	    {
		return Phpfox_Error::set('Hack attempt?');
	    }
	    $iType = (int)$iType;

	    if ($iType != 1 && $iType != 0)
	    {
		return false;
	    }
	    $this->database()->update(Phpfox::getT('music_album'), array('is_featured' => 0, 'is_sponsor' => $iType),
		    'album_id = ' . (int)$iId);

	    $this->cache()->remove('music_album_sponsored');
	    if ($sPlugin = Phpfox_Plugin::get('music.service_process_sponsoralbum__end')){return eval($sPlugin);}
	    return true;
	}
	
	public function approve($iId)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('music.can_approve_songs', true);
		
		$aSong = $this->database()->select('v.*, ma.privacy AS album_privacy, ma.privacy_comment AS album_privacy_comment, ' . Phpfox::getUserField())
			->from($this->_sTable, 'v')
			->leftJoin(Phpfox::getT('music_album'), 'ma', 'ma.album_id = v.album_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = v.user_id')
			->where('v.song_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aSong['song_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('music.unable_to_find_the_song_you_want_to_approve'));
		}
		
		$this->database()->update($this->_sTable, array('view_id' => '0', 'time_stamp' => PHPFOX_TIME), 'song_id = ' . $aSong['song_id']);
		
		if (Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->add('music_songapproved', $aSong['song_id'], $aSong['user_id']);
		}
		
		$bAddFeed = true;
		(($sPlugin = Phpfox_Plugin::get('music.service_process_approve__1')) ? eval($sPlugin) : false);
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->permalink('music', $aSong['song_id'], $aSong['title']);
		Phpfox::getLib('mail')->to($aSong['user_id'])
			->subject(array('music.your_song_title_has_been_approved_on_site_title', array('title' => $aSong['title'], 'site_title' => Phpfox::getParam('core.site_title'))))
			->message(array('music.your_song_title_has_been_approved_on_site_title_to_view_this_song', array('title' => $aSong['title'], 'site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
			->notification('music.song_is_approved')
			->send();				

		if ($aSong['album_id'])
		{			
			$this->database()->updateCounter('music_album', 'total_track', 'album_id', $aSong['album_id']);
			
			(Phpfox::isModule('feed') && $bAddFeed ? Phpfox::getService('feed.process')->add('music_album', $aSong['song_id'], $aSong['album_privacy'], (isset($aSong['album_privacy_comment']) ? (int) $aSong['album_privacy_comment'] : 0), 0, $aSong['user_id']) : null);
		}
		else 
		{
			(Phpfox::isModule('feed') && $bAddFeed ? Phpfox::getService('feed.process')->add('music_song', $aSong['song_id'], $aSong['privacy'], (isset($aSong['privacy_comment']) ? (int) $aSong['privacy_comment'] : 0), 0, $aSong['user_id']) : null);
		}		
			
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
		if ($sPlugin = Phpfox_Plugin::get('music.service_process__call'))
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
