<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 4729 2012-09-24 06:51:00Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link='current'}" enctype="multipart/form-data" onsubmit="$('#btn_invitations_submit').attr('disabled','disabled');return startProcess({$sGetJsForm}, false);" id="js_event_form">
{if !empty($sModule)}
	<div><input type="hidden" name="module" value="{$sModule|htmlspecialchars}" /></div>
{/if}
{if !empty($iItem)}
	<div><input type="hidden" name="item" value="{$iItem|htmlspecialchars}" /></div>
{/if}
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.event_id}" /></div>
{/if}
	<div id="js_event_block_detail" class="js_event_block page_section_menu_holder">
	
		<div class="table">
			<div class="table_left">
				<label for="category">{phrase var='event.category'}:</label>
			</div>
			<div class="table_right form-inline">
				{$sCategories}
			</div>
		</div>
		<div class="separate"></div>	
	
		<div class="table">
			<div class="table_left">
			{required}<label for="title">{phrase var='event.what_are_you_planning'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[title]" value="{value type='input' id='title'}" id="title" size="40" maxlength="100" class="form-control" />
			</div>
		</div>		
		
		<div class="table">
			<div class="table_left">
				<label for="description">{phrase var='event.description'}:</label>
			</div>
			<div class="table_right">
				{editor id='description' rows='6'}
			</div>
		</div>			
			
		<div class="table">
			<div class="table_left">
				{phrase var='event.start_time'}:
			</div>
			<div class="table_right">
				<div style="position: relative;" class="js_event_select">
					{select_date prefix='start_' id='_start' start_year='current_year' end_year='+1' field_separator=' / ' field_order='MDY' default_all=true add_time=true start_hour='+1' time_separator='event.time_separator'}				
				</div>
			</div>
		</div>	
		
		<div class="table" id="js_event_add_end_time" style="display:none;">
			<div class="table_left">
				{phrase var='event.end_time'}:
			</div>
			<div class="table_right">
				<div style="position: relative;" class="js_event_select">
				{select_date prefix='end_' id='_end' start_year='current_year' end_year='+1' field_separator=' / ' field_order='MDY' default_all=true add_time=true start_hour='+4' time_separator='event.time_separator'}
				</div>
			</div>
		</div>		

		<div class="table">
			<div class="table_left">
			{required}<label for="location">{phrase var='event.location_venue'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[location]" value="{value type='input' id='location'}" id="location" size="40" maxlength="200" class="form-control" />
				{if !$bIsEdit}
				<div class="extra_info">
					<a href="#" onclick="$(this).parent().hide(); $('#js_event_add_country').show(); return false;">{phrase var='event.add_address_city_zip_country'}</a>
				</div>
				{/if}				
			</div>
		</div>
		
		<div id="js_event_add_country"{if !$bIsEdit} style="display:none;"{/if}>	
			 
			<div class="table">
				<div class="table_left">
					<label for="street_address">{phrase var='event.address'}</label>
				</div>
				<div class="table_right">
					<input type="text" name="val[address]" value="{value type='input' id='address'}" id="address" size="30" maxlength="200" class="form-control" />
				</div>
			</div>			 			 
				
			<div class="table">
				<div class="table_left">
					<label for="city">{phrase var='event.city'}:</label>
				</div>
				<div class="table_right">
					<input type="text" name="val[city]" value="{value type='input' id='city'}" id="city" size="20" maxlength="200" class="form-control" />
				</div>
			</div>		
			
			<div class="table">
				<div class="table_left">
					<label for="postal_code">{phrase var='event.zip_postal_code'}:</label>
				</div>
				<div class="table_right">
					<input type="text" name="val[postal_code]" value="{value type='input' id='postal_code'}" id="postal_code" size="10" maxlength="20" class="form-control" />
				</div>
			</div>		
			 
			<div class="table">
				<div class="table_left">
					<label for="country_iso">{phrase var='event.country'}:</label>
				</div>
				<div class="table_right form-inline">
					{select_location}
					{module name='core.country-child'}
				</div>
			</div>				 
			 
		</div>
		{if empty($sModule) && Phpfox::isModule('privacy')}
		<div class="table">
			<div class="table_left">
				{phrase var='event.event_privacy'}:
			</div>
			<div class="table_right">	
				{module name='privacy.form' privacy_name='privacy' privacy_info='event.control_who_can_see_this_event' privacy_no_custom=true default_privacy='event.display_on_profile'}
			</div>			
		</div>
		<div class="table">
			<div class="table_left">
				{phrase var='event.share_privacy'}:
			</div>
			<div class="table_right">	
				{module name='privacy.form' privacy_name='privacy_comment' privacy_info='event.control_who_can_share_on_this_event' privacy_no_custom=true}
			</div>			
		</div>
		{/if}
		<div class="table_clear">
		{if $bIsEdit}
			<input type="submit" value="{phrase var='event.update'}" class="button" />
		{else}	
			<input type="submit" value="{phrase var='event.submit'}" class="button" />
		{/if}
		</div>
		
	</div>

	<div id="js_event_block_customize" class="js_event_block page_section_menu_holder" style="display:none;">
		<div id="js_event_block_customize_holder">
			<div class="table">
				<div class="table_left">
					Banner:
				</div>
				<div class="table_right">
					{if $bIsEdit && !empty($aForms.image_path)}
					<div id="js_event_current_image">
						<div class="image_content_holder">{img server_id=$aForms.server_id path='event.url_image' file=$aForms.image_path suffix=''}</div>
						<div class="extra_info">
							{phrase var='event.click_here_to_delete_this_image_and_upload_a_new_one_in_its' java_script=$sJsEventAddCommand}
						</div>
					</div>
					{/if}
					<div id="js_event_upload_image"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>
						<div id="js_progress_uploader"></div>
						<div class="extra_info">
							{phrase var='event.you_can_upload_a_jpg_gif_or_png_file'}
							{if $iMaxFileSize !== null}
							<br />
							{phrase var='event.the_file_size_limit_is_filesize_if_your_upload_does_not_work_try_uploading_a_smaller_picture' filesize=$iMaxFileSize}
							{/if}							
						</div>
					</div>
				</div>
			</div>
			
			<div id="js_submit_upload_image" class="table_clear"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>
				<input type="submit" value="{phrase var='event.upload_photo'}" class="button" />
			</div>
		</div>	
	</div>
	
	<div id="js_event_block_invite" class="js_event_block page_section_menu_holder" style="display:none;">

		<div class="block">
			<div class="title">Invite Friends</div>
			<div class="content">
				{if isset($aForms.event_id)}
				<div id="js_selected_friends" class="hide_it"></div>
				{module name='friend.search' input='invite' hide=true friend_item_id=$aForms.event_id friend_module_id='event'}
				{/if}
			</div>

			<div class="title">{phrase var='event.invite_people_via_email'}</div>
			<div class="content">
				<textarea cols="40" rows="8" name="val[emails]"></textarea>
				<div class="extra_info">
					{phrase var='event.separate_multiple_emails_with_a_comma'}
				</div>
			</div>

			<div class="title">{phrase var='event.add_a_personal_message'}</div>
			<div class="content">
				<textarea cols="40" rows="8" name="val[personal_message]"></textarea>
				<div class="p_top_8">
					<input type="submit" value="{phrase var='event.send_invitations'}" class="button" />
				</div>
			</div>
		</div>
	</div>	
	
	{if $bIsEdit}
	<div id="js_event_block_manage" class="js_event_block page_section_menu_holder" style="display:none;">	
		{module name='event.list'}
	</div>
	{/if}
	
	{if $bIsEdit && Phpfox::getUserParam('event.can_mass_mail_own_members')}
	<div id="js_event_block_email" class="js_event_block page_section_menu_holder" style="display:none;">
		<div class="extra_info">
			{phrase var='event.send_out_an_email_to_all_the_guests_that_are_joining_this_event'}
			{if isset($aForms.mass_email) && $aForms.mass_email}
			<br />
			{phrase var='event.last_mass_email'}: {$aForms.mass_email|date:'mail.mail_time_stamp'}
			{/if}
		</div>

		<div class="block">
			<div id="js_send_email"{if !$bCanSendEmails} style="display:none;"{/if}>
				<div class="table">
					<div class="table_left">
						{phrase var='event.subject'}:
					</div>
					<div class="table_right">
						<input type="text" name="val[mass_email_subject]" value="" size="30" id="js_mass_email_subject" />
					</div>
				</div>
				<div class="table">
					<div class="table_left">
						{phrase var='event.text'}:
					</div>
					<div class="table_right">
						<textarea cols="50" rows="8" name="val[mass_email_text]" id="js_mass_email_text"></textarea>
					</div>
				</div>
			</div>
	</div>
		<div class="table_clear">
			<ul class="table_clear_button">
				<li><input type="button" value="{phrase var='event.send'}" class="button" onclick="$('#js_event_mass_mail_li').show(); $.ajaxCall('event.massEmail', 'type=message&amp;id={$aForms.event_id}&amp;subject=' + $('#js_mass_email_subject').val() + '&amp;text=' + $('#js_mass_email_text').val()); return false;" /></li>
				<li id="js_event_mass_mail_li" style="display:none;">{img theme='ajax/add.gif' class='v_middle'} <span id="js_event_mass_mail_send">Sending mass email...</span></li>
			</ul>
			<div class="clear"></div>
		</div>
			<div id="js_send_email_fail"{if $bCanSendEmails} style="display:none;"{/if}>
				<div class="extra_info">
					{phrase var='event.you_are_unable_to_send_out_any_mass_emails_at_the_moment'}
					<br />
					{phrase var='event.please_wait_till'}: <span id="js_time_left">{$iCanSendEmailsTime|date:'mail.mail_time_stamp'}</span>
				</div>
			</div>
	</div>
	{/if}
	
</form>


<script type="text/javascript">
{literal}
	$Behavior.resetDatepicker = function(){
		$('.js_event_select .js_date_picker').datepicker('option', 'maxDate', '+1y');
	};
{/literal}
</script>
