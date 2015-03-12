<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: export.html.php 5259 2013-01-29 14:30:29Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='apps.export'}
</div>
<form method="post" action="{url link='admincp.apps.export'}">
	<div class="table">
		<div class="table_left">
			{phrase var='apps.package_title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value id='title' type='input'}" size="40" style="width:90%;" />			
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='apps.callback_url'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[url]" value="{value id='url' type='input'}"" size="40" style="width:90%;" />
			<div class="extra_info">
				{phrase var='apps.this_is_the_url_you_will'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='apps.apps_to_export'}:
		</div>
		<div class="table_right">
			<div class="label_flow" style="max-height:200px;">
			{foreach from=$aApps item=aApp}
				<div class="p_4">
					<label for="js_{$aApp.app_id}"><input name="val[apps][]" type="checkbox" value="{$aApp.app_id}" id="js_{$aApp.app_id}" checked="checked" /> {$aApp.app_title|clean}</label>
				</div>
			{/foreach}
			</div>			
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='apps.submit'}" class="button" />
	</div>
</form>