<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: attending.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aInvites)}
<div class="block">
	<div class="title">{$iAttendingCnt} Attending</div>
	<div class="content">
		<ul class="block_listing">
		{foreach from=$aInvites name=invites item=aInvite}
			<li>{img user=$aInvite suffix='_50_square' max_width=32 max_height=32 class='v_middle'} {$aInvite|user}</li>
		{/foreach}
		</ul>
	</div>
</div>
{/if}

{if count($aMaybeInvites)}
<div class="block">
	<div class="title">
		{$iMaybeCnt} {phrase var='event.maybe_attending'}
	</div>
	<div class="content">
		<ul class="block_listing">
		{foreach from=$aMaybeInvites name=invites item=aInvite}
			<li>{img user=$aInvite suffix='_50_square' max_width=32 max_height=32 class='v_middle'} {$aInvite|user}</li>
		{/foreach}
		</ul>
	</div>
</div>	
{/if}	

{if count($aAwaitingInvites)}
<div class="block">
	<div class="title">
		{$iAwaitingCnt} {phrase var='event.awaiting_reply'}
	</div>
	<div class="content">
		<ul class="block_listing">
		{foreach from=$aAwaitingInvites name=invites item=aInvite}
			<li>{img user=$aInvite suffix='_50_square' max_width=32 max_height=32 class='v_middle'} {$aInvite|user}</li>
		{/foreach}
		</ul>
		<div class="clear"></div>
	</div>
</div>
{/if}	

{if count($aNotAttendingInvites)}
<div class="block">
	<div class="title">
		{$iNotAttendingCnt} {phrase var='event.not_attending'}
	</div>
	<div class="content">
		<ul class="block_listing">
		{foreach from=$aNotAttendingInvites name=invites item=aInvite}
			<li>{img user=$aInvite suffix='_50_square' max_width=32 max_height=32 class='v_middle'} {$aInvite|user}</li>
		{/foreach}
		</ul>
	</div>
</div>
{/if}
<script type="text/javascript">
var sEventId = {$aEvent.event_id};
{literal}
$Behavior.onClickEventGuestList = function()
{
	if ($Core.exists('#js_controller_event_view')){
		$('#js_controller_event_view #js_block_bottom_link_1').click(function()
		{
			$Core.box('event.browseList', '400', 'id=' + sEventId);

			return false;
		});		
	}
}
{/literal}
</script>