<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: privacy.html.php 4514 2012-07-17 10:38:33Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="privacy_holder_table" class="p_4">
	<form method="post" action="{url link='user.privacy'}">	
		
		{if Phpfox::getUserParam('user.can_be_invisible')}
		<div id="js_privacy_block_invisible" class="js_privacy_block page_section_menu_holder" style="display:none;">
			<div class="extra_info">
				{phrase var='user.invisible_mode_allows_you_to_browse_the_site_without_appearing_on_any_online_lists'}
			</div>
			<br />
			<div class="table">
				<div class="table_left">
					{phrase var='user.enable_invisible_mode'}
				</div>
				<div class="table_right">			
					<div class="item_is_active_holder">	
						<span class="js_item_active item_is_active"><input value="1" name="val[invisible]" class="checkbox" type="radio"{if $aUserInfo.is_invisible} checked="checked"{/if} /> {phrase var='user.yes'}</span>
						<span class="js_item_active item_is_not_active"><input value="0" name="val[invisible]" class="checkbox" type="radio"{if !$aUserInfo.is_invisible} checked="checked"{/if} /> {phrase var='user.no'}</span>
					</div>
				</div>
			</div>		
			
			<div class="table_clear">
				<input type="submit" value="{phrase var='user.save_changes'}" class="button" />			
			</div>	
		</div>		
		{/if}
	
		{if Phpfox::getUserParam('user.can_control_profile_privacy')}
		<div id="js_privacy_block_profile" class="js_privacy_block page_section_menu_holder">
			<div class="extra_info">
				{phrase var='user.customize_how_other_users_interact_with_your_profile'}	
			</div>
			{foreach from=$aProfiles item=aModules}
			{foreach from=$aModules key=sPrivacy item=aProfile}
				{template file='user.block.privacy-profile'}
			{/foreach}
			{/foreach}
			<div class="table">
				<div class="table_left">
					{phrase var='user.date_of_birth'}:
				</div>
				<div class="table_right">
					<select name="val[special][dob_setting]">
						<option value="0"{if empty($aUserInfo.dob_setting)} selected="selected"{/if}>{phrase var='core.select'}:</option>					
						<option value="1"{if $aUserInfo.dob_setting == '1'} selected="selected"{/if}>{phrase var='user.show_only_month_amp_day_in_my_profile'}</option>		
						<option value="2"{if $aUserInfo.dob_setting == '2'} selected="selected"{/if}>{phrase var='user.display_only_my_age'}</option>
						<option value="3"{if $aUserInfo.dob_setting == '3'} selected="selected"{/if}>{phrase var='user.don_t_show_my_birthday_in_my_profile'}</option>
						<option value="4"{if $aUserInfo.dob_setting == '4'} selected="selected"{/if}>{phrase var='user.show_my_full_birthday_in_my_profile'}</option>
					</select>
				</div>
			</div>		
			
			<div class="table_clear">
				<input type="submit" value="{phrase var='user.save_changes'}" class="button" />		
			</div>		
		</div>
		{/if}
		
		<div id="js_privacy_block_items" class="js_privacy_block page_section_menu_holder" style="display:none;">
			<div class="extra_info">
				{phrase var='user.customize_your_default_settings_for_when_sharing_new_items_on_the_site'}
			</div>			
			{foreach from=$aItems item=aModules}
			{foreach from=$aModules key=sPrivacy item=aItem}
				{template file='user.block.privacy-item'}
			{/foreach}
			{/foreach}	
				
			<div class="table_clear">
				<input type="submit" value="{phrase var='user.save_changes'}" class="button" />			
			</div>			
		</div>
		
		{if Phpfox::getUserParam('user.can_control_notification_privacy') && count($aPrivacyNotifications)}
		<div id="js_privacy_block_notifications" class="js_privacy_block page_section_menu_holder" style="display:none;">
			{foreach from=$aPrivacyNotifications item=aModules}
			{foreach from=$aModules key=sNotification item=aNotification}
				{template file='user.block.privacy-notification'}
			{/foreach}
			{/foreach}
			
			<div class="table_clear">
				<input type="submit" value="{phrase var='user.save_changes'}" class="button" />			
			</div>
		</div>
		{/if}

		<div id="js_privacy_block_blocked" class="js_privacy_block page_section_menu_holder" style="display:none;">
			{if count($aBlockedUsers)}
			<div class="extra_info">
				{phrase var='user.check_the_boxes_to_unblock_users'}
			</div>		
			{foreach from=$aBlockedUsers item=aBlockedUser name=blocked}
			<div class="go_left" style="width:30%;">
				<div class="{if is_int($phpfox.iteration.blocked/2)}row1{else}row2{/if}{if $phpfox.iteration.blocked == 1 || $phpfox.iteration.blocked == 2 || $phpfox.iteration.blocked == 3} row_first{/if}">
					<label><input type="checkbox" name="val[blocked][]" value="{$aBlockedUser.block_user_id}" class="v_middle" /> {$aBlockedUser|user}</label>
				</div>
			</div>
			{if is_int($phpfox.iteration.blocked / 3)}
			<div class="clear"></div>
			{/if}		
			{/foreach}
			<div class="clear"></div>
			<div class="table_clear">
				<input type="submit" value="{phrase var='user.save_changes'}" class="button" />			
			</div>		
			{else}
			<div class="extra_info">
				{phrase var='user.you_have_not_blocked_any_users'}
			</div>
			{/if}
		</div>
		
	</form>
</div>

{if isset($bGoToBlocked)}
<script type="text/javascript">
	$Behavior.showBlocked = function()
	{l}
		$("a[rel^='js_privacy_block_blocke']").click();
	{r}
</script>
{/if}