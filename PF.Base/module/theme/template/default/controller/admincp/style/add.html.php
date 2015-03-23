<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 6642 2013-09-13 09:35:50Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.theme.style.add'}">
	{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.style_id}" /></div>
	{/if}	
	<div class="table_header">
		{phrase var='theme.style_details'}
	</div>
	{if !$bIsEdit}	
	<div class="table">
		<div class="table_left">
		{required}{phrase var='theme.parent_theme'}:
		</div>
		<div class="table_right">
			<select name="val[theme_id]">
				<option value="">{phrase var='theme.select'}:</option>
			{foreach from=$aThemes item=aTheme}
				<option value="{$aTheme.theme_id}"{value type='select' id='theme_id' default=$aTheme.theme_id}>{$aTheme.name}</option>
			{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='theme.parent_style'}:
		</div>
		<div class="table_right">
			<select name="val[parent_id]">
			{foreach from=$aStyles item=aStyle}
				<option value="{$aStyle.style_id}"{value type='select' id='parent_id' default=$aStyle.style_id}>{$aStyle.name}</option>
			{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>	
	{/if}	
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value id='name' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	{if !$bIsEdit}
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.folder_name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[folder]" value="{value id='folder' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>	
	{/if}	
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.logo_image'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[logo_image]" value="{value id='logo_image' type='input'}" size="40" />			
			<div class="extra_info">
				{phrase var='theme.default_logo_file_name_eg_logo_png'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='theme.creator'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[creator]" value="{value id='creator' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='theme.website'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[website]" value="{value id='website' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='theme.version'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[version]" value="{value id='version' type='input'}" size="10" />
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.is_default'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_default]" value="1" {value type='radio' id='is_default' default='1'}/> {phrase var='theme.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_default]" value="0" {value type='radio' id='is_default' default='0' selected='true'}/> {phrase var='theme.no'}</span>
			</div>
		</div>
		<div class="clear"></div>		
	</div>			
	<div class="table">
		<div class="table_left">
			{required}{phrase var='theme.is_active'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='theme.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='theme.no'}</span>
			</div>
		</div>
		<div class="clear"></div>		
	</div>	
	
	<div class="table_header">
		Custom Values
	</div>
	<div class="table">
		<div class="table_left">
			{required}Left Column Width:
		</div>
		<div class="table_right">
			<input type="text" name="val[l_width]" value="{value id='l_width' type='input'}" size="10" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{required}Center Column Width:
		</div>
		<div class="table_right">
			<input type="text" name="val[c_width]" value="{value id='c_width' type='input'}" size="10" />
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{required}Right Column Width:
		</div>
		<div class="table_right">
			<input type="text" name="val[r_width]" value="{value id='r_width' type='input'}" size="10" />
		</div>
		<div class="clear"></div>
	</div>		
	
	<div class="table_clear">
		<input type="submit" value="{if $bIsEdit}{phrase var='theme.update'}{else}{phrase var='theme.submit'}{/if}" class="button" />
	</div>
</form>
