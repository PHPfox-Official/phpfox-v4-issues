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
 * @package 		Phpfox_Component
 * @version 		$Id: album.class.php 3547 2011-11-22 14:00:19Z Raymond_Benc $
 */
class Music_Component_Controller_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->request()->getInt('req3') > 0)
		{
			return Phpfox::getLib('module')->setController('music.view-album');
		}				
		
		Phpfox::getUserParam('music.can_access_music', true);
		Phpfox::getUserParam('music.can_upload_music_public', true);
		// Phpfox::getUserParam('music.can_edit_other_music_albums', true);
		Phpfox::isUser(true);		
	
		
		$bIsEdit = false;
		$bIsSetup = ($this->request()->get('req4') == 'setup' ? true : false);
		$sAction = $this->request()->get('req3');
		$aVals = $this->request()->getArray('val');

		if (($iEditId = $this->request()->getInt('id')) || ($iEditId = $this->request()->getInt('album_edit_id')))
		{
			if (($aAlbum = Phpfox::getService('music.album')->getForEdit($iEditId)))
			{
				if ($aAlbum['module_id'] == 'pages')
				{
					Phpfox::getService('pages')->setIsInPage();
				}				
				
				$bIsEdit = true;
				$this->template()->assign(array(
						'aForms' => $aAlbum
					)
				);
			}
		}		
		
		if (!$bIsEdit && !Phpfox::getUserParam('music.can_upload_music_public'))
		{
			$this->url()->send('music.register');	
		}
		
		$aValidation = array(
			'name' => Phpfox::getPhrase('music.provide_a_name_for_this_album'),
			'year' => array(
				'def' => 'year'
			)
		);
		
		$oValidator = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_album_form',
				'aParams' => $aValidation
			)
		);
		
		if ($aVals)
		{
			if ($oValidator->isValid($aVals))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('music.album.process')->update($aAlbum['album_id'], $aVals))
					{
							switch ($sAction)
							{
								case 'track':		
									$this->url()->permalink('music.album', $aAlbum['album_id'], $aAlbum['name'], true, Phpfox::getPhrase('music.tracks_successfully_uploaded') . (Phpfox::getUserParam('music.music_song_approval') ? ' ' . Phpfox::getPhrase('music.note_that_it_will_have_to_be_approved_first_before_it_is_displayed_publicly') : ''));					
									break;	
								default:									
									$this->url()->permalink('music.album', $aAlbum['album_id'], $aAlbum['name'], true, Phpfox::getPhrase('music.album_successfully_updated'));
									break;
							}
					}
				}
				else 
				{
					if ($iId = Phpfox::getService('music.album.process')->add($aVals))
					{
						$this->url()->send('music.album.track.setup', array('id' => $iId), Phpfox::getPhrase('music.album_successfully_added'));
					}
				}
			}
		}
		
		$sMethod = Phpfox::getParam('music.music_enable_mass_uploader') && ($this->request()->get('method','massuploader') == 'massuploader') ? 'massuploader' : 'simple';		
		$sMethodUrl = str_replace(array('method_simple/','method_massuploader/'), '',$this->url()->getFullUrl()) . 'method_' . ($sMethod == 'simple' ? 'massuploader' : 'simple') . '/';
		
		if ($sMethod == 'massuploader')
		{
			$iMaxFileSize = (Phpfox::getUserParam('music.music_max_file_size') === 0 ? null : ((Phpfox::getUserParam('music.music_max_file_size') / 1024) * 1048576));
			$this->template()->setHeader('cache', array(
				'massuploader/swfupload.js' => 'static_script',
				'massuploader/upload.js' => 'static_script',
					'<script type="text/javascript">
						$oSWF_settings =
						{
							object_holder: function()
							{
								return \'swf_music_upload_button_holder\';
							},
							
							div_holder: function()
							{
								return \'swf_music_upload_button\';
							},
							
							get_settings: function()
							{		
								swfu.setUploadURL("' . $this->url()->makeUrl('music.upload') . '");
								swfu.setFileSizeLimit("' . ($iMaxFileSize * 1048576). '");
								swfu.setFileUploadLimit(1);
								swfu.setFileQueueLimit(1);
								swfu.customSettings.flash_user_id = '.Phpfox::getUserId() .';
								swfu.customSettings.sHash = "'.Phpfox::getService('core')->getHashForUpload().'";
								swfu.setFileTypes("*.mp3","*.mp3");
								swfu.atFileQueue = function()
								{
									$(\'#js_album_form :input\').each(function(iKey, oObject)
									{
										swfu.addPostParam($(oObject).attr(\'name\'), $(oObject).val());
									});
							}
								}
						}						
					</script>',				
				'upload.css' => 'module_music'
			))
			->setPhrase(array(							
							'core.name',
							'core.status',
							'core.in_queue',
							'core.upload_failed_your_file_size_is_larger_then_our_limit_file_size',
							'core.more_queued_than_allowed'
						)
					);
			
		}
		
		
		if ($bIsEdit)
		{
			$this->template()->buildPageMenu('js_upload_music', array(
					'detail' => Phpfox::getPhrase('music.album_details'),
					'track' => Phpfox::getPhrase('music.upload_songs')
				),
				array(
					'link' => $this->url()->permalink('music.album', $aAlbum['album_id'], $aAlbum['name']),
					'phrase' => Phpfox::getPhrase('music.view_this_album')
				)				
			);		
			
			$this->setParam(array(
					'album_user_id' => $aAlbum['user_id'],
					'album_id' => $aAlbum['album_id'],
					'album_view_all' => true
				)
			);
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('music.editing_album') . ': ' . $aAlbum['name'] : Phpfox::getPhrase('music.create_album')))
			->setBreadcrumb(Phpfox::getPhrase('music.music'), $this->url()->makeUrl('music'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('music.update_album') . ': ' . $aAlbum['name'] : Phpfox::getPhrase('music.create_album')), null, true)
			->setPhrase(array(
					'music.select_an_mp3',
					'core.select_a_file_to_upload'
				)
			)
			->setHeader(array(
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'album.js' => 'module_music',
					'upload.js' => 'module_music',
					'progress.js' => 'static_script',
					'<script type="text/javascript">$Behavior.musicAlbumCreate = function(){ if ($Core.exists(\'#js_music_form_holder\')) { oProgressBar = {holder: \'#js_music_form_holder\', progress_id: \'#js_progress_bar\', total: 1, max_upload: 1, uploader: \'#js_progress_uploader\', frame_id: \'js_upload_frame\', file_id: \'mp3\'}; $Core.progressBarInit(); }}</script>'										
				)
			)
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'sCreateJs' => $oValidator->createJS(),
					'sGetJsForm' => $oValidator->getJsForm(false),
					'aGenres' => Phpfox::getService('music.genre')->getList(),
					'iUploadLimit' => Phpfox::getLib('file')->getLimit(Phpfox::getUserParam('music.music_max_file_size')),
					'sJavaScriptEditLink' => ($bIsEdit ? "if (confirm('" . Phpfox::getPhrase('music.are_you_sure', array('phpfox_squote' => true)) . "')) { $('#js_submit_upload_image').show(); $('#js_music_upload_image').show(); $('#js_music_current_image').remove(); $.ajaxCall('music.deleteImage', 'id={$aAlbum['album_id']}'); } return false;" : ''),
					'sMethod' => $sMethod,
					'sMethodUrl' => ($bIsEdit ? $this->url()->makeUrl('music.album.track', array('id' => $aAlbum['album_id'], 'method' => 'simple')) : ''),
					'sActionMethod' => $sAction,
					'bIsEditAlbum' => true
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_album_clean')) ? eval($sPlugin) : false);
	}
}

?>