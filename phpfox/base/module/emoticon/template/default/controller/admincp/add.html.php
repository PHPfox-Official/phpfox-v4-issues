<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Emoticon
 * @version 		$Id: add.html.php 1577 2010-05-06 13:53:38Z Raymond_Benc $
 */

?>

<div class="table_header">{phrase var='emoticon.emoticon_details'}</div>
<form action="{url link='admincp.emoticon.add'}" method="post" enctype="multipart/form-data">
{if isset($aForms.emoticon_id)}
<input type="hidden" name="val[emoticon_id]" value="{$aForms.emoticon_id}">
{/if}
	<div class="table" {if isset($aForms.emoticon_id)} style="display:none;"{/if}>
		<div class="table_left">
			{phrase var='emoticon.package'}:
		</div>
		<div class="table_right">
			<select name='val[package_path]' id="package_path">
				{foreach from=$aPackages item=aPackage key=iKey}
					<option value="{$aPackage.package_path}" {value type='select' id='package_path' default=$aPackage.package_path}>{$aPackage.package_name}</option>					
				{/foreach}
			</select>
		</div>
	</div>	
	<div class="clear"></div>
	{if !isset($aForms.emoticon_id)}
	<div class="table">
		<div class="table_left">
			{phrase var='emoticon.image'}:
		</div>
		<div class="table_right">
			<input type="file" name="file">
		</div>
	</div>
	<div class="clear"></div>
	{/if}
	<div class="table">
		<div class="table_left">
			{phrase var='emoticon.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value type='input' id='title'}" id="title">
		</div>
	</div>
	<div class="clear"></div>
	<div class="table">
		<div class="table_left">
			{phrase var='emoticon.symbol'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[text]" value="{value type='input' id='text'}">
		</div>
	</div>
	<div class="clear"></div>
	<div class="table_clear">
		<input type="submit" value="{if isset($aForms)}{phrase var='emoticon.edit'}{else}{phrase var='emoticon.add'}{/if}" class="button" />
	</div>
</form>