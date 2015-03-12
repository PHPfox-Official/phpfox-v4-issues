<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: view.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $aEvent.view_id == '1'}
<div class="message js_moderation_off">
	{phrase var='event.event_is_pending_approval'}
</div>
{/if}

{if ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')
	|| ($aEvent.view_id == 0 && ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event'))
	|| ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')
	|| ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_delete_own_event')) || Phpfox::getUserParam('event.can_delete_other_event')
}
<div class="item_bar">
	<div class="item_bar_action_holder">
	{if (Phpfox::getUserParam('event.can_approve_events') && $aEvent.view_id == '1')}
		<a href="#" class="item_bar_approve item_bar_approve_image" onclick="return false;" style="display:none;" id="js_item_bar_approve_image">{img theme='ajax/add.gif'}</a>			
		<a href="#" class="item_bar_approve" onclick="$(this).hide(); $('#js_item_bar_approve_image').show(); $.ajaxCall('event.approve', 'inline=true&amp;event_id={$aEvent.event_id}'); return false;">{phrase var='event.approve'}</a>
	{/if}
		<a href="#" class="item_bar_action"><span>{phrase var='event.actions'}</span></a>	
		<ul>
			{template file='event.block.menu'}
		</ul>			
	</div>
</div>
{/if}
{plugin call='event.template_default_controller_view_extra_info'}