<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: profile.html.php 5077 2012-12-13 09:05:45Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $aUser.user_id != Phpfox::getUserId()}
<div class="pages_view_sub_menu">
	<ul>
		{if $aUser.user_id != Phpfox::getUserId()}<li><a href="#?call=report.add&amp;height=220&amp;width=400&amp;type=user&amp;id={$aUser.user_id}" class="inlinePopup" title="{phrase var='report.report_this_user'}">{phrase var='report.report_this_user'}</a></li>{/if}
		{if isset($aUser.is_friend) && $aUser.is_friend}
		<li>
			<a href="#" onclick="if (confirm('{phrase var='core.are_you_sure'}')) $.ajaxCall('friend.delete', 'friend_user_id={$aUser.user_id}&reload=1'); return false;" class="no_ajax_link">
				{phrase var='friend.remove_friend'}
			</a>
		</li>
		{/if}
		{if Phpfox::getUserParam('user.can_block_other_members') && isset($aUser.user_group_id) && Phpfox::getUserGroupParam('' . $aUser.user_group_id . '', 'user.can_be_blocked_by_others')}
		<li><a href="#?call=user.block&amp;height=120&amp;width=400&amp;user_id={$aUser.user_id}" class="inlinePopup js_block_this_user" title="{if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}">{if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}</a></li>
		{/if}
	</ul>
</div>
{/if}