{if $aNotifications}
<ul class="panel_rows">
	{foreach from=$aNotifications name=notifications item=aNotification}
	<li><a href="{$aNotification.link}" class="{if !$aNotification.is_seen} is_new{/if}">
			<div class="panel_rows_image">
				{if !isset($aNotification.no_profile_image)}
				{img user=$aNotification max_width='50' max_height='50' suffix='_50_square' no_link=true}
				{/if}
			</div>
			<div class="panel_rows_content">
				<div class="panel_focus">{$aNotification.message}</div>
				<div class="panel_rows_time">
					{$aNotification.time_stamp|convert_time}
				</div>
			</div>
		</a>
	</li>
	{/foreach}
</ul>
<div class="panel_actions">
	<a href="#" onclick="$('.js_notification_trash > i').removeClass('fa-trash').addClass('fa-circle-o-notch').addClass('fa-spin'); $(this).ajaxCall('notification.removeAll'); return false;" class="js_hover_title js_notification_trash"><i class="fa fa-trash"></i><span class="js_hover_info">Remove all notifications</span></a>
</div>
{else}
<div class="message">
	No new notifications
</div>
{/if}