<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Photo process class. Used to INSERT, UPDATE & DELETE photos.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: process.class.php 7286 2014-04-28 14:58:07Z Fern $
 */
class Photo_Service_Process extends Phpfox_Service
{
    /**
     * Class constructor
     */
    public function __construct()
    {
		$this->_sTable = Phpfox::getT('photo');
    }

	public function makeProfilePicture($iId)
	{
		/* 1.Verify that $iId belongs to Phpfox::getUserId() */
		$aPhoto = $this->database()->select('p.destination, p.title, p.user_id, p.server_id')
			->from(Phpfox::getT('photo'), 'p')
			->where('p.user_id = ' . Phpfox::getUserId() . ' AND photo_id = ' . (int)$iId)
			->execute('getSlaveRow');
		
		if (empty($aPhoto) || !isset($aPhoto['destination']))
		{
			return false;
		}
		
		// A file path should not have curly brackets
		$aPhoto['destination'] = str_replace(array('{', '}'), '', $aPhoto['destination']);
		/* 2.copy the picture to <the folder that I need to find out> */
		$sTempName = PHPFOX_DIR_FILE .'pic' . PHPFOX_DS . 'photo' . PHPFOX_DS . sprintf($aPhoto['destination'],'');
		if (!file_exists($sTempName))
		{
			$sTempName = PHPFOX_DIR_FILE .'pic' . PHPFOX_DS . 'photo' . PHPFOX_DS . sprintf($aPhoto['destination'], '_500');
		}
		
		if (!file_exists($sTempName) && Phpfox::getParam('core.allow_cdn'))
		{
			$sTempName = Phpfox::getLib('cdn')->getUrl(str_replace(PHPFOX_DIR, '', $sTempName));
		}		
		
		define('PHPFOX_USER_PHOTO_IS_COPY', true);
		
		$aRet = Phpfox::getService('user.process')->uploadImage(Phpfox::getUserId(), true, $sTempName, false, $iId);
		
		return (isset($aRet['user_image']) && !empty($aRet['user_image']));
	}
	
    /**
     * Adding a new photo.
     *
     * @param int $iUserId User ID of the user that the photo belongs to.
     * @param array $aVals Array of the post data being passed to insert.
     * @param boolean $bIsUpdate True if we plan to update the entry or false to insert a new entry in the database.
     * @param boolean $bAllowTitleUrl Set to true to allow the editing of the SEO url.
     *
     * @return int ID of the newly added photo or the ID of the current photo we are editing.
     */
    public function add($iUserId, $aVals, $bIsUpdate = false, $bAllowTitleUrl = false)
    {
		$oParseInput = Phpfox::getLib('parse.input');
	
		// Create the fields to insert.
		$aFields = array();

		// Make sure we are updating the album ID
		(!empty($aVals['album_id']) ? $aFields['album_id'] = 'int' : null);
	
		// Is this an update?
		if ($bIsUpdate)
		{
		    // Make sure we only update the fields that the user is allowed to
		    (Phpfox::getUserParam('photo.can_add_mature_images') ? $aFields['mature'] = 'int' : null);
		    (Phpfox::getUserParam('photo.can_control_comments_on_photos') ? $aFields['allow_comment'] = 'int' : null);
		    ((Phpfox::getUserParam('photo.can_add_to_rating_module') && Phpfox::getParam('photo.can_rate_on_photos')) ? $aFields['allow_rate'] = 'int' : null);
		    (!empty($aVals['destination']) ? $aFields[] = 'destination' : null);
		    $aFields['allow_download'] = 'int';
		    $aFields['server_id'] = 'int';
	
		    // Check if we really need to update the title
		    if (!empty($aVals['title']))
		    {
				$aFields[] = 'title';

				// http://www.phpfox.com/tracker/view/14353/
				$bWindows = false;
				if (stristr(PHP_OS, "win"))
				{
					$bWindows = true;
				}
				else
				{
					$aVals['original_title'] = $aVals['title'];
				}
				
				// Clean the title for any sneaky attacks
				$aVals['title'] = $oParseInput->clean($aVals['title'], 255);
				
				if (Phpfox::getParam('photo.rename_uploaded_photo_names'))
				{
				    $aFields[] = 'destination';
		
				    $aPhoto = $this->database()->select('destination')
					    ->from($this->_sTable)
					    ->where('photo_id = ' . $aVals['photo_id'])
					    ->execute('getRow');
		
				    $sNewName = preg_replace("/^(.*?)-(.*?)%(.*?)$/", "$1-" . str_replace('%', '', ($bWindows ? $aVals['title'] : $aVals['original_title'])) . "%$3", $aPhoto['destination']);
				    $sNewName = preg_replace('/&#/i', 'u', $oParseInput->convert($sNewName));
		
				    $aVals['destination'] = $sNewName;
		
					if(file_exists(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], '')))
					{
						Phpfox::getLib('file')->rename(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], ''), Phpfox::getParam('photo.dir_photo') . sprintf($sNewName, ''));
					}
					
				    // Create thumbnails with different sizes depending on the global param.
				    foreach(Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
				    {
						Phpfox::getLib('file')->rename(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], '_' . $iSize), Phpfox::getParam('photo.dir_photo') . sprintf($sNewName, '_' . $iSize));
				    }
				}				
		    }
		    
		    $iAlbumId = (int) (empty($aVals['move_to']) ? (isset($aVals['album_id']) ? $aVals['album_id'] : 0) : $aVals['move_to']);
		    if (!empty($aVals['set_album_cover']))
		    {
		    	$aFields['is_cover'] = 'int';	
		    	$aVals['is_cover'] = '1';		
		    	
		    	$this->database()->update(Phpfox::getT('photo'), array('is_cover' => '0'), 'album_id = ' . (int) $iAlbumId);    
		    }
		    
		    if (!empty($aVals['move_to']))
		    {
		    	$aFields['album_id'] = 'int';
		    	$iOldAlbumId = $aVals['album_id'];
		    	$aVals['album_id'] = (int) $aVals['move_to'];
		    }
		    
		    if (isset($aVals['privacy']))
		    {
		    	$aFields['privacy'] = 'int';	
		    	$aFields['privacy_comment'] = 'int';	
		    }
		    
		    // Update the data into the database.
		    $this->database()->process($aFields, $aVals)->update($this->_sTable, 'photo_id = ' . (int) $aVals['photo_id']);
	
		    // Check if we need to update the description of the photo
				$aFieldsInfo = array(
					'description'
				);
		
				// Clean the data before we add it into the database
				$aVals['description'] = (empty($aVals['description']) ? null : $this->preParse()->prepare($aVals['description']));
	
		    (!empty($aVals['width']) ? $aFieldsInfo[] = 'width' : 0);
		    (!empty($aVals['height']) ? $aFieldsInfo[] = 'height' : 0);
	
		    // Check if we have anything to add into the photo_info table
		    if (isset($aFieldsInfo))
		    {
				$this->database()->process($aFieldsInfo, $aVals)->update(Phpfox::getT('photo_info'), 'photo_id = ' . (int) $aVals['photo_id']);
		    }
	
		    // Add tags for the photo
			if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support') && Phpfox::getUserParam('photo.can_add_tags_on_photos') && !empty($aVals['description']))
			{
				Phpfox::getService('tag.process')->update('photo', $aVals['photo_id'], $iUserId, $aVals['description'], true);
			}
			else
			{
				if (Phpfox::isModule('tag') && isset($aVals['tag_list']) && !empty($aVals['tag_list']) && Phpfox::getUserParam('photo.can_add_tags_on_photos'))
				{
					Phpfox::getService('tag.process')->update('photo', $aVals['photo_id'], $iUserId, $aVals['tag_list']);
				}
			}

		    // Make sure if we plan to add categories for this image that there is something to add
		    if (isset($aVals['category_id']) && count($aVals['category_id']))
		    {
				if (!is_array($aVals['category_id']))
				{
					$aVals['category_id'] = array($aVals['category_id']);
				}
				// Loop through all the categories
		    	$this->database()->delete(Phpfox::getT('photo_category_data'), 'photo_id = ' . (int) $aVals['photo_id']);
				
				foreach ($aVals['category_id'] as $iCategory)
				{
				    // Add each of the categories					
				    Phpfox::getService('photo.category.process')->updateForItem($aVals['photo_id'], $iCategory);
				}
		    }
			
		    $iId = $aVals['photo_id'];
		    
		    if (Phpfox::isModule('privacy') && isset($aVals['privacy']))
		    {
				if ($aVals['privacy'] == '4')
				{
					Phpfox::getService('privacy.process')->update('photo', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));
				}
				else 
				{
					Phpfox::getService('privacy.process')->delete('photo', $iId);
				}	
		    }
			
			if(!empty($iAlbumId))
			{
				$aAlbum = Phpfox::getService('photo.album')->getAlbum($iUserId, $iAlbumId, true);
				if(!empty($aAlbum['privacy']))
				{
					$aVals['privacy'] = $aAlbum['privacy'];
				}
				
				if(!empty($aAlbum['privacy_comment']))
				{
					$aVals['privacy_comment'] = $aAlbum['privacy_comment'];
				}
			}
			
			if (!isset($aVals['privacy']))
			{
				$aVals['privacy'] = 0;
			}
			
			if (!isset($aVals['privacy_comment']))
			{
				$aVals['privacy_comment'] = 0;
			}
			
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('photo', $iId, $aVals['privacy'], $aVals['privacy_comment'], 0, $iUserId) : null);

			if (!empty($aVals['move_to']))
			{
				Phpfox::getService('photo.album.process')->updateCounter($iOldAlbumId, 'total_photo');
				Phpfox::getService('photo.album.process')->updateCounter($aVals['move_to'], 'total_photo');		
				$aCoverPhoto = $this->database()->select('photo_id')
					->from(Phpfox::getT('photo'))
					->where('album_id = ' . $iOldAlbumId)
					->order('time_stamp DESC')
					->execute('getRow');	
				if (isset($aCoverPhoto['photo_id']))
				{
					$this->database()->update(Phpfox::getT('photo'), array('is_cover' => '1'), 'photo_id = ' . (int) $aCoverPhoto['photo_id']);
				}					
			}						
		}
		else
		{
		    if (!empty($aVals['callback_module']))
		    {
		    	$aVals['module_id'] = $aVals['callback_module'];
		    }
			
			// Define all the fields we need to enter into the database
		    $aFields['user_id'] = 'int';
		    $aFields['parent_user_id'] = 'int';
		    $aFields['type_id'] = 'int';
		    $aFields['time_stamp'] = 'int';
		    $aFields['server_id'] = 'int';
		    $aFields['view_id'] = 'int';
		    $aFields['group_id'] = 'int';
		    $aFields[] = 'module_id';
		    $aFields[] = 'title';
		    
		    if (isset($aVals['privacy']))
		    {
		    	$aFields['privacy'] = 'int';	
		    	$aFields['privacy_comment'] = 'int';	
		    }		    
	
		    // Define all the fields we need to enter into the photo_info table
		    $aFieldsInfo = array(
			    'photo_id' => 'int',
			    'file_name',
			    'mime_type',
			    'extension',
			    'file_size' => 'int',
			    'description'
		    );
	
		    // Clean and prepare the title and SEO title
			$aVals['title'] = $oParseInput->clean(rtrim(preg_replace("/^(.*?)\.(jpg|jpeg|gif|png)$/i", "$1", rawurldecode($aVals['name']))), 255);
	
		    // Add the user_id
		    $aVals['user_id'] = $iUserId;
	
		    // Add the original server ID for LB.
		    $aVals['server_id'] = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
	
		    // Add the time stamp.
		    $aVals['time_stamp'] = PHPFOX_TIME;
	
		    $aVals['view_id'] = (Phpfox::getUserParam('photo.photo_must_be_approved') ? '1' : '0');
	
		    // Insert the data into the database.
		    $iId = $this->database()->process($aFields, $aVals)->insert($this->_sTable);
	
		    // Prepare the data to enter into the photo_info table
		    $aInfo = array(
			    'photo_id' => $iId,
			    'file_name' => Phpfox::getLib('parse.input')->clean($aVals['name'], 100),
			    'extension' => strtolower($aVals['ext']),
			    'file_size' => $aVals['size'],
			    'mime_type' => $aVals['type'],
			    'description' => (empty($aVals['description']) ? null : $this->preParse()->prepare($aVals['description']))
		    );
	
		    // Insert the data into the photo_info table
		    $this->database()->process($aFieldsInfo, $aInfo)->insert(Phpfox::getT('photo_info'));
	
		    if (!Phpfox::getUserParam('photo.photo_must_be_approved'))
		    {
				// Update user activity
				Phpfox::getService('user.activity')->update($iUserId, 'photo');
		    }
			
		    // Make sure if we plan to add categories for this image that there is something to add
		    if (isset($aVals['category_id']) && count($aVals['category_id']))
		    {
				// Loop thru all the categories
				foreach ($aVals['category_id'] as $iCategory)
				{
				    // Add each of the categories
				    Phpfox::getService('photo.category.process')->updateForItem($iId, $iCategory);
				}
		    }			
		    
			if (isset($aVals['privacy']))
			{
				if ($aVals['privacy'] == '4')
				{
					Phpfox::getService('privacy.process')->add('photo', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
				}			    
			}

			if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support') && Phpfox::getUserParam('photo.can_add_tags_on_photos') && !empty($aVals['description']))
			{
				Phpfox::getService('tag.process')->add('photo', $iId, $iUserId, $aVals['description'], true);
			}
		}
	
		// Plugin call
		if ($sPlugin = Phpfox_Plugin::get('photo.service_process_add__end'))
		{
		    eval($sPlugin);
		}
	
		// Return the photo ID#
		return $iId;
    }

    /**
     * Updating a new photo. We piggy back on the add() method so we don't have to do the same code twice.
     *
     * @param int $iUserId User ID of the user that the photo belongs to.
     * @param array $aVals Array of the post data being passed to insert.
     * @param boolean $bAllowTitleUrl Set to true to allow the editing of the SEO url.
     *
     * @return int ID of the newly added photo or the ID of the current photo we are editing.
     */
    public function update($iUserId, $iId, $aVals, $bAllowTitleUrl = false)
    {
		$aVals['photo_id'] = $iId;
        if (Phpfox::getParam('feed.cache_each_feed_entry') )
        {
            $this->cache()->remove(array('feeds', 'photo_' . $iId));
        }
		return $this->add($iUserId, $aVals, true, $bAllowTitleUrl);
    }

    /**
     * Used to delete a photo.
     *
     * @param int $iId ID of the photo we want to delete.
     *
     * @return boolean We return true since if nothing fails we were able to delete the image.
     */
    public function delete($iId, $bPass = false)
    {
		// Get the image ID and full path to the image.
		$aPhoto = $this->database()->select('user_id, module_id, group_id, is_sponsor, album_id, photo_id, destination, server_id')
			->from($this->_sTable)
			->where('photo_id = ' . (int) $iId)
			->execute('getRow');
	
		if (!isset($aPhoto['user_id']))
		{
		    return false;
		}
		
		if ($aPhoto['module_id'] == 'pages' && Phpfox::getService('pages')->isAdmin($aPhoto['group_id']))
		{		
			$bPass = true;
		}
	
		if ($bPass === false && !Phpfox::getService('user.auth')->hasAccess('photo', 'photo_id', $iId, 'photo.can_delete_own_photo', 'photo.can_delete_other_photos', $aPhoto['user_id']))
		{
		    return false;
		}
	
		// Create the total file size var for all the images
		$iFileSizes = 0;
		// Make sure the original image exists
		if (!empty($aPhoto['destination']) && file_exists(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], '')))
		{
		    // Add to the file size var
		    $iFileSizes += filesize(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], ''));
	
		    // Remove the image
		    Phpfox::getLib('file')->unlink(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], ''));
		}
	
		// If CDN is in use, remove the original image, as done above
		if(Phpfox::getParam('core.allow_cdn') && $aPhoto['server_id'] > 0)
		{
			// Get the file size stored when the photo was uploaded
			$iFileSizes += $this->database()->select('file_size')
				->from(Phpfox::getT('photo_info'))
				->where('photo_id = ' . (int) $iId)
				->execute('getField');
				
			Phpfox::getLib('cdn')->remove(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], ''));
		}
	
		// Loop thru all the other smaller images
		foreach(Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
		{
		    // Make sure the image exists
		    if (!empty($aPhoto['destination']) && file_exists(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], '_' . $iSize)))
		    {
				// Add to the file size var
				$iFileSizes += filesize(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], '_' . $iSize));
		
				// Remove the image
				Phpfox::getLib('file')->unlink(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], '_' . $iSize));
		    }

		    // If CDN is in use, remove the thumbnails there too
		    if(Phpfox::getParam('core.allow_cdn') && $aPhoto['server_id'] > 0)
		    {
				// Get the file size stored when the photo was uploaded
				$sTempUrl = Phpfox::getLib('cdn')->getUrl(Phpfox::getParam('photo.url_photo') . sprintf($aPhoto['destination'], '_' . $iSize));
				
				$aHeaders = get_headers($sTempUrl, true);
				if(preg_match('/200 OK/i', $aHeaders[0]))
				{
					$iFileSizes += (int) $aHeaders["Content-Length"];
				}
				
			    Phpfox::getLib('cdn')->remove(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], '_' . $iSize));
		    }
		}
	
		// Delete this entry from the database
		$this->database()->delete($this->_sTable, 'photo_id = ' . $aPhoto['photo_id']);
		$this->database()->delete(Phpfox::getT('photo_info'), 'photo_id = ' . $aPhoto['photo_id']);
		// delete the ratings for this photo
		$this->database()->delete(Phpfox::getT('photo_rating'), 'photo_id = ' . $aPhoto['photo_id']);
		// delete the photo tags
		$this->database()->delete(Phpfox::getT('photo_tag'), 'photo_id = ' . $aPhoto['photo_id']);
		// delete the category_data
		$this->database()->delete(Phpfox::getT('photo_category_data'), 'photo_id = ' . $aPhoto['photo_id']);
		// delete the battles
		$this->database()->delete(Phpfox::getT('photo_battle'), 'photo_1 = ' . $aPhoto['photo_id'] . ' OR photo_2 = ' . $aPhoto['photo_id']);
	
		(($sPlugin = Phpfox_Plugin::get('photo.service_process_delete__1')) ? eval($sPlugin) : false);
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('photo', $iId) : null);
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('comment_photo', $iId) : null);
		(Phpfox::isModule('tag') ? Phpfox::getService('tag.process')->deleteForItem($aPhoto['user_id'], $iId, 'photo') : null);
	
		// Update user space usage
		if ($iFileSizes > 0)
		{
		    Phpfox::getService('user.space')->update($aPhoto['user_id'], 'photo', $iFileSizes, '-');
		}
	
		// Update user activity
		Phpfox::getService('user.activity')->update($aPhoto['user_id'], 'photo', '-');
	
		if ($aPhoto['album_id'] > 0)
		{
		    Phpfox::getService('photo.album.process')->updateCounter($aPhoto['album_id'], 'total_photo', true);
		}

		if ($aPhoto['is_sponsor'] == 1)
		{
			$this->cache()->remove('photo_sponsored');
		}
		return true;
    }

    /**
     * Update the photo counters.
     *
     * @param int $iId ID# of the photo
     * @param string $sCounter Field we plan to update
     * @param boolean $bMinus True increases to the count and false decreases the count
     */
    public function updateCounter($iId, $sCounter, $bMinus = false)
    {
	$this->database()->update($this->_sTable, array(
		$sCounter => array('= ' . $sCounter . ' ' . ($bMinus ? '-' : '+'), 1)
		), 'photo_id = ' . (int) $iId
	);
    }

    public function approve($iId)
    {
		$aPhoto = $this->database()->select('p.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.photo_id = ' . (int) $iId)
			->execute('getSlaveRow');
	
		if (!isset($aPhoto['photo_id']))
		{
		    return false;
		}
		if ($aPhoto['view_id'] == '0')
		{
			return true;
		}
		
		$aCallback = (!empty($aPhoto['module_id']) ? Phpfox::callback($aPhoto['module_id'] . '.addPhoto', $aPhoto['photo_id']) : null);		
	
		$this->database()->update($this->_sTable, array('view_id' => 0, 'time_stamp' => PHPFOX_TIME), 'photo_id = ' . $aPhoto['photo_id']);
	
		Phpfox::getService('user.activity')->update($aPhoto['user_id'], 'photo');
	
		if ($aPhoto['album_id'] > 0)
		{
		    Phpfox::getService('photo.album.process')->updateCounter($aPhoto['album_id'], 'total_photo');
		}	
		
		if (Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->add('photo_approved', $aPhoto['photo_id'], $aPhoto['user_id']);
		}		
		
		(Phpfox::isModule('feed') ? $iFeedId = Phpfox::getService('feed.process')->callback($aCallback)->add('photo', $aPhoto['photo_id'], $aPhoto['privacy'], $aPhoto['privacy_comment'], (!empty($aPhoto['group_id']) ? (int) $aPhoto['group_id'] : 0), $aPhoto['user_id']) : null);
		
		$sLink = Phpfox::permalink('photo', $aPhoto['photo_id'], $aPhoto['title']);
		
		(($sPlugin = Phpfox_Plugin::get('photo.service_process_approve__1')) ? eval($sPlugin) : false);
		
		Phpfox::getLib('mail')->to($aPhoto['user_id'])
			->subject(array('photo.your_photo_title_has_been_approved', array('title' => $aPhoto['title'])))
			->message( Phpfox::getPhrase('photo.your_photo_has_been_approved_message', array('sLink' => $sLink, 'title' => $aPhoto['title'])))
			->send();
	
		return true;
    }

    public function feature($iId, $sType)
    {
		$this->database()->update($this->_sTable, array('is_featured' => ($sType == '1' ? 1 : 0)), 'photo_id = ' . (int) $iId);
	
		$this->cache()->remove('photo_featured');
	
		return true;
    }

    public function sponsor($iId, $sType)
    {	    
	    if (!Phpfox::getUserParam('photo.can_sponsor_photo') && !Phpfox::getUserParam('photo.can_purchase_sponsor') && !defined('PHPFOX_API_CALLBACK'))
	    {
		    return Phpfox_Error::set('Hack attempt?');
	    }

	    $iType = (int)$sType;
	    if ($iType != 0 && $iType != 1)
	    {
		    return false;
	    }
	    // if it was featured it cannot be both and sponsored overrides featured. If it was sponsored it couldnt had been featured
	    $this->database()->update($this->_sTable, array('is_featured' => 0, 'is_sponsor' => $iType), 'photo_id = ' . (int)$iId);
	    $this->cache()->remove('photo_sponsored');
	    if ($sPlugin = Phpfox_Plugin::get('photo.service_process_sponsor__end'))
	    {
		    eval($sPlugin);
	    }
	    return true;
    }

    public function rotate($iId, $sCmd)
    {
		$aPhoto = $this->database()->select('user_id, title, photo_id, destination, server_id')
			->from($this->_sTable)
			->where('photo_id = ' . (int) $iId)
			->execute('getSlaveRow');
	
		if (!isset($aPhoto['photo_id']))
		{
		    return Phpfox_Error::set(Phpfox::getPhrase('photo.unable_to_find_the_photo_you_plan_to_edit'));
		}
	
		if (($aPhoto['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('photo.can_edit_own_photo')) || Phpfox::getUserParam('photo.can_edit_other_photo'))
		{
			if(!Phpfox::getParam('photo.delete_original_after_resize'))
			{
				$aSizes = array_merge(array(''), Phpfox::getParam('photo.photo_pic_sizes'));
			}
			else
			{
				$aSizes = Phpfox::getParam('photo.photo_pic_sizes');
			}
			
			$aParts = explode('/', $aPhoto['destination']);
			$sParts = '';
			if(is_array($aParts))
			{
				foreach($aParts as $sPart)
				{
					if(!empty($sPart))
					{
						if(!preg_match('/jpg|gif|png/i', $sPart))
						{
							$sParts .= $sPart . '/';
						}
					}
				}
			}
			
		    foreach($aSizes as $iSize)
		    {
				$sFile = Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['destination'], (empty($iSize) ? '' : '_') . $iSize);
				if (file_exists($sFile) || Phpfox::getParam('core.allow_cdn'))
				{
					if (Phpfox::getParam('core.allow_cdn') && $aPhoto['server_id'] > 0)
					{
						$sMainFile = $sFile;
						$sActualFile = Phpfox::getLib('image.helper')->display(array(
								'server_id' => $aPhoto['server_id'],
								'path' => 'photo.url_photo',
								'file' => $aPhoto['destination'],
								'suffix' => (empty($iSize) ? '' : '_') . $iSize,
								'return_url' => true
							)
						);

						$aExts = preg_split("/[\/\\.]/", $sActualFile);
						$iCnt = count($aExts)-1;
						$sExt = strtolower($aExts[$iCnt]);

						$sFile = Phpfox::getParam('photo.dir_photo') . $sParts . md5($aPhoto['destination']) . (empty($iSize) ? '' : '_') . $iSize . '.' . $sExt;

						copy($sActualFile, $sFile);
						//p($sFile);
					}

				    Phpfox::getLib('image')->rotate($sFile, $sCmd);
				}

				if (Phpfox::getParam('core.allow_cdn') && $aPhoto['server_id'] > 0)
				{
					$this->database()->update(Phpfox::getT('photo'), array('destination' => $sParts . md5($aPhoto['destination']) . '%s.' . $sExt), 'photo_id = ' . (int) $aPhoto['photo_id']);
				}
		    }
	
		    return $aPhoto;
		}
	
		return false;
    }
    
    public function massProcess($aAlbum, $aVals)
    {
    	if (isset($aVals['set_album_cover']))
    	{
    		$this->database()->update(Phpfox::getT('photo'), array('is_cover' => '0'), 'album_id = ' . $aAlbum['album_id']);
    		$this->database()->update(Phpfox::getT('photo'), array('is_cover' => '1'), 'photo_id = ' . $aVals['set_album_cover']);
    	}
    	
    	foreach ($aVals as $iPhotoId => $aVal)
    	{
    		if (!is_numeric($iPhotoId))
    		{
    			continue;
    		}
    		
    		if (isset($aVal['delete_photo']))
    		{
    			if (!$this->delete($iPhotoId))
    			{
    				return false;
    			}
    			
    			continue;
    		}
    		
    		$this->update($aAlbum['user_id'], $iPhotoId, $aVal);
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_process__call'))
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
