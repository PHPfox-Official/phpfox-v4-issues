<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Attachment
 * @version 		$Id: list.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aAttachments)}
<div class="{if $bIsAttachmentNoHeader}attachment_holder{else}attachment_holder_view{/if}">
	{if !$bIsAttachmentNoHeader}
	<div class="attachment_header_holder">
		<div class="attachment_header">{phrase var='attachment.attachments_headline'}</div>
	</div>
	{/if}
	{foreach from=$aAttachments key=iKey item=aAttachment}
		<div class="attachment_row" id="js_attachment_id_{$aAttachment.attachment_id}">				
			{if $aAttachment.link_id}
			{module name='link.display' link_id=$aAttachment.link_id attachment=true}
			{else}		
			
			<div class="attachment_row_title">
				{if $aAttachment.is_video}
				<a href="#" class="attachment_row_link no_ajax_link" onclick="$.ajaxCall('attachment.playVideo', 'attachment_id={$aAttachment.attachment_id}', 'GET'); return false;">{$aAttachment.file_name}</a> ({if !empty($aAttachment.video_duration)}{$aAttachment.video_duration}, {/if}{phrase var='attachment.views' total=$aAttachment.counter})
				{elseif !$bIsAttachmentNoHeader}			
				<a href="{url link='attachment.download' id=''$aAttachment.attachment_id''}" class="attachment_row_link no_ajax_link">{$aAttachment.file_name}</a> ({$aAttachment.file_size|filesize}, {phrase var='attachment.views' total=$aAttachment.counter})
				{else}
				<span class="attachment_row_link">{$aAttachment.file_name}</span>
				{/if}			
				{if (Phpfox::getUserParam('attachment.delete_own_attachment') && $aAttachment.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('attachment.delete_user_attachment')}
					- <a href="#" onclick="if (confirm('{phrase var='core.are_you_sure' phpfox_squote=true}')) $.ajaxCall('attachment.delete', 'id={$aAttachment.attachment_id}'); return false;">{phrase var='attachment.delete'}</a>
				{/if}
				{if $bIsAttachmentNoHeader && !$aAttachment.is_video}				
					<span class="js_attachment_remove_inline"{if !$aAttachment.is_inline} style="display:none;"{/if}>
					- <a href="#" onclick="$(this).parent().hide(); $(this).parents('li:first').find('.js_attachment_add_inline:first').show(); $.ajaxCall('attachment.inlineRemove', 'id={$aAttachment.attachment_id}&amp;text=' + encodeURIComponent(Editor.getContent()) + ''); return false;">{phrase var='attachment.remove_inline'}</a>
					</span>
					<span class="js_attachment_add_inline"{if $aAttachment.is_inline} style="display:none;"{/if}>
					{if $aAttachment.is_image}
					- <a href="#" onclick="$(this).parent().hide(); $(this).parents('li:first').find('.js_attachment_remove_inline:first').show(); Editor.insert({l}is_image: true, name: {if $aAttachment.description}$('#js_description{$aAttachment.attachment_id}').html(){else}'{$aAttachment.file_name}'{/if}, id: '{$aAttachment.attachment_id}:view', type: 'attachment', path: '{img server_id=$aAttachment.server_id title=$aAttachment.description path='core.url_attachment' file=$aAttachment.destination suffix='_view' max_width='attachment.attachment_max_medium' max_height='attachment.attachment_max_medium' return_url=true}', url: '{$sUrlPath}{$aAttachment.destination|sprintf:''}'{r}); $.ajaxCall('attachment.inline', 'id={$aAttachment.attachment_id}', 'GET'); return false;">{phrase var='attachment.use_inline'}</a>
					{else}
					- <a href="#" onclick="$(this).parent().hide(); $(this).parents('li:first').find('.js_attachment_remove_inline:first').show(); Editor.insert({l}is_image: false, name: {if $aAttachment.description}$('#js_description{$aAttachment.attachment_id}').html(){else}'{$aAttachment.file_name}'{/if}, id: '{$aAttachment.attachment_id}', type: 'attachment'{r}); $.ajaxCall('attachment.inline', 'id={$aAttachment.attachment_id}', 'GET'); return false;">{phrase var='attachment.use_inline'}</a>
					{/if}
					</span>
				{/if}			
			</div>
			<div id="js_attachment_id_content_{$aAttachment.attachment_id}">
				<div class="attachment_image">
					{if $aAttachment.is_image}
					{img thickbox=true server_id=$aAttachment.server_id title=$aAttachment.description path='core.url_attachment' file=$aAttachment.destination suffix='_thumb' max_width='attachment.attachment_max_thumbnail' max_height='attachment.attachment_max_thumbnail'}
					{elseif $aAttachment.is_video}			
					<a href="#" class="play_link" onclick="$.ajaxCall('attachment.playVideo', 'attachment_id={$aAttachment.attachment_id}', 'GET'); return false;"><span class="play_link_img">Play</span>{img server_id=$aAttachment.server_id title=$aAttachment.description path='core.url_attachment' file=$aAttachment.video_image_destination suffix='_120' max_width='attachment.attachment_max_thumbnail' max_height='attachment.attachment_max_thumbnail'}</a>
					{/if}				
				</div>
				<div class="attachment_body">				
					{if !empty($aAttachment.description)}
					<div class="attachment_body_description">	
						{$aAttachment.description}
					</div>
					{/if}					
				</div>
				<div class="clear"></div>
			</div>
			{/if}
		</div>
	{/foreach}	
</div>
{else}

{/if}