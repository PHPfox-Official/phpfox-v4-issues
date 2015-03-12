<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Class we used to upload images within a hiddne iframe which gives the effect
 * that we are using AJAX to upload an image in the background.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: frame.class.php 4166 2012-05-15 06:44:59Z Raymond_Benc $
 */
class Photo_Component_Controller_Frame extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		// We only allow users the ability to upload images.
		if (!Phpfox::isUser())
		{
			exit;
		}
		if (isset($_REQUEST['picup']))
		{
			$_FILES['Filedata'] = $_FILES['image'];
			unset($_FILES['image']);
		}
		
		if (isset($_FILES['Filedata']) && !isset($_FILES['image'])) // photo.enable_mass_uploader == true
		{
			$_FILES['image'] = array();//$_FILES['Filedata'];
			$_FILES['image']['error']['image'] = UPLOAD_ERR_OK;
			$_FILES['image']['name']['image'] = $_FILES['Filedata']['name'];
			$_FILES['image']['type']['image'] = $_FILES['Filedata']['type'];
			$_FILES['image']['tmp_name']['image'] = $_FILES['Filedata']['tmp_name'];
			$_FILES['image']['size']['image'] = $_FILES['Filedata']['size'];
			
			if (empty($_FILES['image']['name']['image']) && 
				!empty($_FILES['image']['tmp_name']['image']) && 
				!empty($_FILES['image']['size']['image']))
			{
				$_FILES['image']['name']['image'] = 'temporary';
			}
		}
		
		// If no images were uploaded lets get out of here.
		if (!isset($_FILES['image']))
		{
			exit;
		}
		
		// Make sure the user group is actually allowed to upload an image
		if (!Phpfox::getUserParam('photo.can_upload_photos'))
		{		
			exit;
		}
		
		if (($iFlood = Phpfox::getUserParam('photo.flood_control_photos')) !== 0)
		{
			$aFlood = array(
				'action' => 'last_post', // The SPAM action
				'params' => array(
					'field' => 'time_stamp', // The time stamp field
					'table' => Phpfox::getT('photo'), // Database table we plan to check
					'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
					'time_stamp' => $iFlood * 60 // Seconds);	
				)
			);
				 			
				// actually check if flooding
			if (Phpfox::getLib('spam')->check($aFlood))
			{
				Phpfox_Error::set(Phpfox::getPhrase('photo.uploading_photos_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());	
			}
			
			if (!Phpfox_Error::isPassed())
			{
				// Output JavaScript	
				echo '<script type="text/javascript">';
				if (!$bIsInline)
				{		
					echo 'window.parent.document.getElementById(\'js_progress_cache_holder\').style.display = \'none\';';
					echo 'window.parent.document.getElementById(\'js_photo_form_holder\').style.display = \'block\';';
					echo 'window.parent.document.getElementById(\'js_upload_error_message\').innerHTML = \'<div class="error_message">' . implode('', Phpfox_Error::get()) . '</div>\';';				
				}
				else
				{
					if (isset($aVals['is_cover_photo']))
					{
						echo 'window.parent.$(\'#js_cover_photo_iframe_loader_error\').html(\'<div class="error_message">' . implode('', Phpfox_Error::get()) . '</div>\');';
					}
					else
					{					
						echo 'window.parent.$Core.resetActivityFeedError(\'' . implode('', Phpfox_Error::get()) . '\');';
					}
				}
				echo '</script>';
				exit;			
			}
		}		
		
		$oFile = Phpfox::getLib('file');
		$oImage = Phpfox::getLib('image');
		$aVals = $this->request()->get('val');
		if (!is_array($aVals))
		{
			$aVals = array();
		}
		
		$bIsInline = false;
		if (isset($aVals['action']) && $aVals['action'] == 'upload_photo_via_share')
		{
			$bIsInline = true;
		}		
		
		$oServicePhotoProcess = Phpfox::getService('photo.process');
		$aImages = array();	
		$aFeed = array();
		$iFileSizes = 0;
		$iCnt = 0;
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_frame_start')) ? eval($sPlugin) : false);
		
		if (!empty($aVals['album_id']))
		{
			$aAlbum = Phpfox::getService('photo.album')->getAlbum(Phpfox::getUserId(), $aVals['album_id'], true);		
		}
		
		foreach ($_FILES['image']['error'] as $iKey => $sError)
		{
			if ($sError == UPLOAD_ERR_OK) 
			{				
				if ($aImage = $oFile->load('image[' . $iKey . ']', array(
							'jpg',
							'gif',
							'png'
						), (Phpfox::getUserParam('photo.photo_max_upload_size') === 0 ? null : (Phpfox::getUserParam('photo.photo_max_upload_size') / 1024))
					)
				)
				{					
					if (isset($aVals['action']) && $aVals['action'] == 'upload_photo_via_share')
					{
						$aVals['description'] = (isset($aVals['is_cover_photo']) ? null : $aVals['status_info']);
						$aVals['type_id'] = (isset($aVals['is_cover_photo']) ? '2' : '1');
					}	
					
					if ($iId = $oServicePhotoProcess->add(Phpfox::getUserId(), array_merge($aVals, $aImage)))
					{
						$iCnt++;
						$aPhoto = Phpfox::getService('photo')->getForProcess($iId);
						$fh = fopen(PHPFOX_DIR . 'fupload.log', 'a');
						// Move the uploaded image and return the full path to that image.
						$sFileName = $oFile->upload('image[' . $iKey . ']', 
							Phpfox::getParam('photo.dir_photo'), 
//<<<<<<< .mine
							$aPhoto['title']//$iId							
							(Phpfox::getParam('photo.rename_uploaded_photo_names') ? Phpfox::getUserBy('user_name') . '-' . $aPhoto['title'] : $iId),
							(Phpfox::getParam('photo.rename_uploaded_photo_names') ? array() : true)							
						);
							
						// Get the original image file size.
						$iFileSizes += filesize(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''));
						
						// Get the current image width/height
						$aSize = getimagesize(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''));
						
						// Update the image with the full path to where it is located.
						$oServicePhotoProcess->update(Phpfox::getUserId(), $iId, array(
								'destination' => $sFileName,
								'width' => $aSize[0],
								'height' => $aSize[1],
								'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID'),
								'allow_rate' => (empty($aVals['album_id']) ? '1' : '0')
							)
						);				
									
						
						{
							/*
							$sPath = Phpfox::getParam('photo.dir_photo');
							
							foreach(Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
							{					
								
								if ($oImage->createThumbnail($sPath . sprintf($sFileName, ''), $sPath . sprintf($sFileName, '_' . $iSize), $iSize, $iSize) === false)
								{							
									continue;
								}						
								if (Phpfox::getParam('photo.enabled_watermark_on_photos'))
								{
									$oImage->addMark($sPath . sprintf($sFileName, '_' . $iSize));
								}					
								
							}
							
							
							if (Phpfox::getParam('photo.enabled_watermark_on_photos'))					
							{						
								$oImage->addMark($sPath . sprintf($sFileName, ''));
							}
						}
						// Assign vars for the template.
						$aImages[] = array(
							'photo_id' => $iId,
							// 'album' => (isset($aAlbum) ? $aAlbum : null),
							'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID'),
							'destination' => $sFileName,
							'name' => $aImage['name'],
							'ext' => $aImage['ext'],
							'size' => $aImage['size'],
							'width' => $aSize[0],
							'height' => $aSize[1],
							'completed' => 'false'
						);
						
						(($sPlugin = Phpfox_Plugin::get('photo.component_controller_frame_process_photo')) ? eval($sPlugin) : false);
					}
				}
				else 
				{
					
				}
				
			}
			
		}		
		
		
		$iFeedId = 0;
		
		// Make sure we were able to upload some images
		if (count($aImages))
		{
			
			
			
			$aCallback = (!empty($aVals['callback_module']) ? Phpfox::callback($aVals['callback_module'] . '.addPhoto', $aVals['callback_item_id']) : null);
			
			$sAction = (isset($aVals['action']) ? $aVals['action'] : 'view_photo');
			// Have we posted an album for these set of photos?
			if (isset($aVals['album_id']) && !empty($aVals['album_id']))
			{
				
				$aAlbum = Phpfox::getService('photo.album')->getAlbum(Phpfox::getUserId(), $aVals['album_id'], true);
				
				// Set the album privacy
				Phpfox::getService('photo.album.process')->setPrivacy($aVals['album_id']);				
				
				// Check if we already have an album cover
				if (!Phpfox::getService('photo.album.process')->hasCover($aVals['album_id']))
				{
					
					// Set the album cover
					Phpfox::getService('photo.album.process')->setCover($aVals['album_id'], $iId);
				}
				
				// Update the album photo count
				if (!Phpfox::getUserParam('photo.photo_must_be_approved'))
				{
					
					Phpfox::getService('photo.album.process')->updateCounter($aVals['album_id'], 'total_photo', false, count($aImages));
				}
				
				if (!defined('PHPFOX_SKIP_FEED_ENTRY') && !Phpfox::getUserParam('photo.photo_must_be_approved'))
				{
					// (Phpfox::isModule('feed') ? $iFeedId = Phpfox::getService('feed.process')->callback($aCallback)->delete('photo_album', $aVals['album_id'], Phpfox::getUserId()) : null);					
					// (Phpfox::isModule('feed') ? $iFeedId = Phpfox::getService('feed.process')->callback($aCallback)->add('photo_album', $aVals['album_id'], $aAlbum['privacy'], $aAlbum['privacy_comment'], (isset($aVals['parent_user_id']) ? (int) $aVals['parent_user_id'] : 0)) : null);
				}
				
				$sAction = 'view_album';
			}
			else 
			{	
				
				if (!defined('PHPFOX_SKIP_FEED_ENTRY') && !Phpfox::getUserParam('photo.photo_must_be_approved'))
				{			
					
					// (Phpfox::isModule('feed') ? $iFeedId = Phpfox::getService('feed.process')->callback($aCallback)->add('photo', $iId, (isset($aVals['privacy']) ? (int) $aVals['privacy'] : 0), (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0), (isset($aVals['parent_user_id']) ? (int) $aVals['parent_user_id'] : 0)) : null);
				}				
			}
			
			// Update the user space usage
			Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'photo', $iFileSizes);			

			(($sPlugin = Phpfox_Plugin::get('photo.component_controller_frame_process_photos_done')) ? eval($sPlugin) : false);						
			
			
			if (isset($_REQUEST['picup']))
			{			
				//exit();
			}
			else if (isset($aVals['method']) && $aVals['method'] == 'massuploader')
			{
				
				echo 'window.aImagesUrl.push("' . urlencode(base64_encode(serialize($aImages))) . '");';
				echo 'window.aImagesUrl.push("' . urlencode(base64_encode(json_encode($aImages))) . '");';
			}
			else 
			{
				echo '<script type="text/javascript">';
				echo 'window.parent.$.ajaxCall(\'photo.process\', \'js_disable_ajax_restart=true&twitter_connection=' . ((isset($aVals['connection']) && isset($aVals['connection']['twitter'])) ? $aVals['connection']['twitter'] : '0') . '&facebook_connection=' . (isset($aVals['connection']['facebook']) ? $aVals['connection']['facebook'] : '0') . '&custom_pages_post_as_page=' . $this->request()->get('custom_pages_post_as_page') . '&photos=' . urlencode(base64_encode(json_encode($aImages))) . '&action=' . $sAction . '' . (isset($iFeedId) ? '&feed_id=' . $iFeedId : '') . '' . ($aCallback !== null ? '&callback_module=' . $aCallback['module'] . '&callback_item_id=' . $aCallback['item_id'] : '') . '&parent_user_id=' . (isset($aVals['parent_user_id']) ? (int) $aVals['parent_user_id'] : 0) . '&is_cover_photo=' . (isset($aVals['is_cover_photo']) ? '1' : '0') . '\');';
				echo '</script>';
			}
			(($sPlugin = Phpfox_Plugin::get('photo.component_controller_frame_process_photos_done_javascript')) ? eval($sPlugin) : false);
		}
		else 
		{
			// Output JavaScript	
			echo '<script type="text/javascript">';
			if (!$bIsInline)
			{
				echo 'window.parent.document.getElementById(\'js_progress_cache_holder\').style.display = \'none\';';
				echo 'window.parent.document.getElementById(\'js_photo_form_holder\').style.display = \'block\';';
				echo 'window.parent.document.getElementById(\'js_upload_error_message\').innerHTML = \'<div class="error_message">' . implode('', Phpfox_Error::get()) . '</div>\';';				
			}
			else
			{
				if (isset($aVals['is_cover_photo']))
				{
					echo 'window.parent.$(\'#js_cover_photo_iframe_loader_error\').html(\'<div class="error_message">' . implode('', Phpfox_Error::get()) . '</div>\');';
				}
				else
				{
					echo 'window.parent.$Core.resetActivityFeedError(\'' . implode('', Phpfox_Error::get()) . '\');';
				}
			}
			echo '</script>';
		}		
		exit;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_frame_clean')) ? eval($sPlugin) : false);
	}
}

?>