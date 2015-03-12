<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: display.html.php 3118 2011-09-16 10:51:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

<div class="table">
	<div class="table_left">
		{phrase var='ad.location'}:
	</div>
	<div class="table_right">
		{if isset($aAllCountries)}
			<select multiple="multiple" name="val[country_iso_custom][]" id="country_iso_custom">
				<option value="">{phrase var='core.any'}
				{foreach from=$aAllCountries key=sIso item=aCountry}
					<option value="{$sIso}" {if isset($aForms) && isset($aForms.countries_list)}{foreach from=$aForms.countries_list item=sChosen} {if $sChosen == $sIso} selected="selected" {/if}{/foreach}{/if}> {$aCountry.name}
				{/foreach}
			</select>
		{else}
			{select_location value_title='phrase var=core.any' name='country_iso_custom'}
		{/if}
	</div>
	<div class="clear"></div>
</div>

{if Phpfox::getParam('ad.advanced_ad_filters')}
	<div class="table tbl_province">
		<div class="table_left">
			State/Province:
		</div>
		<div class="table_right">
			{foreach from=$aAllCountries item=aCountry}
				{if is_array($aCountry.children) && !empty($aCountry.children)}				
					<div id="country_{$aCountry.country_iso}" class="select_child_country">
						<div>{$aCountry.name}</div>
						<select class="sct_child_country" id="sct_country_{$aCountry.country_iso}" name="val[child_country][{$aCountry.country_iso}][]" multiple="multiple">
							{foreach from=$aCountry.children item=aChild}
								<option value="{$aChild.child_id}">{$aChild.name_decoded}</option>
							{/foreach}
						</select>
					</div>
				{/if}
			{/foreach}
		</div>
	</div>
	
	<div class="table">
			<div class="table_left">
				Postal Code:
			</div>
			<div class="table_right">
				<input type="text" name="val[postal_code]" id='postal_code' value="{value type='input' id='postal_code'}">
				<div class="extra_info">
					Separate multiple postal codes by a comma.
				</div>
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				City:
			</div>
			<div class="table_right">
				<input type="text" name="val[city_location]" id='city_location' value="{value type='input' id='city_location'}">
				<div class="extra_info">
					Separate multiple cities by a comma.
				</div>
			</div>
		</div>
{/if}
		<div class="table">
			<div class="table_left">
				{phrase var='ad.gender'}:
			</div>
			<div class="table_right">
				{select_gender value_title='phrase var=core.any'}
			</div>
			<div class="clear"></div>
		</div>	
		<div class="table">
			<div class="table_left">
				{phrase var='ad.age_group_between'}:
			</div>
			<div class="table_right">
				<select name="val[age_from]" id="age_from">
					<option value="">{phrase var='ad.any'}</option>
					{foreach from=$aAge item=iAge}
						<option value="{$iAge}"{value type='select' id='age_from' default=$iAge}>{$iAge}</option>
					{/foreach}
				</select>
				<span id="js_age_to">
					{phrase var='ad.and'}
					<select name="val[age_to]" id="age_to">
					<option value="">{phrase var='ad.any'}</option>
					{foreach from=$aAge item=iAge}
						<option value="{$iAge}"{value type='select' id='age_to' default=$iAge}>{$iAge}</option>
					{/foreach}
					</select>
				</span>
			</div>
			<div class="clear"></div>
		</div>		