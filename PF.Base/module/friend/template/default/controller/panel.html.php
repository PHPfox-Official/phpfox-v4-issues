{if $aFriends}
<ul class="panel_rows">
	{foreach from=$aFriends name=notifications item=aNotification}
	<li id="drop_down_{$aNotification.request_id}">
		<div href="{url link=$aNotification.user_name}" class="panel_row {if !$aNotification.is_seen} is_new{/if}">
			<div class="panel_rows_image">
				{img user=$aNotification max_width='50' max_height='50' suffix='_50_square'}
			</div>
			<div class="panel_rows_content">
				<div class="panel_focus">{$aNotification|user}</div>
				<div class="panel_rows_time">
					{$aNotification.mutual_friends.total} mutual friends
				</div>
				<div class="panel_action">
					<span onclick="$.ajaxCall('friend.processRequest', 'type=yes&amp;user_id={$aNotification.user_id}&amp;request_id={$aNotification.request_id}&amp;inline=true'); return false;">Confirm</span>
				</div>
			</div>
		</div>
	</li>
	{/foreach}
</ul>
{else}
<div class="message">
	No new friend requests
</div>
{/if}