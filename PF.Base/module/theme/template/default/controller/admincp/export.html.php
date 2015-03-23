<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: export.html.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.theme.export'}">
	<div><input type="hidden" name="theme" value="{$aTheme.theme_id}" /></div>
	<div><input type="hidden" name="val[theme_id]" value="{$aTheme.theme_id}" /></div>
	<div class="table_header">
		{phrase var='theme.export'}
	</div>	
	{if count($aStyles)}
	<div class="table">
		<div class="table_left">
			{phrase var='theme.export_styles'}:
		</div>
		<div class="table_right">
			<select name="val[styles][]" multiple="multiple" style="width:200px;">
			{foreach from=$aStyles item=aStyle}
				<option value="{$aStyle.style_id}">{$aStyle.name}</option>
			{/foreach}
			</select>
		</div>
		<div class="clear"></div>
	</div>
	{/if}
	<div class="table_clear">
		<input type="submit" value="{phrase var='theme.download'}" class="button" name="export" />
	</div>
</form>