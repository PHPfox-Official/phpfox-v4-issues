<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: secret.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $aGroup.member_id == '0' && $aGroup.invite_id}
<div class="message">{phrase var='group.you_have_been_invited_to_join_this_private_group'}</div>
<ul class="action">	
	<li><a href="{url link='group.'{$aGroup.title_url'.join'}" class="first">{phrase var='group.accept_this_invite_and_join_the_group'}</a></li>
	<li><a href="{url link='group.'{$aGroup.title_url'.leave'}" class="first">{phrase var='group.cancel_this_invite'}</a></li>
	<li><a href="{url link='group'}" class="first">{phrase var='group.leave_the_invite_and_let_me_check_on_other_groups_first'}</a></li>
</ul>
{else}
<div class="extra_info">
	{phrase var='group.this_group_is_closed_and_only_members_that_are_invited_can_join_this_group'}
</div>
{/if}