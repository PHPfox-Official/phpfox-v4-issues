<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: menu.html.php 3335 2011-10-20 17:26:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if Phpfox::getUserId() != $aUser.user_id}
	<div id="profile_nav_list">
		<ul>
			{if Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
			<li><a href="{url link='mail.compose' id={$aUser.user_id}" title="{phrase var='profile.send_a_message'}" class="first">{img theme='misc/email_go.png' alt='' style='vertical-align:middle;'} {phrase var='profile.send_a_message'}</a></li>
			{/if}
			{if Phpfox::isModule('friend') && !$aUser.is_friend && Phpfox::getUserParam('friend.can_add_friends')}
			<li id="js_add_friend_on_profile"><a href="#?call=friend.request&amp;user_id={$aUser.user_id}&amp;width=420&amp;height=250" class="inlinePopup" title="{phrase var='profile.add_to_friends'}">{img theme='misc/user_add.png' alt='' style='vertical-align:middle;'} {phrase var='profile.add_to_friends'}</a></li>
			{/if}
			{if Phpfox::isModule('favorite')}
			<li><a href="#?call=favorite.add&amp;height=100&amp;width=400&amp;type=user&amp;id={$aUser.user_id}" class="inlinePopup" title="{phrase var='profile.add_to_your_favorites'}">{img theme='misc/favorite_16x16.png' alt='' style='vertical-align:middle;'} {phrase var='profile.add_to_favorites'}</a></li>
			{/if}
			{if Phpfox::getUserParam('user.can_block_other_members') && Phpfox::getUserGroupParam('' . $aUser.user_group_id . '', 'user.can_be_blocked_by_others')}			
			<li><a href="#?call=user.block&amp;height=120&amp;width=400&amp;user_id={$aUser.user_id}" class="inlinePopup" title="{if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}">{if $bIsBlocked}{img theme='misc/user_add.png' alt='' style='vertical-align:middle;'}{else}{img theme='misc/user_delete.png' alt='' style='vertical-align:middle;'}{/if} {if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}</a></li>
			{/if}
			{if Phpfox::isModule('group')}
			<li><a href="#?call=group.invite&amp;height=100&amp;width=400&amp;id={$aUser.user_id}" class="inlinePopup" title="{phrase var='profile.invite_to_one_of_your_groups'}">{img theme='module/group.png' class='v_middle'} {phrase var='profile.invite_to_a_group'}</a></li>
			{/if}
			{if isset($aUser.is_online) && $aUser.is_online && Phpfox::isModule('im') && Phpfox::getParam('im.enable_im_in_footer_bar') && $aUser.is_friend == 1}
			<li><a href="#" onclick="$.ajaxCall('im.chat', 'user_id={$aUser.user_id}', 'GET'); return false;">{img theme='module/chat.png' class='v_middle'} {phrase var='profile.instant_chat'}</a></li>
			{/if}
			{if Phpfox::getUserParam('user.can_feature')}
			<li {if !$aUser.is_featured} style="display:none;" {/if} class="user_unfeature_member"><a href="#" title="{phrase var='profile.un_feature_this_member'}" onclick="$(this).parent().hide(); $(this).parents('#profile_nav_list:first').find('.user_feature_member:first').show(); $.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=0&amp;type=1'); return false;">{img theme='misc/photo_unfeature.png' alt='' width='16' height='16' class='v_middle'} {phrase var='profile.unfeature'}</a></li>
			<li {if $aUser.is_featured} style="display:none;" {/if} class="user_feature_member"><a href="#" title="{phrase var='profile.feature_this_member'}" onclick="$(this).parent().hide(); $(this).parents('#profile_nav_list:first').find('.user_unfeature_member:first').show(); $.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=1&amp;type=1'); return false;">{img theme='misc/photo_feature.png' alt='' width='16' height='16' class='v_middle'} {phrase var='profile.feature'}</a></li>
			{/if}			
			{plugin call='profile.template_block_menu'}
		</ul>
	</div>	
	{/if}