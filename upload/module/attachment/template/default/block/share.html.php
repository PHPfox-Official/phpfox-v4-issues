<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: share.html.php 6875 2013-11-11 18:56:02Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">$Behavior.loadAttachmentStaticFiles = function(){l}$Core.loadStaticFile('{jscript file='share.js' module='attachment'}');{r}</script>
<div class="global_attachment">
	<div class="global_attachment_header">
		<div class="global_attachment_manage">
			<a class="border_radius_4{if !isset($aForms.total_attachment)} is_not_active{/if}" href="#" onclick="$('.js_attachment_list').slideToggle(); return false;">{phrase var='attachment.manage_attachments'}</a>
		</div>		
		<ul class="global_attachment_list">	
			<li class="global_attachment_title">{phrase var='attachment.insert'}:</li>
			<li><a href="#" onclick="return $Core.shareInlineBox(this, '{$aAttachmentShare.id}', {if $aAttachmentShare.inline}true{else}false{/if}, 'attachment.add', 500, '&amp;category_id={$aAttachmentShare.type}&amp;attachment_custom=photo');" class="js_global_position_photo js_hover_title">{img theme='feed/photo.png' class='v_middle'}<span class="js_hover_info">{phrase var='attachment.insert_a_photo'}</span></a></li>
			{if Phpfox::isModule('link')}
			<li><a href="#" onclick="return $Core.shareInlineBox(this, '{$aAttachmentShare.id}', {if $aAttachmentShare.inline}true{else}false{/if}, 'link.attach', 600, '&amp;category_id={$aAttachmentShare.type}');" class="js_hover_title">{img theme='feed/link.png' class='v_middle'}<span class="js_hover_info">{phrase var='attachment.attach_a_link'}</span></a></li>
			{/if}
			{if Phpfox::isModule('video') && Phpfox::getParam('video.allow_video_uploading')}
			<li><a href="#" onclick="return $Core.shareInlineBox(this, '{$aAttachmentShare.id}', {if $aAttachmentShare.inline}true{else}false{/if}, 'attachment.add', 500, '&amp;category_id={$aAttachmentShare.type}&amp;attachment_custom=video');" class="js_hover_title">{img theme='feed/video.png' class='v_middle'}<span class="js_hover_info">{phrase var='attachment.insert_a_video'}</span></a></li>
			{/if}
			{if !isset($bNoAttachaFile)}
			<li><a href="#" onclick="return $Core.shareInlineBox(this, '{$aAttachmentShare.id}', {if $aAttachmentShare.inline}true{else}false{/if}, 'attachment.add', 500, '&amp;category_id={$aAttachmentShare.type}');" class="js_hover_title">{img theme='misc/application_add.png' class='v_middle'}<span class="js_hover_info">{phrase var='attachment.attach_a_file'}</span></a></li>
			{/if}
			{if Phpfox::isModule('emoticon')}
			<li><a href="#" onclick="return $Core.shareInlineBox(this, '{$aAttachmentShare.id}', {if $aAttachmentShare.inline}true{else}false{/if}, 'emoticon.preview', 400, '&amp;editor_id=' + Editor.getId());" class="js_hover_title">{img theme='editor/emoticon.png' class='v_middle'}<span class="js_hover_info">{phrase var='attachment.insert_emoticon'}</span></a></li>
			{/if}
		</ul>
		<div class="clear"></div>	
		<div class="global_attachment_list_holder"></div>
	</div>
</div>
<div class="js_attachment_list"{if !isset($aForms.total_attachment)} style="display:none;"{/if}>
	<h3>{phrase var='attachment.attachments_display'}</h3>
	<div class="js_attachment_list_holder"></div>
	{if isset($aForms.total_attachment) && $aForms.total_attachment && isset($aAttachmentShare.edit_id)}
	{module name='attachment.list' sType=$aAttachmentShare.type iItemId=$aAttachmentShare.edit_id attachment_no_header=true}
	{else}
	<div class="extra_info t_center">
		{phrase var='attachment.no_attachments_available'}
	</div>
	{/if}
</div>
