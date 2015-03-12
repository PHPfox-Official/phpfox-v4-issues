<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 4074 2012-03-28 14:02:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>


<div id="js_field_holder">
	<form method="post" onsubmit="return $Core.input.checkSubmit();" action="{if $bIsEdit != 0}{url link='admincp.input.add'}id_{$bIsEdit}/{else}{url link='admincp.input.add'}{/if}" id="js_custom_field">
		<div class="table_header">
			{phrase var='custom.field_details'}
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='input.you_want_to_see_this_input_when_adding_a_new'}:
			</div>
			<div class="table_right">
				<select name="val[module]" id="lst_module">
					{foreach from=$aModulesEnabled item=aModule key=sModule}		
						<option value="{$aModule.module_id}.{$aModule.action}" id="{$aModule.module_id}.{$aModule.action}">{$aModule.module_phrase}</option>
					{/foreach}
				</select>
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='input.what_type_of_input_do_you_want'}:
			</div>
			<div class="table_right">
				<select name="val[type_id]" id="select_type">
					<option value="shorttext" id="opt_shorttext">{phrase var='input.short_text'}</option>
					<option value="longtext" id="opt_longtext">{phrase var='input.long_text'}</option>
					<option value="select" id="opt_select">{phrase var='input.drop_down_list'}</option>
					<option value="multiselect" id="opt_multiselect">{phrase var='input.drop_down_list_with_multiple_selection'}</option>
					<option value="radio" id="opt_radio">{phrase var='input.radio_list'}</option>
					<option value="checkbox" id="opt_checkbox">{phrase var='input.marks_list'}</option>
				</select>
			</div>
		</div>
		
		<div class="table" id="div_options">
			<div class="table_left">
				{phrase var='input.please_add_options_to_this_new_input'}:
			</div>
			<div class="table_right">
				<div id="div_input_option"></div>
					<input type="button" id="btn_addOption" value="{phrase var='input.new_option'}" onclick="$Core.input.addOption();" class="button">
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='input.what_name_do_you_want_for_this_input'}
			</div>
			<div class="table_right">
				<div id="div_input_name">
				</div>
				{* These inputs are added from a JS function that takes into account languages and existing values *}
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='input.who_should_be_able_to_add_info_to_this_input'}:
			</div>
			<div class="table_right">
				{foreach from=$aUserGroups item=aGroup}
					<div>						
						<input id="user_group_id_{$aGroup.user_group_id}" class="chk_input" type="checkbox" name="val[condition][usergroup][]" value="{$aGroup.user_group_id}">
						<label for="group_{$aGroup.user_group_id}">{$aGroup.title}</label>
					</div>
				{/foreach}
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='input.should_we_force_users_to_enter_a_value_here'}
			</div>
			<div class="table_right">
				<select name="val[required]" id="lst_required">
					<option value="1" id="opt_required_yes">{phrase var='input.yes'}</option>
					<option value="2"id="opt_required_no">{phrase var='input.no'}</option>
				</select>
			</div>
		</div>
		
		<div class="table_clear">
			<input type="submit" value="{if $bIsEdit}{phrase var='input.update'}{else}{phrase var='input.add'}{/if}" class="button" />			
		</div>
	</form>
</div>

