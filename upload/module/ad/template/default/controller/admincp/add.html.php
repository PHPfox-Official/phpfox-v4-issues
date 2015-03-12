<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 7263 2014-04-09 20:07:47Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link='admincp.ad.add'}" enctype="multipart/form-data" onsubmit="{$sGetJsForm}">
{if $bIsEdit}
	<div><input type="hidden" name="val[type_id]" value="{$aForms.type_id}" id="type_id" /></div>
	<div><input type="hidden" name="id" value="{$aForms.ad_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='ad.media'}
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='ad.banner_type'}:
		</div>
		<div class="table_right">			
			{if $bIsEdit}
				{if $aForms.type_id == 1}
					{phrase var='ad.image'}
				{elseif $aForms.type_id == 2}
					{phrase var='ad.html'}
				{/if}
			{else}
				<select name="val[type_id]" id="type_id">
					<option value="">{phrase var='core.select'}:</option>
					<option value="1"{value type='select' id='type_id' default='1'}>{phrase var='ad.image'}</option>
					<option value="2"{value type='select' id='type_id' default='2'}>{phrase var='ad.html'}</option>
				</select>	
			{/if}
		</div>
		<div class="clear"></div>
	</div>

	{if $bIsEdit && $aForms.location == 50}
	<div><input type="hidden" name="val[html_code]" value="{value type='input' id='html_code'}" size="25" maxlength="25" id="html_body" /></div>
	<div class="table">
		<div class="table_left">
			{phrase var='ad.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[c_ad_title]" value="{value type='input' id='c_ad_title'}" size="25" maxlength="25" id="c_ad_title" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='ad.body_text'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[c_ad_body]" value="{value type='input' id='c_ad_body'}" size="50" id="c_ad_body" />
		</div>
		<div class="clear"></div>
	</div>
	{else}
	<div class="table js_add_hidden" id="js_type_html" style="display:none;">
		<div class="table_left">
			{required}{phrase var='ad.html'}:
		</div>
		<div class="table_right">
			<textarea name="val[html_code]" cols="60" rows="8" id="html_code" style="width:90%;">{value type='textarea' id='html_code'}</textarea>		
			<div class="extra_info">
				<a href="#" onclick="$Core.popup('{url link='ad.preview'}', {literal}{{/literal}scrollbars: 'yes', location: 'no', menubar: 'no', width: 900, height: 400, resizable: 'yes', center: true{literal}}{/literal}); return false;">{phrase var='ad.preview_this_ad'}</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	{/if}

	<div class="table js_add_hidden" id="js_type_image" style="display:none;">
		<div class="table_left">
			{required}{phrase var='ad.banner_image'}:
		</div>
		<div class="table_right">
		{if $bIsEdit}
			<div id="js_ad_banner">
				{img file=$aForms.image_path path='ad.url_image' server_id=$aForms.server_id}
				<div class="extra_info">
					{phrase var='ad.click_here_to_change_this_banner_image'}
				</div>
			</div>
		{/if}		
			<div id="js_ad_upload_banner"{if $bIsEdit} style="display:none;"{/if}>
				<input type="file" name="image" size="30" />{if $bIsEdit} - <a href="#" onclick="$('#js_ad_upload_banner').hide(); $('#js_ad_banner').show(); return false;">{phrase var='ad.cancel'}</a>{/if}
				<div class="extra_info">
					{phrase var='ad.you_can_upload_a_jpg_gif_or_png_file'}
				</div>		
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table" id="js_type_image_link" style="display:none;">
		<div class="table_left">
		{required}{phrase var='ad.banner_link'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[url_link]" value="{value type='input' id='url_link'}" id="url_link" size="40" />
		</div>
		<div class="clear"></div>
	</div>	
	
	<div class="table_header">
		{phrase var='ad.campaign_details'}
	</div>
	<div class="table">
		<div class="table_left">
		{required}{phrase var='ad.campaign_name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value type='input' id='name'}" id="name" size="40" maxlength="150" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='ad.start_date'}:
		</div>
		<div class="table_right">
			{select_date prefix='start_' start_year='current_year' end_year='+10' field_separator=' / ' field_order='MDY' default_all=true add_time=true time_separator='core.time_separator'}
			<div class="extra_info">
				{phrase var='ad.note_the_time_is_set_to_your_registered_time_zone'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='ad.end_date'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[end_option]" value="0" checked="checked" class="v_middle end_option" {value type='radio' id='end_option' default='0'}/> {phrase var='ad.do_not_end_this_campaign'}</label> <br />
			<label><input type="radio" name="val[end_option]" value="1" class="v_middle end_option" {value type='radio' id='end_option' default='1'}/> {phrase var='ad.end_on_a_specific_date'}</label>
			<div style="display:none;" id="js_end_option">
				<div class="p_4">
					{select_date prefix='end_' start_year='current_year' end_year='+10' field_separator=' / ' field_order='MDY' default_all=true add_time=true start_hour='+10' time_separator='core.time_separator'}
					<div class="extra_info">
						{phrase var='ad.note_the_time_is_set_to_your_registered_time_zone'}
					</div>					
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='ad.total_views'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[total_view]" value="{value type='input' id='total_view'}" id="total_view" class="{if (isset($aForms) && isset($aForms.view_unlimited)) || (!isset($aForms))}disabled {/if}v_middle" size="10"{if (isset($aForms) && isset($aForms.view_unlimited)) || (!isset($aForms))} disabled="disabled" {/if}/>
			<label><input type="checkbox" name="val[view_unlimited]" id="view_unlimited" class="v_middle"{if (isset($aForms) && isset($aForms.view_unlimited)) || (!isset($aForms))} checked="checked" {/if}/> {phrase var='ad.unlimited'}</label>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="table" id="js_total_click" style="display:none;">
		<div class="table_left">
			{phrase var='ad.total_clicks'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[total_click]" value="{value type='input' id='total_click'}" id="total_click" class="{if (isset($aForms) && isset($aForms.click_unlimited)) || (!isset($aForms))}disabled {/if}v_middle" size="10"{if (isset($aForms) && isset($aForms.click_unlimited)) || (!isset($aForms))} disabled="disabled" {/if}/>
			<label><input type="checkbox" name="val[click_unlimited]" id="click_unlimited" class="v_middle"{if (isset($aForms) && isset($aForms.click_unlimited)) || (!isset($aForms))} checked="checked" {/if}/> {phrase var='ad.unlimited'}</label>
		</div>
		<div class="clear"></div>
	</div>	
	
	{if isset($aForms.is_custom) && $aForms.is_custom == '2'}
	<div><input type="hidden" name="val[is_active]" value="1" /></div>
	{else}
	<div class="table">
		<div class="table_left">
			{phrase var='ad.active'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[is_active]" value="1"{value type='radio' id='is_active' default='1' selected=true}/> {phrase var='admincp.yes'}</label>
			<label><input type="radio" name="val[is_active]" value="0"{value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}</label>			
		</div>
		<div class="clear"></div>
	</div>	
	{/if}
	
	<div class="table_header">
		{phrase var='ad.placement'}
	</div>
	{if $bIsEdit && $aForms.location == 50}
	<div style="display:none;">
	{/if}
	{module name='admincp.module.form' module_form_title='ad.module_placement' module_form_required=false module_form_value='All Modules' module_form_id='module_access'}
	{if $bIsEdit && $aForms.location == 50}
	</div>
	{/if}
	<div class="table"{if $bIsEdit && $aForms.location == 50} style="display:none;"{/if}>
		<div class="table_left">
			{phrase var='ad.placement'}:
		</div>
		<div class="table_right">
			{if $bIsEdit && $aForms.location == 50}
			<input type="hidden" name="val[location]" value="50" />
			{else}
			<select name="val[location]" id="location">	
				<optgroup label="Blocks">
					{for $i = 1; $i <= 12; $i++}
						<option value="{$i}"{value type='select' id='location' default=$i}>{phrase var='admincp.block' x=$i}</option>
					{/for}
					{if $bIsEdit && Phpfox::getParam('ad.multi_ad')}
						<option value="50"{value type='select' id='location' default=50}>{phrase var='admincp.block' x=50}</option>
					{/if}
				</optgroup>
				<optgroup label="Specific Locations">
					<option value="photo_theater"{if $bIsEdit && $aForms.location == 'photo_theater'} selected="selected"{/if}>Photo Theater Mode</option>
				</optgroup>
				<optgroup label="Component Block">
					{foreach from=$aComponents key=sName item=aComponent}
						<option value="{$sName}" style="font-weight:bold;"{value type='select' id='m_connection' default=$sName}>{$sName|translate:'module'}</option>
						{foreach from=$aComponent item=aComp}
							<option value="{$sName}|{$aComp.component}"{value type='select' id='component' default=''$sName'|'$aComp.component''}>-- {$aComp.component}</option>
						{/foreach}
					{/foreach}
				</optgroup>
			</select>
			<a href="#?call=ad.sample&amp;width=scan&amp;click=1" class="inlinePopup" title="{phrase var='admincp.sample_layout'}">{phrase var='ad.view_site_layout'}</a>
			<div class="extra_info">
				{phrase var='ad.notice_the_ad_sizes_provided_is_a_recommendation'}
			</div>
			{/if}
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='ad.disallow_controller'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[disallow_controller]" value="{value type='input' id='disallow_controller'}" id="name" size="40" />
			<div class="extra_info">
				{phrase var='ad.separate_each_controller_with_a_comma_eg_blog_index_video_view'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	
	<div class="table_header">
		{phrase var='ad.audience'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='ad.user_groups'}:
		</div>
		<div class="table_right">
			<select name="val[is_user_group]" id="js_is_user_group">
				<option value="1"{value type='select' id='is_user_group' default='1'}>{phrase var='ad.all_user_groups'}</option>
				<option value="2"{value type='select' id='is_user_group' default='2'}>{phrase var='ad.selected_user_groups'}</option>
			</select>
			<div class="p_4" style="display:none;" id="js_user_group">
			{foreach from=$aUserGroups item=aUserGroup}
				<div class="p_4">
					<label><input type="checkbox" name="val[user_group][]" value="{$aUserGroup.user_group_id}"{if isset($aAccess) && is_array($aAccess)}{if in_array($aUserGroup.user_group_id, $aAccess)} checked="checked" {/if}{else} checked="checked" {/if}/> {$aUserGroup.title|convert|clean}</label>
				</div>
			{/foreach}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='ad.location'}:
		</div>
		<div class="table_right">
			{if isset($aAllCountries)}
				<select multiple="multiple" name="val[country_iso_custom][]" id="country_iso_custom">
					<option value="">{phrase var='core.any'}</option>
					{foreach from=$aAllCountries key=sIso item=aCountry}
						<option value="{$sIso}" {if isset($aForms) && isset($aForms.countries_list)}{foreach from=$aForms.countries_list item=sChosen} {if $sChosen == $sIso} selected="selected" {/if}{/foreach}{/if}> {$aCountry.name}</option>
					{/foreach}
				</select>
			{else}
				{select_location value_title='phrase var=core.any' multiple=1 name='country_iso_custom'}
			{/if}
			
		</div>
		<div class="clear"></div>
	</div>
	 
	{if Phpfox::getParam('ad.advanced_ad_filters')}
		<div class="table tbl_province" style="display:none;">
			<div class="table_left">
				State/Province:
			</div>
			<div class="table_right">
				{foreach from=$aAllCountries item=aCountry}
					{if is_array($aCountry.children) && !empty($aCountry.children)}				
						<div id="country_{$aCountry.country_iso}" class="select_child_country" style="display:none;">
							<div>{$aCountry.name}</div>
							<select class="sct_child_country" id="sct_country_{$aCountry.country_iso}" name="val[child_country][{$aCountry.country_iso}][]" multiple="multiple">
								{foreach from=$aCountry.children item=aChild}
									<option value="{$aChild.child_id}" data-id="{$aChild.child_id}">{$aChild.name_decoded}</option>
								{/foreach}
							</select>
						</div>
					{/if}
				{/foreach}
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='ad.postal_code'}:
			</div>
			<div class="table_right">
				<input type="text" name="val[postal_code]" id='postal_code' value="{value type='input' id='postal_code'}">
				<div class="extra_info">
					{phrase var='ad.separate_multiple_postal_codes_by_a_comma'}
				</div>
			</div>
		</div>
		
		<div class="table">
			<div class="table_left">
				{phrase var='ad.city'}:
			</div>
			<div class="table_right">
				<input type="text" name="val[city_location]" id='city_location' value="{value type='input' id='city_location'}">
				<div class="extra_info">
					{phrase var='ad.separate_multiple_cities_by_a_comma'}
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
				and
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
	
	<div class="table_clear">
		{if isset($aForms.is_custom) && $aForms.is_custom == '2'}
		<input type="submit" value="{phrase var='ad.approve'}" class="button" name="val[approve]" />
		<input type="submit" value="{phrase var='ad.deny'}" class="button" name="val[deny]" />
		{else}
		<input type="submit" value="{phrase var='core.submit'}" class="button" />
		{/if}
	</div>
</form>
