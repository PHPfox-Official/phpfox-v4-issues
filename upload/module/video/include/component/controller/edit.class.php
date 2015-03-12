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
 * @version 		$Id: edit.class.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
class Video_Component_Controller_Edit extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		$bIsEdit = false;
		$sStep = $this->request()->get('step', false);
		$sAction = $this->request()->get('req3', false);
		$aCallback = false;		
		
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aVideo = Phpfox::getService('video')->getForEdit($iId)))
			{
				$bIsEdit = true;
			}
		}	
		
		if ($bIsEdit === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('video.unable_to_edit_this_video'));
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (($mReturn = Phpfox::getService('video.process')->update($aVideo['video_id'], $aVals)))
			{
				if (isset($aVals['actions']))
				{
					$this->url()->send('video.edit.' . $aVals['action'], array('id' => $aVideo['video_id']), Phpfox::getPhrase('video.video_successfully_updated'));
				}
				else 
				{					
					$this->url()->permalink('video', $aVideo['video_id'], $aVideo['title'], true, Phpfox::getPhrase('video.video_successfully_updated'));
				}
			}
			
			$sStep = (isset($aVals['step']) ? $aVals['step'] : '');
			$sAction = (isset($aVals['action']) ? $aVals['action'] : '');
		}
		
		if ($aVideo['module_id'] != 'video' && Phpfox::hasCallback($aVideo['module_id'], 'uploadVideo'))
		{
			$aCallback = Phpfox::callback($aVideo['module_id'] . '.uploadVideo', $aVideo['item_id']);			
		}		
		
		$sVideoMessage = '';
		if (($sVideoMessage = Phpfox::getLib('session')->get('video_add_message')))
		{
			Phpfox::getLib('session')->remove('video_add_message');
		}		
		
		$this->template()->buildPageMenu('js_video_block', 
			array(
				'detail' => Phpfox::getPhrase('video.video_details'),
				'photo' => Phpfox::getPhrase('video.photo')
			), 
			array(
				'link' => $this->url()->permalink('video', $aVideo['video_id'], $aVideo['title']),
				'phrase' => Phpfox::getPhrase('video.view_this_video')
			)
		);		

		$iMaxFileSize = (Phpfox::getUserParam('video.max_size_for_video_photos') === 0 ? null : ((Phpfox::getUserParam('video.max_size_for_video_photos')  / 1024) * 1048576));
		$this->template()->setTitle(Phpfox::getPhrase('video.editing_video') . ': ' . $aVideo['title'])
			->setBreadcrumb(Phpfox::getPhrase('video.videos'), $this->url()->makeUrl('video'))
			->setBreadcrumb(Phpfox::getPhrase('video.editing_video') . ': ' . $aVideo['title'], $this->url()->makeUrl('video.edit', array('id' => $iId)), true)
			->setPhrase(array(
					'core.select_a_file_to_upload'
				)
			)				
			->setHeader(array(
					'video.js' => 'module_video',
					'edit.js' => 'module_video',
					'<script type="text/javascript">$Behavior.videoEditCategory = function(){var aCategories = explode(\',\', \'' . $aVideo['categories'] . '\'); for (i in aCategories) { $(\'#js_mp_holder_\' + aCategories[i]).show(); $(\'#js_mp_category_item_\' + aCategories[i]).attr(\'selected\', true); }}</script>',
					'progress.js' => 'static_script',
					'<script type="text/javascript">$Behavior.videoProgressBarSettings = function(){ oProgressBar = {holder: \'#js_video_block_photo_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: false, max_upload: 1, total: 1, frame_id: \'js_upload_frame\', file_id: \'image\'}; $Core.progressBarInit();}</script>'					
				)
			)
			->assign(array(
					'aCallback' => $aCallback,
					'sStep' => $sStep,
					'sVideoMessage' => $sVideoMessage,
					'sAction' => ($sAction ? $sAction : 'detail'),
					'sCategories' => Phpfox::getService('video.category')->get(),
					'aForms' => $aVideo,
					'iMaxFileSize' => $iMaxFileSize,
					'sOnClickDeleteImage' => "if (confirm('".Phpfox::getPhrase('video.are_you_sure')."')) { $('#js_submit_upload_image').show(); $('#js_video_upload_image').show(); $('#js_video_current_image').remove(); $.ajaxCall('video.deleteImage', 'id=".$aVideo['video_id']."'); } return false;",
					'iMaxFileSize_filesize' => Phpfox::getLib('phpfox.file')->filesize($iMaxFileSize)
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_edit_clean')) ? eval($sPlugin) : false);
	}
}

?>