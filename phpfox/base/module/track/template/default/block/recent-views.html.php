<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Track
 * @version 		$Id: recent-views.html.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="block_listing_inline">
	<ul>
{foreach from=$aLatestUsers name=latestusers key=iLatestUser item=aLatestUser}
		<li>{img user=$aLatestUser suffix='_50_square' max_width=32 max_height=32 class='js_hover_title'}</li>
{/foreach}
	</ul>
	<div class="clear"></div>
</div>