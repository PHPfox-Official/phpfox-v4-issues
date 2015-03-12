<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: rsvp-entry.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
					{if isset($aEvent.rsvp_id)}
					<div class="feed_comment_extra">
						<a href="#" onclick="tb_show('{phrase var='event.rsvp' phpfox_squote=true}', $.ajaxBox('event.rsvp', 'height=130&amp;width=300&amp;id={$aEvent.event_id}{if $aCallback !== false}&amp;module={$aCallback.module}&amp;item={$aCallback.item}{/if}')); return false;" id="js_event_rsvp_{$aEvent.event_id}">
						{if $aEvent.rsvp_id == 3}
							{phrase var='event.not_attending'}
						{elseif $aEvent.rsvp_id == 2}
							{phrase var='event.maybe_attending'}
						{elseif $aEvent.rsvp_id == 1}
							{phrase var='event.attending'}
						{else}
							{phrase var='event.respond'}
						{/if}						
						</a>
					</div>
					{/if}