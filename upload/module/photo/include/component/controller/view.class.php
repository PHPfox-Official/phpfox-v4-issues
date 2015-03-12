<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Controller to view images on a users profile.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: view.class.php 7287 2014-04-28 16:29:52Z Fern $
 */
class Photo_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_view__1')) ? eval($sPlugin) : false);
		Phpfox::getUserParam('photo.can_view_photos', true);
		define('PHPFOX_SHOW_TAGS', true); 
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_view__2')) ? eval($sPlugin) : false);
		
		$aCallback = $this->getParam('aCallback', null);
		$sId = $this->request()->get('req2');
		$sAction = $this->request()->get('req4');		
		$aUser = $this->getParam('aUser');
		$this->setParam('sTagType','photo'); // fixes http://forums.phpfox.com/project.php?issueid=5274
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_view_process_start')) ? eval($sPlugin) : false);
		
		if (Phpfox::isUser() && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('comment_photo', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('photo_like', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('photo_tag', $this->request()->getInt('req2'), Phpfox::getUserId());
		}		
		
		// Get the photo
		$aPhoto = Phpfox::getService('photo')->getPhoto($sId, $aUser['user_id']);
		
		if (!empty($aPhoto['module_id']) && $aPhoto['module_id'] != 'photo')
		{			
			if ($aCallback = Phpfox::callback($aPhoto['module_id'] . '.getPhotoDetails', $aPhoto))
			{
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home'])
					->assign(array('aCallback' => $aCallback));
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);
				if ($aPhoto['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aCallback['item_id'], 'photo.view_browse_photos'))
				{
					return Phpfox_Error::display('Unable to view this item due to privacy settings.');
				}					
			}
		}
		
		// No photo founds lets get out of here
		if (!isset($aPhoto['photo_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('photo.sorry_the_photo_you_are_looking_for_no_longer_exists', array('link' => $this->url()->makeUrl('photo'))));
		}
		
		if ($aPhoto['user_id'] == Phpfox::getUserId() && $this->request()->get('refresh'))
		{
			header("Cache-Control: no-cache, must-revalidate");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		}
		
		Phpfox::getService('core.redirect')->check($aPhoto['title']);
		if (Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('photo', $aPhoto['photo_id'], $aPhoto['user_id'], $aPhoto['privacy'], $aPhoto['is_friend']);
		}
		
		if ($aPhoto['mature'] != 0)
		{
			if (Phpfox::getUserId())
			{	
				if ($aPhoto['user_id'] != Phpfox::getUserId())
				{
					if ($aPhoto['mature'] == 1 && Phpfox::getUserParam(array(
							'photo.photo_mature_age_limit' => array(
									'>', 
									(int) Phpfox::getUserBy('age')
								)
							)
						)
					)
					{
						// warning check cookie
					}
					elseif ($aPhoto['mature'] == 2 && Phpfox::getUserParam(array(
							'photo.photo_mature_age_limit' => array(
									'>', 
									(int) Phpfox::getUserBy('age')
								)
							)
						)				
					)
					{
						return Phpfox_Error::display(Phpfox::getPhrase('photo.sorry_this_photo_can_only_be_viewed_by_those_older_then_the_age_of_limit', array('limit' => Phpfox::getUserParam('photo.photo_mature_age_limit'))));	
					}
				}
			}
			else 
			{
				Phpfox::isUser(true);
			}
		}
		
		$this->setParam('bIsValidImage', true);
		
		/* 
			Don't like that this is here, but if added in the service class it would require an extra JOIN to the user table and its such a waste of a query when we could
			just get the users details vis the cached user array.		
		*/
		$aPhoto['bookmark_url'] = $this->url()->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']);
		
		// Increment the total view
		$aPhoto['total_view'] = ((int) $aPhoto['total_view'] + 1);
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_view_process_photo')) ? eval($sPlugin) : false);
		
		// Assign the photo array so other blocks can use this information
		$this->setParam('aPhoto', $aPhoto);	
		define('TAG_ITEM_ID', $aPhoto['photo_id']); // to be used with the cloud block
		
		// Check if we should set another controller
		if (!empty($sAction))
		{
			switch ($sAction)
			{
				case 'all':
					return Phpfox::getLib('module')->setController('photo.size');
					break;
				case 'download':
					return Phpfox::getLib('module')->setController('photo.download');
					break;
				default:
					(($sPlugin = Phpfox_Plugin::get('photo.component_controller_view_process_controller')) ? eval($sPlugin) : false);
					break;
			}			
		}
		
		// Increment the view counter
		if (Phpfox::isModule('track') && Phpfox::isUser() && Phpfox::getUserId() != $aPhoto['user_id'] && !$aPhoto['is_viewed'])
		{
			Phpfox::getService('track.process')->add('photo', $aPhoto['photo_id']);
			Phpfox::getService('photo.process')->updateCounter($aPhoto['photo_id'], 'total_view');
		}
		
		// Add photo tags to meta keywords
		if (!empty($aPhoto['tag_list']) && $aPhoto['tag_list'] && Phpfox::isModule('tag'))
		{
			$this->template()->setMeta('keywords', Phpfox::getService('tag')->getKeywords($aPhoto['tag_list']));
		}		

		$this->template()->setTitle($aPhoto['title']);
		/*
		if (Phpfox::getParam('photo.how_many_categories_to_show_in_title') > 0)
		{
		    $aCategories = explode('<br />',$aPhoto['categories']);
		    $sCategories = '';
		    foreach ($aCategories as $iCount => $sCategory)
		    {
				if ($iCount >= Phpfox::getParam('photo.how_many_categories_to_show_in_title'))
				{
				    break;
				} // clean the categories
				
				$sCategories .= strip_tags($sCategory) . ' - ';
		    }
		    
		    $this->template()->setTitle(rtrim($sCategories, ' - '));
		}
		*/
		$this->setParam('aFeed', array(				
				'comment_type_id' => 'photo',
				'privacy' => $aPhoto['privacy'],
				'comment_privacy' => $aPhoto['privacy_comment'],
				'like_type_id' => 'photo',
				'feed_is_liked' => $aPhoto['is_liked'],
				'feed_is_friend' => $aPhoto['is_friend'],
				'item_id' => $aPhoto['photo_id'],
				'user_id' => $aPhoto['user_id'],
				'total_comment' => $aPhoto['total_comment'],
				'total_like' => $aPhoto['total_like'],
				'feed_link' => $this->url()->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']),
				'feed_title' => $aPhoto['title'],
				'feed_display' => 'view',
				'feed_total_like' => $aPhoto['total_like'],
				'report_module' => 'photo',
				'report_phrase' => Phpfox::getPhrase('photo.report_this_photo')
			)
		);				
				
		$iUserId = $this->request()->get('userid') ? $this->request()->get('userid') : 0;
		if ($iUserId > 0)
		{
			$this->template()->assign(array('feedUserId' => $iUserId));
		}
		
		$iCategory = ($this->request()->getInt('category') ? $this->request()->getInt('category') : null);		
		if ($this->request()->get('theater'))
		{
			define('PHPFOX_IS_THEATER_MODE', true);
		}
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT') || ($aPhoto['server_id'] > 0 && Phpfox::getParam('core.allow_cdn')))
		{
			$sImageUrl = Phpfox::getLib('image.helper')->display(array(
				'server_id' => $aPhoto['server_id'],
				'path' => 'photo.url_photo',
				'file' => $aPhoto['destination'],
				'suffix' => '_1024',
				'return_url' => true
				)
			);
			$iCdnMax = (($aPhoto['height'] < $aPhoto['width']) ? 800 : 500);
			list($iNewImageHeight, $iNewImageWidth) = Phpfox::getLib('image.helper')->getNewSize(array($sImageUrl, $aPhoto['width'], $aPhoto['height']), $iCdnMax, $iCdnMax);
			$this->template()->assign(array(
						'iNewImageHeight' => $iNewImageHeight,
						'iNewImageWidth' => $iNewImageWidth
					)
				); 

		}
		
		if (!Phpfox::getParam('photo.pre_load_header_view'))
		{
			$this->template()->setHeader('cache', array(
						'jquery/plugin/jquery.highlightFade.js' => 'static_script',	
						'jquery/plugin/jquery.scrollTo.js' => 'static_script',
						'jquery/plugin/imgnotes/jquery.tag.js' => 'static_script',
						'imgnotes.css' => 'style_css',
						'quick_edit.js' => 'static_script',
						'comment.css' => 'style_css',
						'pager.css' => 'style_css',
						'view.js' => 'module_photo',
						'photo.js' => 'module_photo',
						'switch_legend.js' => 'static_script',
						'switch_menu.js' => 'static_script',
						'view.css' => 'module_photo',
						'feed.js' => 'module_feed',
						'edit.css' => 'module_photo',
						'index.js' => 'module_photo'
					)
				);	
		}
		
		$this->template()
				->setFullSite()
				->setBreadcrumb(Phpfox::getPhrase('photo.photos'), ($aCallback === null ? $this->url()->makeUrl('photo') : $this->url()->makeUrl($aCallback['url_home_photo'])))
				->setBreadcrumb($aPhoto['title'], $this->url()->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']), true)
				->setMeta('description',  Phpfox::getPhrase('photo.full_name_s_photo_from_time_stamp', array('full_name' => $aPhoto['full_name'], 'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.description_time_stamp'), $aPhoto['time_stamp']))) . ': ' . (empty($aPhoto['description']) ? $aPhoto['title'] : $aPhoto['title'] . '.' . $aPhoto['description']))
				->setMeta('keywords', $this->template()->getKeywords($aPhoto['title']))
				->setMeta('keywords', Phpfox::getParam('photo.photo_meta_keywords'))
				->setMeta('description', Phpfox::getParam('photo.photo_meta_description'))		
				->setMeta('og:image', Phpfox::getLib('image.helper')->display(array(
							'server_id' => $aPhoto['server_id'],
							'path' => 'photo.url_photo',
							'file' => $aPhoto['destination'],
							//'suffix' => '_150',  http://www.phpfox.com/tracker/view/14924/
							'suffix' => '_240',
							'return_url' => true
						)
					)
				)
				->setHeader(array(
					'jquery/plugin/imgnotes/jquery.imgareaselect.js' => 'static_script',
					'jquery/plugin/imgnotes/jquery.imgnotes.js' => 'static_script',
					'imgareaselect-default.css' => 'style_css'
				))
				->setPhrase(array(
						'photo.none_of_your_files_were_uploaded_please_make_sure_you_upload_either_a_jpg_gif_or_png_file',
						'photo.updating_photo',
						'photo.save',
						'photo.cancel',
						'photo.click_here_to_tag_as_yourself'
					)
				)
				->setEditor(array(
						'load' => 'simple'					
					)
				)->assign(array(
					'aForms' => $aPhoto,
					'bVertical' => ($aPhoto['height'] > $aPhoto['width']),
					'aCallback' => $aCallback,
					'aPhotoStream' => Phpfox::getService('photo')->getPhotoStream($aPhoto['photo_id'], ($this->request()->getInt('albumid') ? $this->request()->getInt('albumid') : '0'), $aCallback, $iUserId, $iCategory, $aPhoto['user_id']),
					'bIsTheater' => ($this->request()->get('theater') ? true : false),
					'sPhotoJsContent' => Phpfox::getService('photo.tag')->getJs($aPhoto['photo_id']),
					'iForceAlbumId' => ($this->request()->getInt('albumid') > 0 ? $this->request()->getInt('albumid') : 0),
					'sCurrentPhotoUrl' => Phpfox::getLib('url')->makeUrl('current'),
					'sMicroPropType' => 'Photograph'
				)
			);		
			
		if ( ($iCategory = $this->request()->getInt('category')) && isset($aPhoto['categories']) && !empty($aPhoto['categories']))
		{
			foreach ($aPhoto['categories'] as $aCategory)
			{
				if (isset($aCategory['category_id']) && $aCategory['category_id'] == $iCategory)
				{
					$this->template()->setBreadcrumb($aCategory[0], $aCategory[1]);
				}
			}
		}
		
		if (!empty($aPhoto['album_title']))
		{
			$this->template()->setTitle($aPhoto['album_title']);
			$this->template()->setMeta('description', '' . Phpfox::getPhrase('photo.part_of_the_photo_album') . ': ' . $aPhoto['album_title']);
		}
			
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_view_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_view_clean')) ? eval($sPlugin) : false);	
	}
}

?>
