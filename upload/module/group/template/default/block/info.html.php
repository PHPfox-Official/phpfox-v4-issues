<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: info.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="info">
	<div class="info_left">
		{phrase var='group.founded_on'}:
	</div>
	<div class="info_right">
		{$aGroup.time_stamp|date:'group.group_view_time_stamp'}	
	</div>
</div>

<div class="info">
	<div class="info_left">
		{phrase var='group.members'}:
	</div>
	<div class="info_right">
		<span id="js_group_member_count">{$aGroup.total_member}</span>
	</div>
</div>	

<div class="info">
	<div class="info_left">
		{phrase var='group.location'}:
	</div>
	<div class="info_right">
		{$aGroup.country_iso|location}	
		{if !empty($aGroup.country_child_id)}
		<div class="p_2">&raquo; {$aGroup.country_child_id|location_child}</div>
		{/if}
		{if !empty($aGroup.city)}
		<div class="p_2">&raquo; {$aGroup.city|clean} </div>
		{/if}
	</div>
</div>

<div class="info">
	<div class="info_left">
		{phrase var='group.category'}:
	</div>
	<div class="info_right">
	{foreach from=$aGroup.breadcrumb name=breadcrumbs item=aBredcrumb}
	{if $phpfox.iteration.breadcrumbs != 1}<div class="p_2">&raquo; {/if}
		<a href="{$aBredcrumb.1}">{$aBredcrumb.0}</a>
		{if $phpfox.iteration.breadcrumbs != 1}</div>{/if}
	{/foreach}
	</div>
</div>