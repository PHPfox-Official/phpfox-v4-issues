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
<ul class="block_listing">
{foreach from=$aInvites name=invites item=aInvite}	
	<li>{img user=$aInvite suffix='_50_square' max_width=32 max_height=32 class='v_middle'} {$aInvite|user}</li>
{/foreach}
</ul>
{/if}

{if count($aMaybeInvites)}
<div class="title">
	{$iMaybeCnt} {phrase var='event.maybe_attending'}
</div>
<div class="block_listing_inline">
	<ul>
	{foreach from=$aMaybeInvites name=invites item=aInvite}	
		<li>{img user=$aInvite suffix='_50_square' max_width=24 max_height=24 class='js_hover_title'}</li>
	{/foreach}
	</ul>
	<div class="clear"></div>
</div>	
{/if}	

{if count($aAwaitingInvites)}
<div class="title">
	{$iAwaitingCnt} {phrase var='event.awaiting_reply'}
</div>
<div class="block_listing_inline">
	<ul>
	{foreach from=$aAwaitingInvites name=invites item=aInvite}	
		<li>{img user=$aInvite suffix='_50_square' max_width=24 max_height=24 class='js_hover_title'}</li>
	{/foreach}
	</ul>
	<div class="clear"></div>
</div>
{/if}	

{if count($aNotAttendingInvites)}
<div class="title">
	{$iNotAttendingCnt} {phrase var='event.not_attending'}
</div>
<div class="block_listing_inline">
	<ul>
	{foreach from=$aNotAttendingInvites name=invites item=aInvite}	
		<li>{img user=$aInvite suffix='_50_square' max_width=24 max_height=24 class='js_hover_title'}</li>
	{/foreach}
	</ul>
	<div class="clear"></div>
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