<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 5569 2013-03-27 10:09:46Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bIsEdit}
<div id="js_pages_add_holder">
	<form method="post" action="{url link='pages.add'}{if $bIsNewPage}{$sStep}/new_1/{/if}" enctype="multipart/form-data">
		<div><input type="hidden" name="id" value="{$aForms.page_id}" /></div>
		<div><input type="hidden" name="val[category_id]" value="{value type='input' id='category_id'}" id="js_category_pages_add_holder" /></div>

		<div id="js_pages_block_detail" class="js_pages_block page_section_menu_holder">
			<div class="table">
				<div class="table_left">
					{phrase var='pages.category'}:
				</div>
				<div class="table_right">
					{if $aForms.is_app}
						{phrase var='pages.app'}
					{else}					
					<div class="pages_add_category">
						<select name="val[type_id]">
						{foreach from=$aTypes item=aType}
							<option value="{$aType.type_id}"{value type='select' id='type_id' default=$aType.type_id}>{$aType.name|convert}</option>
						{/foreach}			
						</select>
					</div>
					<div class="pages_sub_category">						
						{foreach from=$aTypes item=aType}
							{if isset($aType.categories) && is_array($aType.categories) && count($aType.categories)}					
								<div class="js_pages_add_sub_category" id="js_pages_add_sub_category_{$aType.type_id}"{if $aType.type_id != $aForms.type_id} style="display:none;"{/if}>
									<select name="js_category_{$aType.type_id}">
										<option value="">{phrase var='core.select'}</option>
										{foreach from=$aType.categories item=aCategory}
										<option value="{$aCategory.category_id}"{value type='select' id='category_id' default=$aCategory.category_id}>{$aCategory.name|convert}</option>
										{/foreach}
									</select>
								</div>					
							{/if}			
						{/foreach}						
					</div>
					<div class="clear"></div>
					{/if}
				</div>
			</div>	
			
			<div class="table">
				<div class="table_left">
					{phrase var='pages.use_timeline'}
				</div>
				<div class="table_right">
					<input type="radio" value="1" name="val[use_timeline]" {value type='radio' id='use_timeline' default='1' selected='true'} id="rdo_timeline_1"> <label for="rdo_timeline_1">{phrase var='pages.yes'}</label>
					<input type="radio" value="0" name="val[use_timeline]" {value type='radio' id='use_timeline' default='0'}id="rdo_timeline_0"> <label for="rdo_timeline_0">{phrase var='pages.no'}</label>
				</div>
			</div>

			<div class="table">
				<div class="table_left">
					{phrase var='pages.name'}:
				</div>
				<div class="table_right">
					{if $aForms.is_app}
					<div><input type="hidden" name="val[title]" value="{$aForms.title|clean}" maxlength="200" size="40" /></div>
					<a href="{permalink module='apps' id=$aForms.app_id title=$aForms.title}">{$aForms.title|clean}</a>
					{else}
					<input type="text" name="val[title]" value="{value type='input' id='title'}" maxlength="200" size="40" />
					{/if}
				</div>
			</div>
			
			<div class="table">
				<div class="table_left">
					{phrase var='pages.landing_page'}:
				</div>
				<div class="table_right">
					<select name="val[landing_page]">
						{foreach from=$aForms.landing_pages item=aLanding}
						{if isset($aLanding.landing)}
						<option value="{$aLanding.landing}"{if isset($aLanding.is_selected) && $aLanding.is_selected} selected="selected"{/if}>{$aLanding.phrase}</option>
						{/if}
						{/foreach}
					</select>
				</div>
			</div>			

			<div class="table_clear">
				<input type="submit" value="{phrase var='pages.update'}" class="button" />
			</div>
		</div>
		
		<div id="js_pages_block_url" class="js_pages_block page_section_menu_holder">
			
			<div class="table">
				<div class="table_left">
					{phrase var='pages.vanity_url'}:
				</div>
				<div class="table_right">
					<span class="extra_info">{param var='core.path'}</span><input type="text" name="val[vanity_url]" value="{value type='input' id='vanity_url'}" size="20" id="js_vanity_url_new" /><span class="extra_info">/</span>
				</div>
			</div>		
			
			<div class="table_clear" id="js_pages_vanity_url_button">
				<ul class="table_clear_button">
					<li>
						<div><input type="hidden" name="val[vanity_url_old]" value="{value type='input' id='vanity_url'}" size="20" id="js_vanity_url_old" /></div>
						<input type="button" value="{phrase var='pages.check_url'}" class="button" onclick="if ($('#js_vanity_url_new').val() != $('#js_vanity_url_old').val()) {l} $Core.processForm('#js_pages_vanity_url_button'); $($(this).parents('form:first')).ajaxCall('pages.changeUrl'); {r} return false;" />						
					</li>
					<li class="table_clear_ajax"></li>
				</ul>		
				<div class="clear"></div>
			</div>			
			
		</div>
		
		<div id="js_pages_block_photo" class="js_pages_block page_section_menu_holder" style="display:none;">
			<div id="js_pages_block_customize_holder">
				<div class="table">
					<div class="table_left">
						{phrase var='pages.photo'}:
					</div>
					<div class="table_right">
						{if $bIsEdit && !empty($aForms.image_path)}
						<div id="js_event_current_image">
							{img server_id=$aForms.image_server_id path='pages.url_image' file=$aForms.image_path suffix='_120' max_width='120' max_height='120'}
							<div class="extra_info">
								{phrase var='pages.click_here_to_change_this_photo'}
							</div>
						</div>
						{/if}
						<div id="js_event_upload_image"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>
							<div id="js_progress_uploader"></div>
							<div class="extra_info">
								{phrase var='pages.you_can_upload_a_jpg_gif_or_png_file'}
								{if $iMaxFileSize !== null}
								<br />
								{phrase var='pages.the_file_size_limit_is_filesize_if_your_upload_does_not_work_try_uploading_a_smaller_picture' filesize=$iMaxFileSize}
								{/if}							
							</div>
						</div>
					</div>
				</div>

				<div id="js_submit_upload_image" class="table_clear"{if $bIsEdit && !empty($aForms.image_path)} style="display:none;"{/if}>
					<input type="submit" value="{phrase var='pages.upload_photo'}" class="button" />
				</div>
			</div>	
		</div>		
		
		<div id="js_pages_block_info" class="js_pages_block page_section_menu_holder" style="display:none;">
			{plugin call='pages.template_controller_add_1'}
			{editor id='text'}
			<div class="table_clear p_top_8">
				<input type="submit" value="{phrase var='pages.update'}" class="button" />
			</div>			
		</div>
		
		<div id="js_pages_block_permissions" class="js_pages_block page_section_menu_holder" style="display:none;">
			<div id="privacy_holder_table">
				{if $bIsEdit}
				<div class="table">
					<div class="table_left">
						{phrase var='pages.page_privacy'}:
					</div>
					<div class="table_right extra_info_custom">	
						{module name='privacy.form' privacy_name='privacy' privacy_info='pages.control_who_can_see_this_page' privacy_no_custom=true}
						<div class="extra_info">
							{phrase var='pages.pages_privacy_information'}
						</div>
					</div>			
				</div>				
				{/if}
				{if $bIsEdit && $aForms.page_type == '1'}
				<div class="table">
					<div class="table_left">
						{phrase var='pages.page_registration_method'}
					</div>
					<div class="table_right">					
						<select name="val[reg_method]">
							<option value="0"{if $aForms.reg_method == '0'} selected="selected"{/if}>{phrase var='pages.anyone'}</option>
							<option value="1"{if $aForms.reg_method == '1'} selected="selected"{/if}>{phrase var='pages.approval_first'}</option>
							<option value="2"{if $aForms.reg_method == '2'} selected="selected"{/if}>{phrase var='pages.invite_only'}</option>						
						</select>					
					</div>
				</div>
				{/if}
				{foreach from=$aPermissions item=aPerm}
				<div class="table">
					<div class="table_left">
						{$aPerm.phrase}
					</div>
					<div class="table_right">					
						<select name="val[perms][{$aPerm.id}]">
							<option value="0"{if $aPerm.is_active == '0'} selected="selected"{/if}>{phrase var='pages.anyone'}</option>
							<option value="1"{if $aPerm.is_active == '1'} selected="selected"{/if}>{phrase var='pages.members_only'}</option>
							<option value="2"{if $aPerm.is_active == '2'} selected="selected"{/if}>{phrase var='pages.admins_only'}</option>						
						</select>					
					</div>
				</div>
				{/foreach}
				<div class="table_clear">
					<input type="submit" value="{phrase var='pages.update'}" class="button" />
				</div>				
			</div>				
		</div>
		
		<div id="js_pages_block_admins" class="js_pages_block page_section_menu_holder" style="display:none;">
						
			<div class="go_left" style="margin-right:5px;">
				<div id="js_custom_search_friend"></div>
				<div class="table_clear">
					<input type="submit" value="{phrase var='pages.update'}" class="button" />
				</div>						
			</div>
			<div>		
				<div id="js_custom_search_friend_placement">{if count($aForms.admins)}
					<div class="js_custom_search_friend_holder">			
						<ul>
						{foreach from=$aForms.admins item=aAdmin}
							<li>
								<a href="#" class="friend_search_remove" title="Remove" onclick="$(this).parents('li:first').remove(); return false;">{phrase var='pages.remove'}</a>
								<div class="friend_search_image">{img user=$aAdmin suffix='_50_square' max_width='25' max_height='25'}</div>
								<div class="friend_search_name">{$aAdmin.full_name|clean}</div>
								<div class="clear"></div>
								<div><input type="hidden" name="admins[]" value="{$aAdmin.user_id}" /></div>
							</li>
						{/foreach}
						</ul>
					</div>
					{/if}</div>					
			</div>
			<div class="clear"></div>		
						
			<script type="text/javascript">
				$Behavior.pagesSearchFriends = function()
				{l}
					$Core.searchFriends({l}
						'id': '#js_custom_search_friend',
						'placement': '#js_custom_search_friend_placement',
						'width': '300px',
						'max_search': 10,
						'input_name': 'admins',
						
						'default_value': '{phrase var='pages.search_friends_by_their_name'}'					
					{r});	
				{r};
			</script>						
		</div>
		
		<div id="js_pages_block_invite" class="js_pages_block page_section_menu_holder" style="display:none;">	
				<div style="width:75%; float:left; position:relative;">
					<h3 style="margin-top:0px; padding-top:0px;">{phrase var='pages.invite_friends'}</h3>
					<div style="height:370px;">			
						{if isset($aForms.page_id)}
						{module name='friend.search' input='invite' hide=true friend_item_id=$aForms.page_id friend_module_id='pages'}
						{/if}
					</div>				
					<div class="p_top_8">
						<input type="submit" value="{phrase var='pages.send_invitations'}" class="button" />
					</div>		
					<br />
				</div>

				<div style="margin-left:77%; position:relative;">
					<div class="block">
						<div class="title">{phrase var='pages.new_guest_list'}</div>				
						<div class="content">
							<div class="label_flow" style="height:330px;">
								<div id="js_selected_friends"></div>
							</div>
						</div>
					</div>
				</div>		

				<div class="clear"></div>		
		</div>		
		
		<div id="js_pages_block_widget" class="js_pages_block page_section_menu_holder" style="display:none;">
			<div class="pages_create_new_widget">
				<a href="#" onclick="$Core.box('pages.widget', 700, 'page_id={$aForms.page_id}'); return false;">{phrase var='pages.create_new_widget'}</a>
			</div>
			<ul class="pages_edit_widget">
			{foreach from=$aWidgetEdits item=aWidgetEdit}
				<li class="widget" id="js_pages_widget_{$aWidgetEdit.widget_id}">
					<div class="pages_edit_widget_tools">
						
						<div class="row_edit_bar_parent" style="display:block;">
							<div class="row_edit_bar_holder">
								<ul>
									<li><a href="#" onclick="$Core.box('pages.widget', 700, 'widget_id={$aWidgetEdit.widget_id}'); return false;">{phrase var='pages.edit'}</a></li>
									<li class="item_delete"><a href="#" onclick="if (confirm('Are you sure?')) {l} $.ajaxCall('pages.deleteWidget', 'widget_id={$aWidgetEdit.widget_id}'); {r} return false;">{phrase var='pages.delete'}</a></li>
								</ul>			
							</div>
							<div class="row_edit_bar">				
									<a href="#" class="row_edit_bar_action"><span>{phrase var='pages.actions'}</span></a>							
							</div>
						</div>						
						
					</div>
					{$aWidgetEdit.title|clean}				
				</li>
			{/foreach}
			</ul>
		</div>
		
		
		{if Phpfox::getParam('core.ip_infodb_api_key') != '' || Phpfox::getParam('core.google_api_key')}
			<div id="js_pages_block_location" class="js_pages_block page_section_menu_holder">
				{phrase var='pages.place_your_page_in_the_map'}
				
				<div class="table" id="js_location_enter">
					<div class="table_left">
						{phrase var='pages.you_can_also_write_your_address'}
					</div>
					<div class="table_right">
						<input type="text" name="val[location][name]" id="txt_location_name">
						<div id="js_add_location_suggestions"></div>
					</div>
					<div>
						<input type="hidden" name="val[location][latlng]" id="txt_location_latlng">
					</div>
				</div>
				
				<div class="table">
					<div class="table_left">
					</div>
					
					<div class="table_right">
						<div id="js_location"></div>
					</div>
				</div>

					<div class="table_clear">
						<input type="submit" value="{phrase var='pages.update'}" class="button" />
					</div>	
			</div>
		{/if}
		
		
		{if $sStep != 'invite' && $bIsNewPage}
		<strong>{phrase var='pages.after_updating'}:</strong> 
		<select name="action">
			<option value="1">{phrase var='pages.go_to_the_next_step'}</option>
			<option value="2">{phrase var='pages.view_this_page_lower'}</option>
		</select>		
		{/if}
	</form>
</div>
{else}
{if Phpfox::getUserBy('profile_page_id')}
{phrase var='pages.logged_in_as_a_page' full_name=$aGlobalProfilePageLogin.full_name}
{else}
<div id="js_pages_add_holder">
	<div class="extra_info">
		{phrase var='pages.connect_with_friends_associates_amp_fans'}
	</div>
	<div class="main_break"></div>
	{foreach from=$aTypes item=aType}
	<div class="pages_type_add_holder">
		<a href="#" class="pages_type_add_inner_link">
			<span>{$aType.name|convert}</span>
		</a>
		<div class="pages_type_add_form">
			<div class="pages_type_add_form_title">{$aType.name|convert}</div>
			<div class="pages_type_add_form_holder">
				<form method="post" action="#">
					<div><input type="hidden" name="val[type_id]" value="{$aType.type_id}" /></div>
					{if isset($aType.categories) && is_array($aType.categories) && count($aType.categories)}					
					<div class="pages_type_add_form_input">
						<select name="val[category_id]">
							<option value="">{phrase var='pages.choose_a_category'}</option>
							{foreach from=$aType.categories item=aCategory}
							<option value="{$aCategory.category_id}">{$aCategory.name|convert}</option>
							{/foreach}
						</select>
					</div>					
					{/if}
					<div class="pages_type_add_form_input">
						{phrase var='pages.name'}:
						<div>							
							<input type="text" name="val[title]" value="" class="pages_type_add_input" />
						</div>
					</div>					
					<div class="pages_type_add_form_input" id="js_pages_add_submit_button">						
						<ul class="table_clear_button">
							<li><input type="submit" value="{phrase var='pages.get_started'}" class="button" /></li>
							<li class="table_clear_ajax"></li>
						</ul>
						<div class="clear"></div>						
					</div>

				</form>
			</div>
		</div>
	</div>
	{if Phpfox::isMobile()}
	<div class="clear"></div>
	{/if}
	{/foreach}
	<div class="clear"></div>
</div>
{/if}
{/if}