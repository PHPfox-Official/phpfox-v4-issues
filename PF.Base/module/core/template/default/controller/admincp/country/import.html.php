<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: import.html.php 1931 2010-10-25 11:58:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !Phpfox::getParam('core.phpfox_is_hosted')}
<form method="post" action="{url link='admincp.core.country.import'}" enctype="multipart/form-data">
	<div class="table_header">
		{phrase var='admincp.import_country_package'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.file'}:
		</div>
		<div class="table_right">
			<input type="file" name="import" size="40" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.overwrite'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="overwrite" value="1" /> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="overwrite" value="0" checked="checked" /> {phrase var='admincp.no'}</span>
			</div>			
		</div>
		<div class="clear"></div>		
	</div>		
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.import'}" class="button" />
	</div>
</form>
<br />
{/if}
<form method="post" action="{url link='admincp.core.country.import'}" enctype="multipart/form-data">
	<div class="table_header">
		{phrase var='admincp.import_text_file'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.country'}:
		</div>
		<div class="table_right">
			{select_location}
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.file'}:
		</div>
		<div class="table_right">
			<input type="file" name="file_import" size="40" />
			<div class="extra_info">
				{phrase var='admincp.you_can_upload_a_text_file_with_a_list'}
			</div>
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.enable_utf_encoding'}:
		</div>
		<div class="table_right">
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[utf_encoding]" value="1" /> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[utf_encoding]" value="0" checked="checked" /> {phrase var='admincp.no'}</span>
			</div>	
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.import'}" class="button" />
	</div>
</form>