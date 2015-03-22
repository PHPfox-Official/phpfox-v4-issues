<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 2540 2011-04-17 20:29:39Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aEvents)}
<div class="extra_info">
	{phrase var='event.no_upcoming_events'}
	<ul class="action">
		<li><a href="{url link='event.add'}">{phrase var='event.add_an_event'}</a></li>
	</ul>
</div>
{else}
{foreach from=$aEvents name=events item=aEvent}
<div class="{if is_int($phpfox.iteration.events/2)}row1{else}row2{/if}{if $phpfox.iteration.events == 1} row_first{/if}" style="position:relative;">
	<div style="width:55px; position:absolute; left:0px;">
		<a href="{$aEvent.url}">{img server_id=$aEvent.server_id title=$aEvent.title path='event.url_image' file=$aEvent.image_path suffix='_50' max_width='50' max_height='50'}</a>
	</div>
	<div style="margin-left:60px; min-height:55px; height:auto !important; height:55px;">	
		<a href="{$aEvent.url}" title="{$aEvent.title|clean}">{$aEvent.title|clean|shorten:30:'...'|split:20}</a>
		{if !empty($aEvent.tag_line)}
		<div class="extra_info">
			{$aEvent.tag_line|clean|shorten:200:'...'|split:20}
		</div>
		{/if}	
		<div class="extra_info">
			{phrase var='event.time_stamp_at_location' time_stamp=$aEvent.start_time_stamp location=$aEvent.location_clean}{if !empty($aEvent.city)}, {$aEvent.city|clean}{/if}, {$aEvent.country_iso|location}
		</div>		
	</div>
</div>
{/foreach}
{/if}