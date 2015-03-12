<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 6858 2013-11-06 17:27:45Z Fern $
 */ 
class Photo_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->request()->get('picup') == '1')
		{
			// This redirects the user when Picup has finished uploading the photo
			if ($this->request()->isIOS())
			{
				die("<script type='text/javascript'>window.location.href = '" . $this->url()->makeUrl('photo.converting') . "'; </script> ");
			}
			else
			{
				die("<script type='text/javascript'>window.open('" . $this->url()->makeUrl('photo.converting') . "', 'my_form'); </script> ");
			}
		}
		// Make sure the user is allowed to upload an image
		Phpfox::isUser(true);
		Phpfox::getUserParam('photo.can_upload_photos', true);		

		$sModule = $this->request()->get('module', false);
		$iItem =  $this->request()->getInt('item', false);	
		
		$bCantUploadMore = (Phpfox::getParam('photo.total_photo_input_bars') > Phpfox::getUserParam('photo.max_images_per_upload'));
		$iMaxFileSize = (Phpfox::getUserParam('photo.photo_max_upload_size') === 0 ? null : ((Phpfox::getUserParam('photo.photo_max_upload_size') / 1024) * 1048576));
		$sMethod = Phpfox::getParam('photo.enable_mass_uploader') && $this->request()->get('method','') != 'simple' ? 'massuploader' : 'simple';
		$sMethodUrl = str_replace(array('method_simple/','method_massuploader/'), '',$this->url()->getFullUrl()) . 'method_' . ($sMethod == 'simple' ? 'massuploader' : 'simple') . '/';
		
		if (Phpfox::isMobile() || $this->request()->isIOS())
		{
			$sMethod = 'simple';
			/*
			$this->template()->setHeader(array(
				'<script type="text/javascript">
						var flash_user_id = '.Phpfox::getUserId() .';
						var sHash = "'.Phpfox::getService('core')->getHashForUpload().'";window.name="my_form";</script>',
						));
				
			if ( ($sBrowser = Phpfox::getLib('request')->getBrowser()) && strpos($sBrowser, 'Safari') !== false)
			{
				$this->template()->setHeader(array(
					'mobile.js' => 'module_photo'
					))
				->assign(array('bRawFileInput' => true));
			}
		*/
		}
		$this->template()->setPhrase(array(
			'core.select_a_file_to_upload'
		));
		if ($sMethod == 'massuploader')
		{			
			$this->template()->setPhrase(array(							
						'photo.you_can_upload_a_jpg_gif_or_png_file',
						'core.name',
						'core.status',
						'core.in_queue',
						'core.upload_failed_your_file_size_is_larger_then_our_limit_file_size',
						'core.more_queued_than_allowed'
					)
				)
				->setHeader(array(
				'massuploader/swfupload.js' => 'static_script',
				'massuploader/upload.js' => 'static_script',
				'<script type="text/javascript">
						// test for Firebug Lite (when preset it reloads the page so the user hash is not valid)
						if (typeof window.Firebug !="undefined" && window.Firebug.Lite != "undefined")
						{
							alert("You are using Firebug Lite which is known to have problems with our mass uploader. Please use the basic uploader or disable Firebug Lite and reload this page.");
						}
					$oSWF_settings =
					{
						object_holder: function()
						{
							return \'swf_photo_upload_button_holder\';
						},
						
						div_holder: function()
						{
							return \'swf_photo_upload_button\';
						},
						
						get_settings: function()
						{		
							swfu.setUploadURL("' . $this->url()->makeUrl('photo.frame') . '");
							swfu.setFileSizeLimit("'.$iMaxFileSize .' B");
							swfu.setFileUploadLimit('.Phpfox::getUserParam('photo.max_images_per_upload').');								
							swfu.setFileQueueLimit('.Phpfox::getUserParam('photo.max_images_per_upload').');
							swfu.customSettings.flash_user_id = '.Phpfox::getUserId() .';
							swfu.customSettings.sHash = "'.Phpfox::getService('core')->getHashForUpload().'";
							swfu.customSettings.sAjaxCall = "photo.process";
							swfu.customSettings.sAjaxCallParams = "' . ($sModule !== false ? '&callback_module=' . $sModule . '&callback_item_id=' . $iItem . '&parent_user_id=' . $iItem . '': '') . '";
							swfu.customSettings.sAjaxCallAction = function(iTotalImages){								
								tb_show(\'\', \'\', null, \'' . Phpfox::getLib('image.helper')->display(array('theme' => 'ajax/add.gif', 'class' => 'v_middle')) . ' ' . Phpfox::getPhrase('photo.please_hold_while_your_images_are_being_processed_processing_image') . ' <span id="js_photo_upload_process_cnt">1</span> ' . Phpfox::getPhrase('photo.out_of') . ' \' + iTotalImages + \'.\', true);
								$Core.loadInit();
							}
							swfu.atFileQueue = function()
							{
								$(\'#js_photo_form :input\').each(function(iKey, oObject)
								{
									swfu.addPostParam($(oObject).attr(\'name\'), $(oObject).val());
								});
							}
						}
					}
				</script>',
				)
			);			
		}

		$this->template()->setHeader('<script type="text/javascript">$Behavior.photoProgressBarSettings = function(){ if ($Core.exists(\'#js_photo_form_holder\')) { oProgressBar = {html5upload: ' . (Phpfox::getParam('photo.html5_upload_photo') ? 'true' : 'false') . ', holder: \'#js_photo_form_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_photo_upload_input\', add_more: ' . ($bCantUploadMore ? 'false' : 'true') . ', max_upload: ' . Phpfox::getUserParam('photo.max_images_per_upload') . ', total: 1, frame_id: \'js_upload_frame\', file_id: \'image[]\', valid_file_ext: new Array(\'gif\', \'png\', \'jpg\', \'jpeg\')}; $Core.progressBarInit(); } }</script>');
		
		$aCallback = false;
		if ($sModule !== false && $iItem !== false && Phpfox::hasCallback($sModule, 'getPhotoDetails'))
		{
			if (($aCallback = Phpfox::callback($sModule . '.getPhotoDetails', array('group_id' => $iItem))))
			{
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);	
				if ($sModule == 'pages' && !Phpfox::getService('pages')->hasPerm($iItem, 'photo.share_photos'))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('photo.unable_to_view_this_item_due_to_privacy_settings'));
				}				
			}
		}		
		
		$aPhotoAlbums = Phpfox::getService('photo.album')->getAll(Phpfox::getUserId(), $sModule, $iItem);
		foreach ($aPhotoAlbums as $iAlbumKey => $aPhotoAlbum)
		{
			if ($aPhotoAlbum['profile_id'] > 0)
			{
				unset($aPhotoAlbums[$iAlbumKey]);
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('photo.upload_photos'))	
			->setFullSite()	
			->setBreadcrumb(Phpfox::getPhrase('photo.photo'), $this->url()->makeUrl(($sModule !== false ? $sModule .'.': '') . ($iItem !== false ? $iItem .'.': '') . 'photo'))
			->setBreadcrumb(Phpfox::getPhrase('photo.upload_photos'), $this->url()->makeUrl('photo.add'), true)
			->setHeader('cache', array(
					'progress.js' => 'static_script'
				)
			)
			->setPhrase(array(
					'core.not_a_valid_file_extension_we_only_allow_ext',
					'photo.photo_uploads',
					'photo.upload_complete_we_are_currently_processing_the_photos'
				)
			)
			->assign(array(
					'iMaxFileSize' => $iMaxFileSize,
					'iAlbumId' => $this->request()->getInt('album'),
					'aAlbums' => $aPhotoAlbums, // Get all the photo albums for this specific user
					'sModuleContainer' => $sModule,
					'iItem' => $iItem,
					'sMethod' => $sMethod,
					'sMethodUrl' => $sMethodUrl,
					'sCategories' => Phpfox::getService('photo.category')->get(false, true),
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_add_clean')) ? eval($sPlugin) : false);
	}
}

?>
