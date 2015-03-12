<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: header.html.php 7154 2014-02-24 16:26:32Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
	<div{if Phpfox::getService('profile')->timeline()} class="profile_timeline_header_holder"{/if}>
		<div class="profile_header{if Phpfox::getService('profile')->timeline()} profile_timeline_header{/if}{if (empty($aUser.cover_photo) && (!isset($aUser.cover_photo_id) || $aUser.cover_photo_id < 1)) || (!Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'profile.view_profile'))} no_cover_photo {/if}">

			{if Phpfox::getService('profile')->timeline()}
				{module name='profile.pic'}
			{/if}

			{if isset($aUser.page_user_id) && isset($aUser.use_timeline) && $aUser.use_timeline}
				{*
				<div style="float:right;margin-right: 155px;">
					{if (isset($aUser.is_app) && $aUser.is_app ) || ( isset($aPage) && isset($aPage.is_admin) && !$aPage.is_admin)}
						<div id="section_menu">
							<ul>								
								{if isset($aPage) && $aPage.is_app}
									<li><a href="{permalink module='apps' id=$aPage.app_id title=$aPage.title}">{phrase var='pages.go_to_app'}</a></li>
								{/if}
								{if Phpfox::getUserParam('pages.can_add_new_pages') && isset($aPage) && !$aPage.is_admin}
									<li><a href="{url link='pages.add'}">{phrase var='pages.create_a_page'}</a></li>		
								{/if}	
								
							</ul>
						</div>
					{/if}
				</div>
				*}
			    {else}
				{if isset($aPage.title)}
					<h1>
                        <a href="{$aPage.link}">{$aPage.title}</a>
					</h1>
				{/if}
			{/if}
			<div class="profile_header_inner{if Phpfox::getService('profile')->timeline()} profile_header_timeline{/if}">
				<div id="section_menu">
					{if defined('PHPFOX_IS_USER_PROFILE_INDEX') || defined('PHPFOX_PROFILE_PRIVACY') || Phpfox::getLib('module')->getFullControllerName() == 'profile.info'}
					<ul>						
						{if Phpfox::getUserId() == $aUser.user_id}
						    {if Phpfox::getUserParam('profile.can_change_cover_photo')}
								<li>
									<a href="#" id="js_change_cover_photo" onclick="$('#cover_section_menu_drop').toggle(); return false;">
										{if empty($aUser.cover_photo)}{phrase var='user.add_a_cover'}{else}{phrase var='user.change_cover'}{/if}
									</a>
									<div id="cover_section_menu_drop">
										<ul>
											<li><a href="{url link='profile.photo'}">{phrase var='user.choose_from_photos'}</a></li>
											<li><a href="#" onclick="$('#cover_section_menu_drop').hide(); $Core.box('profile.logo', 500); return false;">{phrase var='user.upload_photo'}</a></li>
											{if !empty($aUser.cover_photo)}
												<li><a href="{url link='profile' coverupdate='1'}">{phrase var='user.reposition'}</a></li>
												<li><a href="#" onclick="$('#cover_section_menu_drop').hide(); $.ajaxCall('user.removeLogo'); return false;">{phrase var='user.remove'}</a></li>
											{/if}
										</ul>
									</div>
								</li>
						    {/if}
							<li><a href="{url link='user.profile'}">{phrase var='profile.edit_profile'}</a></li>
							{if Phpfox::getUserParam('profile.can_custom_design_own_profile')}
								<li><a href="{url link='profile.designer'}" class="no_ajax_link">{phrase var='profile.design_profile'}</a></li>
							{/if}
						{else}
							{if Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
								<li><a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">{phrase var='profile.send_message'}</a></li>
							{/if}
							{if Phpfox::isUser() && Phpfox::isModule('friend') && Phpfox::getUserParam('friend.can_add_friends') && !$aUser.is_friend && $aUser.is_friend_request !== 2}
								<li id="js_add_friend_on_profile"{if !$aUser.is_friend && $aUser.is_friend_request === 3} class="js_profile_online_friend_request"{/if}>
									<a href="#" onclick="return $Core.addAsFriend('{$aUser.user_id}');" title="{phrase var='profile.add_to_friends'}">
										{if !$aUser.is_friend && $aUser.is_friend_request === 3}{phrase var='profile.confirm_friend_request'}{else}{phrase var='profile.add_to_friends'}{/if}
									</a>
								</li>
							{/if}
							{if $bCanPoke && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'poke.can_send_poke')}
								<li id="liPoke">
									<a href="#" id="section_poke" onclick="$Core.box('poke.poke', 400, 'user_id={$aUser.user_id}'); return false;">{phrase var='poke.poke' full_name=''}</a>
								</li>
							{/if}
							{plugin call='profile.template_block_menu_more'}
							{if (Phpfox::getUserParam('user.can_block_other_members') && isset($aUser.user_group_id) && Phpfox::getUserGroupParam('' . $aUser.user_group_id . '', 'user.can_be_blocked_by_others'))
								|| (isset($aUser.is_online) && $aUser.is_online && Phpfox::isModule('im') && Phpfox::getParam('im.enable_im_in_footer_bar') && $aUser.is_friend == 1)
								|| (Phpfox::getUserParam('user.can_feature'))
								|| (isset($bPassMenuMore))
								|| (Phpfox::getUserParam('core.can_gift_points'))
							}
							<li><a href="#" id="section_menu_more" class="js_hover_title"><span class="section_menu_more_image"></span><span class="js_hover_info">{phrase var='profile.more'}</span></a></li>
							{/if}
						{/if}
					</ul>					
					{elseif Phpfox::getLib('module')->getFullControllerName() == 'friend.profile'}
					    {if Phpfox::getUserId() == $aUser.user_id}
					    <ul>
						    <li><a href="{url link='friend'}">{phrase var='profile.edit_friends'}</a></li>
					    </ul>
					    {/if}
					{else}
					    <ul>
						    {foreach from=$aSubMenus key=iKey name=submenu item=aSubMenu}
						    <li>
								<a href="{url link=$aSubMenu.url)}" class="ajax_link">
								    {if substr($aSubMenu.url, -4) == '.add' || substr($aSubMenu.url, -7) == '.upload' || substr($aSubMenu.url, -8) == '.compose'}
										{img theme='layout/section_menu_add.png' class='v_middle'}
									{/if}
									{if isset($aSubMenu.text)}
										{$aSubMenu.text}
									{else}
										{phrase var=$aSubMenu.module'.'$aSubMenu.var_name}
									{/if}
								</a>
						    </li>
						    {/foreach}
							{if (isset($aUser.is_app) && $aUser.is_app ) || ( isset($aPage) && isset($aPage.is_admin) && !$aPage.is_admin)}
								{if isset($aPage) && $aPage.is_app}
									<li><a href="{permalink module='apps' id=$aPage.app_id title=$aPage.title}">{phrase var='pages.go_to_app'}</a></li>
								{/if}
								{if Phpfox::getUserParam('pages.can_add_new_pages') && isset($aPage) && !$aPage.is_admin}
									<li><a href="{url link='pages.add'}">{phrase var='pages.create_a_page'}</a></li>
								{/if}
							{/if}
					    </ul>
					{/if}
				</div>
				{if Phpfox::getUserBy('profile_page_id') <= 0}
				<div id="section_menu_drop">
					<ul>
						{if Phpfox::getUserParam('user.can_block_other_members') && isset($aUser.user_group_id) && Phpfox::getUserGroupParam('' . $aUser.user_group_id . '', 'user.can_be_blocked_by_others')}
							<li><a href="#?call=user.block&amp;height=120&amp;width=400&amp;user_id={$aUser.user_id}" class="inlinePopup js_block_this_user" title="{if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}">{if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}</a></li>
						{/if}
						{if isset($aUser.is_online) && $aUser.is_online && Phpfox::isModule('im') && Phpfox::getParam('im.enable_im_in_footer_bar') && $aUser.is_friend == 1}
							<li><a href="#" onclick="$.ajaxCall('im.chat', 'user_id={$aUser.user_id}'); return false;">{phrase var='profile.instant_chat'}</a></li>
						{/if}
						{if Phpfox::getUserParam('user.can_feature')}
							<li {if isset($aUser.is_featured) && !$aUser.is_featured} style="display:none;" {/if} class="user_unfeature_member">
								<a href="#" title="{phrase var='profile.un_feature_this_member'}" onclick="$(this).parent().hide(); $(this).parents('#section_menu_drop').find('.user_feature_member:first').show(); $.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=0&amp;type=1'); return false;">{phrase var='profile.unfeature'}</a></li>
							<li {if isset($aUser.is_featured) && $aUser.is_featured} style="display:none;" {/if} class="user_feature_member">
								<a href="#" title="{phrase var='profile.feature_this_member'}" onclick="$(this).parent().hide(); $(this).parents('#section_menu_drop').find('.user_unfeature_member:first').show(); $.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=1&amp;type=1'); return false;">{phrase var='profile.feature'}</a></li>
						{/if}
						{if Phpfox::getUserParam('core.can_gift_points')}
							<li>
								<a href="#?call=core.showGiftPoints&amp;height=120&amp;width=400&amp;user_id={$aUser.user_id}" class="inlinePopup js_gift_points" title="{phrase var='core.gift_points'}">
									{phrase var='core.gift_points'}
								</a>
							</li>
						{/if}
						{if Phpfox::isModule('friend') && Phpfox::getUserParam('friend.link_to_remove_friend_on_profile') && isset($aUser.is_friend) && $aUser.is_friend === true}
							<li>
								<a href="#" onclick="if (confirm('{phrase var='core.are_you_sure'}'))$.ajaxCall('friend.delete', 'friend_user_id={$aUser.user_id}&reload=1'); return false;">
									{phrase var='friend.remove_friend'}
								</a>
							</li>
						{/if}
						{plugin call='profile.template_block_menu'}
					</ul>
				</div>
				{/if}
				
				{if (isset($aUser.is_online) && $aUser.is_online != 0) || $aUser.is_friend === 2 || $aUser.is_friend === 3}
					<span class="profile_online_status">
						{if !$aUser.is_friend && $aUser.is_friend_request === 2}
							<span class="js_profile_online_friend_request">{phrase var='profile.pending_friend_confirmation'}{if $aUser.is_online} &middot; {/if}</span>
						{elseif !$aUser.is_friend && $aUser.is_friend_request === 3}
							<span class="js_profile_online_friend_request">{phrase var='profile.pending_friend_request'}{if $aUser.is_online} &middot; {/if}</span>
						{/if}
						{if Phpfox::getParam('user.display_user_online_status') && $aUser.is_online && $aUser.user_id != Phpfox::getUserId()}
							({phrase var='profile.online'})
						{/if}
					</span>
				{/if}
				
				<h1 style="width:{if isset($aPage)}{else}400px{/if};">
					{if isset($aUser.user_name)}
					    <a href="{if isset($aUser.link) && !empty($aUser.link)}{url link=$aUser.link}{else}{url link=$aUser.user_name}{/if}" title="{$aUser.full_name|clean}">
						    {$aUser.full_name|clean|split:30|shorten:50:'...'}
					    </a>
					{/if}					
                    
                    {foreach from=$aBreadCrumbs key=sLink item=sCrumb name=link}{if $phpfox.iteration.link == 1}<span class="profile_breadcrumb">&#187;</span><a href="{$sLink}">{$sCrumb}</a>{/if}{/foreach}
				</h1>
				
				
				<div class="profile_info">
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
				</div>

			</div>
		</div>
		{if Phpfox::getService('profile')->timeline() && (isset($aUser.page_id) || Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'profile.view_profile'))	}
			<div class="timeline_main_menu">
				<ul>
					{foreach from=$aProfileLinks item=aProfileLink}
						<li class="{if isset($aProfileLink.is_selected)} active{/if}">
							<a href="{url link=$aProfileLink.url}" class="ajax_link">{$aProfileLink.phrase}{if isset($aProfileLink.total)}<span>({$aProfileLink.total|number_format})</span>{/if}</a>
							{if isset($aProfileLink.sub_menu) && is_array($aProfileLink.sub_menu) && count($aProfileLink.sub_menu)}
							{*
								<ul>
								{foreach from=$aProfileLink.sub_menu item=aProfileLinkSub}
									<li class="{if isset($aProfileLinkSub.is_selected)} active{/if}"><a href="{url link=$aProfileLinkSub.url}">{$aProfileLinkSub.phrase}</a></li>
								{/foreach}
								</ul>
							*}
							{/if}
						</li>
					{/foreach}
				</ul>
				<div class="clear"></div>
			</div>
		{/if}
	</div>
{block location='12'}
