<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: invite.html.php 3533 2011-11-21 14:07:21Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="block_listing">
{foreach from=$aEventInvites item=aEventInvite}
	<li>
		<div class="block_listing_image">
			{img server_id=$aEventInvite.server_id title=$aEventInvite.title path='event.url_image' file=$aEventInvite.image_path suffix='_50' max_width='32' max_height='32'}
		</div>
		<div class="block_listing_title" style="padding-left:36px;">
			<a href="{permalink module='event' id=$aEventInvite.event_id title=$aEventInvite.title}">{$aEventInvite.title|clean}</a>
			<div class="extra_info">
				{$aEventInvite.start_time_phrase} at {$aEventInvite.start_time_phrase_stamp}	
				<div class="event_rsvp_invite_image" id="js_event_rsvp_invite_image_{$aEventInvite.event_id}">
					{img theme='ajax/add.gif'}
				</div>
				<ul class="event_rsvp_invite"><li>{phrase var='event.rsvp'}:</li><li><a href="#" onclick="$(this).parent().parent().hide(); $('#js_event_rsvp_invite_image_{$aEventInvite.event_id}').show(); $.ajaxCall('event.addRsvp', 'id={$aEventInvite.event_id}&amp;rsvp=1&amp;inline=1'); return false;">{phrase var='event.yes'}</a></li><li><span>&middot;</span></li><li><a href="#" onclick="$(this).parent().parent().hide(); $('#js_event_rsvp_invite_image_{$aEventInvite.event_id}').show(); $.ajaxCall('event.addRsvp', 'id={$aEventInvite.event_id}&amp;rsvp=3&amp;inline=1'); return false;">{phrase var='event.no'}</a></li><li><span>&middot;</span></li><li><a href="#" onclick="$(this).parent().parent().hide(); $('#js_event_rsvp_invite_image_{$aEventInvite.event_id}').show(); $.ajaxCall('event.addRsvp', 'id={$aEventInvite.event_id}&amp;rsvp=2&amp;inline=1'); return false;">{phrase var='event.maybe'}</a></li></ul>
			</div>
		</div>		
		<div class="clear"></div>
	</li>
{/foreach}
</ul>