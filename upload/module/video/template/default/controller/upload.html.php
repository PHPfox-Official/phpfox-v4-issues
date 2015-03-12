<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: upload.html.php 2526 2011-04-13 18:15:51Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if PHPFOX_IS_AJAX && !$bHideSwitchMenu}
<div class="main_break"></div>
<div class="label_flow_menu">	
	<ul>
		<li class="label_flow_menu_active"><a href="#video.upload{if defined('PHPFOX_GROUP_VIEW')}?bIsGroup=true{/if}">{phrase var='video.add_a_video'}</a></li>
		<li class="last"><a href="#video.share{if defined('PHPFOX_GROUP_VIEW')}?bIsGroup=true{/if}">{phrase var='video.share_a_video'} </a></li>
	</ul>
	<br class="clear" />
</div>	
<div class="labelFlowContent label_flow" id="js_video_content">
{/if}	
	<div id="js_video_detail"></div>
	<div id="js_video_process" style="display:none;">
		<div class="message">
			{img theme='ajax/small.gif' alt='' class='v_middle'} <span id="js_upload_command">{phrase var='video.uploading'}</span>: <span id="js_upload_file_name"></span>
		</div>
	</div>	
	
	<form method="post" action="{url link='video.frame'}" id="js_video_form" enctype="multipart/form-data" target="js_upload_frame">
	{if $sModule}
		<div><input type="hidden" name="module" value="{$sModule}" /></div>
	{/if}
	{if $iItem}
		<div><input type="hidden" name="item" value="{$iItem}" /></div>
	{/if}	
	{if PHPFOX_IS_AJAX}
		<div><input type="hidden" name="is_ajax" value="1" /></div>
	{/if}
	{if !empty($sEditorId)}
		<div><input type="hidden" name="editor_id" value="{$sEditorId}" /></div>
	{/if}
	{if defined('PHPFOX_GROUP_VIEW')}
		<div><input type="hidden" name="bIsGroup" value="1" /></div>
	{/if}
		<div><input type="hidden" name="video_id" value="" class="js_cache_video_id" /></div>
		<div id="js_upload_inner_form">
			<div class="message" style="font-weight:normal;" id="copyright_notice">
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
			
			<div class="table">
				<div class="table_left">
					{if $sMethod != 'massuploader'}
					{required}{phrase var='video.select_video'}:
					{/if}
				</div>
				<div class="table_right">				
					
						<div id="method_massuploader" class="upload_method" style="display:none;">
							<div id="swfUploaderContainer">
								<div id="swfUploaderButton"></div>
							</div>
							<span id="swfUploadText">{phrase var='video.select_video'}</span>
							<div id="js_progress_bar"></div>								
						</div>
					
					
						<div id="method_simple" class="upload_method" style="display:none;">
							<input type="file" name="video" size="40" id="js_upload_video" />			
							<div><input id="hidden_input_method" type="hidden" name="method" value="massuploader"></div>
						</div>
						
						<br />

					<script type="text/javascript">
						function switchMethod(sMethod)
						{left_curly}
							$('.upload_method').hide();
							$('#method_'+sMethod).show();
							$('#hidden_input_method').val(sMethod);
						{right_curly}
						{if isset($sMethod)}
							switchMethod('{$sMethod}');
						{/if}
					</script>
					<div class="extra_info">
						{phrase var='video.you_can_upload_a_sfileext_file' sFileExt=$sFileExt}
					</div>		
					<div class="extra_info">
						<strong>{phrase var='video.max_file_size_iuploadlimit' iUploadLimit=$iUploadLimit}</strong>
					</div>
					{if isset($sMethod) && $sMethod == 'massuploader' && !PHPFOX_IS_AJAX}
					<div class="p_10">
						{phrase var='core.upload_problems' link=$sMassPath}
					</div>			
					{/if}		
				</div>
			</div>
			<div class="table_clear">
				<input type="submit" value="Upload" class="button" />
			</div>
		</div>
	</form>	
	<div id="js_upload_frame"></div>
{if PHPFOX_IS_AJAX && !$bHideSwitchMenu}
</div>
{/if}