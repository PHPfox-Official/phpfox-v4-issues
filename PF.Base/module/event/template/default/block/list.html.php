<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 6532 2013-08-29 11:15:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_event_item_holder">
{/if}
	{if count($aInvites)}
	{foreach from=$aInvites name=invites item=aUser}
		{template file='user.block.rows'}
	{/foreach}
	<div class="clear"></div>
	{else}
	<div class="extra_info">
	{if $iRsvp == 1}
		{phrase var='event.no_attendees'}
	{else}
		{phrase var='event.no_results'}
	{/if}
	</div>
	{/if}
	{pager}
{if !PHPFOX_IS_AJAX}
</div>
{/if}