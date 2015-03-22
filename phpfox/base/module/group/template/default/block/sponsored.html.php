<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: sponsored.html.php 1559 2010-05-04 13:06:56Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($aSponsorGroup.image_path) && !empty($aSponsorGroup)}
<div class="t_center">
    <a href="{url link='ad.sponsor' view=$aSponsorGroup.sponsor_id}">
	{img server_id=$aSponsorGroup.server_id title=$aSponsorGroup.title path='group.url_image' file=$aSponsorGroup.image_path suffix='_200' max_width='200' max_height='200'}
    </a>
</div>
{/if}
<div class="t_center info sponsored_title">
    <a href="{url link='ad.sponsor' view=$aSponsorGroup.sponsor_id}">
	{$aSponsorGroup.title}
    </a>
</div>
<div class="t_center info sponsored_short_description">
    {$aSponsorGroup.short_description}
</div>

<div class="info">
    <div class="info_left">
		{phrase var='group.founded_on'}:
    </div>
    <div class="info_right">
		{$aSponsorGroup.time_stamp|date:'group.group_view_time_stamp'}
    </div>
</div>

<div class="info">
    <div class="info_left">
		{phrase var='group.members'}:
    </div>
    <div class="info_right">
	<span id="js_group_member_count">{$aSponsorGroup.total_member}</span>
    </div>
</div>

<div class="info">
    <div class="info_left">
		{phrase var='group.location'}:
    </div>
    <div class="info_right">
		{$aSponsorGroup.country_iso|location}
		{if !empty($aSponsorGroup.country_child_id)}
	<div class="p_2">&raquo; {$aSponsorGroup.country_child_id|location_child}</div>
		{/if}
		{if !empty($aSponsorGroup.city)}
	<div class="p_2">&raquo; {$aSponsorGroup.city|clean} </div>
		{/if}
    </div>

    <div class="info_left">
		{phrase var='group.category'}:
    </div>
    <div class="info_right">
	{foreach from=$aSponsorGroup.categories name=categories item=aCategory}
	{if $phpfox.iteration.categories != 1}<div class="p_2">&raquo; {/if}
	    <a href="{$aCategory.1}">{$aCategory.0}</a>
		{if $phpfox.iteration.categories != 1}</div>{/if}
	{/foreach}
    </div>
</div>