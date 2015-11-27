<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: entry.html.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="js_notification_id_{$aNotification.notification_id} {if is_int($phpfox.iteration.notifications/2)}row1{else}row2{/if}{if $phpfox.iteration.notifications == 1} row_first{/if}{if $bNotifyIsInline && !$aNotification.is_seen} row_focus{/if}">
	{if $aNotification.user_id > 0 || !empty($aNotification.item_image)}
	<div style="float:left;">
	{if !empty($aNotification.item_image)}
	<a href="{$aNotification.link}">
		{if $bNotifyIsInline}
			{img server_id=$aNotification.item_server_id path=$aNotification.path file=$aNotification.item_image suffix=$aNotification.suffix max_width=20 max_height=20 class='v_middle'}
		{else}
			{img server_id=$aNotification.item_server_id path=$aNotification.path file=$aNotification.item_image suffix=$aNotification.suffix max_width=50 max_height=50 class='v_middle'}
		{/if}
	</a>
	{else}	
	{if $bNotifyIsInline}
		{img user=$aNotification suffix='_50_square' max_width=20 max_height=20 class='v_middle'} 
	{else}
		{img user=$aNotification suffix='_50_square' max_width=50 max_height=50 class='v_middle'} 
	{/if}
	{/if}
	</div>
	<div style="margin-left:{if $bNotifyIsInline}30{else}60{/if}px;">
	{/if}
		{$aNotification.message}
		{if !$bNotifyIsInline}
		<div style="margin:5px 0px 0px 10px;">
			<div class="extra_info" style="font-size:8pt;">
				{$aNotification.time_stamp|date:'core.global_update_time'} - <a href="{$aNotification.link}">{phrase var='notification.view'}</a> &middot; <a href="#" onclick="$.ajaxCall('notification.hide', 'id={$aNotification.notification_id}'); return false;">{phrase var='notification.hide'}</a>
			</div>
		</div>
		{/if}
	{if $aNotification.user_id > 0 || !empty($aNotification.item_image)}
	</div>
	<div class="clear"></div>
	{/if}
	{if $bNotifyIsInline}
	<div class="extra_info" style="font-size:8pt; margin-top:4px;">
		{$aNotification.time_stamp|date:'core.global_update_time'} - <a href="{$aNotification.link}">{phrase var='notification.view'}</a> &middot; <a href="#" onclick="$.ajaxCall('notification.hide', 'id={$aNotification.notification_id}'); return false;">{phrase var='notification.hide'}</a>		
	</div>
	{/if}
</div>