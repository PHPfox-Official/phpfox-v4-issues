<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: file.html.php 7162 2014-02-27 13:05:41Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<div id="js_video_detail"></div>
	<div id="js_video_process" style="display:none;">
		<div class="message">
			{img theme='ajax/add.gif' alt='' class='v_middle'} {phrase var='video.uploading'} {phrase var='video.item_phrase'}...			
		</div>
	</div>	

	<form method="post" action="{if Phpfox::getParam('video.convert_servers_enable')}{$sVideoServerUrl}{else}{url link='video.frame'}{/if}" id="js_video_form" enctype="multipart/form-data" target="js_upload_frame">
	{if Phpfox::getParam('video.convert_servers_enable')}
		<div><input type="hidden" name="_v_hash" value="{$sCustomVideoHash}" /></div>
	{/if}
	{if $sModule}
		<div><input type="hidden" name="val[callback_module]" value="{$sModule}" /></div>
	{/if}
	{if $iItem}
		<div><input type="hidden" name="val[callback_item_id]" value="{$iItem}" /></div>
	{/if}	
	{if PHPFOX_IS_AJAX}
		<div><input type="hidden" name="is_ajax" value="1" /></div>
	{/if}
	{if !empty($sEditorId)}
		<div><input type="hidden" name="editor_id" value="{$sEditorId}" /></div>
	{/if}	
		<div><input type="hidden" name="video_id" value="" class="js_cache_video_id" /></div>
		<div id="js_upload_inner_form">
		
			<div id="js_upload_actual_inner_form">		
				<div class="message" style="font-weight:normal;">
					<p>
						{phrase var='video.upload_copyrights_notice'}
					</p>
					<p>
						{phrase var='video.copyright_consequences_notice'}
					</p>
				</div>	
							
				<div class="main_break"></div>
				
				<div id="js_video_upload_error" style="display:none;">
					<div class="error_message" id="js_video_upload_message">
						
					</div>		
					<div class="main_break"></div>
				</div>
				
				{template file='video.block.form'}
			</div>
			
			{if isset($sMethod) && $sMethod == 'massuploader'}
			{if Phpfox::getParam('video.video_upload_service')}
				<iframe src="http://vupload.phpfox.com/?key={param var='video.video_upload_public_key'}&amp;params={$sVidlyParams}" frameborder="0" width="400" height="100"></iframe>							
			{else}
			<div><input type="hidden" name="val[method]" value="massuploader" /></div>
			<div class="table mass_uploader_table">
				<div id="swf_video_upload_button_holder">
					<div class="swf_upload_holder">
						<div id="swf_video_upload_button"></div>
					</div>
					
					<div class="swf_upload_text_holder">
						<div class="swf_upload_progress"></div>
						<div class="swf_upload_text">
							{phrase var='video.select_video'}
						</div>
					</div>				
				</div>
					<div class="extra_info">
						{phrase var='video.you_can_upload_a_sfileext_file' sFileExt=$sFileExt}
					</div>		
					<div class="extra_info">
						<strong>{phrase var='video.max_file_size_iuploadlimit' iUploadLimit=$iUploadLimit}</strong>
					</div>	
			</div>
			{/if}
			<div class="mass_uploader_link">{phrase var='video.upload_problems_try_the_basic_uploader' link=$sMethodUrl}</div>				
			{else}				
			
			<div class="table">
				<div class="table_left">
					{required}{phrase var='video.select_video'}:
				</div>
				<div class="table_right">	
					{if Phpfox::getParam('video.video_upload_service')}
						<iframe src="http://vupload.phpfox.com/?key={param var='video.video_upload_public_key'}&amp;params={$sVidlyParams}&amp;form=noflash" frameborder="0" width="400" height="100"></iframe>							
					{else}					
					<input type="file" name="video" size="40" id="js_upload_video" />					
					<div class="extra_info">
						{phrase var='video.you_can_upload_a_sfileext_file' sFileExt=$sFileExt}
					</div>		
					<div class="extra_info">
						<strong>{phrase var='video.max_file_size_iuploadlimit' iUploadLimit=$iUploadLimit}</strong>
					</div>
					{/if}
				</div>
			</div>
			{if !Phpfox::getParam('video.video_upload_service')}
			<div class="table_clear">
				<input type="submit" value="{phrase var='video.upload'}" class="button" />
			</div>
			{/if}
			{/if}
			
		</div>
	</form>	
	<div id="js_upload_frame"></div>
