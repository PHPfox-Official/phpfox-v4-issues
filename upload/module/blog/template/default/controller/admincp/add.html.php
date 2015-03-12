<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: add.html.php 281 2009-03-05 12:20:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link="admincp.blog.add"}" id="js_form" onsubmit="{$sGetJsForm}">
	<div class="table_header">
	{phrase var='blog.category_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='blog.category'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value type='input' id='name'}" id="name" size="30" />
			{help var='admincp.blog_category_add_name'}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
	</div>
</form>