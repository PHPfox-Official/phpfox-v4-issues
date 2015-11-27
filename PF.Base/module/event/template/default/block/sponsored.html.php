<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox
 * @version 		$Id: sponsored.html.php 3214 2011-09-30 12:05:14Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if isset($aSponsorEvents.image_path) && $aSponsorEvents.image_path != ''}
<div class="t_center">
    <a href="{url link='ad.sponsor' view=$aSponsorEvents.sponsor_id}">
	{img title=$aSponsorEvents.title path='event.url_image' file=$aSponsorEvents.image_path suffix='_200' max_width='200' max_height='200'}
    </a>
</div>
{/if}
<div class="t_center info sponsored_title">
    <a href="{url link='ad.sponsor' view=$aSponsorEvents.sponsor_id}">
	{$aSponsorEvents.title}
    </a>
</div>

{if isset($aSponsorEvents.host)}
<div class="info">
	<div class="info_left">
		{phrase var='event.host'}:
	</div>
	<div class="info_right">
		{$aSponsorEvents.host|clean}
	</div>
</div>
{/if}
<div class="info">
	<div class="info_left">
		{phrase var='event.date'}:
	</div>
	<div class="info_right">
		{$aSponsorEvents.event_date}
	</div>
</div>
{if !empty($aSponsorEvents.country_iso)}
<div class="info">
    <div class="info_left">
		{phrase var='event.location'}:
    </div>
    <div class="info_right">
		{$aSponsorEvents.country_iso|location}
		{if !empty($aSponsorEvents.country_child_id)}
	<div class="p_2">&raquo; {$aSponsorEvents.country_child_id|location_child}</div>
		{/if}
		{if !empty($aSponsorEvents.city)}
	<div class="p_2">&raquo; {$aSponsorEvents.city|clean} </div>
		{/if}
    </div>
</div>
{/if}