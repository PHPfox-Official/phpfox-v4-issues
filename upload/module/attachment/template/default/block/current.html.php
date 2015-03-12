{foreach from=$aItems key=iKey item=aItem name=attachment}
	<div class="sJsAttachmentLi{$aItem.attachment_id} {if is_int($phpfox.iteration.attachment/2)}row1{else}row2{/if}{if $phpfox.iteration.attachment == 1} row_first{/if}">
		<a href="#" class="sJsDropMenu">{$aItem.file_name}</a> ({$aItem.file_size|filesize})
		<div class="link_menu dropContent">
				<ul>
					<li>
						<div class="p_10">
							<form method="post" action="#" id="js_attachment_form_{$aItem.attachment_id}">
								<input size="18" type="text" name="info" value="{if $aItem.description}{$aItem.description}{else}{phrase var='attachment.add_description'}{/if}" onclick="if(this.value=='{phrase var='attachment.add_description' phpfox_squote=true}')this.value='';" onblur="if(this.value=='')this.value='{phrase var='attachment.add_description' phpfox_squote=true}';" /> <input type="button" class="button" value="{phrase var='attachment.add'}" onclick="$('#js_attachment_form_{$aItem.attachment_id}').ajaxCall('attachment.updateDescription', 'iId={$aItem.attachment_id}'); $('.dropContent').hide(); return false;" />
							</form>
						</div>
					</li>
					{if empty($sAttachmentInput)}
					{if $bCanUseInline && $aItem.is_inline}
					<li><a href="#" onclick="Editor.remove({literal}{{/literal}id: '{$aItem.attachment_id}:view', type: 'attachment'{literal}}{/literal}); $('.dropContent').hide(); $.ajaxCall('attachment.inlineRemove', 'id={$aItem.attachment_id}'); return false;">{phrase var='attachment.remove_inline'}</a></li>
					{else}
					{if $aItem.is_image}
					<li><a href="#" onclick="Editor.insert({literal}{{/literal}is_image: true, name: {if $aItem.description}$('#js_description{$aItem.attachment_id}').html(){else}'{$aItem.file_name}'{/if}, id: '{$aItem.attachment_id}:view', type: 'attachment', path: '{img server_id=$aItem.server_id title=$aItem.description path='core.url_attachment' file=$aItem.destination suffix='_view' max_width='attachment.attachment_max_medium' max_height='attachment.attachment_max_medium' return_url=true}', url: '{$sUrlPath}{$aItem.destination|sprintf:''}'{literal}}{/literal});$('.dropContent').hide(); {if $bCanUseInline} $.ajaxCall('attachment.inline', 'id={$aItem.attachment_id}');{/if} return false;">{phrase var='attachment.use_inline_full_image'}</a></li>
					<li><a href="#" onclick="Editor.insert({literal}{{/literal}is_image: true, name: {if $aItem.description}$('#js_description{$aItem.attachment_id}').html(){else}'{$aItem.file_name}'{/if}, id: '{$aItem.attachment_id}:thumb', type: 'attachment', path: '{img server_id=$aItem.server_id title=$aItem.description path='core.url_attachment' file=$aItem.destination suffix='_thumb' max_width='attachment.attachment_max_thumbnail' max_height='attachment.attachment_max_thumbnail' return_url=true}'{literal}}{/literal}); $('.dropContent').hide();{if $bCanUseInline} $.ajaxCall('attachment.inline', 'id={$aItem.attachment_id}');{/if} return false;">{phrase var='attachment.use_inline_thumbnail'}</a></li>
					{else}
					<li><a href="#" onclick="Editor.insert({literal}{{/literal}is_image: false, name: {if $aItem.description}$('#js_description{$aItem.attachment_id}').html(){else}'{$aItem.file_name}'{/if}, id: '{$aItem.attachment_id}', type: 'attachment'{literal}}{/literal}); $('.dropContent').hide();{if $bCanUseInline} $.ajaxCall('attachment.inline', 'id={$aItem.attachment_id}');{/if} return false;">{phrase var='attachment.use_inline'}</a></li>
					{/if}
					{/if}
					{else}
					<li><a href="#" onclick="$('#{$sAttachmentInput}').val('{img server_id=$aItem.server_id path='core.url_attachment' file=$aItem.destination suffix='' max_width='attachment.attachment_max_medium' max_height='attachment.attachment_max_medium' return_url=true}').focus().blur(); tb_remove(); return false;">{phrase var='attachment.use_image'}</a></li>
					{/if}
					{if (Phpfox::getUserParam('attachment.delete_own_attachment') && $aItem.user_id == Phpfox::getUserId()) || Phpfox::getUserParam('attachment.delete_user_attachment')}
					<li><a href="#" onclick="if (confirm('{phrase var='core.are_you_sure' phpfox_squote=true}')) $.ajaxCall('attachment.delete', 'id={$aItem.attachment_id}'); return false;">{phrase var='attachment.delete'}</a></li>
					{/if}
				</ul>
		</div>
		{if $aItem.is_image}
		<div class="p_4">
			<div class="go_left">
				{img server_id=$aItem.server_id title=$aItem.description path='core.url_attachment' file=$aItem.destination suffix='_thumb' max_width='attachment.attachment_max_thumbnail' max_height='attachment.attachment_max_thumbnail'}
			</div>
			<div id="js_description{$aItem.attachment_id}">{$aItem.description}</div>
			<div class="clear"></div>
		</div>
		{/if}		
	</div>
{foreachelse}
<div class="extra_info">
	{phrase var='attachment.no_attachments_available'}
</div>
{/foreach}
