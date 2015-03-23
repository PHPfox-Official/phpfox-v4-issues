<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * INSERTS, UPDATES & DELETES photo albums.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: process.class.php 4770 2012-09-26 07:59:38Z Raymond_Benc $
 */
class Photo_Service_Album_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo_album');
	}
	
	/**
	 * Add a new photo album.
	 *
	 * @param int $iUserId User ID.
	 * @param array $aVals $_POST data array.
	 * @param boolean $bIsUpdate True for INSERT, false for UPDATE.
	 * 
	 * @return int ID of the item we inserted/updated.
	 */
	public function add($aVals, $bIsUpdate = false)
	{		
		// Get the parser object.
		$oParseInput = Phpfox::getLib('parse.input');
		
		// Create the fields to insert
		$aFields = array(
			'name',					
			'privacy' => 'int',
			'privacy_comment' => 'int'	
		);
		
		// Create the fields to insert
		$aFieldsInfo = array(
			'description'		
		);					

		Phpfox::getService('ban')->checkAutomaticBan($aVals['name'] . ' ' . $aVals['description']);
		// Clean album name
		$aVals['name'] = $oParseInput->clean($aVals['name'], 255);		
		
		// Prepare description.
		if (!empty($aVals['description']))
		{
			$aVals['description'] = $oParseInput->clean($aVals['description'], 255);
		}			
		
		if ($bIsUpdate)
		{
			$aAlbum = $this->database()->select('user_id')
				->from(Phpfox::getT('photo_album'))
				->where('album_id = ' . (int) $aVals['album_id'])
				->execute('getSlaveRow');
			
			// Insert the data into the database.
			$this->database()->process($aFields, $aVals)->update($this->_sTable, 'album_id = ' . $aVals['album_id']);			
						
			// Insert album info.			
			$this->database()->process($aFieldsInfo, $aVals)->update(Phpfox::getT('photo_album_info'), 'album_id = ' . $aVals['album_id']);	
			
			$iId = $aVals['album_id'];	
			
			$this->setPrivacy($iId, $aVals['privacy'], $aVals['privacy_comment']);
			
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('photo_album', $iId, $aVals['privacy'], $aVals['privacy_comment'], 0, $aAlbum['user_id']) : null);
			
			if (Phpfox::isModule('privacy'))
			{
				if (isset($aVals['privacy']) && $aVals['privacy'] == '4')
				{
					Phpfox::getService('privacy.process')->update('photo_album', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));
				}
				else 
				{
					Phpfox::getService('privacy.process')->delete('photo_album', $iId);
				}			
			}
		}
		else 
		{
			$aFields[] = 'module_id';
			$aFields['group_id'] = 'int';
			$aFields['user_id'] = 'int';
			$aFields[] = 'time_stamp';
			
			// Add the users ID to the fields array
			$aVals['user_id'] = Phpfox::getUserId();			
			
			// Add a time_stamp
			$aVals['time_stamp'] = PHPFOX_TIME;			
			
			// Insert the data into the database.
			$iId = $this->database()->process($aFields, $aVals)->insert($this->_sTable);
			
			$aFieldsInfo['album_id'] = 'int';
			
			$aVals['album_id'] = $iId;			
			
			// Insert album info.			
			$this->database()->process($aFieldsInfo, $aVals)->insert(Phpfox::getT('photo_album_info'));
			
			if (Phpfox::isModule('privacy'))
			{
				if (isset($aVals['privacy']) && $aVals['privacy'] == '4')
				{
					Phpfox::getService('privacy.process')->add('photo_album', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
				}
			}
		}
		
		return $iId;	
	}
	
	public function delete($iAlbumId)
	{
		$aAlbum = $this->database()->select('album_id, user_id')
			->from($this->_sTable)
			->where('album_id = ' . (int) $iAlbumId)
			->execute('getRow');
			
		if (!isset($aAlbum['album_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('photo.not_a_valid_photo_album_to_delete'));
		}
			
		if (!Phpfox::getService('user.auth')->hasAccess('photo_album', 'album_id', $iAlbumId, 'photo.can_delete_own_photo_album', 'photo.can_delete_other_photo_albums', $aAlbum['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('photo.you_do_not_have_sufficient_permission_to_delete_this_photo_album'));
		}			
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('photo_album', $aAlbum['album_id']) : null);
		
		$aPhotos = $this->database()->select('photo_id')
			->from(Phpfox::getT('photo'))
			->where('album_id = ' . $aAlbum['album_id'])
			->execute('getRows');
			
		foreach ($aPhotos as $aPhoto)
		{
			Phpfox::getService('photo.process')->delete($aPhoto['photo_id']);
		}
		
		(($sPlugin = Phpfox_Plugin::get('photo.service_album_process_delete__1')) ? eval($sPlugin) : false);
		
		$this->database()->delete($this->_sTable, 'album_id = ' . $aAlbum['album_id']);
		$this->database()->delete(Phpfox::getT('photo_album_info'), 'album_id = ' . $aAlbum['album_id']);
		
		return true;
	}
	
	public function update($iAlbumId, $aVals)
	{
		$aVals['album_id'] = $iAlbumId;
		
		return $this->add($aVals, true);
	}
	
	public function setPrivacy($iAlbumId, $iPrivacy = null, $iPrivacyComment = null)
	{
		if ($iPrivacy === null)
		{
			$aAlbum = $this->database()->select('privacy, privacy_comment')
				->from($this->_sTable)
				->where('album_id = ' . (int) $iAlbumId)
				->execute('getSlaveRow');
				
			$iPrivacy = $aAlbum['privacy'];
			$iPrivacyComment = $aAlbum['privacy_comment'];
		}
		
		$this->database()->update(Phpfox::getT('photo'), array('privacy' => (int) $iPrivacy, 'privacy_comment' => (int) $iPrivacyComment), 'album_id = ' . (int) $iAlbumId);
		
		if ($iPrivacy == '4')
		{
			$aList = array();
			$aPrivacyLists = $this->database()->select('*')
				->from(Phpfox::getT('privacy'))
				->where('module_id = \'photo_album\' AND item_id = ' . (int) $iAlbumId)
				->execute('getSlaveRows');

			foreach ($aPrivacyLists as $aPrivacyList)
			{
				$aList[] = $aPrivacyList['friend_list_id'];
			}
		}
		
		$aPhotos = $this->database()->select('photo_id')
			->from(Phpfox::getT('photo'))
			->where('album_id = ' . (int) $iAlbumId)
			->execute('getSlaveRows');
		foreach ($aPhotos as $aPhoto)
		{
			if (Phpfox::isModule('feed'))
			{
				Phpfox::getService('feed.process')->update('photo', $aPhoto['photo_id'], $iPrivacy, $iPrivacyComment);
			}
			if (Phpfox::isModule('privacy'))
			{
				if ($iPrivacy == '4')
				{
					Phpfox::getService('privacy.process')->update('photo', $aPhoto['photo_id'], $aList);
				}
				else 
				{
					Phpfox::getService('privacy.process')->delete('photo', $aPhoto['photo_id']);
				}			
			}
		}

		return true;
	}
	
	public function hasCover($iAlbumId)
	{
		return $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('photo'))
			->where('album_id = ' . (int) $iAlbumId . ' AND is_cover = 1')
			->execute('getField');
	}
	
	public function setCover($iAlbumId, $iPhotoId)
	{
		$this->database()->update(Phpfox::getT('photo'), array('is_cover' => 0), 'album_id = ' . (int) $iAlbumId);
		$this->database()->update(Phpfox::getT('photo'), array('is_cover' => 1), 'photo_id = ' . (int) $iPhotoId);
		
		return true;
	}
	
	/**
	 * Update the album counters.
	 *
	 * @param int $iId ID# of the album
	 * @param string $sCounter Field we plan to update
	 * @param boolean $bMinus True increases to the count and false decreases the count
	 * @param mixed $sValue Pass a null to use 1 or pass an int value to define how many should we plus/minus
	 */
	public function updateCounter($iId, $sCounter, $bMinus = false, $sValue = null)
	{		
		$iTotal = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('photo'))
			->where('album_id = ' . (int) $iId . ' AND view_id = 0')
			->execute('getField');
		
		$this->database()->update($this->_sTable, array($sCounter => $iTotal), 'album_id = ' . (int) $iId);
	}

	public function updateTitle($iAlbumId, $sTitle)
	{
		Phpfox::getService('ban')->checkAutomaticBan($sTitle);
		$this->database()->update($this->_sTable, array('name' => Phpfox::getLib('parse.input')->clean($sTitle, 255)), 'album_id = ' . (int) $iAlbumId);
		
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_album_process__call'))
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