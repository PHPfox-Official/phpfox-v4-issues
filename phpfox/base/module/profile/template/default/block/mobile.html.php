<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: mobile.html.php 6719 2013-10-03 10:35:48Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="mobile_profile_header">
	<div id="mobile_profile_photo">
	
		{if defined('PHPFOX_IS_USER_PROFILE') && $aUser.is_online}<span class="profile_online_status">({phrase var='profile.online'})</span>{/if}
	
		<div id="mobile_profile_photo_image">
			{$sProfileImage}
		</div>
		{if defined('PHPFOX_IS_USER_PROFILE')}
		<div id="mobile_profile_photo_name">
			{$aUser.full_name|clean|split:50}
			<ul>
			{if Phpfox::getUserId() != $aUser.user_id}
				{if Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
					<li><a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">{phrase var='profile.message'}</a></li>
				{/if}
				{if Phpfox::isModule('friend') && !$aUser.is_friend}
					<li id="js_add_friend_on_profile"><a href="#" onclick="return $Core.addAsFriend('{$aUser.user_id}');" title="{phrase var='profile.add_to_friends'}">{phrase var='profile.add_to_friends'}</a></li>
				{/if}
				{if $bCanPoke && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'poke.can_send_poke')}
					<li id="liPoke">
						<a href="#" id="section_poke" onclick="$Core.box('poke.poke', 400, 'user_id={$aUser.user_id}'); return false;">{phrase var='poke.poke' full_name=''}</a>
					</li>
				{/if}			
			{/if}
			</ul>
			<div class="clear"></div>				
		</div>
		{/if}
		{if defined('PHPFOX_IS_PAGES_VIEW')}
		<div id="mobile_profile_photo_name">
			<ul>
				{if !isset($aUser.is_liked) && $aUser.is_liked != true}
					<li>
						<a href="#" id="pages_like_join" onclick="$(this).parent().hide(); {if $aUser.page_type == '1' && $aUser.reg_method == '1'} $.ajaxCall('pages.signup', 'page_id={$aUser.page_id}'); {else}$.ajaxCall('like.add', 'type_id=pages&amp;item_id={$aUser.page_id}');{/if} return false;">
							{if $aPage.page_type == '1' }
								{phrase var='pages.join'}
							{else}
								{phrase var='pages.like'}
							{/if}
						</a>
					</li>
				{/if}
			</ul>
			<div class="clear"></div>				
		</div>
		{/if}			
	</div>
	<ul class="mobile_profile_header_menu">
		{if defined('PHPFOX_IS_USER_PROFILE')}
		<li><a href="{url link=$aUser.user_name'.wall'}"{if !$bIsInfo} class="active"{/if}>{phrase var='profile.wall'}</a></li>
		<li><a href="{url link=$aUser.user_name'.info'}"{if $bIsInfo} class="active"{/if}>{phrase var='profile.info'}</a></li>
		{else}
			{if !empty($aUser.vanity_url)}
			<li><a href="{url link=$aUser.vanity_url'.wall'}"{if !$bIsInfo} class="active"{/if}>{phrase var='profile.wall'}</a></li>
			<li><a href="{url link=$aUser.vanity_url'.info'}"{if $bIsInfo} class="active"{/if}>{phrase var='profile.info'}</a></li>
			{else}
			<li><a href="{url link='pages.'$aUser.page_id'.wall'}"{if !$bIsInfo} class="active"{/if}>{phrase var='profile.wall'}</a></li>
			<li><a href="{url link='pages.'$aUser.page_id'.info'}"{if $bIsInfo} class="active"{/if}>{phrase var='profile.info'}</a></li>
			{/if}
		{/if}
	</ul>
	<div class="clear"></div>
</div>
