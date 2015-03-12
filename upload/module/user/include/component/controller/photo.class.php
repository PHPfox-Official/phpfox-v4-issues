<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * User Settings
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			natio
 * @package  		Module_User
 * @version 		$Id: photo.class.php 6532 2013-08-29 11:15:56Z Raymond_Benc $
 */
class User_Component_Controller_Photo extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);		
		
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");		
		
		list($bIsRegistration, $sNextUrl) = $this->url()->isRegistration(3);
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_photo_1')) ? eval($sPlugin) : false);

		$bIsProcess = false;		
		if ($this->request()->get('req3') == 'process')
		{
			if (($sStep = $this->request()->get('step')))
			{
				$bIsProcess = true;
				$aCacheImage = unserialize(base64_decode(urldecode($sStep)));
			}
		}
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_photo_2')) ? eval($sPlugin) : false);
		if ($aVals = $this->request()->getArray('val'))
		{
			$aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'), (Phpfox::getUserParam('user.max_upload_size_profile_photo') === 0 ? null : (Phpfox::getUserParam('user.max_upload_size_profile_photo') / 1024)));
			
			if (!empty($aImage['name']))
			{
				$iUserId = Phpfox::getUserId();
				if (isset($aVals['is_iframe']) && Phpfox::isAdmin())
				{
					$iUserId = (int) $aVals['user_id'];	
				}
				
				if (($aImage = Phpfox::getService('user.process')->uploadImage($iUserId, (isset($aVals['is_iframe']) ? true : (Phpfox::getUserParam('user.force_cropping_tool_for_photos') ? false : true)))) !== false)
				{				
					if (isset($aVals['is_iframe']))
					{
						$sImage = Phpfox::getLib('image.helper')->display(array(
								'server_id' => $aImage['server_id'],
								'path' => 'core.url_user',
								'file' => $aImage['user_image'],
								'suffix' => '_75',
								'max_width' => 75,
								'max_height' => 75,
								'thickbox' => true,
								'time_stamp' => true								
							)
						);
						
						echo "<script type=\"text/javascript\">window.parent.document.getElementById('js_user_photo_" . $iUserId . "').innerHTML = '{$sImage}'; window.parent.tb_remove();</script>";
						exit;
					}
					else 
					{				
						if (Phpfox::getUserParam('user.force_cropping_tool_for_photos'))
						{					
							$this->url()->send('user.photo.process', array('step' => urlencode(base64_encode(serialize($aImage)))));
						}
						else 
						{
							if ($bIsRegistration === true)
							{
								$this->url()->send($sNextUrl, null, Phpfox::getPhrase('user.profile_photo_successfully_uploaded'));
							}
							else 
							{
								$this->url()->send('user.photo', null, Phpfox::getPhrase('user.profile_photo_successfully_uploaded'));
							}
						}						
					}
				}			
			}
		}
		
		if (isset($aVals['is_iframe']))
		{
			exit;
		}		
		
		$sImage = Phpfox::getLib('image.helper')->display(array(
				'server_id' => Phpfox::getUserBy('server_id'),
				'title' => Phpfox::getUserBy('full_name'),
				'path' => 'core.url_user',
				'file' => ($bIsProcess === true ? $aCacheImage['user_image'] : Phpfox::getUserBy('user_image')),
				'suffix' => '',
				'max_width' => 500,
				'max_height' => 500,
				'no_default' => true,
				'time_stamp' => true,
				'id' => 'user_profile_photo',				
				'class' => 'border'
			)
		);
		/*
		$sImageThumb = Phpfox::getLib('image.helper')->display(array(
				'server_id' => Phpfox::getUserBy('server_id'),
				'title' => Phpfox::getUserBy('full_name'),
				'path' => 'core.url_user',
				'file' => Phpfox::getUserBy('user_image'),
				'suffix' => '_120' . (Phpfox::getParam('core.keep_non_square_images') ? '_square' : ''),
				'max_width' => 120,
				'max_height' => 120,
				'no_default' => true,
				'time_stamp' => true,
				'class' => 'border'	
			)
		);		
		*/
		$sImageAvatar = Phpfox::getLib('image.helper')->display(array(
				'server_id' => Phpfox::getUserBy('server_id'),
				'title' => Phpfox::getUserBy('full_name'),
				'path' => 'core.url_user',
				'file' => Phpfox::getUserBy('user_image'),
				'suffix' => '_50_square',
				'max_width' => 75,
				'max_height' => 75,
				'no_default' => true,
				'time_stamp' => true,
				'class' => 'border'
			)
		);		
		
		$sPageTitle = ($bIsRegistration ? Phpfox::getPhrase('user.upload_profile_picture') : Phpfox::getPhrase('user.edit_profile_picture'));		
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_photo_3')) ? eval($sPlugin) : false);
		$this->template()->setTitle($sPageTitle)
			->setBreadcrumb($sPageTitle)
			->setFullSite()
			->setPhrase(array(
					'core.select_a_file_to_upload'
				)
			)				
			->setHeader(array(
					'progress.js' => 'static_script',
					'<script type="text/javascript">$Behavior.changeUserPhoto = function(){ if ($Core.exists(\'#js_photo_form_holder\')) { oProgressBar = {holder: \'#js_photo_form_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: false, max_upload: 1, total: 1, frame_id: \'js_upload_frame\', file_id: \'image\'}; $Core.progressBarInit(); } }</script>'					
				)
			)
			->assign(array(
					'sProfileImage' => $sImage,
					// 'sImageThumb' => $sImageThumb,
					'sImageAvatar' => $sImageAvatar,
					'sProfileImage2' => str_replace('id="user_profile_photo"', 'id="js_profile_photo_preview"', $sImage),
					'bIsRegistration' => $bIsRegistration,
					'sNextUrl' => $this->url()->makeUrl($sNextUrl),
					'bIsProcess' => $bIsProcess,
					'sCacheImage' => ($bIsProcess ? $aCacheImage['user_image'] : ''),
					'iMaxFileSize' => (Phpfox::getUserParam('user.max_upload_size_profile_photo') === 0 ? null : ((Phpfox::getUserParam('user.max_upload_size_profile_photo') / 1024) * 1048576))
				)
			);
		
		if ((Phpfox::getUserBy('user_image') && !empty($sImage)) || ($bIsProcess === true && !empty($sImage)))
		{
			preg_match("/height=\"(.*?)\" width=\"(.*?)\"/", $sImage, $aMatches);
			if (!isset($aMatches[1]))
			{
				preg_match("/src=\"(.*?)\"/", $sImage, $aMatches);

				$aImage = getimagesize($aMatches[1]);
				$iHeight = $aImage[1];
				$iWidth = $aImage[0];
			}
			else
			{
				$iHeight = $aMatches[1];
				$iWidth = $aMatches[2];
			}
			
			$this->template()->setHeader('cache', array(
						'jquery/plugin/jquery.crop.js' => 'static_script',
						'jquery/plugin/imgnotes/jquery.imgareaselect.js' => 'static_script',
						'imgareaselect-default.css' => 'style_css',
						'<script type="text/javascript">$Behavior.initPhotoCrop = function(){$Core.photo_crop.init({width: 75, height: 75, image_width: ' . $iWidth . ', image_height: ' . $iHeight . '}); };</script>'		
					)
				)		
				->assign(array(
						'iImageHeight' => $iHeight,
						'iImageWidth' => $iWidth
					)
				);
		}
	}
}

?>