<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: parent.html.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aEvents)}
<div class="extra_info">
	{phrase var='event.no_upcoming_events'}
	<ul class="action">
		<li><a href="{url link='event.add' module=$aEventParent.module item=$aEventParent.item}">{phrase var='event.add_an_event'}</a></li>
	</ul>
</div>
{else}
{foreach from=$aEvents name=events item=aEvent}
<div class="{if is_int($phpfox.iteration.events/2)}row1{else}row2{/if}{if $phpfox.iteration.events == 1} row_first{/if}">
	<div style="width:55px; position:absolute; text-align:center;">
		<a href="{$aEvent.url}">{img server_id=$aEvent.server_id title=$aEvent.title path='event.url_image' file=$aEvent.image_path suffix='_50' max_width='50' max_height='50'}</a>
	</div>
	<div style="margin-left:60px; min-height:55px; height:auto !important; height:55px;">	
		<a href="{$aEvent.url}">{$aEvent.title|clean|shorten:25:'...'|split:20}</a>
		{if !empty($aEvent.tag_line)}
		<div class="extra_info">
			{$aEvent.tag_line|clean|shorten:30:'...'|split:20}
		</div>
		{/if}	
		<div class="extra_info">
			{phrase var='event.time_stamp_at_location' time_stamp=$aEvent.start_time_stamp location=$aEvent.location_clean}{if !empty($aEvent.city)}, {$aEvent.city|clean}{/if}, {$aEvent.country_iso|location}
		</div>		
	</div>
</div>
{/foreach}
{/if}