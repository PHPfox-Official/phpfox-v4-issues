<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 1482 2010-02-23 14:28:34Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aGroups)}
<div class="extra_info">
	{phrase var='group.no_groups_added_yet'}
	<ul class="action">
		<li><a href="{url link='group.add'}">{phrase var='group.create_a_new_group'}</a></li>
	</ul>
</div>
{else}
{foreach from=$aGroups name=groups item=aGroup}
<div class="{if is_int($phpfox.iteration.groups/2)}row1{else}row2{/if}{if $phpfox.iteration.groups == 1} row_first{/if}">
	<div style="width:55px; position:absolute; text-align:center; left:20px;">
		<a href="{url link='group.'$aGroup.title_url'}">{img server_id=$aGroup.server_id title=$aGroup.title path='group.url_image' file=$aGroup.image_path suffix='_50' max_width='50' max_height='50'}</a>
	</div>
	<div style="margin-left:60px; min-height:55px; height:auto !important; height:55px;">	
		<a href="{url link='group.'$aGroup.title_url'}" title="{$aGroup.title|clean}">{$aGroup.title|shorten:30:'...'|split:20|clean}</a>
		{if !empty($aGroup.short_description)}
		<div class="extra_info">
			{$aGroup.short_description|shorten:200:'...'|split:20|clean}
		</div>
		{/if}	
		<div class="extra_info">
		{if !$aGroup.total_member}
			{phrase var='group.founded_on_time_stamp_with_no_members' time_stamp=$aGroup.time_stamp|date:'group.group_view_time_stamp'}
		{elseif $aGroup.total_member == 1}
			{phrase var='group.founded_on_time_stamp_with_a_href_link_1_member_a' time_stamp=$aGroup.time_stamp|date:'group.group_view_time_stamp' link=$aGroup.group_url}
		{else}
			{phrase var='group.founded_on_time_stamp_with_a_href_link_total_member_members_a' time_stamp=$aGroup.time_stamp|date:'group.group_view_time_stamp' link=$aGroup.group_url total_member=$aGroup.total_member}</a>.
		{/if}
		</div>		
	</div>
</div>
{/foreach}
{/if}