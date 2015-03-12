<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 2710 2011-07-06 20:22:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{*
<div class="header_bar_menu" style="margin-left:20px; position:relative;">
	{if isset($aForms.title_url) && $bIsEdit && !$sStep}
	<ul style="position:absolute; right:0; margin-right:10px;">
		<li class="last"><a href="{url link='group.'$aForms.title_url''}">{phrase var='group.view_this_group'}</a></li>
	</ul>
	{/if}
	{if $bIsEdit && $sStep}
	<ul style="position:absolute; right:0; margin-right:10px;">
		<li class="last"><a href="{url link='group.'$aForms.title_url''}">{phrase var='group.skip_amp_view_this_group'}</a></li>
	</ul>
	{/if}
	<ul>
		<li{if $sAction == 'detail' && !$sStep} class="active"{/if}><a href="#detail" class="js_group_change_group">{if !$bIsEdit || $sStep}{phrase var='group.step_1'}: {/if}{phrase var='group.group_details'}</a></li>
		<li class="{if $sStep == 'customize' || $sAction == 'customize'}active{else}{if !$bIsEdit}locked{/if}{/if}"><a href="#customize" class="js_group_change_group">{if !$bIsEdit || $sStep}{phrase var='group.step_2'}: {/if}{phrase var='group.customize'}</a></li>
		<li class="{if !isset($aForms.title_url) || $bIsEdit && $sStep}last {/if}{if $sStep == 'invite' || $sAction == 'invite'}active{else}{if !$bIsEdit}locked{/if}{/if}"><a href="#invite" class="js_group_change_group">{if !$bIsEdit || $sStep}{phrase var='group.step_3'}: {/if}{phrase var='group.invite'}</a></li>
		{if isset($aForms.title_url) && $bIsEdit && !$sStep}
		<li class="last {if $sAction == 'manage'}active{/if}"><a href="#manage" class="js_group_change_group">{phrase var='group.members'}</a></li>
		{/if}
	</ul>
</div>
*}

{if !empty($sGroupMessage)}
<div class="message">
	{$sGroupMessage}
</div>
<div class="main_break"></div>
{/if}

{if count($aGroupErrors)}
{foreach from=$aGroupErrors item=sErrorMessage}
	<div class="error_message">{$sErrorMessage}</div>
{/foreach}
<div class="main_break"></div>
{/if}

{$sCreateJs}
<form method="post" action="{url link='group.add'}" enctype="multipart/form-data" onsubmit="return startProcess({$sGetJsForm}, false);" id="js_group_form" enctype="multipart/form-data">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.group_id}" /></div>
{/if}
	{if !$bIsEdit || $sStep}
	<div><input type="hidden" name="val[step]" value="{$sStep}" /></div>
	{/if}
	{if $bIsEdit || !$sStep}
	<div><input type="hidden" name="val[action]" value="{$sAction}" id="js_group_add_action" /></div>
	{/if}
	<div id="js_group_block_detail" class="js_group_block">
	
		<div class="table">
			<div class="table_left">
			{required}<label for="category">{phrase var='group.category'}:</label>
			</div>
			<div class="table_right">
				{$sCategories}
			</div>
		</div>
		<div class="separate"></div>	
	
		<div class="table">
			<div class="table_left">
			{required}<label for="title">{phrase var='group.group_name'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[title]" value="{value type='input' id='title'}" id="title" size="40" maxlength="100" />
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{required}<label for="short_description">{phrase var='group.short_description'}:</label>
			</div>
			<div class="table_right">
				<textarea name="val[short_description]" rows="10" cols="50" style="height:50px;" id="short_description">{value type='textarea' id='short_description'}</textarea>
			</div>
		</div>		
		
		<div class="table">
			<div class="table_left">
				{required}<label for="description">{phrase var='group.description'}:</label>
			</div>
			<div class="table_right">
				{editor id='description' rows='10'}
			</div>
		</div>		
		
		<div class="table">
			<div class="table_left">
				{required}<label for="country_iso">{phrase var='group.location'}:</label>
			</div>
			<div class="table_right">
				{select_location}				
				{module name='core.country-child'}
			</div>
		</div>	
		<div class="table">
			<div class="table_left">
				<label for="city">{phrase var='group.city'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[city]" value="{value type='input' id='city'}" id="city" size="20" maxlength="200" />
			</div>
		</div>		
		<div class="table">
			<div class="table_left">
				<label for="postal_code">{phrase var='group.zip_postal_code'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[postal_code]" value="{value type='input' id='postal_code'}" id="postal_code" size="10" maxlength="20" />
			</div>
		</div>		
		
		<h3>{phrase var='group.group_access'}</h3>
		
		<div class="table">
			<div class="table_left">
				<label for="view_id">{phrase var='group.general_access'}:</label>
			</div>
			<div class="table_right">
				<select name="val[view_id]" style="width:300px;" id="js_group_view_id">
					<option value="0"{value type='select' id='view_id' default='0'}>{phrase var='group.open_anyone_can_join_and_see_group_data'}</option>
					<option value="1"{value type='select' id='view_id' default='1'}>{phrase var='group.closed_admins_must_approve_members_before_they_can_join_anyone_can_see_group_description_however'}</option>
					<option value="2"{value type='select' id='view_id' default='2'}>{phrase var='group.secret_group_will_not_appear_anywhere_membership_is_by_invite_only_and_only_members_can_see_any_da'}</option>
				</select>				
			</div>
		</div>
		
		<div id="js_access_items" style="display:none;">
			{foreach from=$aGroupAccess item=aAccess}
			<div class="table">
				<div class="table_left">
					<label for="view_id">{$aAccess.phrase}:</label>
				</div>
				<div class="table_right">
					<select name="val[access][{$aAccess.param}]" style="width:300px;">
						<option value="1"{if $aAccess.value !== null && $aAccess.value == '1'} selected="selected"{/if}>{phrase var='group.allow_members_and_non_members'}</option>
						<option value="2"{if $aAccess.value !== null && $aAccess.value == '2'} selected="selected"{/if}>{phrase var='group.allow_only_members'}</option>					
						<option value="3"{if $aAccess.value !== null && $aAccess.value == '3'} selected="selected"{/if}>{phrase var='group.allow_only_admins'}</option>
					</select>				
				</div>
			</div>			
			{/foreach}				
		</div>

		<div class="table" id="js_auto_approve" style="display:none;">
			<div class="table_left">
				<label for="auto_approve">{phrase var='group.auto_approve'}:</lavel>
			</div>
			<div class="table_right">
				<select name="val[auto_approve]" style="width:300px;">
					<option value="0"{if $aAccess.value !== null && $aAccess.value == '0'} selected="selected"{/if}>{phrase var='group.no_every_user_will_have_to_be_approved_before_becoming_a_member'}</option>
					<option value="1"{if $aAccess.value !== null && $aAccess.value == '1'} selected="selected"{/if}>{phrase var='group.yes_invited_users_will_not_need_to_be_approved'}</option>					
				</select>
			</div>
		</div>
		
		<h3>{phrase var='group.group_posting_privileges'}</h3>
		
		{foreach from=$aGroupPosting item=aAccess}
		<div class="table">
			<div class="table_left">
				<label for="view_id">{$aAccess.phrase}:</label>
			</div>
			<div class="table_right">
				<select name="val[access][{$aAccess.param}]" style="width:300px;">					
					<option value="1"{if $aAccess.value !== null && $aAccess.value == '1'} selected="selected"{/if}>{phrase var='group.allow_members_and_non_members'}</option>
					<option value="2"{if $aAccess.value !== null && $aAccess.value == '2'} selected="selected"{/if}{if empty($aAccess.value) && !$bIsEdit} selected="selected"{/if}>{phrase var='group.allow_only_members'}</option>
					<option value="3"{if $aAccess.value !== null && $aAccess.value == '3'} selected="selected"{/if}>{phrase var='group.allow_only_admins'}</option>
				</select>				
			</div>
		</div>			
		{/foreach}				
		
		<div class="table_clear">
		{if $bIsEdit}
			<input type="submit" value="{phrase var='group.save'}" class="button" />
		{else}	
			<input type="submit" value="{phrase var='group.create_group'}" class="button" />
		{/if}
		</div>
		
	</div>
	
	<div id="js_group_block_customize" class="js_group_block" style="display:none;">
		<div id="js_upload_inner_form">
			<div class="table">
				<div class="table_left">
					{phrase var='group.group_photo'}:
				</div>
				<div class="table_right">
					{if $bIsEdit && !empty($aForms.image_path)}
					<div id="js_group_current_image">
						{img server_id=$aForms.server_id path='group.url_image' file=$aForms.image_path suffix='_120' max_width='120' max_height='120'}
						<div class="extra_info">
							{phrase var='group.click_here_to_delete_this_image_and_upload_a_new_one' java_script=$sJsOnClickLink}
						</div>
					</div>
					{/if}
					<div id="js_group_upload_image"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>
						<div id="js_progress_uploader"></div>
						<div class="extra_info">
							{phrase var='group.you_can_upload_a_jpg_gif_or_png_file'}
							{if $iMaxFileSize !== null}
							<br />
							{phrase var='group.the_file_size_limit_is_limit' limit=$iMaxFileSize|filesize}
							{/if}								
						</div>
					</div>
				</div>
			</div>
			
			<div id="js_submit_upload_image" class="table_clear"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>
				<input type="submit" value="{phrase var='group.save'}" class="button" />
			</div>
		</div>
	</div>
	
	<div id="js_group_block_invite" class="js_group_block" style="display:none;">	
	{if isset($aForms) && $aForms.is_public == '1'}
	{phrase var='group.this_group_is_still_pending_an_admins_approval'}
	{else}
			<div style="width:75%; float:left; position:relative;">
				<h3 style="margin-top:0px; padding-top:0px;">{phrase var='group.invite_friends'}</h3>
				<div style="height:370px;">			
				{if isset($aForms.group_id)}
					{module name='friend.search' input='invite' hide=true friend_item_id=$aForms.group_id friend_module_id='group'}
				{/if}
				</div>
				
				<h3>{phrase var='group.invite_people_via_email'}</h3>
				<div class="p_4">
					<textarea cols="40" rows="8" name="val[emails]" style="width:98%; height:60px;"></textarea>
					<div class="extra_info">
						{phrase var='group.separate_multiple_emails_with_a_comma'}
					</div>
				</div>
				
				<h3>{phrase var='group.add_a_personal_message'}</h3>
				<div class="p_4">
					<textarea cols="40" rows="8" name="val[personal_message]" style="width:98%; height:60px;"></textarea>					
				</div>				
				
				<div class="p_top_8">
					<input type="submit" value="{phrase var='group.send_invitations'}" class="button" />
				</div>
				
			</div>
			
			<div style="margin-left:77%; position:relative;">
				<div class="block">
					<div class="title">{phrase var='group.guest_list'}</div>				
					<div class="content">
						<div class="label_flow" style="height:330px;">
							<div id="js_selected_friends"></div>
						</div>
					</div>
				</div>
			</div>		

			<div class="clear"></div>		
		{/if}
		
	</div>	
	{if isset($aForms.title_url) && $bIsEdit && !$sStep}
	<div id="js_group_block_manage" class="js_group_block" style="display:none;">	
		{module name='group.list' group_list_menu=true}
	</div>
	{/if}
</form>