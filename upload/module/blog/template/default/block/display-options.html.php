<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: display-options.html.php 305 2009-03-24 21:09:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{$sFormUrl}">
<div class="p_bottom_15">

{phrase var='blog.search_for_text'}:
<div class="p_4">
	{$aFilters.search}
</div>

<div class="p_top_4">
	{phrase var='blog.display'}:
	<div class="p_4">
		{$aFilters.display}
	</div>
</div>

<div class="p_top_4">
	{phrase var='blog.sort_single'}:
	<div class="p_4">
		{$aFilters.sort}
	</div>
</div>

<div class="p_top_4">
	{phrase var='blog.single'}:
	<div class="p_4">
		{$aFilters.sort_by}
	</div>
</div>

{plugin call='blog.template_block_displayoptions'}

<div class="p_top_8">
	<input type="submit" name="search[submit]" value="{phrase var='core.submit'}" class="button" />
	<input type="submit" name="search[reset]" value="{phrase var='core.reset'}" class="button" />	
</div>

</div>
</form>