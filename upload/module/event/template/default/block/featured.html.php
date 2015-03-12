<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aFeatured item=aFeature name=featured}
<div class="{if is_int($phpfox.iteration.featured/2)}row1{else}row2{/if}{if $phpfox.iteration.featured == 1} row_first{/if}">
	<div style="float:left; width:50px;" class="t_center">
		<a href="{permalink module='event' id=$aFeature.event_id title=$aFeature.title}" title="{$aFeature.title|clean}">{img server_id=$aFeature.server_id path='event.url_image' file=$aFeature.image_path suffix='_50' max_width=50 max_height=50}</a>
	</div>
	<div style="margin-left:60px;">
		<a href="{permalink module='event' id=$aFeature.event_id title=$aFeature.title}" class="row_sub_link" title="{$aFeature.title|clean}">{$aFeature.title|clean|shorten:50:'...'|split:20}</a>
		<div class="extra_info_link">
			{phrase var='event.by'} {$aFeature|user}
		</div>
	</div>
	<div class="clear"></div>
</div>
{/foreach}