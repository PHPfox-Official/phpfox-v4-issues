<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: rsvp.html.php 4503 2012-07-11 14:41:02Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='current'}" onsubmit="$('#js_event_rsvp_button').find('input:first').attr('disabled', true); $('#js_event_rsvp_update').html($.ajaxProcess('{phrase var="event.updating"}')).show(); $(this).ajaxCall('event.addRsvp', '&id={$aEvent.event_id}'); return false;">
{if isset($aCallback) && $aCallback !== false}
	<div><input type="hidden" name="module" value="{$aCallback.module}" /></div>
	<div><input type="hidden" name="item" value="{$aCallback.item}" /></div>
{/if}
	<div class="p_2">
		<label onclick="$('#js_event_rsvp_button').show(); $('.js_event_rsvp').attr('checked', false); $(this).find('.js_event_rsvp').attr('checked', true);"><input type="radio" name="rsvp" value="1" class="checkbox v_middle js_event_rsvp" {if $aEvent.rsvp_id == 1}checked="checked" {/if}/> {phrase var='event.attending'}</label>
	</div>
	<div class="p_2">
		<label onclick="$('#js_event_rsvp_button').show(); $('.js_event_rsvp').attr('checked', false); $(this).find('.js_event_rsvp').attr('checked', true);"><input type="radio" name="rsvp" value="2" class="checkbox v_middle js_event_rsvp" {if $aEvent.rsvp_id == 2}checked="checked" {/if}/> {phrase var='event.maybe_attending'}</label>
	</div>
	<div class="p_2">
		<label onclick="$('#js_event_rsvp_button').show(); $('.js_event_rsvp').attr('checked', false); $(this).find('.js_event_rsvp').attr('checked', true);"><input type="radio" name="rsvp" value="3" class="checkbox v_middle js_event_rsvp" {if $aEvent.rsvp_id == 3}checked="checked" {/if}/> {phrase var='event.not_attending'}</label>
	</div>	
	<div id="js_event_rsvp_button" class="p_2" style="margin-top:10px;{if $aEvent.rsvp_id} display:none;{/if}">
		<input type="submit" id="btn_rsvp_submit" value="{if $aEvent.rsvp_id}{phrase var='event.update_your_rsvp'}{else}{phrase var='event.submit_your_rsvp'}{/if}" class="button" /> <span id="js_event_rsvp_update"></span>
	</div>
</form>