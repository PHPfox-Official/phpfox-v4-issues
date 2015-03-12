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
 * @version 		$Id: add.html.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */

?>
<div class="table_header">{phrase var='emoticon.package_details'}</div>
<form action="{url link='admincp.emoticon.package.add'}" method="post" enctype="multipart/form-data">
	{if isset($aForms)}
	<input type="hidden" name="val[package_path]" value="{$aForms.package_path}">
	{/if}
	{module name='admincp.product.form'}
	<div class="table">
		<div class="table_left">{required}{phrase var='emoticon.name'}: </div>
		<div class="table_right"><input type="text" id="package_name" name="val[package_name]" value="{value type='input' id='package_name'}" size="40" /></div>
		<div class="clear"></div>
	</div>
	{if !isset($aForms)}
	<div class="table">
		<div class="table_left">
			{phrase var='emoticon.mass_import'}:
		</div>
		<div class="table_right">
			<input type="file" name="import" size="30" />
			<div class="extra_info">
				{phrase var='emoticon.you_can_optionally_mass_import_emoticons_from_a_zip_package'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	{/if}
	<div class="table_clear">
		<input type="submit" value="{if isset($aForms)}{phrase var='emoticon.edit_package'}{else}{phrase var='emoticon.add'}{/if}" class="button" />
	</div>
</form>

