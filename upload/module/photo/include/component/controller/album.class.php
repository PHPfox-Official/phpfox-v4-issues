<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Controller used to view photo albums on a users profile.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: album.class.php 7275 2014-04-21 14:44:05Z Fern $
 */
class Photo_Component_Controller_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_album__1')) ? eval($sPlugin) : false);
		
		Phpfox::getUserParam('photo.can_view_photo_albums', true);
		Phpfox::getUserParam('photo.can_view_photos', true);
		
		// Get the user details (person we are viewing)
		$aUser = $this->getParam('aUser');				
		
		if (Phpfox::isUser() && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('comment_photo_album', $this->request()->getInt('req3'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('photo_album_like', $this->request()->getInt('req3'), Phpfox::getUserId());
		}		
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_album_process_start')) ? eval($sPlugin) : false);		
		
		$bIsProfilePictureAlbum = false;
		if ($this->request()->getInt('req3') == 'profile')
		{
			$bIsProfilePictureAlbum = true;
			$aAlbum = Phpfox::getService('photo.album')->getForProfileView($this->request()->getInt('req4'));
		}
		else
		{
			// Get the current album we are trying to view
			$aAlbum = Phpfox::getService('photo.album')->getForView($this->request()->getInt('req3'));			
			if ($aAlbum['profile_id'] > 0)
			{
				$bIsProfilePictureAlbum = true;
			}
		}
		
		// Make sure this is a valid album
		if ($aAlbum === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('photo.invalid_photo_album'));
		}
		
		// http://www.phpfox.com/tracker/view/15419/
		if ($bIsProfilePictureAlbum)
		{
			$aAlbum['name'] = Phpfox::getPhrase('photo.profile_pictures');
		}		
		
		$aCallback = null;
		if (!empty($aAlbum['module_id']))
		{			
			if ($aCallback = Phpfox::callback($aAlbum['module_id'] . '.getPhotoDetails', $aAlbum))
			{
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);
			}
		}		
		
		if (!$bIsProfilePictureAlbum)
		{
			Phpfox::getService('core.redirect')->check($aAlbum['name'], 'req4');
		}
		
		if (Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('photo_album', $aAlbum['album_id'], $aAlbum['user_id'], $aAlbum['privacy'], $aAlbum['is_friend']);		
		}
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_album_process_album')) ? eval($sPlugin) : false);
		
		// Store the album details so we can use it in a block later on
		$this->setParam('aAlbum', $aAlbum);

		// Setup the page data
		$iPage = $this->request()->getInt('page');
		$iPageSize = Phpfox::getUserParam('photo.total_photo_display_profile');

		// Create the SQL condition array
		$aConditions = array();
		$aConditions[] = 'p.album_id = ' . $aAlbum['album_id'] . '';
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_album_process_conditions')) ? eval($sPlugin) : false);
		
		// Get the photos based on the conditions
		list($iCnt, $aPhotos) = Phpfox::getService('photo')->get($aConditions, 'p.photo_id DESC', $iPage, $iPageSize);
		
		// Set the pager for the photos
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));		

		foreach ($aPhotos as $aPhoto)
		{
			$this->template()->setMeta('keywords', $this->template()->getKeywords($aPhoto['title']));		
			if ($aPhoto['is_cover'])
			{				
				$this->template()->setMeta('og:image', Phpfox::getLib('image.helper')->display(array(
							'server_id' => $aPhoto['server_id'],
							'path' => 'photo.url_photo',
							'file' => $aPhoto['destination'],
							//'suffix' => '_150',  http://www.phpfox.com/tracker/view/14924/
							'suffix' => '_240',
							'return_url' => true
						)
					)
				);
			}
		}	
		
		if (Phpfox::getUserBy('profile_page_id'))
		{
			Phpfox::getService('pages')->setIsInPage();
		}		
		
		$this->setParam('aFeed', array(
				'comment_type_id' => 'photo_album',
				'privacy' => $aAlbum['privacy'],
				'comment_privacy' => $aAlbum['privacy_comment'],
				'like_type_id' => 'photo_album',
				'feed_is_liked' => $aAlbum['is_liked'],
				'feed_is_friend' => $aAlbum['is_friend'],
				'item_id' => $aAlbum['album_id'],
				'user_id' => $aAlbum['user_id'],
				'total_comment' => $aAlbum['total_comment'],
				'total_like' => $aAlbum['total_like'],
				'feed_link' => $this->url()->permalink('photo.album', $aAlbum['album_id'], $aAlbum['name']),
				'feed_title' => $aAlbum['name'],
				'feed_display' => 'view',
				'feed_total_like' => $aAlbum['total_like'],
				'report_module' => 'photo_album',
				'report_phrase' => Phpfox::getPhrase('photo.report_this_photo_album')
			)
		);

		// Assign the template vars
		$this->template()->setTitle($aAlbum['name'])
				->setBreadcrumb(Phpfox::getPhrase('photo.photos'), ($aCallback === null ? $this->url()->makeUrl('photo') : $this->url()->makeUrl($aCallback['url_home_photo'])))
				->setBreadcrumb($aAlbum['name'], $this->url()->permalink('photo.album', $aAlbum['album_id'], $aAlbum['name']), true)
				->setMeta('description', (empty($aAlbum['description']) ? $aAlbum['name'] : $aAlbum['description']))
				->setMeta('keywords', $this->template()->getKeywords($aAlbum['name']))
				->setMeta('keywords', Phpfox::getParam('photo.photo_meta_keywords'))
				->setPhrase(array(
						'photo.updating_album',
						'photo.none_of_your_files_were_uploaded_please_make_sure_you_upload_either_a_jpg_gif_or_png_file'
					)
				)
				->setEditor()
				->setHeader('cache', array(
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',	
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'jquery/plugin/imgnotes/jquery.tag.js' => 'static_script',						
					'quick_edit.js' => 'static_script',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'view.js' => 'module_photo',
					'photo.js' => 'module_photo',
					'switch_legend.js' => 'static_script',
					'switch_menu.js' => 'static_script',
					'index.css' => 'module_photo',
					'view.css' => 'module_photo',
					'feed.js' => 'module_feed',
					'browse.css' => 'module_photo',
					'edit.css' => 'module_photo',
					'index.js' => 'module_photo'					
				)
			)
			->assign(array(
				'aPhotos' => $aPhotos,
				'aForms' => $aAlbum,
				'aAlbum' => $aAlbum,
				'aCallback' => null,
				'bIsInAlbumMode' => true,
				'iForceAlbumId' => $aAlbum['album_id'],
				'iPhotosPerRow' => 5
			)
		);
		
		$this->setParam('global_moderation', array(
				'name' => 'photo',
				'ajax' => 'photo.moderation',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('photo.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('photo.approve'),
						'action' => 'approve'
					)					
				)
			)
		);		
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_album_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_album_clean')) ? eval($sPlugin) : false);
	}
}

?>
