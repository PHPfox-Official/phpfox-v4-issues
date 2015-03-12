<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Friend
 * @version 		$Id: request.html.php 6551 2013-08-30 10:50:19Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{literal}
	<script type="text/javascript">
	$Core.loadStaticFile(getParam('sJsHome') + 'static/jscript/jquery/plugin/jquery.limitTextarea.js');
	function processList(sValue)
	{
		if (sValue == '')
		{
			return false;
		}
		
		if (sValue == 'create_new')
		{
			$('#js_list_options').hide(); 
			$('#js_add_new_list').show();
			return false;
		}
		
		return false;
	}

	function resetList()
	{
		$('#js_add_new_list').hide(); 
		$('#js_list_options').show();
		
		$('option').each(function()
		{
			this.selected = false;
		});
		
		return false;	
	}
	</script>
{/literal}


<form method="post" action="#" id="js_process_request" onsubmit="return false;">
{if $bInvite}
	<div>
		<input type="hidden" name="val[invite]" value="true" />
	</div>
{/if}
{if $bSuggestion}
	<div>
		<input type="hidden" name="val[suggestion]" value="true" />
	</div>
{/if}
{if $bPageSuggestion}
	<div>
		<input type="hidden" name="val[page_suggestion]" value="true" />
	</div>
{/if}
<div>
	<input type="hidden" name="val[user_id]" value="{$aUser.user_id}" />
</div>
<div class="go_left t_center" id="profile_picture_container" style="width:125px;">
	{img user=$aUser suffix='_120_square' max_width=120 max_height=120}
</div>
<div class="request_text">
{if $sError}
	{if $sError == 'already_asked'}
		<div>{phrase var='friend.you_have_already_asked_full_name_to_be_your_friend' full_name=$aUser.full_name}</div>
	{elseif $sError == 'user_asked_already'}
		<div>{phrase var='friend.full_name_has_already_asked_to_be_your_friend' full_name=$aUser.full_name}</div>
		<div class="p_4">
			{phrase var='friend.would_you_like_to_accept_their_request_to_be_friends'}
			<div class="p_4">
				<input type="submit" onclick="$('#js_process_request').ajaxCall('friend.processRequest', 'type=yes&amp;user_id={$aUser.user_id}');" value="{phrase var='friend.yes'}" class="button" />
				<input type="submit" onclick="$('#js_process_request').ajaxCall('friend.processRequest', 'type=no&amp;user_id={$aUser.user_id}');" value="{phrase var='friend.no'}" class="button" />
			</div>
		</div>	
	{elseif $sError == 'same_user'}
		<div>{phrase var='friend.cannot_add_yourself_as_a_friend'}</div>
	{elseif $sError == 'already_friends'}
		<div>{phrase var='friend.you_are_already_friends_with_full_name' full_name=$aUser.full_name}</div>
	{/if}
{else}
	{phrase var='friend.user_link_will_have_to_confirm_that_you_are_friends' user=$aUser}.
	<div class="p_top_8">
		<div id="js_personal_link" class="extra_info_link">
			<a href="#" onclick="$('#js_personal_link').hide(); $('#js_personal_message').show(); return false;">
				{phrase var='friend.add_a_personal_message'}
			</a>
		</div>
		<div id="js_personal_message" style="display:none;">
			{phrase var='friend.add_a_personal_message_form'}: <a href="#" onclick="$('#js_personal_message').hide(); $('#js_personal_link').show(); return false;">
				{phrase var='friend.cancel'}
			</a>
			<div>
				<textarea id="js_message" rows="4" cols="30" name="val[text]" onkeyup="limitChars('js_message', 250, 'js_limit_info');"></textarea>
				<div id="js_limit_info">{phrase var='friend.write_your_message_within_250_characters'}</div>
			</div>
		</div>
	</div>
	{if Phpfox::getUserParam('friend.can_add_folders')}
	<div class="p_top_8">
		<div id="js_list_options" style="display:none;">
			<select id="js_options" name="val[list_id]" onchange="return processList(this.value);">
				<option value="" class="sJsDefaultList">{phrase var='friend.add_to_a_friend_list'}</option>
				<optgroup label="{phrase var='friend.lists'}" class="sJsListOptGroup">
					{foreach from=$aOptions item=aOption}
					<option value="{$aOption.list_id}">{$aOption.name}</option>
					{/foreach}
				</optgroup>
				<option value="">---</option>
				<option value="create_new">{phrase var='friend.create_a_new_list'}</option>
			</select> {phrase var='friend.optional'}
		</div>
		<div id="js_add_new_list"  style="display:none;">
			<input type="text" name="name" value="" size="20" class="sJsCreateName" /> <input type="submit" value="{phrase var='friend.create'}" class="button" onclick="$('.sJsCreateName').ajaxCall('friend.addList', '&amp;type=single');" />
			<div class="p_4">
				<a href="#" onclick="return resetList();">{phrase var='friend.show_all_lists'}</a>
			</div>
		</div>
	</div>
	{/if}
	<div class="p_top_8" id="container_submit_friend_request">
		<input type="submit" onclick="{if $bSuggestion}$('#js_friend_suggestion').hide(); $('#js_friend_suggestion_loader').show(); {/if}$('#js_process_image').show(); $('#js_process_request').ajaxCall('friend.addRequest');" value="{phrase var='friend.add_friend'}" class="button" /> <span id="js_process_image" style="display:none;">{img theme='ajax/add.gif'}</span>
	</div>
{/if}
</div>
<div class="clear"></div>
</form>