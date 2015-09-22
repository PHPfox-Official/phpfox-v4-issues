<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: pic.html.php 7305 2014-05-07 19:35:55Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
<div class="profiles_banner">
	{if (isset($customMenu))}
	<div class="breadcrumbs_menu">
		<ul>
			<li><a href="{$customMenu.url}">{$customMenu.title}</a></li>
		</ul>
	</div>
	{/if}
	{if isset($aCoverPhoto.server_id)}
	<div class="profiles_banner_bg">
	<div class="cover_bg"></div>
	<div class="cover">
		{img server_id=$aCoverPhoto.server_id path='photo.url_photo' file=$aCoverPhoto.destination suffix='_1024'}
	</div>
	{/if}

	<div class="profiles_info">
		<h1>
			<a href="{if isset($aUser.link) && !empty($aUser.link)}{url link=$aUser.link}{else}{url link=$aUser.user_name}{/if}" title="{$aUser.full_name|clean}">
				{$aUser.full_name|clean}
			</a>
		</h1>
		<div class="profiles_extra_info">
			{if Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'profile.view_location') && (!empty($aUser.city_location) || !empty($aUser.country_child_id) || !empty($aUser.location))}
			{phrase var='profile.lives_in'} {if !empty($aUser.city_location)}{$aUser.city_location}{/if}
			{if !empty($aUser.city_location) && (!empty($aUser.country_child_id) || !empty($aUser.location))},{/if}
			{if !empty($aUser.country_child_id)}&nbsp;{$aUser.country_child_id|location_child}{/if} {if !empty($aUser.location)}{$aUser.location}{/if} &middot;
			{/if}
			{if isset($aUser.birthdate_display) && is_array($aUser.birthdate_display) && count($aUser.birthdate_display)}
			{foreach from=$aUser.birthdate_display key=sAgeType item=sBirthDisplay}
			{if $aUser.dob_setting == '2'}
			{phrase var='profile.age_years_old' age=$sBirthDisplay}
			{else}
			{phrase var='profile.born_on_birthday' birthday=$sBirthDisplay}
			{/if}
			{/foreach}
			{/if}
			{if Phpfox::getParam('user.enable_relationship_status') && isset($sRelationship) && $sRelationship != ''}&middot; {$sRelationship} {/if}
			{if isset($aUser.category_name)}{$aUser.category_name|convert}{/if}
			{if (isset($aUser.is_friend_request) && $aUser.is_friend_request)}
			<div><span class="pending-friend-request">Pending Friend Request</span></div>
			{/if}
			{if (!empty($aUser.gender_name))}
			&middot; {$aUser.gender_name}
			{/if}
		</div>
	</div>

	<div class="profile_image">
		<div class="profile_image_holder">
		    {if Phpfox::isModule('photo')}
			{if isset($aUser.user_name)}
			    <a href="{permalink module='photo.album.profile' id=$aUser.user_id title=$aUser.user_name}">{$sProfileImage}</a>
			{else}
			    <a href="{permalink module='photo.album.profile' id=$aUser.user_id}">{$sProfileImage}</a>
			{/if}
		    {else}
			    {$sProfileImage}
		    {/if}
		</div>
		{if Phpfox::getUserId() == $aUser.user_id}
		{literal}
		<script>
			function changingProfilePhoto() {
				$('.profile_image_holder').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
			};
		</script>
		{/literal}
		<form class="p_4" method="post" enctype="multipart/form-data" action="#">
			<input type="file" class="ajax_upload" value="Upload" name="image" data-url="{url link='user.photo'}" data-onstart="changingProfilePhoto">
			<span href="{url link='user.photo'}">{phrase var='profile.change_picture'}</span>
		</form>
		{/if}
	</div>

	{if isset($aCoverPhoto.server_id)}
	</div>
	{/if}
</div>
<div class="profiles_menu set_to_fixed" data-class="profile_menu_is_fixed">
	<ul>
		<li><a href="{url link=$aUser.user_name}">Profile</a></li>
		<li><a href="{url link=''$aUser.user_name'.info'}">Info</a></li>
		<li><a href="{url link=''$aUser.user_name'.friend'}">Friends{if $aUser.total_friend > 0}<span>{$aUser.total_friend}</span>{/if}</a></li>
		{if $aProfileLinks}
		<li>
			<a href="#" class="explore"><i class="fa fa-ellipsis-h"></i></a>
			<ul>
				{foreach from=$aProfileLinks item=aProfileLink}
					<li class="{if isset($aProfileLink.is_selected)} active{/if}">
						<a href="{url link=$aProfileLink.url}" class="ajax_link">{$aProfileLink.phrase}{if isset($aProfileLink.total)}<span>{$aProfileLink.total|number_format}</span>{/if}</a>
					</li>
				{/foreach}
			</ul>
		</li>
		{/if}
	</ul>

	<div class="profiles_action">

		{if Phpfox::getUserId() == $aUser.user_id}
		<ul>
			<li>
				<a href="#" onclick="return false;">
					<i class="fa fa-cog"></i>
					<span>Manage</span>
				</a>
				<ul>
					{if Phpfox::getUserParam('profile.can_change_cover_photo')}
					<li>
						<a href="#" id="js_change_cover_photo" onclick="$Core.box('profile.logo', 500); return false;">
							{if empty($aUser.cover_photo)}{phrase var='user.add_a_cover'}{else}Change Cover Photo{/if}
						</a>
						{if !empty($aUser.cover_photo)}
						<li><a href="#" onclick="$('#cover_section_menu_drop').hide(); $.ajaxCall('user.removeLogo'); return false;">Remove Cover Photo</a></li>
						{/if}
					</li>
					{/if}
					<li><a href="{url link='user.profile'}">{phrase var='profile.edit_profile'}</a></li>
				</ul>
			</li>
		</ul>
		{/if}

		{if Phpfox::getUserId() != $aUser.user_id}
		<ul>
			{if Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
			<li>
				<a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">
					<i class="fa fa-envelope"></i>
					<span>{phrase var='profile.send_message'}</span>
				</a>
			</li>
			{/if}
			{if Phpfox::isUser() && Phpfox::isModule('friend') && Phpfox::getUserParam('friend.can_add_friends') && !$aUser.is_friend && $aUser.is_friend_request !== 2}
			<li id="js_add_friend_on_profile"{if !$aUser.is_friend && $aUser.is_friend_request === 3} class="js_profile_online_friend_request"{/if}>
				<a href="#" onclick="return $Core.addAsFriend('{$aUser.user_id}');" title="{phrase var='profile.add_to_friends'}">
					<i class="fa fa-user-plus"></i>
					<span>{if !$aUser.is_friend && $aUser.is_friend_request === 3}{phrase var='profile.confirm_friend_request'}{else}{phrase var='profile.add_to_friends'}{/if}</span>
				</a>
			</li>
			{/if}

			{if $bCanPoke && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'poke.can_send_poke')}
			<li id="liPoke">
				<a href="#" id="section_poke" onclick="$Core.box('poke.poke', 400, 'user_id={$aUser.user_id}'); return false;">
					<i class="fa fa-hand-o-right"></i>
					<span>{phrase var='poke.poke' full_name=''}</span>
				</a>
			</li>
			{/if}
			{plugin call='profile.template_block_menu_more'}
		</ul>

		{/if}
	</div>

</div>
<div class="clear"></div>
<div class="js_cache_check_on_content_block" style="display:none;"></div>
<div class="js_cache_profile_id" style="display:none;">{$aUser.user_id}</div>
<div class="js_cache_profile_user_name" style="display:none;">{if isset($aUser.user_name)}{$aUser.user_name}{/if}</div>