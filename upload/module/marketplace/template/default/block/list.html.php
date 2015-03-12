<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !PHPFOX_IS_AJAX}
<div id="js_mp_item_holder">
{/if}
	{if count($aInvites)}
	{foreach from=$aInvites name=invites item=aInvite}	
		<div class="go_left t_center" style="width:30%; padding:4px;" id="js_mp_member_{$aInvite.invite_id}">			
			<div class="p_4">
				{if !$aInvite.invited_user_id}
					{$aInvite.invited_email|hide_email}
				{else}
					{$aInvite|user}
				{/if}		
			</div>
			<div class="js_mp_fix_holder" style="width:75px; margin:auto; position:relative;">
				{if !$aInvite.invited_user_id}
					{img file='' suffix='_50' max_width=75 max_height=75 class='js_mp_fix_width'}
				{else}
					{img user=$aInvite suffix='_50' max_width=75 max_height=75 class='js_mp_fix_width'}
				{/if}
			</div>
		</div>
		{if is_int($phpfox.iteration.invites / 3)}
		<div class="clear"></div>
		{/if}	
	{/foreach}
	<div class="clear"></div>
	{else}
	<div class="extra_info">
	{if $iType == 1}
		{phrase var='marketplace.no_visits'}
	{else}
		{phrase var='marketplace.no_results'}
	{/if}
	</div>
	{/if}
	{pager}
{if !PHPFOX_IS_AJAX}
</div>
{/if}