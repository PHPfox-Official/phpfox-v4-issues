<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: form.html.php 3805 2011-12-14 14:22:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
		<div class="custom_block_form">
			{if $aSetting.var_type == 'textarea'}
				<textarea class="custom_textarea" cols="60" style="width:90%;" rows="8" name="custom[{$aSetting.field_id}]">{if isset($aSetting.value)}{$aSetting.value|clean}{/if}</textarea>
			{elseif $aSetting.var_type == 'text'}
				<input type="text" name="custom[{$aSetting.field_id}]" value="{if isset($aSetting.value)}{$aSetting.value|clean}{/if}" size="30" maxlength="255"{if PHPFOX_IS_AJAX} style="width:90%;"{/if} />
			{elseif $aSetting.var_type == 'select'}
				<select name="custom[{$aSetting.field_id}]" id="custom_field_{$aSetting.field_id}">
					{if !$aSetting.is_required && !isset($aSetting.value)}
						{if !isset($aSetting.value)}
							<option value="">{phrase var='custom.select'}:</option>
						{/if}
					{else}
						{if !$aSetting.is_required}
						<option value="">{phrase var='custom.no_answer'}</option>
						{else}
						{if !isset($aSetting.value)}
						<option value="">{phrase var='custom.select'}:</option>
						{/if}
						{/if}						
					{/if}
					
					{foreach from=$aSetting.options key=iKey item=sOption}
						<option value="{$iKey}"{if isset($sOption.selected) && ($sOption.selected == true || $sOption.selected == 1)} selected="selected"{/if}>{$sOption.value}</option>
					{/foreach}
				</select>
			{elseif $aSetting.var_type == 'multiselect'}
				<select name="custom[{$aSetting.field_id}][]" multiple="multiple" id="custom_field_{$aSetting.field_id}">
					{*					
						{if !$aSetting.is_required}
							{if !isset($aSetting.value)}
								<option value="">{phrase var='custom.select'}:</option>
							{/if}
						{/if}					
					*}
					{foreach from=$aSetting.options key=iKey item=aOption}
						<option value="{$iKey}"{if isset($aOption.value) && isset($aOption.selected) && $aOption.selected == true} selected="selected"{/if}>{$aOption.value}</option>
					{/foreach}
				</select>
			{elseif $aSetting.var_type == 'radio'}
				{if !$aSetting.is_required}
					<div class="custom_block_form_radio">
						<input id="radio_no_answer" type="radio" name="custom[{$aSetting.field_id}]" value="0" checked="checked" />
						<label for="radio_no_answer"> {phrase var='custom.no_answer'} </label>
					</div> 
				{/if}
				{foreach from=$aSetting.options key=iKey item=aOption}
					<div class="custom_block_form_radio">
						<input id="radio_{$aSetting.field_id}_{$iKey}" type="radio" name="custom[{$aSetting.field_id}]" value="{$iKey}" {if isset($aOption.selected) && $aOption.selected == true}checked="checked"{/if}>
						<label for="radio_{$aSetting.field_id}_{$iKey}"> {$aOption.value} </label>
					</div> 
				{/foreach}
			{elseif $aSetting.var_type == 'checkbox'}
				{foreach from=$aSetting.options key=iKey item=aOption}
					<div class="custom_block_form_checkbox">
						<input id="checkbox_{$aSetting.field_id}_{$iKey}" type="checkbox" name="custom[{$aSetting.field_id}][]" value="{$iKey}" {if isset($aOption.selected) && $aOption.selected == true}checked="checked"{/if}>
						<label for="checkbox_{$aSetting.field_id}_{$iKey}">{$aOption.value} </label>
					</div>
				{/foreach}
			{/if}
		</div>