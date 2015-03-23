<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 7246 2014-04-01 16:28:05Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aFriends)}
{if $bDisplayUl}
{literal}
<script type="text/javascript">
	function showLoader()
	{
		$('#js_im_user_list').html($.ajaxProcess(oTranslations['core.loading'], 'large'));
	}

	$Behavior.im_block_keypress = function()
	{
		if ($.browser.mozilla)
		{
			$('#js_im_find_friend_value').keypress(imCheckForEnter);
		} 
		else 
		{
			$('#js_im_find_friend_value').keydown(imCheckForEnter);
		}
	};	

	function imCheckForEnter(event)
	{
		if (event.keyCode == 13) 
		{
			showLoader(); 
			
			$.ajaxCall('im.searchFriends', 'find=' + $('#js_im_find_friend_value').val());   
		
			return false;	
		}
	}
	
	function letsHaveAChat(iId)
	{
		if (!$('#js_chat_with_' + iId).hasClass('we_have_already_clicked'))
		{
			$('#js_chat_with_' + iId).addClass('we_have_already_clicked');
			
			$.ajaxCall('im.chat', 'user_id=' + iId + $Core.im.getChatOrder());   
		}
		
		return false;
	}	
</script>
{/literal}
<div id="js_im_user_list">
{/if}
{foreach from=$aFriends item=aFriend name=friends}
<a id="js_chat_with_{$aFriend.user_id}" class="im_user_list {if $phpfox.iteration.friends == 1}first{/if}" href="#" onclick="return letsHaveAChat('{$aFriend.user_id}');">
	<div class="im_user_list_status">
		{if $aFriend.im_status == '1'}
		{img theme='misc/bullet_yellow.png' class='v_middle'}
		{else}
		{img theme='misc/bullet_green.png' class='v_middle'}
		{/if}
	</div>
	<div class="im_user_list_name">
		{$aFriend.full_name|clean|shorten:20:'...'}			
	</div>	
	{img user=$aFriend suffix='_50_square' no_link=true class='v_middle' no_online_status='true' max_width=28 max_height=28}
</a>	
{/foreach}
{pager}
{if $bDisplayUl}
</div>
{/if}
{else}
<div class="extra_info p_4">
	{phrase var='im.no_friends_online'}
</div>
{/if}

<div id="js_friend_input_search">	
	<div class="im_in_chat_menu_bar im_in_chat_menu_bar_on">
		<a href="#" class="first" onclick="return $Core.im.goOffline();">{phrase var='im.go_offline'}</a>
		<a href="#" id="im_a_toggle_sound" onclick="return $Core.im.toggleSound();">{phrase var='im.play_sound_on_new_message'}:						
				<span id="im_a_toggle_sound_yes" {if !Phpfox::getUserBy('im_beep')}style="display:none;"{/if}>{phrase var='user.yes'}</span>
				<span id="im_a_toggle_sound_no" {if Phpfox::getUserBy('im_beep')}style="display:none;"{/if}>{phrase var='user.no'}</span>				
		</a>
		<a href="{url link='user.privacy'}view_blocked">{phrase var='im.edit_block_list'}</a>
	</div>		
	<div class="im_main_search_bar">
		<div id="js_im_toggle_main_option">
			<a href="#" onclick="$(this).parents('#js_friend_input_search').find('.im_in_chat_menu_bar_on:first').slideToggle('fast'); return false;">Options</a>		
		</div>		
		<input type="text" name="find" onkeyup="stopForSearch();" 
				{if $sBrowser == "firefox"}
					onkeypress="imCheckForEnter(event);"
				{else}
					onkeydown="imCheckForEnter(event);"
				{/if}
				id="js_im_find_friend_value" value="{phrase var='im.find_your_friends'}" size="20" 
				onfocus="if (this.value == '{phrase var='im.find_your_friends' phpfox_squote=true}'){l}this.value = '';{r}" 
				onblur="if (this.value == '') this.value = '{phrase var='im.find_your_friends' phpfox_squote=true}';" />		
	</div>
</div>
