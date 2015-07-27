<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 4731 2012-09-24 07:21:33Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if !$bIsEdit}
<div id="js_group_holder" style="display:none;">
	{$sGroupCreateJs}
	<form method="post" action="{url link='admincp.custom.add'}" id="js_group_field" onsubmit="if ({$sGroupGetJsForm}) {literal}{{/literal} $(this).ajaxCall('custom.addGroup'); {literal}}{/literal} return false;">
		{template file='custom.block.group-form'}
		<div class="table_clear">
			<input type="submit" value="{phrase var='custom.add_group'}" class="button" />
			<input type="button" value="{phrase var='custom.cancel_uppercase'}" class="button" id="js_cancel_new_group" />
		</div>
	</form>
</div>
{/if}

<div id="js_field_holder">
	{$sCustomCreateJs}
	<form method="post" action="{url link='admincp.custom.add'}" id="js_custom_field" onsubmit="{$sCustomGetJsForm}">
		{if $bIsEdit}
		<div><input type="hidden" name="id" value="{$aForms.field_id}" /></div>
		<div><input type="hidden" name="val[module_id]" value="{$aForms.module_id}"></div>
		{/if}

		<div class="block_content">

			<div{if $bShowUserGroups == false} style="display:none;"{/if}>
				<div class="table">
					<div class="table_left">
						{phrase var='custom.user_group'}:
					</div>
					<div class="table_right">
						<select name="val[user_group_id]">
							<option value="">{phrase var='custom.select'}:</option>
							{foreach from=$aUserGroups key=iKey item=aGroup}
								<option value="{$aGroup.user_group_id}" {if $bIsEdit && $aGroup.user_group_id == $aForms.user_group_id} selected="selected"{/if}>{$aGroup.title}</option>
							{/foreach}
						</select>
						<div class="extra_info">
							{phrase var='custom.select_only_if_you_want_a_specific_user_group_to_have_special_custom_fields'}
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>

			<div class="table">
				<div class="table_left">
					{required}{phrase var='custom.location'}:
				</div>
				<div class="table_right">
					<select name="val[type_id]" class="type_id">
						<option value="">{phrase var='custom.select'}:</option>
						{foreach from=$aTypes key=sVar item=sPhrase}
						<option value="{$sVar}"{value type='select' id='type_id' default=$sVar}>{$sPhrase}</option>
						{/foreach}
					</select>
				</div>
			</div>

			<div class="table"{if $bIsEdit} style="display:none;"{/if}>
				<div class="table_left">
					{required}{phrase var='custom.type'}:
				</div>
				<div class="table_right">
					<select name="val[var_type]" class="var_type">
						<option value="">{phrase var='custom.select'}:</option>
						<option value="textarea"{value type='select' id='var_type' default='textarea'}>{phrase var='custom.large_text_area'}</option>
						<option value="text"{value type='select' id='var_type' default='text'}>{phrase var='custom.small_text_area_255_characters_max'}</option>
						<option value="select"{value type='select' id='var_type' default='select'}>{phrase var='custom.selection'}</option>
						<option value="multiselect"{value type='select' id='var_type' default='multiselect'}>{phrase var='core.multiple_selection'}</option>
						<option value="radio"{value type='select' id='var_type' default='radio'}>{phrase var='core.radio'}</option>
						<option value="checkbox"{value type='select' id='var_type' default='checkbox'}>{phrase var='core.checkbox'}</option>
					</select>
				</div>
			</div>

			<div class="table">
				<div class="table_left">
					{required}{phrase var='custom.name'}:
				</div>
				<div class="table_right">

					{if $bIsEdit && isset($aForms.name) && Phpfox::getLib('locale')->isPhrase('$aForms.name')}
					{module name='language.admincp.form' type='text' id='name' mode='text' value=$aForms.name}
					{else}
					{if isset($aForms.name) && is_array($aForms.name)}
					{foreach from=$aForms.name key=sPhrase item=aValues}
					{module name='language.admincp.form' type='text' id='name' mode='text' value=$aForms.name}
					{/foreach}
					{else}
					{module name='language.admincp.form' type='text' id='name' mode='text'}
					{/if}
					{/if}
				</div>
			</div>

			{if $bIsEdit && isset($aForms.option)}
			<div class="table_header">
				{phrase var='custom.current_values'}:
			</div>
			{foreach from=$aForms.option name=options key=iKey item=aOptions}
			<div class="table js_current_value js_option_holder" id="js_current_value_{$iKey}">
				<div class="table_left">{phrase var='custom.option_count' count=$phpfox.iteration.options}:</b> <a href="#?id={$iKey}" class="js_delete_current_option"><i class="fa fa-remove"></i></a></div>
				<div class="table_right">
					{module name='language.admincp.form' type='text' id='current' value=$aOptions mode='text'}
				</div>
			</div>
			{/foreach}
			{/if}

			{* This next block is used as a template *}
			<div class="table_header">
				{if $bIsEdit}Extra Values{else}{phrase var='custom.values'}{/if}:
			</div>

			{*
			<div class="table" id="js_multi_select"{if $bHideOptions || $bIsEdit} style="display:none;"{/if}>
				<div class="table_left">
					{if $bIsEdit}Extra Values{else}{phrase var='custom.values'}{/if}:
				</div>
			<div class="table_right">
			*}
				<div id="js_sample_option" style="display:none;">
					<div class="js_option_holder">
						<div class="table">
							<div class="table_left">{phrase var='custom.option_html_count'}:</b> <span class="js_option_delete"></span></div>
							<div class="table_right">
								{foreach from=$aLanguages item=aLang}
								<div>
									<input type="text" name="val[option][#][{$aLang.language_code}][text]" value="" placeholder="{$aLang.title}" />
								</div>
								{/foreach}
							</div>
						</div>
					</div>
				</div>

			{*
			</div>
			</div>
			*}
			{if $bIsEdit == true && ($aForms.var_type == 'textarea' || $aForms.var_type == 'text')}
			<!--
			{/if}

			<div class="_table" id="tbl_option_holder">
				<div id="js_option_holder"></div>
			</div>
			<div class="table_clear_more_options" id="tbl_add_custom_option">
				<a href="#" class="js_add_custom_option">{phrase var='custom.add_new_option'}</a>
			</div>
			{if $bIsEdit == true && ($aForms.var_type == 'textarea' || $aForms.var_type == 'text')}
			-->
			{/if}

			<div class="table_clear">
				<input type="submit" value="{if $bIsEdit}{phrase var='custom.update'}{else}{phrase var='custom.add'}{/if}" class="button" />
			</div>
		</div>

		<div class="block_search">
			<div{if $bIsEdit} style="display:none;"{/if}>
				{module name='admincp.product.form' class=true}
			</div>

			<div class="table">
				<div class="table_left">
					{phrase var='custom.group'}:
				</div>
				<div class="table_right">
					<select name="val[group_id]" id="js_group_listing">
						{foreach from=$aGroups item=aGroup}
						<option value="{$aGroup.group_id}"{value type='select' id='group_id' default=$aGroup.group_id}>{phrase var=$aGroup.phrase_var_name}</option>
						{/foreach}
					</select>
					{if !$bIsEdit}
					<div class="table_clear_more_options"><a href="#" id="js_create_new_group">{phrase var='custom.create_a_new_group'}</a></div>
					{/if}
				</div>
			</div>

			<div class="table">
				<div class="table_left">
					{phrase var='custom.required'}:
				</div>
				<div class="table_right">
					<label><input type="radio" name="val[is_required]" value="1" class="v_middle checkbox" {value type='radio' id='is_required' default='1'}/>{phrase var='custom.yes'}</label>
					<label><input type="radio" name="val[is_required]" value="0" class="v_middle checkbox" {value type='radio' id='is_required' default='0' selected=true}/>{phrase var='custom.no'}</label>
				</div>
			</div>

			<div class="table">
				<div class="table_left">
					{phrase var='custom.include_on_registration'}:
				</div>
				<div class="table_right">
					<label><input type="radio" name="val[on_signup]" value="1" class="v_middle checkbox" {value type='radio' id='on_signup' default='1'}/>{phrase var='custom.yes'}</label>
					<label><input type="radio" name="val[on_signup]" value="0" class="v_middle checkbox" {value type='radio' id='on_signup' default='0' selected=true}/>{phrase var='custom.no'}</label>
				</div>
			</div>

		</div>

	</form>
</div>
