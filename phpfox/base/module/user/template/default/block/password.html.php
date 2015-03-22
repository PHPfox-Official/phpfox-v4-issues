<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
<div id="js_progress_cache_loader"></div>
<form method="post" action="{url link='current'}" onsubmit="$(this).ajaxCall('user.updatePassword'); return false;">
	<div class="table">
		<div class="table_left">
			{phrase var='user.old_password'}:
		</div>
		<div class="table_right">
			<input type="password" name="val[old_password]" value="" size="30" />
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="separate"></div>
	
	<div class="table">
		<div class="table_left">
			{phrase var='user.new_password'}:
		</div>
		<div class="table_right">
			<input type="password" name="val[new_password]" value="" size="30" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='user.confirm_password'}:
		</div>
		<div class="table_right">
			<input type="password" name="val[confirm_password]" value="" size="30" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='user.update'}" class="button" />
	</div>
</form>