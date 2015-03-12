<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: accept.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_request_group_holder">
	<div id="group"><a name="group"></a></div>
	<h3>{phrase var='group.group_invites'}</h3>
	{foreach from=$aGroups name=groups item=aGroup}
	<div id="js_group_invite_{$aGroup.group_id}" class="{if is_int($phpfox.iteration.groups/2)}row1{else}row2{/if}{if $phpfox.iteration.groups == 1} row_first{/if}">
		<div class="row_title">
			<div class="row_title_image">
				<a href="{url link='group.'$aGroup.title_url''}">{img server_id=$aGroup.server_id title=$aGroup.title path='group.url_image' file=$aGroup.image_path suffix='_50' max_width='50' max_height='50'}</a>
			</div>
			<div class="row_title_info">	
				<a href="{url link='group.'$aGroup.title_url''}" class="link">{$aGroup.title|clean}</a>
				<div class="extra_info">
					{phrase var='group.group_created_on_time_stamp_phrase_by_user_link_with_total_members_member_s' time_stamp_phrase=$aGroup.time_stamp|date user=$aGroup total_members=$aGroup.total_member}
					<div style="margin-top:6px;">
						<form method="post" action="#" onsubmit="$(this).ajaxCall('group.processUserInvite'); return false;">
							<div><input type="hidden" name="group_id" value="{$aGroup.group_id}" /></div>
							<input type="submit" value="{phrase var='group.accept'}" class="button" name="accept" />
							<input type="submit" value="{phrase var='group.deny'}" class="button" name="deny" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	{/foreach}
</div>