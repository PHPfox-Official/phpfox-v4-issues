<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: file.html.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.setting.file'}">
	<div class="table_header">
		{phrase var='admincp.export'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.product'}:
		</div>
		<div class="table_right">
			<select name="export">
			{foreach from=$aProducts item=aProduct}
				<option value="{$aProduct.product_id}">{$aProduct.title}</option>
			{/foreach}
			</select>
			{help var='admincp.setting_file_product'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.download_file_format'}:
		</div>
		<div class="table_right">
			<select name="file_extension">
			{foreach from=$aArchives item=aArchives}
				<option value="{$aArchives}">.{$aArchives}</option>
			{/foreach}
			</select>
			{help var='admincp.setting_file_extension'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.download'}" class="button" />
	</div>
</form>

<br />

<form method="post" action="{url link='admincp.setting.file'}" enctype="multipart/form-data">
	<div class="table_header">
		{phrase var='admincp.import'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.select_file'}:
		</div>
		<div class="table_right">
			<input type="file" name="import" />
			<div class="p_4">
				{phrase var='admincp.valid_file_extensions'}: {$sSupported}
			</div>
			{help var='admincp.setting_file_import'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.upload'}" class="button" />
	</div>
</form>