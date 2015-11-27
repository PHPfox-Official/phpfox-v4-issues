<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aLikes name=like item=aLike}
<div class="{if is_int($phpfox.iteration.like/2)}row1{else}row2{/if}{if $phpfox.iteration.like == 1} row_first{/if}">
	<div class="go_left">
		{img user=$aLike suffix='_50' max_width=50 max_height=50}	
	</div>
	<div>
		{$aLike|user}
	</div>
	<div class="clear"></div>
</div>
{/foreach}