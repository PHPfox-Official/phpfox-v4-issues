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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Video_Component_Controller_Frame extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (!Phpfox::isUser())
		{
			exit;
		}
		
		if (!Phpfox::getParam('video.allow_video_uploading') && !Phpfox::getParam('video.vidly_support'))
		{
			exit;
		}
		
		if (!Phpfox::getUserParam('video.can_upload_videos'))
		{
			exit;
		}
		
		$bMassUploader = Phpfox::getParam('video.video_enable_mass_uploader') && (isset($_POST['sMethod']) && $_POST['sMethod'] == 'massuploader');
		if (isset($_FILES['Filedata']) && !isset($_FILES['video']))
		{
			$_FILES['video'] = $_FILES['Filedata'];
		}		
		
		$bIsInline = false;
		$aVals = $this->request()->get('val');
		if (isset($aVals['video_inline']))
		{
			$bIsInline = true;
		}
							
		if (!isset($_FILES['video']))
		{
			echo '<script type="text/javascript">';					
			if (!$bIsInline)
			{
				echo 'if (window.parent.$Core.exists(\'#js_video_upload_error\')){';
				echo 'window.parent.document.getElementById(\'js_video_upload_error\').style.display = \'block\';';
				echo 'window.parent.document.getElementById(\'js_video_upload_message\').innerHTML = \''.Phpfox::getPhrase('video.upload_failed_file_is_too_large').'\';';
				echo 'window.parent.document.getElementById(\'js_upload_inner_form\').style.display = \'block\';';
				echo 'window.parent.document.getElementById(\'js_video_detail\').style.display = \'none\';';
				echo 'window.parent.document.getElementById(\'js_video_process\').style.display = \'none\';';				
				echo '}else{';
				echo 'window.parent.$Core.resetActivityFeedError(\'' . Phpfox::getPhrase('video.upload_failed_file_is_too_large') . '\');';
				echo '}';
			}
			else 
			{
				echo 'window.parent.$Core.resetActivityFeedError(\'' . Phpfox::getPhrase('video.upload_failed_file_is_too_large') . '\');';				
			}			
			echo '</script>';
			exit;
		}
		
		if (($iFlood = Phpfox::getUserParam('video.flood_control_videos')) !== 0)
		{
			$aFlood = array(
				'action' => 'last_post', // The SPAM action
				'params' => array(
					'field' => 'time_stamp', // The time stamp field
					'table' => Phpfox::getT('video'), // Database table we plan to check
					'condition' => 'view_id = 0 AND user_id = ' . Phpfox::getUserId(), // Database WHERE query
					'time_stamp' => $iFlood * 60 // Seconds);	
				)
			);
							 			
			// actually check if flooding
			if (Phpfox::getLib('spam')->check($aFlood))
			{
				Phpfox_Error::set(Phpfox::getPhrase('video.you_are_uploading_a_video_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());	
			}
		}					
					
		if (!Phpfox_Error::isPassed())
		{
			if (!empty($_FILES['video']['tmp_name']))
			{
				Phpfox::getService('video.process')->delete();
			}
			echo '<script type="text/javascript">';			
			if (!$bIsInline)
			{				
				echo 'window.parent.document.getElementById(\'js_video_upload_error\').style.display = \'block\';';
				echo 'window.parent.document.getElementById(\'js_video_upload_message\').innerHTML = \'' . implode('<br />', Phpfox_Error::get()) . '\';';				
				echo 'window.parent.document.getElementById(\'js_upload_inner_form\').style.display = \'block\';';
				echo 'window.parent.document.getElementById(\'js_video_detail\').style.display = \'none\';';
				echo 'window.parent.document.getElementById(\'js_video_process\').style.display = \'none\';';
			}
			else 
			{
				// echo 'window.parent.$(\'.activity_feed_form_share_process\').hide(); window.parent.$(\'.activity_feed_form_button .button\').removeClass(\'button_not_active\'); window.parent.$bButtonSubmitActive = true;';
				echo 'window.parent.$Core.resetActivityFeedError(\'' . implode('<br />', Phpfox_Error::get()) . '\');';
			}			
			echo '</script>';
			exit;
		}
		
		if ($iId = Phpfox::getService('video.process')->add($this->request()->get('val')))
		{		
			if (Phpfox::getParam('video.vidly_support'))
			{				
				$aVideo = Phpfox::getService('video')->getVideo($iId, true);

				Phpfox::getLib('cdn')->put(Phpfox::getParam('video.dir') . sprintf($aVideo['destination'], ''));

				Phpfox::getLib('database')->insert(Phpfox::getT('vidly_url'), array(
						'video_id' => $aVideo['video_id'],
						//'video_url' => rtrim(Phpfox::getParam('core.rackspace_url'), '/') . '/file/video/' . sprintf($aVideo['destination'], ''),
						'video_url' => rtrim(Phpfox::getLib('cdn')->getUrl(Phpfox::getParam('video.url') . sprintf($aVideo['destination'], ''), $aVideo['server_id'])),
						'upload_video_id' => '0'
					)
				);
				
				$mReturn = Phpfox::getService('video')->vidlyPost('AddMedia', array('Source' => array(
							//'SourceFile' => rtrim(Phpfox::getParam('core.rackspace_url'), '/') . '/file/video/' . sprintf($aVideo['destination'], ''),
							'SourceFile' => rtrim(Phpfox::getLib('cdn')->getUrl(Phpfox::getParam('video.url') . sprintf($aVideo['destination'], ''), $aVideo['server_id'])),
							'CDN' => ((Phpfox::getParam('core.cdn_service') == 's3') ? 'S3' : 'RS')
						)
					), 'vidid_' . $aVideo['video_id'] . '/'
				);								
				
				if ($bMassUploader)
				{
					echo 'window.location.href = \'' . Phpfox::permalink('video', $iId, $aVideo['title']) . '\';';
				}
				else
				{
					echo '<script type="text/javascript">'; 
					echo 'window.parent.location.href = \'' . Phpfox::permalink('video', $iId, $aVideo['title']) . '\';';
					echo '</script>';
				}
			}
			else
			{
				if ($bMassUploader)
				{
					// echo 'uploadCompleted('.$iId.', "'.$this->request()->get('fObjectId').'");';
					// echo '$(\'#js_video_process\').show();';
					Phpfox::getLib('ajax')->alert(Phpfox::getLib('image.helper')->display(array('theme' => 'ajax/add.gif', 'class' => 'v_middle')) . ' ' . Phpfox::getPhrase('video.your_video_has_successfully_been_uploaded_please_standby_while_we_convert_your_video'), Phpfox::getPhrase('video.converting_video'), 600);
					echo '$.ajaxCall(\'video.convert\', \'attachment_id=' . $iId . '&twitter_connection=' . (isset($aVals['connection']['twitter']) ? $aVals['connection']['twitter'] : '0') . '&facebook_connection=' . ((isset($aVals['connection']) && isset($aVals['connection']['facebook'])) ? $aVals['connection']['facebook'] : '0') . '&full=true&custom_pages_post_as_page=' . $this->request()->get('custom_pages_post_as_page') . '\', \'GET\');';
				}
				else
				{
					echo '<script type="text/javascript">'; 
					if (!$bIsInline)
					{
						$sAlert = Phpfox::getLib('ajax')->alert(Phpfox::getLib('image.helper')->display(array('theme' => 'ajax/add.gif', 'class' => 'v_middle')) . ' ' . Phpfox::getPhrase('video.your_video_has_successfully_been_uploaded_please_standby_while_we_convert_your_video'), Phpfox::getPhrase('video.converting_video'), 600, 150, false, true);

						echo str_replace('tb_show', 'window.parent.tb_show', str_replace('$.ajaxBox', 'window.parent.$.ajaxBox', $sAlert));					
					}
					echo 'window.parent.$.ajaxCall(\'video.convert\', \'attachment_id=' . $iId . '&twitter_connection=' . (isset($aVals['connection']['twitter']) ? $aVals['connection']['twitter'] : '0') . '&facebook_connection=' . ((isset($aVals['connection']) && isset($aVals['connection']['facebook'])) ? $aVals['connection']['facebook'] : '0') . '&' . ($bIsInline ? 'inline=true' : 'full=true') . '&custom_pages_post_as_page=' . $this->request()->get('custom_pages_post_as_page') . '\', \'GET\');';
					echo '</script>';
					// $this->url()->send('video.convert', array('id' => $iId, 'editor-id' => base64_encode($this->request()->get('editor_id')), 'video-inline' => ($bIsInline ? '1' : '0'), 'isajax' => $this->request()->get('is_ajax', '0')));
				}
			}
		}
		else 
		{
			if (!empty($_FILES['video']['tmp_name']))
			{
				Phpfox::getService('video.process')->delete($this->request()->get('video_id'));
			}
			echo '<script type="text/javascript">';			
			if (!$bIsInline)
			{
				echo 'window.parent.document.getElementById(\'js_video_upload_error\').style.display = \'block\';';
				echo 'window.parent.document.getElementById(\'js_video_upload_message\').innerHTML = \'' . implode('<br />', Phpfox_Error::get()) . '\';';
				echo 'window.parent.document.getElementById(\'js_upload_inner_form\').style.display = \'block\';';
				echo 'window.parent.document.getElementById(\'js_video_detail\').style.display = \'none\';';
				echo 'window.parent.document.getElementById(\'js_video_process\').style.display = \'none\';';
			}
			else 
			{
				// echo 'window.parent.$(\'.activity_feed_form_share_process\').hide(); window.parent.$(\'.activity_feed_form_button .button\').removeClass(\'button_not_active\'); window.parent.$bButtonSubmitActive = true;';
				echo 'window.parent.$Core.resetActivityFeedError(\'' . implode('<br />', Phpfox_Error::get()) . '\');';
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
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_frame_clean')) ? eval($sPlugin) : false);
	}
}

?>
