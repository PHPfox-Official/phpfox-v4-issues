<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.user.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$iFormUserId}" id="js_user_id" /></div>
{/if}
	{foreach from=$aEditForm item=aEditForm}
	<div class="table_header">
		{$aEditForm.title}
	</div>
	{foreach from=$aEditForm.data item=aData}
		<div class="table">
			<div class="table_left">
			{if isset($aData.required) && $aData.required}{required}{/if}{$aData.title}:
			</div>
			<div class="table_right">
				{if $aData.type == 'input:text'}
				<input type="text" name="val[{$aData.id}]" size="30" value="{$aData.value|clean}" />
				{elseif $aData.type == 'input:text:check' || $aData.type == 'input:password:check'}
				<input type="{if $aData.type == 'input:password:check'}password{else}text{/if}" name="val[{$aData.id}]" size="30" value="{$aData.value|clean}" />		
				{if $bIsEdit}
				<div class="extra_info">
					<label><input type="checkbox" name="val[{$aData.id}_check]" value="1" class="v_middle" /> {phrase var='user.check_the_box_to_confirm_that_you_want_to_edit_this_field'}</label>
				</div>	
				{/if}				
				{elseif $aData.type == 'input:textarea'}
				<textarea name="val[{$aData.id}]">{$aData.value|clean}</textarea>
				{if $bIsEdit}
				<div class="extra_info">
					<label><input type="checkbox" name="val[{$aData.id}_check]" value="1" class="v_middle" /> {phrase var='user.check_the_box_to_confirm_that_you_want_to_edit_this_field'}</label>
				</div>	
				{/if}
				{elseif $aData.type == 'date_of_birth'}
				{select_date start_year=$sDobStart end_year=$sDobEnd field_separator=' / ' field_order='MDY'}				
				{elseif $aData.type == 'select'}
				{if $aData.id == 'user_group_id' && !Phpfox::getUserParam('user.can_edit_user_group_membership')}
				<div><input type="hidden" name="val[{$aData.id}]" value="{$aData.value}" /></div>
				{foreach from=$aData.options key=sOptionValue item=sOptionTitle}
				{if $sOptionValue == $aData.value}
					{$sOptionTitle}
				{/if}
				{/foreach}
				{else}
				<select name="val[{$aData.id}]" id="{$aData.id}">				
					<option value="">{phrase var='user.select'}:</option>				
				{foreach from=$aData.options key=sOptionValue item=sOptionTitle}
					<option value="{$sOptionValue}"{if $sOptionValue == $aData.value} selected="selected"{/if}>{$sOptionTitle}</option>
				{/foreach}
				</select>
				{/if}
				{if $aData.id == 'country_iso'}
				{module name='core.country-child' country_child_value=$aUser.country_iso country_child_id=$aUser.country_child_id country_not_user=true}
				{/if}
				{/if}
			</div>
			<div class="clear"></div>
		</div>
	{/foreach}
	{/foreach}
	<div class="table_header">
		{phrase var='user.profile_picture'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='user.photo'}:
		</div>
		<div class="table_right">
			<div id="js_user_photo_{$aUser.user_id}">{img user=$aUser max_width='75' max_height='75' suffix='_50' thickbox=true}</div>
			<div class="extra_info">
				<a href="#" onclick="tb_show('{phrase var='user.edit_profile_picture' phpfox_squote=true}', $.ajaxBox('user.changePicture', 'height=150&width=700&user_id={$aUser.user_id}')); return false;">
					{phrase var='user.change_this_photo'}
				</a>
			</div>			
		</div>
		<div class="clear"></div>
	</div>
	{if Phpfox::getUserParam('user.can_edit_other_user_privacy')}
	<div class="table_header">
		{phrase var='user.profile_privacy'}
	</div>
	{foreach from=$aProfiles item=aModules}
	{foreach from=$aModules key=sPrivacy item=aProfile}
		{template file='user.block.privacy-profile'}
	{/foreach}
	{/foreach}	
	<div class="table_header">
		{phrase var='user.notification'}
	</div>	
	{foreach from=$aPrivacyNotifications item=aModules}
	{foreach from=$aModules key=sNotification item=aNotification}
		{template file='user.block.privacy-notification'}
	{/foreach}
	{/foreach}		
	{/if}
	{if !empty($aSettings)}
		<div class="table_header">
			{phrase var='user.custom_fields'}
		</div>
		<div id="js_custom_field_holder">		
			{template file='user.block.custom'}		
		</div>
	{/if}
	<div class="table_header">
		{phrase var='user.activity_points'}
	</div>	
	{foreach from=$aActivityPoints key=sActivityKeyName item=aActivityPoint}
		<div class="table">
			{foreach from=$aActivityPoint key=sActivityPhrase item=iActivityCount}
				<div class="table_left">
					{$sActivityPhrase}:
				</div>
				<div class="table_right">
					<input type="text" name="val[activity][{$sActivityKeyName}]" value="{$iActivityCount}" />
				</div>
				<div class="clear"></div>
			{/foreach}
		</div>
	{/foreach}
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.update'}" class="button" />
	</div>
</form>