<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Controls photo albums.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: album.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Photo_Service_Album_Album extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo_album');	
	}
	
	/**
	 * Get all albums based on filters we passed via the params.
	 *
	 * @param array $mConditions SQL Conditions
	 * @param string $sOrder SQL Ordering
	 * @param int $iPage Current page we are on
	 * @param int $iPageSize Define how many photos we can display at one time
	 * 
	 * @return array Return an array of the total album count and the albums
	 */
	public function get($mConditions = array(), $sOrder = 'pa.time_stamp DESC', $iPage = '', $iPageSize = '')
	{		
		$aAlbums = array();
		
		(($sPlugin = Phpfox_Plugin::get('photo.service_album_album_get_count')) ? eval($sPlugin) : false);
		
		$iCnt = $this->database()->select('COUNT(DISTINCT pa.name)')
			->from($this->_sTable, 'pa')
			->leftJoin(Phpfox::getT('photo'), 'p', 'p.album_id = pa.album_id')
			->where($mConditions)
			->execute('getSlaveField');
		
		if ($iCnt)
		{
			(($sPlugin = Phpfox_Plugin::get('photo.service_album_album_get_query')) ? eval($sPlugin) : false);
			
			$aAlbums = $this->database()->select('pa.*, p.destination, p.server_id, p.mature, ' . Phpfox::getUserField())
				->from($this->_sTable, 'pa')
				->leftJoin(Phpfox::getT('photo'), 'p', 'p.album_id = pa.album_id AND pa.view_id = 0 AND p.is_cover = 1')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = pa.user_id')
				->where($mConditions)
				->order($sOrder)
				->limit($iPage, $iPageSize, $iCnt)
				->group('pa.name')
				->execute('getSlaveRows');	
		}		

		return array($iCnt, $aAlbums);
	}	
	
	/**
	 * Get all the albums for a specific user.
	 *
	 * @param int $iUserId User ID.
	 * 
	 * @return array Return the array of albums.
	 */
	public function getAll($iUserId, $sModule = false, $iItem = false)
	{
		(($sPlugin = Phpfox_Plugin::get('photo.service_album_album_getall')) ? eval($sPlugin) : false);

		return $this->database()->select('album_id, name, profile_id')
			->from($this->_sTable)
			->where(($sModule === false ? '' : 'module_id = \'' . $this->database()->escape($sModule) . '\' AND group_id = ' . (int) $iItem . ' AND ') . 'user_id = ' . (int) $iUserId)
			->group('name')
			->execute('getSlaveRows');
	}
	
	/**
	 * Get the total count of albums for a specific user.
	 *
	 * @param int $iUserId User ID.
	 * 
	 * @return int Return the total number of albums.
	 */
	public function getAlbumCount($iUserId)
	{
		(($sPlugin = Phpfox_Plugin::get('photo.service_album_album_getalbumcount')) ? eval($sPlugin) : false);
		
		return $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('view_id = 0 AND group_id = 0 AND user_id = ' . (int) $iUserId)
			->execute('getField');		
	}
	
	/**
	 * Get a specific album based on the user ID and album ID or album title.
	 *
	 * @param int $iUserId User ID this album belongs to
	 * @param mixed $mId Album ID or Album title
	 * @param boolean $bUseId True to use an album ID call or else it is an album title
	 *
	 * @return array Array of the album
	 */
	public function getAlbum($iUserId, $mId, $bUseId = false)
	{
		(($sPlugin = Phpfox_Plugin::get('photo.service_album_album_getalbum')) ? eval($sPlugin) : false);
		
		return $this->database()->select('pa.*, pai.*')
			->from($this->_sTable, 'pa')
			->join(Phpfox::getT('photo_album_info'), 'pai', 'pai.album_id = pa.album_id')
			->where('pa.user_id = ' . (int) $iUserId . ' AND ' . ($bUseId === true ? 'pa.album_id = ' . (int) $mId : 'pa.name_url = \'' . $this->database()->escape($mId) . '\''))
			->execute('getSlaveRow');
	}
	
	public function getForView($iId, $bIsProfile = false)
	{
		if (Phpfox::isModule('friend'))
		{
			$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = pa.user_id AND f.friend_user_id = " . Phpfox::getUserId());					
		}		
		
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'photo_album\' AND l.item_id = pa.album_id AND l.user_id = ' . Phpfox::getUserId());
		}		
		
		$aAlbum = $this->database()->select('pa.*, pai.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'pa')
			->join(Phpfox::getT('photo_album_info'), 'pai', 'pai.album_id = pa.album_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = pa.user_id')
			->where(($bIsProfile ? 'pa.profile_id = ' . (int) $iId : 'pa.album_id = ' . (int) $iId))
			->execute('getSlaveRow');
			
		if (!isset($aAlbum['album_id']))
		{
			return false;
		}
		
		if (!isset($aAlbum['is_friend']))
		{
			$aAlbum['is_friend'] = $aAlbum['privacy'] == 0;
		}
		if (!isset($aAlbum['is_liked']))
		{
			$aAlbum['is_liked'] = false;
		}
		return $aAlbum;
	}
	
	public function getForProfileView($iProfileId, $bForceCreation = false)
	{
		$aAlbum = $this->getForView($iProfileId, true);
		
		if (!isset($aAlbum['album_id']) || $bForceCreation === true)
		{
			$aUser = $this->database()->select(Phpfox::getUserField())
				->from(Phpfox::getT('user'), 'u')
				->where('u.user_id = ' . (int) $iProfileId)
				->execute('getSlaveRow');
		
			if (!isset($aUser['user_id']))
			{
				return false;
			}	
			
			if (!isset($aAlbum['album_id']))
			{
				$iId = $this->database()->insert(Phpfox::getT('photo_album'), array(
						'privacy' => '0',
						'privacy_comment' => '0',
						'user_id' => $aUser['user_id'],
						'name' => "{phrase var='photo.profile_pictures'}",//'Profile Pictures',
						'time_stamp' => PHPFOX_TIME,
						'profile_id' => $aUser['user_id']						
					)
				);

				$this->database()->insert(Phpfox::getT('photo_album_info'), array('album_id' => $iId));			
			}
			else
			{
				$iId = $aAlbum['album_id'];
			}
			
			if (!empty($aUser['user_image']) && file_exists(Phpfox::getParam('core.dir_user') . sprintf($aUser['user_image'], '')))
			{
				$aImage = getimagesize(Phpfox::getParam('core.dir_user') . sprintf($aUser['user_image'], ''));
				$iFileSize = filesize(Phpfox::getParam('core.dir_user') . sprintf($aUser['user_image'], ''));
				
				$aInsert = array(
						'album_id' => $iId,
						'title' => date('F j, Y'),
						'user_id' => $aUser['user_id'],
						'server_id' => $aUser['user_server_id'], 
						'time_stamp' => PHPFOX_TIME,
						'is_cover' => '1',
						'is_profile_photo' => '1'
					);
				if (defined('PHPFOX_FORCE_PHOTO_VERIFY_EMAIL'))
				{
					$aInsert['view_id'] = 3;
				}
				$this->database()->update(Phpfox::getT('photo'), array('is_cover' => '0'), 'album_id = ' . (int) $iId);
				$iPhotoInsert = $this->database()->insert(Phpfox::getT('photo'), $aInsert);
				
				$sFilename = strtolower(sprintf($aUser['user_image'], ''));
				$aExts = preg_split("/[\/\\.]/", sprintf($aUser['user_image'], ''));
				$iCnt = count($aExts)-1;
				$sExt = strtolower($aExts[$iCnt]);

				$this->database()->insert(Phpfox::getT('photo_info'), array(
						'photo_id' => $iPhotoInsert,
						'file_name' => sprintf($aUser['user_image'], ''),
						'mime_type' => $aImage['mime'],
						'extension' => $sExt,
						'width' => $aImage[0],
						'height' => $aImage[1],
						'file_size' => $iFileSize
					)
				);				
				
				$sFileName = md5($iPhotoInsert) . '%s.' . $sExt;
				
				$this->database()->update(Phpfox::getT('photo'), array('destination' => $sFileName), 'photo_id = ' . (int) $iPhotoInsert);
				
				copy(Phpfox::getParam('core.dir_user') . sprintf($aUser['user_image'], ''), Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''));
				
				$oImage = Phpfox::getLib('image');
				foreach(Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
				{
					// Create the thumbnail
					if ($oImage->createThumbnail(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''), Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize, true, ((Phpfox::getParam('photo.enabled_watermark_on_photos') && Phpfox::getParam('core.watermark_option') != 'none') ? (Phpfox::getParam('core.watermark_option') == 'image' ? 'force_skip' : true) : false)) === false)
					{		
					    continue;
					}
					
					if (Phpfox::getParam('photo.enabled_watermark_on_photos'))
					{
					    $oImage->addMark(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize));
					}
				}
		
				if (Phpfox::getParam('photo.enabled_watermark_on_photos'))
				{
					$oImage->addMark(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''));
				}
				
				Phpfox::getService('user.activity')->update($aUser['user_id'], 'photo');
			}
			
			$aAlbum = $this->getForView($iProfileId, true);
		}
		
		if($bForceCreation)
		{
			$aAlbum['photo_id'] = $iPhotoInsert;
		}
		return $aAlbum;
	}
	
	public function getForEdit($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('photo.service_album_album_getforedit')) ? eval($sPlugin) : false);
		
		$aAlbum = $this->database()->select('pa.*, pai.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'pa')
			->join(Phpfox::getT('photo_album_info'), 'pai', 'pai.album_id = pa.album_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = pa.user_id')
			->where('pa.album_id = ' . (int) $iId)
			->execute('getSlaveRow');

		if (!isset($aAlbum['album_id']))
		{
			return false;
		}
			
		if ((Phpfox::getUserId() == $aAlbum['user_id'] && Phpfox::getUserParam('photo.can_edit_own_photo_album')) || Phpfox::getUserParam('photo.can_edit_other_photo_albums'))
		{
			return $aAlbum;
		}
			
		return false;
	}

	public function inThisAlbum($iAlbumId)
	{
		$aRows = $this->database()->select('SQL_CALC_FOUND_ROWS ' . Phpfox::getUserField())
			->from(Phpfox::getT('photo_tag'), 'pt')
			->innerJoin(Phpfox::getT('photo'), 'p', 'p.album_id = ' . (int) $iAlbumId)
			->join(Phpfox::getT('user'), 'u', 'u.user_id = pt.tag_user_id')
			->where('pt.photo_id = p.photo_id')
			->group('u.user_id')
			->limit(7)
			->execute('getSlaveRows');

		$iCnt = $this->database()->getField('SELECT FOUND_ROWS()');
				
		return array($iCnt, $aRows);
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_album__call'))
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
