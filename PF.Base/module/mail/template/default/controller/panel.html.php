{if $aMessages}
<ul class="panel_rows">
	{foreach from=$aMessages item=aMail}
	<li><a onclick="$(this).removeClass('is_new');" href="{url link='mail.thread' id=$aMail.thread_id}" class="popup {if $aMail.viewer_is_new} is_new{/if}" data-custom-class="mail_thread">
			<div class="panel_rows_image">
				{if $aMail.user_id == Phpfox::getUserId()}
				{img user=$aMail suffix='_50_square' max_width=50 max_height=50 no_link=true}
				{else}
				{if (isset($aMail.user_id) && !empty($aMail.user_id))}
				{img user=$aMail suffix='_50_square' max_width=50 max_height=50 no_link=true}
				{/if}
				{/if}
			</div>
			<div class="panel_rows_content">
				<div class="panel_focus">
					{foreach from=$aMail.users name=mailusers item=aMailUser}
						<span>{$aMailUser.full_name|clean|shorten:35:'...'}</span>
					{/foreach}
				</div>
				<div class="panel_rows_preview">
					{$aMail.preview|clean|shorten:40:'...'|cleanbb}
				</div>
				<div class="panel_rows_time">
					{$aMail.time_stamp|convert_time}
				</div>
			</div>
		</a>
		<div class="panel_rows_action">
			<i onclick="$.ajaxCall('mail.delete', 'id={$aMail.thread_id}', 'GET'); $(this).parents('li:first').slideUp('fast');" class="fa fa-remove js_hover_title"><span class="js_hover_info">Archive</span></i>
		</div>
	</li>
	{/foreach}
</ul>
{else}
<div class="message">
	No new messages
</div>
{/if}
<div class="panel_actions">
	<a href="{url link='mail.compose'}" class="popup js_hover_title"><i class="fa fa-pencil-square"></i><span class="js_hover_info">Compose</span></a>
	<a href="#" class="js_hover_title no_ajax" onclick="$('body').toggleClass('mail_in_shift_mode'); return false;"><i class="fa fa-archive"></i><span class="js_hover_info">Archive Message(s)</span></a>
</div>