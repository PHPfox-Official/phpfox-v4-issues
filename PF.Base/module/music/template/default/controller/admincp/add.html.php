<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1164 2009-10-09 09:27:09Z Anna_Eliasson $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link='admincp.music.add'}" onsubmit="{$sGetJsForm}">
	<div class="table_header">
		{phrase var='music.genre_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='music.genre_name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value type='input' id='name'}" id="name" size="40" maxlength="150" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='music.add_genre'}" class="button" />
	</div>
</form>