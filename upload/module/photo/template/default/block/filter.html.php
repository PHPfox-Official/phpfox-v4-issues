<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: filter.html.php 1247 2009-11-03 16:08:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{$sPhotoUrl}" id="js_photo_form">
	{phrase var='photo.search_for_keyword'}:
	<div class="p_4">
		{filter key='search'}
	</div>
	<div class="p_top_4">
	{phrase var='photo.display'}:
		<div class="p_4">
			{filter key='display'}
		</div>
	</div>	
	<div class="p_top_4">
	{phrase var='photo.sort'}:
		<div class="p_4">
			{filter key='sort'} {filter key='sort_by'}
		</div>
	</div>		
	<div class="p_top_8">
		<input type="submit" name="search[submit]" value="{phrase var='core.submit'}" class="button" />
		<input type="submit" name="search[reset]" value="{phrase var='core.reset'}" class="button" />	
	</div>
</form>