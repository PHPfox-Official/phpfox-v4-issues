<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: inline-search.html.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aRows key=sKey item=aRow name=inline}
<div class="item{if $phpfox.iteration.inline == 1} first{/if}">
		{if isset($bIsUser)}
		<div class="go_left t_right" style="width:21px; position:relative;">
			<a href="#?tag={$aRow.tag_text}" class="js_inline_search_link">{img no_link=true user=$aRow suffix='_50' max_width=20 max_height=20}</a>
		</div>
		<div style="margin-left:30px; position:relative;">
		{/if}
		<a href="#?id={$sJsId}&amp;tag={$aRow.tag_text}{if isset($bIsUser)}&amp;input={$aRow.user_id}{/if}" class="js_inline_search_link">{$aRow.tag_text|tag_search:$sSearch}</a>
		{if isset($bIsUser)}
		</div>
		<div class="clear"></div>
		{/if}
</div>	
{/foreach}
<script type="text/javascript">
	$Core.loadInit();
</script>