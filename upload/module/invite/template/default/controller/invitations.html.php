<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: invitations.html.php 3215 2011-10-05 14:40:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aInvites)}

	<form method="post" action="{url link='current'}" id="js_form">
		<div class="main_break">
			{foreach from=$aInvites name=invite item=aInvite}
				<div id="js_invite_{$aInvite.invite_id}" class="js_selector_class_{$aInvite.invite_id} {if is_int($phpfox.iteration.invite/2)}row1{else}row2{/if}{if $phpfox.iteration.invite == 1} row_first{/if}">
					<div class="go_left t_center" style="width:20px;">						
						<a href="#{$aInvite.invite_id}" class="moderate_link" rel="invitations">Moderate</a>
					</div>
					<div class="go_left" style="width:250px;">
						{$aInvite.count}. {$aInvite.email}
					</div>
					<div class="t_right">
						<a href="{url link='current' del=$aInvite.invite_id}">{img theme='misc/delete.png' alt='' class='go_right'}</a>
					</div>
					<div class="clear"></div>
				</div>
			{/foreach}
		</div>
	</form>
	
{moderation}
{pager}
{else}
	<div class="extra_info">
		{phrase var='invite.there_are_no_pending_invitations'}
		<ul class="action">
			<li><a href="{url link='invite'}">{phrase var='invite.invite_your_friends'}</a></li>
		</ul>
	</div>
{/if}