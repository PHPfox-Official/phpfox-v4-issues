<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="user_tooltip_image">
	{img user=$aUser suffix='_50_square' max_width=50 max_height=50}
</div>
<div class="user_tooltip_info">
	{plugin call='user.template_block_tooltip_1'}
	<div class="user_tooltip_info_user">{$aUser|user:'':'':30|split:20}</div>
	{plugin call='user.template_block_tooltip_3'}
	{if $bIsPage}
		{$aUser.page.category_name|convert}
		<br />
		{if $aUser.page.page_type == '1'}
			{if $aUser.page.total_like == 1}
				{phrase var='user.1_member'}
			{elseif $aUser.page.total_like > 1}
				{phrase var='user.total_members' total=$aUser.page.total_like|number_format}{/if}	
		{else}
			{if $aUser.page.total_like == 1}
				{phrase var='user.1_person_likes_this'}
			{elseif $aUser.page.total_like > 1}
				{phrase var='user.total_people_like_this' total=$aUser.page.total_like|number_format}
			{/if}
		{/if}
	{else}
		{$aUser.gender_name}<br />
		{foreach from=$aUser.birthdate_display key=sAgeType item=sBirthDisplay}
			{if $aUser.dob_setting == '2'}
				{phrase var='user.age_years_old' age=$sBirthDisplay}
			{else}
				{if $aUser.dob_setting != '3'}
					{$sBirthDisplay}
				{/if}
			{/if}
		{/foreach}	
		<br />
		{$aUser.location}
		{if $iMutualTotal > 0}
		<div class="user_tooltip_mutual">
			<a href="#" onclick="$Core.box('friend.getMutualFriends', 300, 'user_id={$aUser.user_id}'); return false;">{phrase var='user.mutual_friends_total' total=$iMutualTotal}</a>
			<div class="block_listing_inline">
				<ul>			
				{foreach from=$aMutualFriends item=aMutual}
					<li>{img user=$aMutual suffix='_50_square' max_width=32 max_height=32 class='js_hover_title'}</li>
				{/foreach}
				</ul>
			</div>
		</div>
		{/if}
		{plugin call='user.template_block_tooltip_5'}
	{/if}
	
	{plugin call='user.template_block_tooltip_2'}
	
</div>
<div class="clear"></div>
{if $aUser.user_id != Phpfox::getUserId() && !$bIsPage}
<div class="user_tooltip_action">
	<ul>
		{if !$aUser.is_friend}
		<li><a href="#" onclick="return $Core.addAsFriend('{$aUser.user_id}');" title="{phrase var='profile.add_to_friends'}">{phrase var='user.add_as_friend'}</a></li>
		{/if}
		<li><a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">{phrase var='user.send_message'}</a></li>
		{if $bShowBDay == true}
			<li><a href="{url link=$aUser.user_name}">{phrase var='user.say_happy_birthday'}</a></li>
		{/if}
	</ul>
</div>
{/if}
