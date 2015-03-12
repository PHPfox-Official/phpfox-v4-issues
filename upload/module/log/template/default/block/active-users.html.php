<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Log
 * @version 		$Id: active-users.html.php 2675 2011-06-15 20:03:11Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="block_listing_inline">
	<ul>
{foreach from=$aActiveUsers key=iActiveUser item=aActiveUser}
		<li>{img user=$aActiveUser suffix='_50_square' max_width=32 max_height=32 class='js_hover_title'}</li>
{/foreach}
	</ul>
	<div class="clear"></div>
</div>