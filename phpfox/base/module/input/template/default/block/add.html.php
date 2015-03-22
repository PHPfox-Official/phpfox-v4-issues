<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: block.html.php 3042 2011-09-08 09:58:34Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div >
	{if isset($bAjaxSearch) && $bAjaxSearch}
		
			<div>
				<input type="hidden" name="val[searchByInputs]" value="1" />		
			</div>
	{/if}
	{foreach from=$aInputs item=aInput name=input}
		<div class="table">
			<div class="table_left">
				{if (isset($aInput.is_required) && $aInput.is_required == 1) && (!isset($bAjaxSearch) || $bAjaxSearch != true)}{required}{/if}{phrase var=$aInput.input_name_var}:
			</div>
			<div class="table_right">			
				{if $aInput.type_id == 'shorttext'}
					<input type="text" name="val[input_{$aInput.field_id}]" class="input_shorttext" value="{value type='input' id=$aInput.template_id}">
				{/if}
				
				{if $aInput.type_id == 'longtext'}
					<textarea class="input_longtext" name="val[input_{$aInput.field_id}]">{value type='textarea' id=$aInput.template_id}</textarea>
				{/if}
				
				{if $aInput.type_id == 'select' || $aInput.type_id == 'multiselect'}
					<select name="val[input_{$aInput.field_id}]{if $aInput.type_id == 'multiselect'}[]{/if}" {if $aInput.type_id == 'multiselect'}multiple="multiple"{/if}>
						{foreach from=$aInput.option item=aOption}
							<option value="{$aOption.option_id}" {value type='select' id=$aOption.option_id default=$aOption.option_id}>
								{phrase var=$aOption.phrase_var}
							</option>
						{/foreach}
					</select>
				{/if}
				
				{if $aInput.type_id == 'checkbox'}
					{foreach from=$aInput.option item=aOption}
						<div class="div_input_checkbox">
							<input type="checkbox" class="input_checkbox" {value type='checkbox' id=$aOption.option_id default='0'} value="{$aOption.option_id}" name="val[input_{$aInput.field_id}][]" id="input_{$aInput.field_id}_checkbox_{$phpfox.iteration.input}">
							<label for="input_{$aInput.field_id}_checkbox_{$phpfox.iteration.input}">
								{phrase var=$aOption.phrase_var}
							</label>
						</div>
					{/foreach}
				{/if}
				
				{if $aInput.type_id == 'radio'}
					{foreach from=$aInput.option item=aOption}
						<div class="div_input_radio">
							<input type="radio" class="input_radio" {value type='radio' id=$aOption.option_id default='0'} value="{$aOption.option_id}" name="val[input_{$aInput.field_id}]" id="input_{$aInput.field_id}_radio_{$phpfox.iteration.input}">
							<label for="input_{$aInput.field_id}_radio_{$phpfox.iteration.input}">
								{phrase var=$aOption.phrase_var}
							</label>
						</div>
					{/foreach}
				{/if}
			</div>
		</div>
	{/foreach}

	{if isset($bAjaxSearch) && $bAjaxSearch}
		<div class="clear"></div>
		<div>
			<input type="submit" class="button" value="Search">
			<div class="js_search_input_close">
				<a href="#" onclick="$('#js_search_input_holder').hide(); return false;">
					{phrase var='input.close'}
				</a>
			</div>
		</div>
	{/if}
</div>