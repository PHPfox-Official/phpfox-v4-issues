<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: view.html.php 1709 2010-07-29 09:26:34Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>	
{if $aGroup.is_public == '1'}
	<div class="message">
		{phrase var='group.this_group_is_pending_an_admins_approval'}
	</div>
	{if Phpfox::getUserParam('group.can_approve_groups')}
		<form method="post" action="{url link='group.'$aGroup.title_url''}">
			<div><input type="hidden" name="approve" value="1" /></div>
			<input type="submit" value="{phrase var='group.approve_group'}" class="button" />
		</form>
	{/if}
{/if}
{if $aGroup.member_id == '2'}
<div class="message">
	{phrase var='group.your_membership_to_this_group_is_pending_approval'}
</div>
{/if}
{$aGroup.description|parse}

<br />
<br />
{plugin call='group.template_default_controller_view_extra_info'}