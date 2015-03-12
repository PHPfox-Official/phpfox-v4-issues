<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: album-tag.html.php 2610 2011-05-19 18:43:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="block_listing_inline">
	<ul>
{foreach from=$aTaggedUsers item=aTaggedUser}
		<li>{img user=$aTaggedUser suffix='_50_square' max_width=32 max_height=32 class='js_hover_title'}</li>	
{/foreach}
	</ul>
	<div class="clear"></div>
</div>