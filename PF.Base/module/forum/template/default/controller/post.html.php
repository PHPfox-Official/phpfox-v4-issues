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
{if isset($iEditId) && !PHPFOX_IS_AJAX}
	<div class="view_item_link">
		<a href="{permalink module='forum.thread' id=$aForms.thread_id title=$aForms.title}">{phrase var='forum.view_thread'}</a>
	</div>
{/if}
{if Phpfox::getUserParam('forum.can_post_announcement') || Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_announcement')}
	<script type="text/javascript">
	{literal}
	function selectThreadType(oObj)
	{
		if (oObj.value == 'announcement')
		{
			$('.js_announcement_list').show();
			$('#js_forum_close').hide();
		}
		else
		{
			$('.js_announcement_list').hide();
			$('#js_forum_close').show();
		}	
	}
	{/literal}
	</script>
{/if}
{$sCreateJs}
<form method="post" action="{$sFormLink}" id="js_forum_form" onsubmit="{if PHPFOX_IS_AJAX} if ({$sGetJsForm}) {l} $Core.processForm('#js_forum_submit_button'); {plugin call='forum.template_controller_post_ajax_onsubmit'}{if isset($iEditId)} $(this).ajaxCall('forum.updateText'); {else} $(this).ajaxCall('forum.addReply'); {/if} {r} return false;{else}{$sGetJsForm}{/if}">
	<div><input type="hidden" name="val[attachment]" class="js_attachment" value="{value type='input' id='attachment'}" /></div>
	{if isset($iTotalPosts)}
		<div><input type="hidden" name="val[total_post]" value="{$iTotalPosts}" /></div>
	{/if}
{if $aCallback !== false}
	<div><input type="hidden" name="val[group_id]" value="{$aCallback.item}" /></div>
{/if}
{if isset($iForumId)}
	<div><input type="hidden" name="val[forum_id]" value="{$iForumId}" /></div>
{/if}
{if isset($iThreadId)}
	<div><input type="hidden" name="val[thread_id]" value="{$iThreadId}" /></div>
{/if}
{if isset($iEditId)}
	<div><input type="hidden" name="edit" value="{$iEditId}" /></div>
{/if}
	{if isset($iForumId)}
		<div class="table">
			<div class="table_left">
				<label for="title">{if isset($iForumId)}{required}{/if}{phrase var='forum.title'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[title]" value="{value type='input' id='title'}" size="40" id="title" />	
			</div>
		</div>
	{/if}
	<div class="table">
		<div class="table_left">
			<label for="text">{required}{phrase var='forum.message'}:</label>
		</div>
		<div class="table_right">
			{editor id='text'}
		</div>
	</div>
	{if Phpfox::isMobile()}
		<div class="table_clear">
			<a href="#" class="mobile_view_options">{phrase var='forum.view_additional_options'}</a>
			<input type="submit" value="{if isset($iEditId)}{phrase var='forum.update'}{else}{phrase var='forum.submit'}{/if}" class="button" />
		</div>		
	{/if}
	<div{if Phpfox::isMobile()} id="js_mobile_form_holder" style="display:none;"{/if}>
		{if !isset($iEditId)}
			<div class="table">
				<div class="table_left">
					{phrase var='forum.subscribe'}:
				</div>
				<div class="table_right">
					<div class="item_is_active_holder">		
						<span class="js_item_active item_is_active"><input type="radio" name="val[is_subscribed]" value="1" class="v_middle"{value type='radio' id='is_subscribed' default='1' selected='true'}/> {phrase var='forum.yes'}</span>
						<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_subscribed]" value="0" class="v_middle"{value type='radio' id='is_subscribed' default='0'}/> {phrase var='forum.no'}</span>
					</div>			
				</div>
			</div>	
		{/if}

		{if isset($iForumId) && $iForumId > 0 && Phpfox::isModule('poll') && Phpfox::getUserParam('poll.can_create_poll') && Phpfox::getUserParam('forum.can_add_poll_to_forum_thread')}	
			<div><input type="hidden" name="val[poll_id]" value="" id="js_poll_id"></div>
			<div class="separate"></div>
			<div class="table">
				<div class="table_left">
					{phrase var='forum.poll'}:
				</div>
				<div class="table_right">
				<div id="js_attach_poll_question">
				{if $bIsEdit && $aForms.poll_id > 0}
					{$aForms.poll_question|clean} - <a href="#" onclick="$.ajaxCall('forum.deletePoll', 'poll_id={$aForms.poll_id}&amp;thread_id={$aForms.thread_id}'); return false;" title="{phrase var='forum.click_to_delete_this_poll'}">{phrase var='forum.delete'}</a>
				{/if}
				</div>
				<div id="js_attach_poll"{if $bIsEdit && $aForms.poll_id > 0} style="display:none;"{/if}>
					<input type="button" name="poll" value="{phrase var='forum.attach_poll'}" class="button button_off" onclick="tb_show('{phrase var='forum.attach_poll'}', $.ajaxBox('poll.add', 'height=340&amp;width=550&amp;item_id={$iForumId}&amp;module_id=forum'));" />	
				</div>
				</div>
			</div>		
		{/if}	

		{if isset($aCallback) && $aCallback !== false}
		{else}
			{if Phpfox::isModule('tag') && Phpfox::getUserParam('forum.can_add_tags_on_threads') && isset($iForumId)}
				{if isset($aCallback) && $aCallback !== false}
				{module name='tag.add' sType='forum_group'}
				{else}
				{module name='tag.add' sType='forum'}
				{/if}
			{/if}
		{/if}
		{if Phpfox::isModule('captcha') && Phpfox::getUserParam('forum.enable_captcha_on_posting')}{module name='captcha.form' sType='forum'}{/if}

		<div class="table_clear" id="js_forum_submit_button">
			<ul class="table_clear_button">
				<li><input type="submit" value="{if isset($iEditId)}{phrase var='forum.update'}{else}{phrase var='forum.submit'}{/if}" class="button" /></li>
				<li class="table_clear_ajax"></li>
			</ul>		
			<div class="clear"></div>
		</div>
		{if isset($iForumId)}

		{if Phpfox::getUserParam('forum.can_stick_thread') 
			|| Phpfox::getUserParam('forum.can_close_a_thread') 
			|| Phpfox::getUserParam('forum.can_post_announcement')
			|| Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_announcement')
			|| Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_sticky')
			
		}

		{if (($bIsEdit && $aForms.is_announcement != 1) || (!$bIsEdit))}

			<h3>{phrase var='forum.additional_options'}</h3>	

			{if Phpfox::getUserParam('forum.can_stick_thread') 
				|| Phpfox::getUserParam('forum.can_post_announcement')
				|| Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_announcement')
				|| Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_sticky')
				
			}

			{if ($bIsEdit && $aForms.is_announcement != 1) || (!$bIsEdit)}
				<div class="table">
					<div class="table_left">
						{phrase var='forum.type'}:
					</div>
					<div class="table_right label_hover">			
						<select name="val[type_id]" style="width:200px;"{if Phpfox::getUserParam('forum.can_post_announcement') || Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_announcement')} onchange="selectThreadType(this);"{/if}>
							<option value="thread"{value type='select' id='type_id' default='thread'}>{phrase var='forum.thread'}</option>
							{if Phpfox::getUserParam('forum.can_stick_thread') || Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_sticky')}
							<option value="sticky"{value type='select' id='type_id' default='sticky'}>{phrase var='forum.sticky'}</option>	
							{/if}
							{if Phpfox::getUserParam('forum.can_sponsor_thread') && (!isset($bIsGroup) || $bIsGroup != '1')}
							<option value="sponsor"{value type='select' id='type_id' default='sponsor'}>{phrase var='forum.sponsor'}</option>
							{/if}
							{if (Phpfox::getUserParam('forum.can_post_announcement') || Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_announcement')) && !$bIsEdit}
							<option value="announcement"{value type='select' id='type_id' default='announcement'}>{phrase var='forum.announcement'}</option>
							{/if}
						</select>
						{if $aCallback === false}
						{if (Phpfox::getUserParam('forum.can_post_announcement') || Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'post_announcement')) && !$bIsEdit}
						<div style="margin-top:10px;{if !$bPosted} display:none;{/if}" class="js_announcement_list">
							{phrase var='forum.select_a_parent_forum'}:
							<div class="p_4">
								<select name="val[announcement_forum_id]" style="width:300px;">
									{$sForumParents}
								</select>
								<div class="extra_info">
									{phrase var='forum.announcement_will_be_included_in_child_forums'}
								</div>
							</div>						
						</div>
						{/if}
						{/if}
					</div>
				</div>
				<div class="js_announcement_list" style="display:none;">
					<div class="separate"></div>
				</div>
			{/if}

		{/if}	

		{if Phpfox::getUserParam('forum.can_close_a_thread') || Phpfox::getService('forum.moderate')->hasAccess('' . $iActualForumId . '', 'close_thread')}
		{if ($bIsEdit && $aForms.is_announcement != 1) || (!$bIsEdit)}
		<div class="table" id="js_forum_close">
			<div class="table_left">
				{phrase var='forum.closed'}:
			</div>
			<div class="table_right">
				<div class="item_is_active_holder">		
					<span class="js_item_active item_is_active"><label><input type="radio" name="val[is_closed]" value="1" class="v_middle"{value type='radio' id='is_closed' default='1'}/> {phrase var='forum.yes'}</label></span>
					<span class="js_item_active item_is_not_active"><label><input type="radio" name="val[is_closed]" value="0" class="v_middle"{value type='radio' id='is_closed' default='0' selected='true'}/> {phrase var='forum.no'}</label></span>
				</div>				
			</div>
		</div>
		{/if}
		{/if}
	
	<div class="table_clear">
		<input type="submit" value="{if isset($iEditId)}{phrase var='forum.update'}{else}{phrase var='forum.submit'}{/if}" class="button" />
	</div>
	{/if}
	{/if}
	{/if}
	
	</div>
	
</form>
{if isset($iThreadId) && count($aPreviews) && !PHPFOX_IS_AJAX}
	<h3>{phrase var='forum.topic_preview_newest_first'}</h3>
	<div class="label_flow" style="height:300px; position:relative;">
		{foreach from=$aPreviews item=aPost}
			{template file='forum.block.preview'}
		{/foreach}
	</div>
	{if $iTotalPosts > Phpfox::getParam('forum.total_forum_post_preview')}
		<div class="t_right p_4">
			{phrase var='forum.this_thread_has_more_than_total_setting_replies' total_setting=$iTotalPostPreview link=$sThreadReturnLink}
		</div>
	{/if}
{/if}