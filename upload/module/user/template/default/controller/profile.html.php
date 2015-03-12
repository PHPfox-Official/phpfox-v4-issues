<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 6730 2013-10-07 10:59:41Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="page_section_menu">
	<ul>
		<li class="active">
			<a href="#" class="js_custom_change_group" id="group_basic">{phrase var='user.basic_information'}</a>
		</li>
		{if count($aGroups)}		
			{foreach from=$aGroups name=groups item=aGroup}
				<li class="{if $phpfox.iteration.groups == count($aGroups) && Phpfox::isModule('music') && !Phpfox::getUserParam('music.can_upload_music_public')} last{/if}"><a href="#" class="js_custom_change_group" id="group_{$aGroup.group_id}">{phrase var=$aGroup.phrase_var_name}</a></li>
			{/foreach}
		{else}
			<div class="main_break"></div>
		{/if}
	</ul>
	<div class="clear"></div>
</div>



	<div id="js_custom_public_message" class="public_message" style="margin-bottom:10px;">
		<a href="{url link='profile'}">{phrase var='user.view_your_updated_profile'}</a>
	</div>

	<form method="post" action="{url link='user.profile'}"{if !$bIsEdit} onsubmit="{plugin call='user.template_controller_profile_form_onsubmit'} $('#js_custom_public_message').hide(); $('#js_custom_submit_button').attr('disabled', true).addClass('disabled'); $('#js_custom_update_info').html($.ajaxProcess('{phrase var='user.updating_profile' phpfox_squote=true}')).show(); $(this).ajaxCall('custom.updateFields'); return false;"{/if}>
	{if isset($iUserId)}
		<div><input type="hidden" name="id" value="{$iUserId}" /></div>
	{/if}
<div class="table js_custom_groups js_custom_group_basic">
	<div class="table">
			<div class="table_left">
				<label for="country_iso">{required}{phrase var='user.location'}:</label>
			</div>
			<div class="table_right">
				{select_location}
				{module name='core.country-child'}
			</div>
			<div class="clear"></div>
		</div>

		<div class="table">
			<div class="table_left">
				<label for="city_location">{phrase var='user.city'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[city_location]" id="city_location" value="{value type='input' id='city_location'}" size="30" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="table">
			<div class="table_left">
				<label for="postal_code">{phrase var='user.zip_postal_code'}:</label>
			</div>
			<div class="table_right">
				<input type="text" name="val[postal_code]" id="postal_code" value="{value type='input' id='postal_code'}" size="10" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="separate"></div>
		{if Phpfox::getUserParam('user.can_edit_dob')}
		<div class="table">
			<div class="table_left">
				{required}{phrase var='user.date_of_birth'}:
			</div>
			<div class="table_right">
				{select_date start_year=$sDobStart end_year=$sDobEnd field_separator=' / ' field_order='MDY' bUseDatepicker=false sort_years='DESC'}
			</div>
			<div class="clear"></div>
		</div>
		{/if}
		{if Phpfox::getUserParam('user.can_edit_gender_setting')}
		<div class="table">
			<div class="table_left">
				<label for="gender">{required}{phrase var='user.gender'}:</label>
			</div>
			<div class="table_right">
				{select_gender}
			</div>
			<div class="clear"></div>
		</div>
		{/if}
		
		{if Phpfox::getParam('user.enable_relationship_status') && Phpfox::getUserParam('custom.can_have_relationship') && isset($aRelations) && !empty($aRelations)}
		<div class="table">
			<div class="table_left">
				{phrase var='custom.relationship_status'}
			</div>
			<div class="table_right">
				<select name="val[relation]" id="relation" onchange="$Behavior.displayRelationshipChange()">
					{foreach from=$aRelations item=aRelation}
						<option value="{$aRelation.relation_id}" {if isset($aForms.relation_id) && $aForms.relation_id == $aRelation.relation_id} selected="selected"{/if}>{phrase var=$aRelation.phrase_var_name} </option>
					{/foreach}
				</select>
				
				<script type="text/javascript">
					var aRelationshipChange = {$sJsArray};
					
					{if isset($aForms.relation_id)}
						$Behavior.setRelationship = function(){l} $('#relation').val({$aForms.relation_id}); {r}
					{/if}
				</script>
				
				<span id="relation_with">
					<span class="js_relation_with_message" id="relation_with_message_to" style="display:none;">{phrase var='user.to'}:</span>
					<span class="js_relation_with_message" id="relation_with_message_with" style="display:none;">{phrase var='user.with'}:</span>
						<div class="edit_friend_relation">
										<span id="js_custom_search_friend"></span>	
										<span id="sFriendImage">
											{if isset($aForms.with_user) && isset($aForms.with_user.user_image) &&  !empty($aForms.with_user) && $aForms.with_user.with_user_id > 0}
												{img user=$aForms.with_user suffix='_50_square' max_height=50 max_height=50}
											{/if}
										</span>
										{if isset($aForms.with_user.user_id) && !empty($aForms.with_user.user_id)}
											<input type="hidden" id="relation_with_input_hidden" name="val[relation_with]" value="{$aForms.with_user.user_id}">
										{/if}
										<div id="js_custom_search_friend_placement"></div>
										
										<input type="hidden" name="val[previous_relation_with]" value="{if isset($aForms.with_user.user_id)}{$aForms.with_user.user_id}{else}0{/if}">
										<input type="hidden" name="val[previous_relation_type]" value="{if isset($aForms.relation_id)}{$aForms.relation_id}{else}0{/if}">
										{if isset($aForms.with_user.status_id) && $aForms.with_user.status_id == 1}
										<div style="margin-left:60px;">{phrase var='user.pending_confirmation'}</div>
										{/if}
						</div>
						{literal}
						<script type="text/javascript">
						$Behavior.profileSearchFriends = function()
						{
							$Core.searchFriends({
								'id': '#js_custom_search_friend',
								'placement': '#js_custom_search_friend_placement',
								'width': '300px',
								'max_search': 10,
								'input_name': 'friends',
								'default_value': {/literal}{if isset($aForms.with_user) && $aForms.with_user.with_user_id > 0}'{$aForms.with_user.full_name}' {else} '{phrase var='user.search_friends_by_their_name'}'{/if}{literal},
								'search_input_id' : 'sFriendInput',
								'onclick': function()
								{																	
									return false;
								},
								'onBeforePrepend' : function()
								{
									$('#sFriendInput').val($Core.searchFriendsInput.aFoundUser['full_name']);
									$Core.searchFriendsInput.sHtml = '';
									if ($('#sFriendImage').length < 1)
									{
										$('#sFriendInput').before('<span id="sFriendImage"></span>');
									}
									$('#sFriendImage').html('<span style=""><img src="'+$Core.searchFriendsInput.aFoundUser['user_image'] + '"></span>');
									$('#js_custom_search_friend_placement').hide();
									
									/* Make sure there's only one input with the name 
									 * -safe check for when user doesnt reload the page like in ajax browsing- */
									if ($('#relation_with_input_hidden').length > 0)
									{
										$('#relation_with_input_hidden').remove();
									}
									if ($('#relation_with_input_hidden').length < 1)
									{
										$('#sFriendImage').after('<input type="hidden" id="relation_with_input_hidden" name="val[relation_with]" value="' + $Core.searchFriendsInput.aFoundUser['user_id'] + '">');
									}
									else
									{
										$('#relation_with_input_hidden').val($Core.searchFriendsInput.aFoundUser['user_id']);
									}
								}
							});	
						}
						</script>
						{/literal}
					
					
					
				</span>
			</div>
		</div>
		{/if}
		
		
		{if Phpfox::isModule('forum')}
		<div class="separate"></div>		
		<div class="table">
			<div class="table_left">
				{phrase var='user.forum_signature'}:
			</div>
			<div class="table_right">
				<textarea cols="40" rows="5" id="signature" name="val[signature]">{$aForms.signature}</textarea>
			</div>
			<div class="clear"></div>
		</div>		
		{/if}
		
		{if Phpfox::isModule('feed') && Phpfox::getParam('feed.timeline_optional')}
		<div class="separate"></div>		
		<div class="table">
			<div class="table_left">
				{phrase var='user.timeline'}:
			</div>
			<div class="table_right">
				<select name="val[use_timeline]">
					<option value="0"{value id='use_timeline' type='select' default=0}>{phrase var='user.no'}</option>
					<option value="1"{value id='use_timeline' type='select' default=1}>{phrase var='user.yes'}</option>
				</select>
			</div>
			<div class="clear"></div>
		</div>			
		{/if}
		
		{if Phpfox::getParam('profile.allow_user_select_landing')}
		{if Phpfox::isModule('feed') && !Phpfox::getParam('feed.timeline_optional')}
		<div class="separate"></div>		
		{/if}
		<div class="table">
			<div class="table_left">
				{phrase var='user.landing_page'}:
			</div>
			<div class="table_right">
				<select name="val[landing_page]">
					<option value="wall"{value id='landing_page' type='select' default='wall'}>{phrase var='user.wall'}</option>
					<option value="info"{value id='landing_page' type='select' default='info'}>{phrase var='user.profile_info'}</option>
				</select>
			</div>
			<div class="clear"></div>
		</div>		
		{/if}
</div>

	{if count($aSettings)}
		{foreach from=$aSettings item=aSetting}
			<div class="table js_custom_groups js_custom_group_{$aSetting.group_id}" style="display:none;">
				<div class="table_left">
				{if $aSetting.is_required}{required}{/if}{phrase var=$aSetting.phrase_var_name}:
				</div>
				<div class="table_right">
					{template file='custom.block.form'}
				</div>
			</div>
		{/foreach}	
	{else}
		<div class="extra_info">			
			{if Phpfox::getUserParam('custom.can_add_custom_fields')}
				{phrase var='user.no_custom_fields_have_been_added'}
				<ul class="action">
					<li><a href="{url link='admincp.custom.add'}">{phrase var='user.add_a_new_custom_field'}</a></li>
				</ul>
			{/if}
		</div>
	{/if}
	{plugin call='user.template_controller_profile_form'}
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.update'}" class="button" id="js_custom_submit_button"> <span id="js_custom_update_info"></span>
	</div>
</form>

