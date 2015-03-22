<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 7023 2014-01-06 20:22:55Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.theme.add'}">
	{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.theme_id}" /></div>
	{/if}
	<div class="table_header">
		{phrase var='theme.theme_details'}
	</div>
	{if count($aThemes)}
	<div class="table">
		<div class="table_left">
			{phrase var='theme.parent_theme'}:
		</div>
		<div class="table_right">
			<select name="val[parent_id]">
			{foreach from=$aThemes item=aTheme}
				<option value="{$aTheme.theme_id}"{value id='parent_id' type='select' default=$aTheme.theme_id}>{$aTheme.name}</option>
			{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>	
	{/if}	
	<div class="table">
		<div class="table_left">
			{phrase var='theme.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value id='name' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='theme.folder'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[folder]" value="{value id='folder' type='input'}" size="40" />
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
			Columns:
		</div>
		<div class="table_right">
			<select name="val[total_column]" id="total_column">
				<option value="">{phrase var='theme.select'}</option>
				<option value="2" {value id='total_column' type='select' default='2'}>2</option>
				<option value="3" {value id='total_column' type='select' default='3'}>3</option>
				<option value="4" {value id='total_column' type='select' default='4'}>4</option>
			</select> 
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
	<div class="table_clear">
		<input type="submit" value="{if $bIsEdit}{phrase var='theme.update'}{else}{phrase var='theme.submit'}{/if}" class="button" />
	</div>
</form>
