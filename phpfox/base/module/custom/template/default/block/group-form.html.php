<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: group-form.html.php 4413 2012-06-28 10:54:17Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>			
		<div class="table_header">
			{phrase var='custom.group_details'}
		</div>
		<div{if $bIsEdit} style="display:none;"{/if}>
			{module name='admincp.product.form' class=true}
			{module name='admincp.module.form' class=true}		
			<div class="table">
				<div class="table_left">
					{required}{phrase var='custom.location'}:
				</div>
				<div class="table_right">
					<select name="val[type_id]" class="type_id">
						<option value="">{phrase var='custom.select'}:</option>
					{foreach from=$aGroupTypes key=sVar item=sPhrase}
						<option value="{$sVar}"{value type='select' id='type_id' default=$sVar}>{$sPhrase}</option>
					{/foreach}
					</select>
				</div>
			</div>		
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
			{required}{phrase var='custom.group'}:
			</div>
			<div class="table_right">
			{if $bIsEdit}
				{module name='language.admincp.form' type='text' id='group' value=$aForms.group}
			{else}
				{module name='language.admincp.form' type='text' id='group'}
			{/if}
			</div>
		</div>