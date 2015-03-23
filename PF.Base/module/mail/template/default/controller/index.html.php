<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Mail
 * @version 		$Id: index.html.php 6749 2013-10-08 13:04:25Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{if $bIsInLegacyView}
<div class="message">
	{phrase var='mail.you_are_currently_viewing_our_legacy_inbox'}
</div>
{/if}

{if Phpfox::getParam('mail.threaded_mail_conversation')}

{else}
{if $iMailSpaceUsed == 100}
	<div class="error_message">
		 {phrase var='mail.you_have_reached_your_mail_box_capacity_and_wont_be_able'}
	</div>
{else}
	{if (Phpfox::getUserParam('mail.mail_box_warning') <= $iMailSpaceUsed) && $iMailSpaceUsed > 0}
		<div class="error_message">
			 {phrase var='mail.you_are_approaching_your_mail_box_limit', total=$iMailSpaceUsed}
		</div>
	{/if}
{/if}
{/if}

{if $iFolder}
<div style="position:absolute; right:0px; top:-15px;">
	<a href="#" onclick="if (confirm('{phrase var='mail.are_you_sure'}')) {l} $.ajaxCall('mail.deleteFolder', 'id={$iFolder}'); {r} return false;">{phrase var='mail.delete_this_list'}</a>
</div>
{/if}
{if count($aMails)}
{foreach from=$aMails item=aMail name=mail}
<div id="js_message_{if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMail.thread_id}{else}{$aMail.mail_id}{/if}" class="mail_holder{if !$bIsSentbox && !$bIsTrash && $aMail.viewer_is_new} mail_is_new{/if}">
	<div class="mail_moderation">
		<a href="#{if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMail.thread_id}{else}{$aMail.mail_id}{/if}" class="moderate_link" rel="mail">{phrase var='mail.moderate'}</a>		
	</div>
	<div class="mail_image">
		{if $aMail.user_id == Phpfox::getUserId()}
			{img user=$aMail suffix='_50_square' max_width=50 max_height=50}
		{else}
			{if (isset($aMail.user_id) && !empty($aMail.user_id))}
				{img user=$aMail suffix='_50_square' max_width=50 max_height=50}
			{/if}
		{/if}
	</div>
	<div class="mail_content">
		{if !$bIsInLegacyView}
		<div class="mail_action">
			<ul>
				<li>{$aMail.time_stamp|convert_time}</li>
				{if $bIsSentbox && isset($aMail.users_is_read) && count($aMail.users_is_read)}
				<li class="js_hover_title">
					{img theme='misc/email_read.png' class='v_middle'} 
					<span class="js_hover_info">{phrase var='mail.message_has_been_read'}</span>
				</li>
				{/if}
				{if !$bIsSentbox && !$bIsTrash}				
				<li class="js_mail_mark_read"{if !$aMail.viewer_is_new} style="display:none;"{/if}><a href="#" class="mail_read js_hover_title" onclick="$.ajaxCall('mail.toggleRead', 'id={if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMail.thread_id}{else}{$aMail.mail_id}{/if}', 'GET'); $(this).parent().hide(); $(this).parents('ul:first').find('.js_mail_mark_unread').show(); $(this).parents('.mail_holder:first').removeClass('mail_is_new'); return false;"><span class="js_hover_info">{phrase var='mail.mark_as_read'}</span></a></li>
				<li class="js_mail_mark_unread"{if $aMail.viewer_is_new} style="display:none;"{/if}><a href="#" class="mail_read js_hover_title" onclick="$.ajaxCall('mail.toggleRead', 'id={if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMail.thread_id}{else}{$aMail.mail_id}{/if}', 'GET'); $(this).parent().hide(); $(this).parents('ul:first').find('.js_mail_mark_read').show(); $(this).parents('.mail_holder:first').addClass('mail_is_new'); return false;"><span class="js_hover_info">{phrase var='mail.mark_as_unread'}</span></a></li>
				{/if}
				{if Phpfox::getParam('mail.threaded_mail_conversation') && $bIsTrash}
				
				{else}
				<li><a href="#" class="mail_delete js_hover_title" onclick="$.ajaxCall('mail.delete', 'id={if Phpfox::getParam('mail.threaded_mail_conversation')}{$aMail.thread_id}{else}{$aMail.mail_id}{/if}{if $bIsSentbox}&amp;type=sentbox{/if}{if $bIsTrash}&amp;type=trash{/if}', 'GET'); return false;"><span class="js_hover_info">{if Phpfox::getParam('mail.threaded_mail_conversation')}Archive{else}{phrase var='mail.delete'}{/if}</span></a></li>
				{/if}
			</ul>
			<div class="clear"></div>
		</div>	
		{/if}
		{if Phpfox::getParam('mail.threaded_mail_conversation')}
		<a href="{url link='mail.thread' id=$aMail.thread_id}{if $bIsSentbox}view_sent/{/if}" class="mail_link">		
			{foreach from=$aMail.users name=mailusers item=aMailUser}{if count($aMail.users) == $phpfox.iteration.mailusers && count($aMail.users) > 1} &amp; {else}{if $phpfox.iteration.mailusers != 1 && count($aMail.users) != 2}, {/if}{/if}{$aMailUser.full_name|clean|shorten:35:'...'}{/foreach}			
		</a>		
		{else}
		<a href="{url link='mail.view' id=$aMail.mail_id}" class="mail_link">			
			{if $aMail.parent_id}{phrase var='mail.re'}: {/if}{$aMail.subject|clean|shorten:35:'...'}
		</a>
		{/if}
		
		{if !Phpfox::getParam('mail.threaded_mail_conversation')}
		<div class="extra_info">
			{if $aMail.user_id == Phpfox::getUserId()}
				{phrase var='mail.to'}: {phrase var='mail.you'}
			{else}
				{if $bIsSentbox}
				{phrase var='mail.to'}: {$aMail|user:'':'':50}
				{else}
				{phrase var='mail.from'}: {if empty($aMail.user_id)}{param var='core.site_title'}{else}{$aMail|user:'':'':50}{/if}
				{/if}
			{/if}	
		</div>
		{/if}
		
		{if Phpfox::getParam('mail.show_preview_message')}
		<div class="mail_preview">
			{if isset($aMail.last_user_id) && $aMail.last_user_id == Phpfox::getUserId()}{img theme='layout/arrow_left.png' class='v_middle'} {/if}{$aMail.preview|clean|shorten:40:'...'|cleanbb}
		</div>
		{/if}		
		
	</div>	
</div>
{/foreach}
{else}
<div class="extra_info">
	{phrase var='mail.no_messages_found_here'}
</div>
{/if}
<input type="button" value="{phrase var='mail.mark_all_read'}" class="button button_off" onclick="$.ajaxCall('mail.markallread')"/>
{if $iTotalMessages}
{moderation}
{/if}
{pager}