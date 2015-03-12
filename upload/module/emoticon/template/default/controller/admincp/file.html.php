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
<form method="post" action="{url link='admincp.emoticon.file'}" enctype="multipart/form-data">	
	<div class="table_header">
		{phrase var='emoticon.import'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='emoticon.file'}:
		</div>
		<div class="table_right">
			<input type="file" name="import" size="40" />
			<div class="extra_info">
				{phrase var='emoticon.xml_files_only_and_must'}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='emoticon.overwrite'}:
		</div>
		<div class="table_right">	
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[overwrite]" value="1" /> {phrase var='emoticon.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[overwrite]" value="0" checked="checked" /> {phrase var='emoticon.no'}</span>
			</div>
		</div>
		<div class="clear"></div>		
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='emoticon.import'}" class="button" name="import" />
	</div>
</form>