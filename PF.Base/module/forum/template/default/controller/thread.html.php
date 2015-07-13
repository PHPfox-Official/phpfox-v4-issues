<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Forum
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if isset($isReplies)}
		{foreach from=$aThread.posts name=posts item=aPost}
			{plugin call='forum.template_controller_post_1'}
			{template file='forum.block.post'}
			{plugin call='forum.template_controller_post_2'}
		{/foreach}
	{else}
		{if $sPermaView === null}
		{if $aThread.view_id}
		<div class="message">
			{phrase var='forum.thread_is_pending_approval'}
		</div>
		{/if}
		{if !$aThread.is_announcement}
		<div class="forum_header_menu">
			<ul class="sub_menu_bar">
				{if Phpfox::isModule('share')}
				{module name='share.link' type='forum' url=$sCurrentThreadLink title=$aThread.title display='menu'}
				{/if}
				{if Phpfox::isUser()}
				<li class="sub_menu_bar_li">
					<a href="#" class="sJsDropMenu drop_down_link">{phrase var='forum.thread_tools'}</a>
					<div class="link_menu dropContent">
						<ul>
						{if $aThread.view_id && (Phpfox::getUserParam('forum.can_approve_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess('' . $aThread.forum_id . '', 'approve_thread'))}
							<li><a href="{url link='current' approve='true'}">{phrase var='forum.approve_thread'}</a></li>
						{/if}
						{if $bCanEditThread}
							<li><a href="{if $aCallback === null}{url link='forum.post.thread' edit=$aThread.thread_id}{else}{url link='forum.post.thread' module='pages' item=$aCallback.group_id edit=$aThread.thread_id}{/if}">{phrase var='forum.edit_thread'}</a></li>
						{/if}
						{if $aCallback === null}
						{if Phpfox::getUserParam('forum.can_move_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess('' . $aThread.forum_id . '', 'move_thread')}
							<li><a href="#" onclick="tb_show('{phrase var='forum.move_thread' phpfox_squote=true}', $.ajaxBox('forum.move', 'height=200&amp;width=550&amp;thread_id={$aThread.thread_id}')); return false;">{phrase var='forum.move_thread'}</a></li>
						{/if}
						{if Phpfox::getUserParam('forum.can_copy_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess('' . $aThread.forum_id . '', 'copy_thread')}
							<li><a href="#" onclick="tb_show('{phrase var='forum.copy_thread' phpfox_squote=true}', $.ajaxBox('forum.copy', 'height=200&amp;width=550&amp;thread_id={$aThread.thread_id}')); return false;">{phrase var='forum.copy_thread'}</a></li>
						{/if}
						{/if}
						{if $bCanDeleteThread}
							<li><a href="#" onclick="return $Core.forum.deleteThread('{$aThread.thread_id}');">{phrase var='forum.delete_thread'}</a></li>
						{/if}
						{if $bCanStickThread}
						{if $aThread.order_id == 1}
							<li id="js_stick_thread"><a href="#" onclick="return $Core.forum.stickThread('{$aThread.thread_id}', 0);">{phrase var='forum.unstick_thread'}</a></li>
						{else}
							<li id="js_stick_thread"><a href="#" onclick="return $Core.forum.stickThread('{$aThread.thread_id}', 1);">{phrase var='forum.stick_thread'}</a></li>
						{/if}
						{/if}
						{if $bCanCloseThread}
						{if $aThread.is_closed}
							<li id="js_close_thread"><a href="#" onclick="return $Core.forum.closeThread('{$aThread.thread_id}', 0);">{phrase var='forum.open_thread'}</a></li>
						{else}
							<li id="js_close_thread"><a href="#" onclick="return $Core.forum.closeThread('{$aThread.thread_id}', 1);">{phrase var='forum.close_thread'}</a></li>
						{/if}
						{/if}
						{if $bCanMergeThread}
							<li><a href="#" onclick="tb_show('{phrase var='forum.merge_threads' phpfox_squote=true}', $.ajaxBox('forum.merge', 'height=200&amp;width=550&amp;thread_id={$aThread.thread_id}')); return false;">{phrase var='forum.merge_threads'}</a></li>
						{/if}
							<li id="js_subscribe"{if $aThread.is_subscribed} style="display:none;"{/if}><a href="#" onclick="$(this).parent().hide(); $('#js_unsubscribe').show(); $.ajaxCall('forum.subscribe', 'thread_id={$aThread.thread_id}&amp;subscribe=1'); return false;">{phrase var='forum.subscribe'}</a></li>
							<li id="js_unsubscribe"{if !$aThread.is_subscribed} style="display:none;"{/if}><a href="#" onclick="$(this).parent().hide(); $('#js_subscribe').show(); $.ajaxCall('forum.subscribe', 'thread_id={$aThread.thread_id}&amp;subscribe=0'); return false;">{phrase var='forum.unsubscribe'}</a></li>

						{if $bCanPurchaseSponsor}
						    {if Phpfox::getUserParam('forum.can_sponsor_thread')} {* 2 = sponsored *}
							<li>
							    <span id="js_sponsor_thread_{$aThread.thread_id}" {if $aThread.order_id == 2}style="display:none;"{/if}>
								<a href="#" onclick="$.ajaxCall('forum.sponsor','thread_id={$aThread.thread_id}&type=2');return false;">
								   {phrase var='forum.sponsor'}
								</a>
							    </span>
							    <span id="js_unsponsor_thread_{$aThread.thread_id}" {if $aThread.order_id != 2}style="display:none;"{/if}>
								  <a href="#" onclick="$.ajaxCall('forum.sponsor','thread_id={$aThread.thread_id}&type=0');return false;">
								   {phrase var='forum.unsponsor'}
								</a>
							    </span>
							</li>

						    {elseif Phpfox::getUserParam('forum.can_purchase_sponsor')}
							<li>
							    <a href="{permalink module='ad.sponsor' id=$aThread.thread_id}section_forum-thread/">{phrase var='forum.sponsor'}</a>
							</li>
						    {/if}
						{/if}
						</ul>
					</div>
				</li>
				{/if}
			</ul>
			<div class="clear"></div>
		</div>

		{if !empty($aPoll.question)}
		<div class="table_info">
			{phrase var='forum.poll'}: {$aPoll.question|clean}
		</div>
		<div class="forum_poll_content">
			{template file='poll.block.entry'}
		</div>
		{/if}

		{/if}
		{/if}

		{if $sPermaView !== null}
		<div class="table_info">
			<div class="go_left">
				{phrase var='forum.viewing_single_post'}
			</div>
			<div class="t_right" style="padding-right:5px;">
				{phrase var='forum.thread'}: <a href="{permalink module='forum.thread' id=$aThread.thread_id title=$aThread.title}" title="{$aThread.title|clean}">{$aThread.title|clean|shorten:50:'...'}</a>
			</div>
			<div class="clear"></div>
		</div>
		{/if}

		<div class="forum_thread_view_holder">
			<div id="js_thread_start"></div>
			<meta itemprop="dateCreated" content="{$aThread.time_stamp|micro_time}" />
			<meta itemprop="dateModified" content="{$aThread.time_update|micro_time}" />
			<meta itemprop="interactionCount" content="Posts:{$iTotalPosts}" />
			{if isset($aThread.post_starter)}
			<div class="thread_view_holder">
				<section class="thread_starter">
					{template file='forum.block.post'}
				</section>
				<section class="thread_replies">
					{if ($iTotalPosts > 20)}
					<div class="tr_view_all">
						<a href="{permalink module='forum.thread' id=$aThread.thread_id title=$aThread.title view=all}" class="ajax view_all_previous" data-add-class="is-clicked" data-add-spin="true">View All Previous Posts</a>
					</div>
					{/if}
			{/if}
					<div class="tr_content">
						{foreach from=$aThread.posts name=posts item=aPost}
							{plugin call='forum.template_controller_post_1'}
							{template file='forum.block.post'}
							{plugin call='forum.template_controller_post_2'}
						{/foreach}
					</div>

			{if isset($aThread.post_starter)}
					<div id="js_post_new_thread"></div>
					{if !PHPFOX_IS_AJAX && (Phpfox::getUserParam('forum.can_approve_forum_thread') || Phpfox::getUserParam('forum.can_delete_other_posts'))}
					{moderation}
					{/if}
				</section>
			</div>
			{/if}
		</div>
	{/if}