<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Class controls all AJAX requests related to the photo module.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: ajax.class.php 7279 2014-04-23 13:41:35Z Fern $
 */
class Photo_Component_Ajax_Ajax extends Phpfox_Ajax
{
    public function viewAllSizes()
	{
		if (!$this->get('replace'))
		{
			$this->setTitle(Phpfox::getPhrase('photo.view_all_sizes'));
		}
		Phpfox::getComponent('photo.size', array(), 'controller');
		if ($this->get('replace'))
		{
			$this->html('#js_photo_view_all_sizes', $this->getContent(false));
		}
	}
	
	/**
     * Displays the form that adds a new photo album.
     *
     */
    public function newAlbum()
    {
		$this->setTitle(Phpfox::getPhrase('photo.create_a_new_photo_album'));	
    	// Only users can view this form.
		Phpfox::isUser(true);
		// Only users with this specific user group perm. can view this form.
		Phpfox::getUserParam('photo.can_create_photo_album', true);
		// Display the block form
		Phpfox::getBlock('photo.album');
		
		$this->call('<script type="text/javascript">$Core.loadInit();</script>');
    }

    /**
     * Add a new album into the database
     *
     * @return boolean Return false only to exit the call earlier.
     */
    public function addAlbum()
    {
		// Only users can view this form.
		Phpfox::isUser(true);
		// Only users with this specific user group perm. can view this form.
		Phpfox::getUserParam('photo.can_create_photo_album', true);
		// Get the total number of albums this user has
		$iTotalAlbums = Phpfox::getService('photo.album')->getAlbumCount(Phpfox::getUserId());
		// Check if they are allowed to create new albums
		$bAllowedAlbums = (Phpfox::getUserParam('photo.max_number_of_albums') == 'null' ? true : (!Phpfox::getUserParam('photo.max_number_of_albums') ? false : (Phpfox::getUserParam('photo.max_number_of_albums') <= $iTotalAlbums ? false : true)));

		// Are they allowed to create new albums?
		if (!$bAllowedAlbums)
		{
			// They have reached their limit
			$this->alert(Phpfox::getPhrase('photo.you_have_reached_your_limit_you_are_currently_unable_to_create_new_photo_albums'));

			return false;
		}

		// Assigned the post vals
		$aVals = $this->get('val');

		// Add the photo album
		if ($iId = Phpfox::getService('photo.album.process')->add($aVals))
		{
			// $this->alert(Phpfox::getPhrase('photo.album_successfully_created'));
			// $this->call('setTimeout(tb_remove, 1000);');
			
			// All went well, add the new album to our form and close the AJAX popup.
			$this->show('#js_photo_albums')
				->remove('#js_photo_albums_span')
				->slideUp('#js_photo_privacy_holder')
				->call('tb_remove();')
				->append('#js_photo_album_select', '<option value="' . $iId. '" selected="selected">' . Phpfox::getLib('parse.output')->clean(Phpfox::getLib('parse.input')->clean($aVals['name'])) . '</option>');
				// ->call('$(\'#js_album_form\').hide();$(\'#js_upload_form\').show();					$(\'#js_create_new_album\')[0].reset();					$(\'.js_cached_friend_name\').remove();					$(\'#js_allow_list_input\').hide();					if (swfu != undefined){swfu.addPostParam(\'album_id\', '.$iId.');}');
		}
    }

    /**
     * Displays the photo index page using the pagination.
     *
     */
    public function browse()
    {
		if (!defined('PHPFOX_IS_AJAX_CONTROLLER')) define('PHPFOX_IS_AJAX_CONTROLLER', true);
		Phpfox::getLib('module')->getComponent('photo.index', $this->getAll(), 'controller');
		$this->call('$(".pager_container, .moderation_holder").remove();');
		$this->call('$(\'#js_ajax_browse_content\').append(\'' . $this->getContent() . '\'); ');
		$this->call('$Core.loadInit();');
    }

    /**
     * Browse a users album
     *
     */
    public function browseUserAlbum()
    {
		Phpfox::getLib('module')->getComponent('photo.profile', $this->getAll(), 'controller');
	
		$this->call('$(\'#js_user_photo_albums\').html(\'' . $this->getContent() . '\'); $.scrollTo(\'#js_user_photo_albums_outer\', 340);');
    }

    /**
     * Browse a users album
     *
     */
    public function browseAlbum()
    {
		Phpfox::getLib('module')->getComponent('photo.album', $this->getAll(), 'controller');
	
		$this->call('$(\'#js_album_content\').html(\'' . $this->getContent() . '\'); $.scrollTo(\'#js_album_content\', 340);');
    }

    /**
     * Browser a set of photos by a user
     *
     */
    public function browseUserPhotos()
    {
		Phpfox::getLib('module')->getComponent('photo.profile', $this->getAll(), 'controller');
	
		$this->call('$(\'#js_user_photos\').html(\'' . $this->getContent() . '\'); $.scrollTo(\'#js_user_photos_outer\', 340); $Behavior.hoverAction(); $Behavior.imageHoverHolder();');
    }

    /**
     * Refresh the featured image and reset the refresh time.
     *
     */
    public function refreshFeaturedImage()
    {
		Phpfox::getBlock('photo.featured');
	
		$this->html('#js_block_content_featured_photo', $this->getContent(false))->call('setTimeout("$.ajaxCall(\'photo.refreshFeaturedImage\');", ' + Phpfox::getService('photo')->getFeaturedRefreshTime() + ');');
    }

    public function updateAlbumTitle()
    {
		Phpfox::isUser(true);
	
		if (Phpfox::getLib('parse.format')->isEmpty($this->get('quick_edit_input')))
		{
		    $this->alert(Phpfox::getPhrase('photo.add_a_title'));
	
		    return false;
		}
	
		if (Phpfox::getService('user.auth')->hasAccess('photo_album', 'album_id', $this->get('album_id'), 'photo.can_edit_own_photo_album', 'photo.can_edit_other_photo_albums') && Phpfox::getService('photo.album.process')->updateTitle($this->get('album_id'), $this->get('quick_edit_input')))
		{
		    $this->html('#' . $this->get('id'), '<a href="' . Phpfox::getLib('url')->makeUrl($this->get('user_name'), array('photo', $this->get('old_title'))) . '" id="js_ge_edit_inner_title' . $this->get('album_id') . '">' . Phpfox::getLib('parse.output')->clean(Phpfox::getLib('parse.input')->clean($this->get('quick_edit_input'))) . '</a>', '.highlightFade()');
		}
    }

    public function updateAlbum()
    {
		Phpfox::isUser(true);
	
		$aVals = $this->get('val');
	
		if (Phpfox::getService('user.auth')->hasAccess('photo_album', 'album_id', $aVals['album_id'], 'photo.can_edit_own_photo_album', 'photo.can_edit_other_photo_albums') && Phpfox::getService('photo.album.process')->update($aVals['album_id'], $aVals))
		{
		    $oParseInput = Phpfox::getLib('parse.input');
		    $oParseOutput = Phpfox::getLib('parse.output');
	
		    if (isset($aVals['inline']))
		    {
			$sTitle = $oParseOutput->clean($oParseInput->clean($aVals['name']));
	
			$this->hide('#js_album_edit_form')
				->call('$(\'#js_album_inner_title_link_' . $aVals['album_id'] . '\').attr(\'title\', \'' . $sTitle . '\');')
				->html('#js_album_inner_title_' . $aVals['album_id'], $sTitle)
				->show('#js_user_photo_albums')
				->html('#js_updating_album', ' - <a href="#" onclick="$(\'#js_album_edit_form\').hide(); $(\'#js_user_photo_albums\').show(); return false;">' . Phpfox::getPhrase('photo.cancel') . '</a>');
		    }
		    else
		    {
			$this->html('#js_ge_edit_inner_title' . $aVals['album_id'], $oParseOutput->clean($oParseInput->clean($aVals['name'])))
				->html('#js_album_description', $oParseOutput->clean($oParseInput->clean($aVals['description'])))
				->html('#js_updating_album', ' - <a href="#" id="js_album_cancel_edit">' . Phpfox::getPhrase('photo.cancel') . '</a>');
		    }
		}
    }

    public function updatePhoto()
    {
		$aPostVals = $this->get('val');		
		$aVals = $aPostVals[$this->get('photo_id')];		
		$aVals['set_album_cover'] = (isset($aPostVals['set_album_cover']) ? $aPostVals['set_album_cover'] : null);
		if (!isset($aVals['privacy']) && isset($aPostVals['privacy']))
		{
			$aVals['privacy'] = $aPostVals['privacy'];
			$aVals['privacy_comment'] = $aPostVals['privacy_comment'];	
		}
		else 
		{
			$aVals['privacy'] = (isset($aVals['privacy']) ? $aVals['privacy'] : 0);
			$aVals['privacy_comment'] = (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : 0);
		}
			
		if (($iUserId = Phpfox::getService('user.auth')->hasAccess('photo', 'photo_id', $aVals['photo_id'], 'photo.can_edit_own_photo', 'photo.can_edit_other_photo')) && Phpfox::getService('photo.process')->update($iUserId, $aVals['photo_id'], $aVals))
		{
		    $oParseInput = Phpfox::getLib('parse.input');
		    $oParseOutput = Phpfox::getLib('parse.output');
		    
		    $aPhoto = Phpfox::getService('photo')->getForEdit($aVals['photo_id']);
		    
		    if ($this->get('inline'))
		    {
		    	$this->html('#js_photo_title_' . $this->get('photo_id'), Phpfox::getLib('parse.output')->clean(Phpfox::getLib('parse.input')->clean($aVals['title'])));
		    	$this->call('tb_remove();');
		    }
		    else 
		    {
		    	$this->call('window.location.href = "' . Phpfox::getLib('url')->permalink('photo', $aPhoto['photo_id'], Phpfox::getLib('parse.input')->clean($aVals['title'])) . '";');
		    }
		}
    }

    /**
     * Set an album cover
     *
     */
    public function setAlbumCover()
    {
		if (Phpfox::getService('user.auth')->hasAccess('photo_album', 'album_id', $this->get('album_id'), 'photo.can_edit_own_photo_album', 'photo.can_edit_other_photo_albums') && Phpfox::getService('photo.album.process')->setCover($this->get('album_id'), $this->get('photo_id')))
		{
	
		}
    }

    /**
     * After uploading a photo we give an option that allows users the ability
     * to delete their photos on the spot. This method does that job for us.
     *
     */
    public function deleteNewPhoto()
    {
		// Only users can view this form.
		Phpfox::isUser(true);
	
		// Delete the photo.
		if (Phpfox::getService('photo.process')->delete($this->get('id')))
		{
	
		}
    }
    
    public function deleteTheaterPhoto()
    {
    	Phpfox::isUser(true);
    	
    	if (Phpfox::getService('photo.process')->delete($this->get('photo_id')))
    	{
	    	$this->call("js_box_remove($('.js_box_image_holder_full').find('.js_box_content:first'));");
	    	$this->call("$('.js_photo_item_" . $this->get('photo_id') . "').parents('.js_parent_feed_entry:first').remove();");
	    	$this->call("$('#js_photo_id_" . $this->get('photo_id') . "').remove();");
    	}
    }

    public function deletePhoto()
    {
		Phpfox::isUser(true);
	
		if (Phpfox::getService('photo.process')->delete($this->get('photo_id')))
		{
		    $this->remove('#js_photo_id_' . $this->get('photo_id'))
			    ->call('$(\'#js_pager_to\').html((parseInt($(\'#js_pager_to\').html()) - 1));')
			    ->call('$(\'#js_pager_total\').html((parseInt($(\'#js_pager_total\').html()) - 1));');
		}
    }

    public function editPhoto()
    {
		Phpfox::isUser(true);

		if (Phpfox::getService('user.auth')->hasAccess('photo', 'photo_id', $this->get('photo_id'), 'photo.can_edit_own_photo', 'photo.can_edit_other_photo'))
		{
	    	Phpfox::getBlock('photo.edit-photo', array('ajax_photo_id' => $this->get('photo_id')));
	    	$this->setTitle(Phpfox::getPhrase('photo.editing_photo'));
	    	$this->call('<script type="text/javascript">$Core.loadInit();</script>');
		}
    }

    public function warning()
    {		
    	Phpfox::getBlock('photo.warning');
    }

	/** @deprecated 3.7.3
	 * called from rate.js in photo module but this file is not included in any controller. This function will be removed soon.
	 */ 
    public function getPhotosForRating()
    {
		exit();
    }

    public function battle()
    {
		$aPhotos = $this->get('photo_id');
	
		if (is_array($aPhotos) && Phpfox::getService('photo.battle.process')->add($aPhotos))
		{
	
		}
	
		$sCategory = $this->get('category');
		if (empty($sCategory))
		{
		    $sCategory = null;
		}
	
		$sJavaScript = Phpfox::getService('photo.battle')->getJavaScript($sCategory);
	
		$this->call('$Core.photoBattle.populate(' . $sJavaScript . ');');
    }

    public function getCategoryForEdit()
    {
		Phpfox::isUser(true);
		Phpfox::getUserParam('photo.can_edit_photo_categories', true);
	
		$aCategory = Phpfox::getService('photo.category')->getCategory($this->get('id'));
	
		$this->call('$(\'#js_photo_category_' . $aCategory['parent_id'] . '\').attr(\'selected\', true);');
	
		$this->html('#js_photo_table_header', Phpfox::getPhrase('photo.editing_category') . ': ' . $aCategory['name'])
			->html('#js_photo_hidden', '<input type="hidden" name="val[edit_id]" value="' . $aCategory['category_id'] . '" />')
			->html('#js_photo_extra_button', ' <input type="button" name="" value="' . Phpfox::getPhrase('photo.cancel') . '" class="button" onclick="$(\'#js_photo_category_' . $aCategory['parent_id'] . '\').attr(\'selected\', false); $(\'#js_category_holder\').show(); $(\'#js_photo_table_header\').html(\'' . Phpfox::getPhrase('photo.add_a_photo_category') . '\'); $(\'#js_photo_extra_button\').html(\'\'); $(\'#js_photo_hidden\').html(\'\'); $(\'#name\').val(\'\');" /> <input type="submit" value="' . Phpfox::getPhrase('photo.delete') . '" onclick="return confirm(\'' . Phpfox::getPhrase('photo.are_you_sure') . '\');" class="button" name="val[delete]" />')
			->val('#name', $aCategory['name']);
		
		if (strpos($aCategory['name'], '&#') !== false)
		{
			$this->call("$('#name').val($('<div />').html($('#name').val()).text());");
		}
    }

    public function approve()
    {
		Phpfox::isUser(true);
		Phpfox::getUserParam('photo.can_approve_photos', true);
	
		if (Phpfox::getService('photo.process')->approve($this->get('id')))
		{
			$this->alert(Phpfox::getPhrase('photo.photo_has_been_approved'), Phpfox::getPhrase('photo.photo_approved'), 300, 100, true);
			$this->hide('#js_item_bar_approve_image');
			$this->hide('.js_moderation_off'); 
			$this->show('.js_moderation_on');			    
		}
    }

    public function getNew()
    {
		Phpfox::getBlock('photo.new');
	
		$this->html('#' . $this->get('id'), $this->getContent(false));
		$this->call('$(\'#' . $this->get('id') . '\').parents(\'.block:first\').find(\'.bottom li a\').attr(\'href\', \'' . Phpfox::getLib('url')->makeUrl('photo') . '\');');
    }

    public function feature()
    {
		Phpfox::isUser(true);
		Phpfox::getUserParam('photo.can_feature_photo', true);
	
		if (Phpfox::getService('photo.process')->feature($this->get('photo_id'), $this->get('type')))
		{
		    if ($this->get('type') == '1')
		    {
				$sHtml = '<a href="#" title="' . Phpfox::getPhrase('photo.un_feature_this_photo') . '" onclick="$.ajaxCall(\'photo.feature\', \'photo_id=' . $this->get('photo_id') . '&amp;type=0\'); return false;">' . Phpfox::getPhrase('photo.un_feature') . '</a>';
		    }
		    else
		    {
				$sHtml = '<a href="#" title="' . Phpfox::getPhrase('photo.feature_this_photo') . '" onclick="$.ajaxCall(\'photo.feature\', \'photo_id=' . $this->get('photo_id') . '&amp;type=1\'); return false;">' . Phpfox::getPhrase('photo.feature') . '</a>';
		    }
	
		    $this->html('#js_photo_feature_' . $this->get('photo_id'), $sHtml)->alert(($this->get('type') == '1' ? Phpfox::getPhrase('photo.photo_successfully_featured') : Phpfox::getPhrase('photo.photo_successfully_un_featured')));
		    if ($this->get('type') == '1')
		    {
				$this->addClass('#js_photo_id_' . $this->get('photo_id'), 'row_featured_image');
				$this->call('$(\'#js_photo_id_' . $this->get('photo_id') . '\').find(\'.js_featured_photo:first\').show();');
		    }
		    else
		    {
				$this->removeClass('#js_photo_id_' . $this->get('photo_id'), 'row_featured_image');
				$this->call('$(\'#js_photo_id_' . $this->get('photo_id') . '\').find(\'.js_featured_photo:first\').hide();');
		    }
		}
    }

    public function sponsor()
    {
		Phpfox::getUserParam('photo.can_sponsor_photo', true);
		// 0 = remove sponsor; 1 = add sponsor
		if (Phpfox::getService('photo.process')->sponsor($this->get('photo_id'), $this->get('type')))
		{
		    if ($this->get('type') == '1')
		    {
				Phpfox::getService('ad.process')->addSponsor(array('module' => 'photo', 'item_id' => $this->get('photo_id')));
				// image was sponsored
				$sHtml = '<a href="#" title="' . Phpfox::getPhrase('photo.unsponsor_this_photo') . '" onclick="$.ajaxCall(\'photo.sponsor\', \'photo_id=' . $this->get('photo_id') . '&amp;type=0\'); return false;">' . Phpfox::getPhrase('photo.unsponsor_this_photo') . '</a>';	
		    }
		    else
		    {
				Phpfox::getService('ad.process')->deleteAdminSponsor('photo', $this->get('photo_id'));
				$sHtml = '<a href="#" title="' . Phpfox::getPhrase('photo.unsponsor_this_photo') . '" onclick="$.ajaxCall(\'photo.sponsor\', \'photo_id=' . $this->get('photo_id') . '&amp;type=1\'); return false;">' . Phpfox::getPhrase('photo.sponsor_this_photo') . '</a>';
		    }
		    $this->html('#js_photo_sponsor_' . $this->get('photo_id'), $sHtml)->alert($this->get('type') == '1' ? Phpfox::getPhrase('photo.photo_successfully_sponsored') : Phpfox::getPhrase('photo.photo_successfully_un_sponsored'));
		    if($this->get('type') == '1')
		    {
				$this->addClass('#js_photo_id_' . $this->get('photo_id'), 'row_sponsored_image');
				$this->call('$(\'#js_photo_id_' . $this->get('photo_id') . '\').find(\'.js_sponsor_photo:first\').show();');
		    }
		    else
		    {
				$this->removeClass('#js_photo_id_' . $this->get('photo_id'), 'row_sponsored_image');
				$this->call('$(\'#js_photo_id_' . $this->get('photo_id') . '\').find(\'.js_sponsor_photo:first\').hide();');
		    }
		}
    }
    
    public function rotate()
    {    	
		Phpfox::isUser(true);
		if ($aPhoto = Phpfox::getService('photo.process')->rotate($this->get('photo_id'), $this->get('photo_cmd')))
		{
		    Phpfox::getService('photo.tag.process')->deleteAll($this->get('photo_id'));

		    $this->call('window.location.href = \'' . Phpfox::getLib('url')->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']) . 'refresh_1/' . (!empty($_REQUEST['currenturl']) ? $_REQUEST['currenturl'] : '') . '\';');
		}
    }

    public function addPhotoTag()
    {
		$aVals = $this->get('val');
	
		$this->val('#js_tag_user_id', '0')->val('#NoteNote', '');
		if (($sReturn = Phpfox::getService('photo.tag.process')->add($aVals['tag'])))
		{
		    $this->append('#js_photo_in_this_photo', ', ' . $sReturn)->call('$(\'#js_photo_in_this_photo\').parent().show();');
		    $this->call('$(\'#js_photo_in_this_photo\').html(ltrim($(\'#js_photo_in_this_photo\').html(), \', \'));');
		    $this->call('$Core.photo_tag.init({' . Phpfox::getService('photo.tag')->getJs($aVals['tag']['item_id']) . '});');
		}
    }

    public function removePhotoTag()
    {
		if ($iPhoto = Phpfox::getService('photo.tag.process')->delete($this->get('tag_id')))
		{
		    $this->call('$(\'.note\').remove(); $Core.photo_tag.init({' . Phpfox::getService('photo.tag')->getJs($iPhoto) . '});');
		}
    }

    public function process()
    {
		$aPostPhotos = $this->get('photos');
		
		if (is_array($aPostPhotos))
		{
			$aImages = array();
			foreach ($aPostPhotos as $aPostPhoto)
			{
				$aPart = json_decode(urldecode($aPostPhoto), true);
				$aImages[] = $aPart[0];
			}
		}
		else 
		{
			
    		$aImages = json_decode(urldecode($aPostPhotos), true);
		}		

		$oImage = Phpfox::getLib('image');
		$iFileSizes = 0;
		$iGroupId = 0;
		$bProcess = false;
		$bIsPicup = false;
		
		foreach ($aImages as $iKey => $aImage)
		{
			$aImage['destination'] = urldecode($aImage['destination']);
			if (isset($aImage['picup']))
			{
				$bIsPicup = true;
			}
		    if ($aImage['completed'] == 'false')
		    {
				$aPhoto = Phpfox::getService('photo')->getForProcess($aImage['photo_id']);
				if (isset($aPhoto['photo_id']))
				{
					if (Phpfox::getParam('core.allow_cdn'))
					{
						Phpfox::getLib('cdn')->setServerId($aPhoto['server_id']);
					}
					
				    if ($aPhoto['group_id'] > 0)
				    {
						$iGroupId = $aPhoto['group_id'];
				    }
		
				    $sFileName = $aPhoto['destination'];
		
				    //$this->call('p(\'Processing photo: ' . $aPhoto['photo_id'] . '\');');
		
					// If use of CDN and keep files in server is set to false
					// see file "include/library/phpfox/phpfox/phpfox.class.php, around line 1360
					// Bug: http://www.phpfox.com/tracker/view/14641/
					if (!file_exists(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '')) 
						&& Phpfox::getParam('core.allow_cdn')
						&& !Phpfox::getParam('core.keep_files_in_server'))
					{
						if (Phpfox::getParam('core.allow_cdn') && $aPhoto['server_id'] > 0)
						{
							$sActualFile = Phpfox::getLib('image.helper')->display(array(
									'server_id' => $aPhoto['server_id'],
									'path' => 'photo.url_photo',
									'file' => $aPhoto['destination'],
									'suffix' => '',
									'return_url' => true
								)
							);

							$aExts = preg_split("/[\/\\.]/", $sActualFile);
							$iCnt = count($aExts)-1;
							$sExt = strtolower($aExts[$iCnt]);

							$aParts = explode('/', $aPhoto['destination']);
							$sFile = Phpfox::getParam('photo.dir_photo') . $aParts[0] . '/' . $aParts[1] . '/' . md5($aPhoto['destination']) . '.' . $sExt;

							// Create a temp copy of the original file in local server, deleted later in line 606
							copy($sActualFile, $sFile);
						}
					}
		
				    foreach(Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
				    {
						// Create the thumbnail
						if ($oImage->createThumbnail(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''), Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize, true, ((Phpfox::getParam('photo.enabled_watermark_on_photos') && Phpfox::getParam('core.watermark_option') != 'none') ? (Phpfox::getParam('core.watermark_option') == 'image' ? 'force_skip' : true) : false)) === false)
						{
						    //$this->call('p(\'Thumbnail failed: ' . $aPhoto['photo_id'] . ' (' . $iSize . ')\');');
			
						    continue;
						}
		
						//$this->call('p(\'Created thumbnail: ' . $aPhoto['photo_id'] . ' (' . $iSize . ')\');');
		
						if (Phpfox::getParam('photo.enabled_watermark_on_photos'))
						{
						    $oImage->addMark(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize));
						}
		
						// Add the new file size to the total file size variable
						$iFileSizes += filesize(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize));
						
						if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
						{
							unlink(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize));
						}
				    }

				    //if (((Phpfox::getParam('photo.delete_original_after_resize') || !Phpfox::getParam('core.keep_files_in_server')) && $this->get('is_page') != 1) && !defined('PHPFOX_IS_HOSTED_SCRIPT'))
				    if ( (
							(Phpfox::getParam('core.allow_cdn') != true && Phpfox::getParam('photo.delete_original_after_resize')) || 
							(Phpfox::getParam('core.allow_cdn') && !Phpfox::getParam('core.keep_files_in_server'))
						) && $this->get('is_page') != 1 && !defined('PHPFOX_IS_HOSTED_SCRIPT')
						)
				    {
						Phpfox::getLib('file')->unlink(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''));
					}
				    else if (Phpfox::getParam('photo.enabled_watermark_on_photos'))
				    {
						$oImage->addMark(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''));
				    }
		
				    $aImages[$iKey]['completed'] = 'true';
					
					(($sPlugin = Phpfox_Plugin::get('photo.component_ajax_ajax_process__1')) ? eval($sPlugin) : false);
					
				    break;
				}
		    }
		}
	
		// Update the user space usage
		Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'photo', $iFileSizes);
	
		$iNotCompleted = 0;
		foreach ($aImages as $iKey => $aImage)
		{
		    if ($aImage['completed'] == 'false')
		    {
				$iNotCompleted++;
		    }
		}
	
		if ($iNotCompleted === 0)
		{
		    //$this->call('p(\'Photo process completed.\');');
			
			$aCallback = ($this->get('callback_module') ? Phpfox::callback($this->get('callback_module') . '.addPhoto', $this->get('callback_item_id')) : null);

			$iFeedId = 0;
			if (!Phpfox::getUserParam('photo.photo_must_be_approved') && !$this->get('is_cover_photo'))
			{
				if (Phpfox::isModule('feed'))
				{
					$iFeedId = Phpfox::getService('feed.process')->callback($aCallback)->add('photo', $aPhoto['photo_id'], $aPhoto['privacy'], $aPhoto['privacy_comment'], (int) $this->get('parent_user_id', 0));
				}
				if (count($aImages) && !$this->get('callback_module'))
				{
					$aExtraPhotos = array();
					foreach ($aImages as $aImage)
					{
						if ($aImage['photo_id'] == $aPhoto['photo_id'])
						{
							continue;
						}

						Phpfox::getLib('database')->insert(Phpfox::getT('photo_feed'), array(
								'feed_id' => $iFeedId,
								'photo_id' => $aImage['photo_id']
							)
						);
					}
				}
			}
			
			// this next if is the one you will have to bypass if they come from sharing a photo in the activity feed.
			if ( ($this->get('page_id') > 0) )
			{
				$this->call('window.location.href = "' . Phpfox::getLib('url')->permalink('pages', $this->get('page_id'), '') .'coverupdate_1";');
			}
			else if ($bIsPicup)
			{
				$this->call('window.location.href = "' . Phpfox::getLib('url')->permalink('mobile.photo', $aPhoto['photo_id'], $aPhoto['title']) . 'userid_' . Phpfox::getUserId() . '";');

			}
		    else if ($this->get('action') == 'upload_photo_via_share')
		    {
		    	// $aCallback = ($this->get('callback_module') ? Phpfox::callback($this->get('callback_module') . '.addPhoto', $this->get('callback_item_id')) : null);		    	
			    if ($this->get('is_cover_photo'))
				{
					Phpfox::getService('user.process')->updateCoverPhoto($aImage['photo_id']);
					
					$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('profile', array('coverupdate' => '1')) . '\';');
				}
				else
				{
					Phpfox::getService('feed')->callback($aCallback)->processAjax($iFeedId);

					(($sPlugin = Phpfox_Plugin::get('photo.component_ajax_process_done')) ? eval($sPlugin) : false);

					$this->call('$Core.resetActivityFeedForm();');
				}
		    }
		    else 
		    {
			    if (Phpfox::getParam('photo.html5_upload_photo'))
			    {
					// http://www.phpfox.com/tracker/view/14571/
					if (Phpfox::getParam('photo.photo_upload_process'))
					{
						foreach ($aImages as $aImage)
						{
							// use the JS var set at progress.js
							$this->call('sImages = sImages + ' . $aImage['photo_id'] . ' + ",";');
						}
						// Make a call similar to the non HTML5 uploads.
						$this->call('var sCurrentProgressLocation = \'' . Phpfox::getLib('url')->makeUrl('photo', array('view' => 'my', 'mode' => 'edit')) . '\';');
					}
					else
					{
						$this->call('var sCurrentProgressLocation = \'' . Phpfox::getLib('url')->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']) . 'userid_' . Phpfox::getUserId() . '/\';');
					}
			    }
			    else
			    {
					// Only display the photo block if the user plans to upload more pictures
				    if ($this->get('action') == 'view_photo')
				    {
						Phpfox::addMessage((count($aImages) == 1 ? Phpfox::getPhrase('photo.photo_successfully_uploaded') : Phpfox::getPhrase('photo.photos_successfully_uploaded')));

						$this->call('window.parent.location.href = \'' . Phpfox::getLib('url')->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']) . 'userid_' . Phpfox::getUserId() . '/\';');
				    }
				    elseif ($this->get('action') == 'view_album' && isset($aImages[0]['album']))
				    {
						Phpfox::addMessage((count($aImages) == 1 ? Phpfox::getPhrase('photo.photo_successfully_uploaded') : Phpfox::getPhrase('photo.photos_successfully_uploaded')));

						$this->call('window.location.href = \'' . Phpfox::getLib('url')->permalink('photo.album', $aImages[0]['album']['album_id'], $aImages[0]['album']['name']) . '\';');
				    }
				    else
				    {
						Phpfox::addMessage((count($aImages) == 1 ? Phpfox::getPhrase('photo.photo_successfully_uploaded') : Phpfox::getPhrase('photo.photos_successfully_uploaded')));

						if (Phpfox::getParam('photo.photo_upload_process'))
						{
							$sImages = '';
							foreach ($aImages as $aImage)
							{
								$sImages .= $aImage['photo_id'] . ',';
							}
							$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('photo', array('view' => 'my', 'mode' => 'edit', 'photos' => urlencode(base64_encode($sImages)))) . '\';');
						}
						else
						{
							$this->call('window.location.href = \'' . Phpfox::getLib('url')->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']) . 'userid_' . Phpfox::getUserId() . '/\';');
						}
				    }
			    }
		
			    $this->call('completeProgress();');
		    }
		}
		else
		{
		    $this->call('$(\'#js_progress_cache_holder\').html(\'\' + $.ajaxProcess(\'' . Phpfox::getPhrase('photo.processing_image_current_total', array('phpfox_squote' => true, 'current' => (count($aImages) - $iNotCompleted), 'total' => count($aImages))) . '\', \'large\') + \'\');');
			$this->html('#js_photo_upload_process_cnt', (count($aImages) - $iNotCompleted));
			
			$sExtra = '';
			if ($this->get('callback_module'))
			{
				$sExtra .= '&callback_module=' . $this->get('callback_module') . '&callback_item_id=' . $this->get('callback_item_id') . '';
			}
			if ($this->get('parent_user_id'))
			{
				$sExtra .= '&parent_user_id=' . $this->get('parent_user_id');
			}
			
			if ($this->get('start_year') && $this->get('start_month') && $this->get('start_day'))
			{
				$sExtra .= '&start_year= ' . $this->get('start_year') . '&start_month= ' . $this->get('start_month') . '&start_day= ' . $this->get('start_day') . '';
			}			
			
			$sExtra .= '&is_cover_photo=' . $this->get('is_cover_photo');
			
		    $this->call('$.ajaxCall(\'photo.process\', \'&action=' . $this->get('action') . '&js_disable_ajax_restart=true&photos=' . json_encode($aImages) . $sExtra . '\');');
		}
		
		$aVals = $this->get('core');
		
		if (isset($aVals['profile_user_id']) && !empty($aVals['profile_user_id']) && $aVals['profile_user_id'] != Phpfox::getUserId() && Phpfox::isModule('notification'))
		{
			// Phpfox::getService('notification.process')->add('feed_comment_profile', $aPhoto['photo_id'], $aVals['profile_user_id']);
			Phpfox::getService('notification.process')->add('photo_feed_profile', $aPhoto['photo_id'], $aVals['profile_user_id']);
		}
    }

    public function editAlbum()
    {
		$aAlbum = Phpfox::getService('photo.album')->getForEdit($this->get('id'));
	
		if (isset($aAlbum['album_id']))
		{
		    $this->template()->assign(array(
			    'aForms' => $aAlbum
			    )
		    );
	
		    $this->template()->getTemplate('photo.block.form-album');
	
		    $this->html('#js_album_edit_form_template', $this->getContent(false));
		    $this->val('#js_album_edit_form_id', $aAlbum['album_id']);
		    $this->show('#js_album_edit_form');
		    $this->hide('#js_user_photo_albums');
		}
    }
    
    public function view()
    {
    	Phpfox::getComponent('photo.view', array(), 'controller');
		$aHeaderFiles = Phpfox::getLib('template')->getHeader(true);		
		
		$aPhrases = Phpfox::getLib('template')->getPhrases();

		$sLoadFiles = '';		
		$sEchoData = '';
		foreach ($aHeaderFiles as $sHeaderFile)
		{
			if (preg_match('/<style(.*)>(.*)<\/style>/i', $sHeaderFile))
			{
				continue;
			}			
			
			$sHeaderFile = strip_tags($sHeaderFile);
			
			$sNew = preg_replace('/\s+/','',$sHeaderFile);
			if (empty($sNew))
			{
				continue;
			}
			
			if (substr($sNew, 0, 13) == 'oTranslations')
			{
				continue;
			}
			
			if (strpos($sHeaderFile, 'custom.css') !== false)
			{
				continue;
			}
			
			$sLoadFiles .= '\'' . str_replace("'", "\'", $sHeaderFile) . '\',';
		}		
		$sLoadFiles = rtrim($sLoadFiles, ',');    	

		$sContent = $this->getContent(false);		

		if (count($aPhrases) && is_array($aPhrases))
		{
			$sPhrases = '<script type="text/javascript">';
			foreach ($aPhrases as $sKey => $sValue)
			{
				$sPhrases .= 'oTranslations[\'' . $sKey . '\'] = \'' . str_replace("'", "\'", $sValue) . '\';';	
			}			
			$sPhrases .= '</script>';
			
			echo $sPhrases;
		}		
		
		echo '<script type="text/javascript">$Core.loadStaticFiles([' . $sLoadFiles . ']);</script>';
		echo $sContent;
		echo '<script type="text/javascript">$Core.loadInit();</script>';
    }
    
	public function moderation()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('photo.can_approve_photos', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('photo.process')->approve($iId);
					$this->call('$(\'#js_photo_id_' . $iId . '\').remove();');					
				}								
				$sMessage = Phpfox::getPhrase('photo.photo_s_successfully_approved');
				$this->alert($sMessage, 'Moderation', 300, 150, true);
				break;			
			case 'delete':
				Phpfox::getUserParam('photo.can_delete_other_photos', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('photo.process')->delete($iId);
					$this->call('$(\'#js_photo_id_' . $iId . '\').remove();');		
				}				
				$sMessage = Phpfox::getPhrase('photo.photo_s_successfully_deleted');
				break;
		}
		
		$this->updateCount();	
		
		$this->hide('.moderation_process');			
	}

	public function massUpdate()
	{
		$aVals = $this->get('val');
		
		foreach ($aVals as $iPhotoId => $aVal)
		{
			$aPhoto = Phpfox::getLib('database')->select('photo_id, album_id, title, user_id')
				->from(Phpfox::getT('photo'))
				->where('photo_id = ' . (int) $iPhotoId)
				->execute('getSlaveRow');
				
			if (isset($aPhoto['photo_id']))
			{
				if ($aPhoto['user_id'] != Phpfox::getUserId())
				{
					continue;
				}
				
				if(!empty($aPhoto['album_id']))
				{
					$aVal['album_id'] = $aPhoto['album_id'];
				}
				
				if (isset($aVal['delete_photo']))
				{
					Phpfox::getService('photo.process')->delete($aPhoto['photo_id']);
					$this->slideUp('#photo_edit_item_id_' . $aPhoto['photo_id']);						
				}
				else 
				{
					Phpfox::getService('photo.process')->update($aPhoto['user_id'], $aPhoto['photo_id'], $aVal);	
				}
			}
		}
		
		if ($this->get('is_photo_upload'))
		{
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']) . 'userid_' . Phpfox::getUserId() . '/\';');
		}
		else
		{
			$this->alert(Phpfox::getPhrase('photo.successfully_updated_photo_s'), Phpfox::getPhrase('photo.notice'), 300, 150, true);
			$this->hide('#js_photo_multi_edit_image');
			$this->show('#js_photo_multi_edit_submit');
		}
	}
	
	public function getForAttachment()
	{
		Phpfox::isUser(true);
		
		Phpfox::getBlock('photo.attachment');
		
		$this->hide('#' . $this->get('div-id') . ' .js_upload_form_holder_global:first');
		if ($this->get('page') > 1)
		{
			$this->remove('#' . $this->get('div-id') . ' .js_upload_form_holder_global_temp:first .js_pager_view_more_link');
			$this->append('#' . $this->get('div-id') . ' .js_upload_form_holder_global_temp:first', $this->getContent(false));
		}
		else 
		{
			$this->html('#' . $this->get('div-id') . ' .js_upload_form_holder_global_temp:first', $this->getContent(false), '.show()');
			$this->call('$(\'#' . $this->get('div-id') . '\').parents(\'.js_upload_attachment_parent_holder:first .js_global_attachment_loader:first\').hide();');
		}
	}
	
	public function attachToItem()
	{
		Phpfox::isUser(true);
		
		$iFileSizes = 0;
		
		$oAttachment = Phpfox::getService('attachment.process');		
		$oFile = Phpfox::getLib('file');
		$oImage = Phpfox::getLib('image');		
		
		$aPhoto = Phpfox::getService('photo')->getPhoto($this->get('photo-id'));
		
		if (!isset($aPhoto['photo_id']))
		{
			$this->alert(Phpfox::getPhrase('photo.unable_to_find_the_photo_you_are_looking_for'));
			
			return;
		}
		
		if ($aPhoto['user_id'] != Phpfox::getUserId())
		{
			$this->alert(Phpfox::getPhrase('photo.unable_to_import_this_photo'));
			
			return;
		}
		
		$iId = $oAttachment->add(array(
				'category' => $this->get('category'),
				'file_name' => $aPhoto['file_name'],
				'extension' => $aPhoto['extension'],
				'is_image' => true
			)
		);
		
		$sIds = $iId . ',';
		
		$sFileName = md5($iId . PHPFOX_TIME . uniqid()) . '%s.' . $aPhoto['extension'];
		$sFileToCopy = Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['original_destination'], '');
		if (!file_exists($sFileToCopy))
		{
			$sFileToCopy = Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['original_destination'], '_500');
		}
		$oFile->copy($sFileToCopy, Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, ''));

		$sFileSize = $aPhoto['file_size'];	
		$iFileSizes += $sFileSize;		
					
		$oAttachment->update(array(
				'file_size' => $sFileSize,
				'destination' => $sFileName,
				'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')
		), $iId);
					
		$sThumbnail = Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, '_thumb');
		$sViewImage = Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, '_view');
					
		$oImage->createThumbnail(Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, ''), $sThumbnail, Phpfox::getParam('attachment.attachment_max_thumbnail'), Phpfox::getParam('attachment.attachment_max_thumbnail'));
		$oImage->createThumbnail(Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, ''), $sViewImage, Phpfox::getParam('attachment.attachment_max_medium'), Phpfox::getParam('attachment.attachment_max_medium'));
						
		$iFileSizes += (filesize($sThumbnail) + filesize($sThumbnail));
		
		Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'attachment', $iFileSizes);
		
		/*
		ob_start();
		
		Phpfox::getBlock('attachment.list', array('sIds' => $sIds, 'bCanUseInline' => true, 'attachment_no_header' => true, 'attachment_edit' => true, 'sAttachmentInput' => $this->get('input')));
		
		$sContent = ob_get_contents();
		
		ob_clean();

		$this->call('var $oParent = $(\'#' . $this->get('obj-id') . '\'); $oParent.find(\'.js_attachment:first\').val($oParent.find(\'.js_attachment:first\').val() + \'' . $sIds . '\'); $oParent.find(\'.js_attachment_list:first\').show(); $oParent.find(\'.js_attachment_list_holder:first\').prepend(\'' . str_replace("'", "\'", str_replace(array("\n", "\t", "\r"), '', $sContent)) . '\'); $Core.loadInit();');
		*/
		$aAttachment = Phpfox::getLib('database')->select('*')
			->from(Phpfox::getT('attachment'))
			->where('attachment_id = ' . (int) $iId)
			->execute('getSlaveRow');
						
		$sImagePath = Phpfox::getLib('image.helper')->display(array('server_id' => $aAttachment['server_id'], 'path' => 'core.url_attachment', 'file' => $aAttachment['destination'], 'suffix' => '_view', 'max_width' => 'attachment.attachment_max_medium', 'max_height' =>'attachment.attachment_max_medium', 'return_url' => true));
				
		$this->call('Editor.insert({is_image: true, name: \'\', id: \'' . $iId . ':view\', type: \'image\', path: \'' . $sImagePath . '\'});');
		
		if ($this->get('attachment-inline'))
		{
			$this->call('$Core.clearInlineBox();');
		}
		else 
		{
			$this->call('tb_remove();');
		}
	}
	
	/**
	 * Sets a new picture as a Profile Picture adding it to the Profile Pictures Album 
	 * @param int photo_id 
	 */
	public function makeProfilePicture()
	{
		/* Just call the service it'll take care of everything */
		if (Phpfox::getService('photo.process')->makeProfilePicture($this->get('photo_id')))
		{
			
		}
		
		Phpfox::addMessage(Phpfox::getPhrase('photo.profile_photo_successfully_updated'));
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('user.photo') . '\';');
	}
}

?>
