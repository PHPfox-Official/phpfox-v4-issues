<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1174 2009-10-11 13:56:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link='admincp.photo'}" id="js_form" onsubmit="{$sGetJsForm}">
	<div id="js_photo_hidden"></div>
	<div class="table_header" id="js_photo_table_header">
		{phrase var='photo.add_a_photo_category'}
	</div>
	<div class="table" id="js_photo_parent">
		<div class="table_left">
			{phrase var='photo.parent'}:
		</div>
		<div class="table_right">
			{module name='photo.drop-down' multiple=false}
		</div>			
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='photo.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value type='input' id='name'}" id="name" size="30" />
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" /><span id="js_photo_extra_button"></span>
	</div>
</form>
<div id="js_category_holder">
<br />
	<form method="post" action="{url link='admincp.photo'}">
		<div class="table_header">
			{phrase var='photo.categories'}
		</div>
		<div class="table">
			<div class="sortable">		
				{module name='photo.category' parent=false anchor=false}
			</div>
		</div>
		<div class="table_clear">
			<span id="js_update_order"></span><input type="submit" value="{phrase var='photo.update'}" class="button" />
		</div>
	</form>
</div>