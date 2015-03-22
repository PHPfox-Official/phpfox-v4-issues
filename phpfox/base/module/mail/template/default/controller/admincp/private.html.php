<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Mail
 * @version 		$Id: private.html.php 4742 2012-09-24 10:38:10Z Raymond_Benc $
 */

?>
<form method="post" action="{url link='admincp.mail.private'}">
	<div class="table_header">
		{phrase var='mail.member_search'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='mail.search'}:
		</div>
		<div class="table_right">
			{filter key='keyword'}
			<div class="extra_info"{if Phpfox::getParam('mail.threaded_mail_conversation')} style="display:none;"{/if}>
				{phrase var='mail.within'}: {filter key='type'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	{if Phpfox::getParam('mail.threaded_mail_conversation')}
	
	{else}
	<div class="table">
		<div class="table_left">
			{phrase var='mail.user_group'}:
		</div>
		<div class="table_right">
			{filter key='group'}
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='mail.show_members'}:
		</div>
		<div class="table_right">
			{filter key='status'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='mail.message_sender'}:
		</div>
		<div class="table_right">
			{filter key='sender'}
			<div class="extra_info">{phrase var='mail.use_the_exact_user_name'}</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='mail.message_receiver'}:
			
		</div>
		<div class="table_right">
			{filter key='receiver'}
				<div class="extra_info">{phrase var='mail.use_the_exact_user_name'}</div>
		</div>
		<div class="clear"></div>
	</div>
	{/if}
	<div class="table_clear">
		<input type="submit" name="search[submit]" value="{phrase var='core.submit'}" class="button" />
	</div>
</form>

<br />

{pager}
<div class="table_header">
	{phrase var='mail.messages_title'}
</div>
<table cellpadding="0" cellspacing="0" id="js_drag_drop">
	<tr>
		<th style="width:20px;"></th>
		{if !Phpfox::getParam('mail.threaded_mail_conversation')}
		<th>{phrase var='mail.from'}</th>
		<th>{phrase var='mail.to'}</th>
		<th>{phrase var='mail.subject'}</th>
		{/if}
		<th>Conversation</th>
		<th>{phrase var='mail.sent'}</th>
	</tr>
	{foreach from=$aMessages name=messages key=iKey item=aMessage}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" id="js_mail_{if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMessage.thread_id}{else}{$aMessage.mail_id}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="#" onclick="tb_show('', $.ajaxBox('mail.readMessage', 'id={if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMessage.thread_id}{else}{$aMessage.mail_id}{/if}&amp;height=400&amp;width=600')); return false;">{phrase var='mail.read_message'}</a></li>
					<li><a href="#" onclick="if (confirm('{phrase var='mail.are_you_sure' phpfox_squote=true}')) $.ajaxCall('mail.deleteMessage', 'id={if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMessage.thread_id}{else}{$aMessage.mail_id}{/if}');return false;">{phrase var='mail.delete_message'}</a></li>
					{if !Phpfox::getParam('mail.threaded_mail_conversation')}
					<li><a href="{url link='mail.compose' id=$aMessage.sender_user_id}"  title="{phrase var='mail.message_user'}">{phrase var='mail.message_sender'}</a></li>
					<li><a href="{url link='mail.compose' id=$aMessage.receiver_user_id}"  title="{phrase var='mail.message_user'}">{phrase var='mail.message_receiver'}</a></li>
					{/if}
				</ul>
			</div>
		</td>
		{if !Phpfox::getParam('mail.threaded_mail_conversation')}
		<td>{$aMessage|user:'sender_'}</td>
		<td>{$aMessage|user:'receiver_'}</td>
		<td><a href="#" onclick="tb_show('', $.ajaxBox('mail.readMessage', 'id={if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMessage.thread_id}{else}{$aMessage.mail_id}{/if}&amp;height=400&amp;width=600')); return false;">{$aMessage.subject}</a></td>		
		{else}
		<td>
			{foreach from=$aMessage.users name=mailusers item=aMailUser}{if count($aMessage.users) == $phpfox.iteration.mailusers && count($aMessage.users) > 1} &amp; {else}{if $phpfox.iteration.mailusers != 1 && count($aMessage.users) != 2}, {/if}{/if}{$aMailUser|user}{/foreach}
			<div class="extra_info">
				{$aMessage.preview|strip_tags|shorten:40:'...'}
			</div>			
		</td>
		{/if}		
		<td>{$aMessage.time_stamp|date}</td>
	</tr>
	{foreachelse}
		<tr><td colspan="5" style="text-align:center;">{phrase var='mail.no_messages_to_show'}</td></tr>
	{/foreach}
</table>
{pager}