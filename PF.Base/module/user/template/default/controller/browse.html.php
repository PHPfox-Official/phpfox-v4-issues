<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: browse.html.php 6960 2013-12-02 16:17:27Z Miguel_Espinoza $
 * {* *}
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if defined('PHPFOX_IS_ADMIN_SEARCH')}

{if !PHPFOX_IS_AJAX}
<div class="block_search">
	<form method="get" action="{url link='admincp.user.browse'}">
		<div class="table">
			<div class="table_left">
				{phrase var='user.search'}:
			</div>
			<div class="table_right">
				{filter key='keyword'}
				<div class="extra_info">
					{phrase var='user.within'}: {filter key='type'}
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<div id="js_admincp_search_options" style="display:none;">

			<div class="table">
				<div class="table_left">
					{phrase var='user.user_group'}:
				</div>
				<div class="table_right">
					{filter key='group'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.gender'}:
				</div>
				<div class="table_right">
					{filter key='gender'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.location'}:
				</div>
				<div class="table_right">
					{filter key='country'}
					{module name='core.country-child' country_child_filter=true country_child_type='browse'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.city'}:
				</div>
				<div class="table_right">
					{filter key='city'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.zip_postal_code'}:
				</div>
				<div class="table_right">
					{filter key='zip'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.ip_address'}:
				</div>
				<div class="table_right">
					{filter key='ip'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.age_group'}:
				</div>
				<div class="table_right">
					{filter key='from'} and {filter key='to'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.show_members'}:
				</div>
				<div class="table_right">
					{filter key='status'}
				</div>
				<div class="clear"></div>
			</div>
			<div class="table">
				<div class="table_left">
					{phrase var='user.sort_results_by'}:
				</div>
				<div class="table_right">
					{filter key='sort'}
				</div>
				<div class="clear"></div>
			</div>

			<div class="table_header">
				{phrase var='user.custom_fields'}
			</div>
			{foreach from=$aCustomFields item=aCustomField}
				{template file='custom.block.foreachcustom'}
			{/foreach}
		</div>

		<div class="table_clear">
			<div class="table_clear_more_options">
				<a href="#" onclick="$('#js_admincp_search_options').toggle(); return false;">{phrase var='user.view_more_search_options'}</a>
			</div>
			<input type="submit" value="{phrase var='user.search'}" class="button" name="search[submit]" />
		</div>
	</form>
</div>

<div class="block_content">
	{literal}
	<script>
		function process_admincp_browse() {
			$('input.button').hide();
			$('#table_hover_action_holder, .table_hover_action').prepend('<div class="t_center admincp-browse-fa"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
		}

		function delete_users(response, form, data) {
			// p(form);
			$('.admincp-browse-fa').remove();
			$('input.button').show();
			for (var i in data) {
				var e = data[i];
					// p('is delete...');
					form.find('input[type="checkbox"]').each(function() {
						if ($(this).is(':checked')) {
							if (e.name == 'delete') {
								$('#js_user_' + $(this).val()).remove();
							}
							else {
								$(this).prop('checked', false);
								var thisClass = $('#js_user_' + $(this).val());
								thisClass.removeClass('is_checked').addClass('is_processed');
								setTimeout(function() {
									thisClass.removeClass('is_processed');
								}, 600);
							}
						}
					});
			}
		};
	</script>
	{/literal}
	<form method="post" action="{url link='admincp.user.browse'}" class="ajax_post" data-include-button="true" data-callback-start="process_admincp_browse" data-callback="delete_users">
{/if}
		{if $aUsers}
		<table cellpadding="0" cellspacing="0" {if !Phpfox::getParam('user.randomize_featured_members') && isset($bShowFeatured) && $bShowFeatured == 1} id="js_drag_drop"{/if}>
		<tr>
			<th style="width:10px;">
				{if !PHPFOX_IS_AJAX}
					<input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" />
				{/if}
			</th>
			<th style="width:20px;"></th>
			<th>{phrase var='user.user_id'}</th>
			<th>{phrase var='user.photo'}</th>
			<th>{phrase var='user.display_name'}</th>
			<th>{phrase var='user.email_address'}</th>
			<th>{phrase var='user.group'}</th>
			<th>{phrase var='user.last_activity'}</th>
		</tr>
		{foreach from=$aUsers name=users key=iKey item=aUser}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" id="js_user_{$aUser.user_id}">
			<td>
				{if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

				{else}
				<input type="checkbox" name="id[]" class="checkbox" value="{$aUser.user_id}" id="js_id_row{$aUser.user_id}" />

				{/if}
			</td>
		{if !Phpfox::getParam('user.randomize_featured_members') && isset($bShowFeatured) && $bShowFeatured == 1}
			<td class="drag_handle"><input type="hidden" name="val[ordering][{$aUser.user_id}]" value="{$aUser.featured_order}" /></td>
		{/if}
			<td>
				<a href="#" class="js_drop_down_link" title="{phrase var='user.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						{if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

						{else}
						<li><a href="{url link='admincp.user.add' id=$aUser.user_id}">{phrase var='user.edit_user'}</a></li>
						{/if}
						{if $aUser.view_id == '1'}
						<li class="js_user_pending_{$aUser.user_id}">
							<a href="#" onclick="$.ajaxCall('user.userPending', 'type=1&amp;user_id={$aUser.user_id}'); return false;">
								{phrase var='user.approve_user'}
							</a>
						</li>
						<li class="js_user_pending_{$aUser.user_id}">
							<a href="#" onclick="tb_show('{phrase var='user.deny_user' phpfox_squote=true}', $.ajaxBox('user.showDenyUser', 'height=240&amp;width=400&amp;iUser={$aUser.user_id}'));return false;">
								{phrase var='user.deny_user'}
							</a>
						</li>
						<!-- onclick="" -->
						{/if}
						<li><div  class="js_feature_{$aUser.user_id}">{if !isset($aUser.is_featured) || $aUser.is_featured < 0}<a href="#" onclick="$.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=1'); return false;">{phrase var='user.feature_user'}{else}<a href="#" onclick="$.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=0'); return false;">{phrase var='user.unfeature_user'}{/if}</a></div></li>
						{if (isset($aUser.pendingMail) && $aUser.pendingMail != '') || (isset($aUser.unverified) && $aUser.unverified > 0)}
							<li><div class="js_verify_email_{$aUser.user_id}"> <a href="#" onclick="$.ajaxCall('user.verifySendEmail', 'iUser={$aUser.user_id}'); return false;">{phrase var='user.resend_verification_mail'}</a></div></li>
							<li><div class="js_verify_email_{$aUser.user_id}"> <a href="#" onclick="$.ajaxCall('user.verifyEmail', 'iUser={$aUser.user_id}'); return false;">{phrase var='user.verify_this_user'}</a></div></li>
						{/if}
						{if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

						{else}
						<li id="js_ban_{$aUser.user_id}">
							{if $aUser.is_banned}
								<a href="#" onclick="$.ajaxCall('user.ban', 'user_id={$aUser.user_id}&amp;type=0'); return false;">
									{phrase var='user.un_ban_user'}
								</a>
							{else}
								<a href="{url link='admincp.user.ban' user=$aUser.user_id}">
									{phrase var='user.ban_user'}
								</a>
							{/if}
						</li>
						{/if}
						{if Phpfox::getUserParam('user.can_delete_others_account')}
						    {if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

						    {else}
						    <li>
							<div class="user_delete">
							    <a href="#" onclick="tb_show('{phrase var='user.delete_user' phpfox_squote=true}', $.ajaxBox('user.deleteUser', 'height=240&amp;width=400&amp;iUser={$aUser.user_id}'));return false;" title="{phrase var='user.delete_user_full_name' full_name=$aUser.full_name|clean}">{phrase var='user.delete_user'}</a></div></li>
						    {/if}

						{/if}
						{if Phpfox::getUserParam('user.can_member_snoop')}
							<li><div class="user_delete"><a href="{url link='admincp.user.snoop' user=$aUser.user_id}" >{phrase var='user.log_in_as_this_user'}</a></div></li>
						{/if}
					</ul>
				</div>
			</td>
			<td>#{$aUser.user_id}</td>
			<td>{img user=$aUser suffix='_50_square' max_width=50 max_height=50}</td>
			<td>{$aUser|user}</td>
			<td><a href="mailto:{$aUser.email}">{if (isset($aUser.pendingMail) && $aUser.pendingMail != '')} {$aUser.pendingMail} {else} {$aUser.email} {/if}</a>{if isset($aUser.unverified) && $aUser.unverified > 0} <span class="js_verify_email_{$aUser.user_id}" onclick="$.ajaxCall('user.verifyEmail', 'iUser={$aUser.user_id}');">{phrase var='user.verify'}</span>{/if}</td>
			<td>
			{if ($aUser.status_id == 1)}
				<div class="js_verify_email_{$aUser.user_id}">{phrase var='user.pending_email_verification'}</div>
			{/if}
			{if Phpfox::getParam('user.approve_users') && $aUser.view_id == '1'}
				<span id="js_user_pending_group_{$aUser.user_id}">{phrase var='user.pending_approval'}</span>
			{elseif $aUser.view_id == '2'}
				{phrase var='user.not_approved'}
			{else}
				{$aUser.user_group_title|convert}
			{/if}
			</td>
			<td>
			{if $aUser.last_activity > 0}
				{$aUser.last_activity|date:'core.profile_time_stamps'}
			{/if}
				{if !empty($aUser.last_ip_address)}
				<div class="p_4">
					(<a href="{url link='admincp.core.ip' search=$aUser.last_ip_address_search}" title="{phrase var='user.view_all_the_activity_from_this_ip'}">{$aUser.last_ip_address}</a>)
				</div>
				{/if}
			</td>
		</tr>
		{/foreach}
		</table>

		{pager}

		{/if}

	{/if}
{if !PHPFOX_IS_AJAX && defined('PHPFOX_IS_ADMIN_SEARCH')}
		<div class="table_clear table_hover_action">
			<input type="submit" name="approve" value="{phrase var='user.approve'}" class="button sJsCheckBoxButton disabled" disabled="true" />
			<input type="submit" name="ban" value="{phrase var='user.ban'}" class="sJsConfirm button sJsCheckBoxButton disabled" disabled="true" />
			<input type="submit" name="unban" value="{phrase var='user.un_ban'}" class="button sJsCheckBoxButton disabled" disabled="true" />
			<input type="submit" name="verify" value="{phrase var='user.verify'}" class="button sJsCheckBoxButton disabled" disabled="true" />
			<input type="submit" name="resend-verify" value="{phrase var='user.resend_verification_mail'}" class="button sJsCheckBoxButton disabled" disabled="true" />
			<input type="submit" name="delete" value="{phrase var='user.delete'}" class="sJsConfirm button sJsCheckBoxButton disabled" disabled="true" />
		</div>
	</form>
</div>
{else}
	{if isset($highlightUsers)}
<div class="ajax" data-url="{url link='user.browse' recommend=1}"></div>
	<div class="ajax" data-url="{url link='user.browse' featured=1}"></div>
	{else}
		{if $aUsers}
		{foreach from=$aUsers name=users item=aUser}
			{template file='user.block.rows'}
		{/foreach}
		{pager}
		{/if}
	{/if}
{/if}
