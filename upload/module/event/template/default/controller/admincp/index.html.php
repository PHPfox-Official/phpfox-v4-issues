<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 2197 2010-11-22 15:26:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_menu_drop_down" style="display:none;">
	<div class="link_menu dropContent" style="display:block;">
		<ul>
			<li><a href="#" onclick="return $Core.event.action(this, 'edit');">{phrase var='event.edit'}</a></li>
			<li><a href="#" onclick="return $Core.event.action(this, 'delete');">{phrase var='event.delete'}</a></li>
		</ul>
	</div>
</div>
<div class="table_header">
	{phrase var='event.categories'}
</div>
<form method="post" action="{url link='admincp.event'}">
	<div class="table">
		<div class="sortable">
			{$sCategories}			
		</div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='event.update_order'}" class="button" />
	</div>
</form>