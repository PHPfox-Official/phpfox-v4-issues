<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_forum_add_moderator">
	<form method="post" action="#" onsubmit="$('#js_update_mod').show().html($.ajaxProcess()); $(this).ajaxCall('forum.updateModerator'); return false;">
	<div><input type="hidden" name="val[user_id]" id="js_actual_user_id" value="" /></div>
		<div class="table_header">
			{phrase var='forum.manage_moderators'}
		</div>	
		<div class="table">
			<div class="table_left" style="margin-top:8px;">
				<span class="input_button">
					<a href="#" onclick="$Core.browseUsers({literal}{{/literal}input : 'users'{literal}}{/literal}); return false;">{phrase var='forum.moderators'}</a>:
				</span>
			</div>			
			<div class="table_right">
				{if !count($aUsers)}
				<div><input type="text" name="default_users" id="js_default_users" value="" size="30" onclick="$Core.browseUsers({literal}{{/literal}input : 'users'{literal}}{/literal}); return false;" class="w_95" /></div>
				{/if}
				<div class="label_flow w_95 input_clone" style="{if !count($aUsers)}height:30px; display:none;{else}height:90px;{/if}" id="js_selected_users">
				{if count($aUsers) && is_array($aUsers)}
					{foreach from=$aUsers name=users item=aUser}						
						<div class="js_cached_user_name row1 js_cached_user_id_{$aUser.user_id}{if $phpfox.iteration.users == 1} row_first{/if}" id="js_user_id_{$aUser.user_id}"><span style="display:none;">{$aUser.user_id}</span><input type="hidden" name="val[users][]" value="{$aUser.user_id}" /><a href="#" onclick="if (confirm('{phrase var='forum.are_you_sure' phpfox_squote=true}')) {left_curly} $('.js_cached_user_id_{$aUser.user_id}').remove(); $.ajaxCall('forum.removeModerator', 'id={$aUser.moderator_id}'); {right_curly} return false;">{img theme='misc/delete.gif' class='delete_hover' style='vertical-align:middle;'}</a> {$aUser|user:'':' onclick="return plugin_userLinkClick(this);"'}</div>
					{/foreach}
				{/if}
				</div>
			</div>			
		</div>	
		<div class="table">
			<div class="table_left">
				{phrase var='forum.forums'}:
			</div>			
			<div class="table_right">
				<select name="val[forum]" id="js_forum_list_drop" style="width:300px;">
					{$sForumDropDown}
				</select>
			</div>			
		</div>
		<div id="js_perm_holder">
			<div class="table_header" id="js_perm_title">
				{phrase var='forum.global_moderator_permissions'}
			</div>
			{foreach from=$aPerms key=sVar item=aPerm}
			<div class="table">
				<div class="table_left">
					{$aPerm.phrase}:
				</div>
				<div class="table_right">
					<label><input type="radio" id="js_true_{$sVar}" value="1" name="val[param][{$sVar}]" class="js_radio_true v_middle" {if $aPerm.value}checked="checked" {/if}/>{phrase var='forum.yes'}</label> <label><input type="radio" value="0" name="val[param][{$sVar}]" class="js_radio_false v_middle" {if !$aPerm.value}checked="checked" {/if}/>{phrase var='forum.no'}</label>
				</div>			
			</div>			
			{/foreach}
		</div>
		<div class="table_clear">
			<span id="js_update_mod"></span><input type="submit" value="{phrase var='forum.save'}" class="button" /> <input type="button" value="{phrase var='forum.manage_forums'}" class="button" onclick="window.location.href = '#'; $('#js_forum_edit_content').hide(); $('#js_form_actual_content').show();" /> <input type="button" value="Cancel" class="button" onclick="window.location.href = '#'; $('#js_forum_edit_content').hide(); $('#js_form_actual_content').show();" />
		</div>				
	</form>
</div>