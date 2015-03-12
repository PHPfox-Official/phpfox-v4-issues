<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: latest.html.php 5155 2013-01-17 12:55:36Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aMessages)}
<ul id="js_new_message_holder_drop">
{foreach from=$aMessages name=messages item=aMessage}
	<li id="js_mail_read_{if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMessage.thread_id}{else}{$aMessage.mail_id}{/if}" class="holder_notify_drop_data{if $phpfox.iteration.messages == 1} first{/if}"><a href="{if Phpfox::getParam('mail.threaded_mail_conversation')}{url link='mail.thread' id=$aMessage.thread_id'}{else}{url link='mail.view.'$aMessage.mail_id''}{/if}" title="{$aMessage.preview|clean}" class="main_link{if $aMessage.viewer_is_new} is_new{/if}">
			<div class="drop_data_image">
				{if !empty($aMessage.user_id)}
				    {img user=$aMessage max_width='50' max_height='50' suffix='_50_square' no_link=true}
				{/if}
			</div>
			<div class="drop_data_content">
				<div class="drop_data_user">
					{if empty($aMessage.user_id)}
					{param var='core.site_title'}
					{else}
					{$aMessage.full_name|clean}
					{/if}
				</div>
				{if Phpfox::getParam('mail.threaded_mail_conversation')}
				{$aMessage.preview|clean|shorten:40:'...'|cleanbb}
				{else}
				{$aMessage.subject|clean}
				{/if}
				<div class="drop_data_time">
					{$aMessage.time_stamp|convert_time}
				</div>
			</div>
			<div class="clear"></div>
		</a>
	</li>
{/foreach}
</ul>
{if Phpfox::getParam('mail.update_message_notification_preview')}
{literal}
<script type="text/javascript">	
	var $iTotalMessages = parseInt($('#js_total_new_messages').html());
	var $iNewTotalMessages = 0;
	$('#js_new_message_holder_drop li').each(function()
	{
		$iNewTotalMessages++;
		$aMailOldHistory[$(this).attr('id').replace('js_mail_read_', '')] = true;		
	});
	
	$iTotalMessages = parseInt(($iTotalMessages - $iNewTotalMessages));
	if ($iTotalMessages < 0)
	{
		$iTotalMessages = 0;
	}
	
	if ($iTotalMessages === 0)
	{
		$('#js_total_new_messages').html('').hide();	
	}
	else
	{
		$('#js_total_new_messages').html($iTotalMessages);
	}	
</script>
{/literal}
{/if}
{else}
<div class="drop_data_empty">
	{phrase var='mail.no_new_messages'}
</div>
{/if}
<a href="{url link='mail'}" class="holder_notify_drop_link">{phrase var='mail.see_all_messages'}</a>