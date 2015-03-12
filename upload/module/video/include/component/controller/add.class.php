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
 * @version 		$Id: add.class.php 6343 2013-07-19 19:42:10Z Raymond_Benc $
 */
class Video_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('video.can_upload_videos', true);
		
		if (Phpfox::getParam('video.convert_servers_enable'))
		{
			$this->template()->assign('sCustomVideoHash', Phpfox::getService('video')->addCustomHash());
		}

		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			if (Phpfox::getService('video')->getOnCloudLimit())
			{
				return Phpfox_Error::display('Monthly video limit reached.');
			}
		}
		
		if ($sPlugin = Phpfox_Plugin::get('video.component_controller_add_1')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		
		$sModule = $this->request()->get('module', false);
		$iItem =  $this->request()->getInt('item', false);		
		
		$aCallback = false;
		if ($sModule !== false && $iItem !== false && Phpfox::hasCallback($sModule, 'getVideoDetails'))
		{			
			if ($sPlugin = Phpfox_Plugin::get('video.component_controller_add_2')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
			if (($aCallback = Phpfox::callback($sModule . '.getVideoDetails', array('item_id' => $iItem))))
			{			
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);	
				if ($sModule == 'pages' && !Phpfox::getService('pages')->hasPerm($iItem, 'video.share_videos'))
				{
					$sPhrase = Phpfox::getPhrase('video.unable_to_view_this_item_due_to_privacy_settings');
					if ( ($sPlugin = Phpfox_Plugin::get('video.component_controller_add_sphrase'))){ eval($sPlugin); }
					return Phpfox_Error::display($sPhrase);
				}
				else
				{
					$sPhrase = '';
					if ( ($sPlugin = Phpfox_Plugin::get('video.component_controller_add_sphrase_2'))){ eval($sPlugin); }
					if (!empty($sPhrase))
					{
						return Phpfox_Error::display($sPhrase);
					}
				}
			}
		}		
		
		if (($aVals = $this->request()->get('val')))
		{
			if ($sPlugin = Phpfox_Plugin::get('video.component_controller_add_3')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
			if (($iFlood = Phpfox::getUserParam('video.flood_control_videos')) !== 0)
			{
				$aFlood = array(
					'action' => 'last_post', // The SPAM action
					'params' => array(
						'field' => 'time_stamp', // The time stamp field
						'table' => Phpfox::getT('video'), // Database table we plan to check
						'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
						'time_stamp' => $iFlood * 60 // Seconds);	
					)
				);
							 			
				// actually check if flooding
				if (Phpfox::getLib('spam')->check($aFlood))
				{
					Phpfox_Error::set(Phpfox::getPhrase('video.you_are_sharing_a_video_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());	
				}
			}					
					
			if (Phpfox_Error::isPassed())
			{			
				if ($sPlugin = Phpfox_Plugin::get('video.component_controller_add_4')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
				if (Phpfox::getService('video.grab')->get($aVals['url']))
				{			
					if ($iId = Phpfox::getService('video.process')->addShareVideo($aVals))
					{
						$aVideo = Phpfox::getService('video')->getForEdit($iId);
						
						if (Phpfox::getService('video.grab')->hasImage())
						{					
							if (isset($aVals['module']) && isset($aVals['item']) && Phpfox::hasCallback($aVals['module'], 'uploadVideo'))
							{
								$aCallback = Phpfox::callback($aVals['module'] . '.uploadVideo', $aVals['item']);
					
								if ($aCallback !== false)
								{
									$this->url()->send($aCallback['url_home'], array('video', $sTitle), Phpfox::getPhrase('video.video_successfully_added'));
								}
							}
							
							$this->url()->permalink('video', $aVideo['video_id'], $aVideo['title'], true, Phpfox::getPhrase('video.video_successfully_added'));
						}
						else 
						{
							$this->url()->send('video.edit.photo', array('id' => $aVideo['video_id']), Phpfox::getPhrase('video.video_successfull_added_however_you_will_have_to_manually_upload_a_photo_for_it'));
						}
					}
				}
			}
			
			$sModule = (isset($aVals['module']) ? $aVals['module'] : false);
			$iItem =  (isset($aVals['item']) ? $aVals['item'] : false);
		}
		
		$sMethod = Phpfox::getParam('video.video_enable_mass_uploader') && $this->request()->get('method','') != 'simple' ? 'massuploader' : 'simple';
		$sMethodUrl = str_replace(array('method_simple/','method_massuploader/'), '',$this->url()->getFullUrl()) . 'method_' . ($sMethod == 'simple' ? 'massuploader' : 'simple') . '/';				
	
		if (Phpfox::isMobile())
		{
			$sMethod = 'simple';
		}
		
		if (Phpfox::getParam('video.convert_servers_enable'))
		{
			$aVideoServers = Phpfox::getParam('video.convert_servers');
			$sCustomServerUrl = $aVideoServers[rand(0, (count($aVideoServers) - 1))];
			$this->template()->assign('sVideoServerUrl', $sCustomServerUrl);
		}		
		
		if ($sMethod == 'massuploader')
		{
			$iMaxFileSize = (Phpfox::getUserParam('video.video_file_size_limit') === 0 ? null : ((Phpfox::getUserParam('video.video_file_size_limit') / 1) * 1048576));
			if (Phpfox::isModule('photo'))
			{
				$this->template()->setPhrase(array('photo.you_can_upload_a_jpg_gif_or_png_file'));
			}

			// video.video_array_support
			$sVideoFormats = '*.mpg; *.mpeg; *.wmv; *.avi; *.mov; *.flv';
			$sVideoNames = 'Video files (mpg, mpeg, wmv, avi, mov or flv)';
			if (Phpfox::getParam('video.upload_for_html5'))
			{
				$sVideoFormats = '';
				foreach ((array) Phpfox::getParam('video.video_array_support') as $sFormat => $sType)
				{
					$sVideoFormats .= '*.' . $sFormat . '; ';
				}
				$sVideoFormats = trim(trim($sVideoFormats), ';');
				$sVideoNames = $sVideoFormats;
			}

			$this->template()->setPhrase(array(							
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
					// document.domain = "phpfox.com";
					$oSWF_settings =
					{
						object_holder: function()
						{
							return \'swf_video_upload_button_holder\';
						},
						
						div_holder: function()
						{
							return \'swf_video_upload_button\';
						},
						
						get_settings: function()
						{		
							swfu.setUploadURL("' . (isset($sCustomServerUrl) ? $sCustomServerUrl : $this->url()->makeUrl('video.frame')) . '");
							swfu.setFileSizeLimit("'.$iMaxFileSize .' B");
							swfu.setFileUploadLimit(1);
							swfu.setFileQueueLimit(1);
							swfu.customSettings.flash_user_id = '.Phpfox::getUserId() .';
							swfu.customSettings.sHash = "'.Phpfox::getService('core')->getHashForUpload().'";
							swfu.setFileTypes("' . $sVideoFormats . '","' . $sVideoNames . '");
							swfu.atFileQueue = function()
							{
								$(\'#js_upload_actual_inner_form\').slideUp();
							
								$(\'#js_video_form :input\').each(function(iKey, oObject)
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
		
		$aMenus = array();		
		if (Phpfox::getParam('video.allow_video_uploading') || Phpfox::getParam('video.vidly_support'))
		{
			$aMenus[$this->url()->makeUrl('video.add')] = Phpfox::getPhrase('video.file_upload');
		}
		$aMenus[$this->url()->makeUrl('video.add.url')] = Phpfox::getPhrase('video.paste_url');
		
		if (!empty($sModule))
		{
			foreach ($aMenus as $sUrl => $sPhrase)
			{
				unset($aMenus[$sUrl]);
				
				$aMenus[$sUrl . 'module_' . $sModule . '/item_' . $iItem . '/'] = $sPhrase;
			}
		}
		
		$bIsVideoUploading = false;
		if ((Phpfox::getParam('video.allow_video_uploading') || Phpfox::getParam('video.vidly_support')) && $this->request()->get('req3') != 'url')
		{
			$bIsVideoUploading = true;
		}
		
		$this->template()->buildPageMenu('js_upload_video', $aMenus, null, true);
		
		if (Phpfox::getParam('video.video_upload_service'))
		{
			Phpfox::getService('video.process')->createVidlyToken();
			$aVidlyParams = array(
				'phrases' => array(
					'select_video' => Phpfox::getPhrase('video.select_video')
				)
			);
			$this->template()->assign('sVidlyParams', urlencode(json_encode($aVidlyParams)));
			$this->template()->setHeader('<script type="text/javascript">$Behavior.checkOnVideo = function(){setInterval("$(\'#js_video_form\').ajaxCall(\'video.checkOnVideo\');", 5000);}</script>');
		}

		if (Phpfox::getParam('video.convert_servers_enable'))
		{
			$this->template()->setHeader('<script type="text/javascript">document.domain = "' . Phpfox::getParam('video.convert_js_parent') . '";</script>');
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('video.upload_share_a_video'))
			->setBreadcrumb(Phpfox::getPhrase('video.video'), ($aCallback === false ? $this->url()->makeUrl('video') : $aCallback['url_home_photo']))
			->setBreadcrumb(Phpfox::getPhrase('video.upload_share_a_video'), ($aCallback === false ? $this->url()->makeUrl('video.add') : $this->url()->makeUrl('video.add', array('module' => $sModule, 'item' => $iItem))), true)
			->setFullSite()			
			->assign(array(
					'sModule' => $sModule,
					'iItem' => $iItem,				
					'sMethod' => $sMethod,
					'sMethodUrl' => $sMethodUrl,
					'bIsVideoUploading' => $bIsVideoUploading	
				)
			)
			->setHeader('cache', array(
					'upload.js' => 'module_video',
					'video.js' => 'module_video'
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_add_clean')) ? eval($sPlugin) : false);
	}
}

?>