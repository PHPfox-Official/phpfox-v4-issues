<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: menu.html.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="menu">
	<ul>
		{if $aGroup.invite_id && ($aGroup.member_id == 1 || $aGroup.member_id == 2)}		
		<li id="js_group_leave"><a href="{url link='group.'{$aGroup.title_url'.leave'}" class="first">{phrase var='group.leave_group'}</a></li>		
		{else}
		<li id="js_group_join"><a href="{url link='group.'{$aGroup.title_url'.join'}" class="first">{phrase var='group.join_group'}</a></li>
		{/if}
	{if ($aGroup.user_id == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin('' . $aGroup.group_id . '')}
		<li><a href="{url link='group.add.invite' id=$aGroup.group_id}">{phrase var='group.invite'}</a></li>	
	{/if}		
	{if ($aGroup.user_id == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin('' . $aGroup.group_id . '')}
		<li><a href="{url link='group.add' id=$aGroup.group_id}">{phrase var='group.edit_group'}</a></li>	
	{/if}	
	{if ($aGroup.user_id == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin('' . $aGroup.group_id . '')}
		<li><a href="{url link='group.add.manage' id=$aGroup.group_id}">{phrase var='group.manage_members'}</a></li>	
	{/if}
	{if ($aGroup.user_id == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin('' . $aGroup.group_id . '')}
		<li><a href="{url link='group.'$aGroup.title_url'.designer'}">{phrase var='group.customize_group'}</a></li>	
	{/if}	
	{if $aGroup.user_id != Phpfox::getUserId()}
		<li><a href="{url link='mail.compose' id=$aGroup.user_id}">{phrase var='group.contact_full_name_creator' full_name=$aGroup.full_name|first_name}</a></li>
	{/if}
	{if ($aGroup.view_id == '2' && $aGroup.is_admin) || ($aGroup.view_id != '2') && Phpfox::isModule('share')}
		{module name='share.link' type='group' display='menu' url=$aGroup.bookmark_url title=$aGroup.title}			
	{/if}	
	{if Phpfox::isModule('report')}
		{if $aGroup.user_id != Phpfox::getUserId()}<li><a href="#?call=report.add&amp;height=210&amp;width=400&amp;type=group&amp;id={$aGroup.group_id}" class="inlinePopup" title="{phrase var='group.report_a_group'}">{phrase var='group.report'}</a></li>{/if}
	{/if}
	{if ($aGroup.user_id == Phpfox::getUserId() && Phpfox::getUserParam('group.can_delete_own_group')) || Phpfox::getUserParam('group.can_delete_other_group')}
		<li><a href="{url link='group' delete=$aGroup.group_id}" class="sJsConfirm">{phrase var='group.delete_group'}</a></li>
	{/if}
	{if Phpfox::getUserParam('group.can_feature_groups')}
		<li id="js_group_is_not_featured"{if $aGroup.is_featured} style="display:none;"{/if}><a href="#" onclick="$('#js_group_is_not_featured').hide(); $('#js_group_is_featured').show(); $.ajaxCall('group.feature', 'id={$aGroup.group_id}&amp;type=1'); return false;">{phrase var='group.feature_this_group'}</a></li>
		<li id="js_group_is_featured"{if !$aGroup.is_featured} style="display:none;"{/if}><a href="#" onclick="$('#js_group_is_not_featured').show(); $('#js_group_is_featured').hide(); $.ajaxCall('group.feature', 'id={$aGroup.group_id}&amp;type=0'); return false;">{phrase var='group.unfeature_this_group'}</a></li>
	{/if}
	    
	{if Phpfox::getUserParam('group.can_sponsor_group')}
	<li>
	    <span id="js_sponsor_{$aGroup.group_id}" class="" style="{if $aGroup.is_sponsor}display:none;{/if}">
		<a href="#" onclick="$('#js_sponsor_{$aGroup.group_id}').hide();$('#js_unsponsor_{$aGroup.group_id}').show();$.ajaxCall('photo.sponsor','group_id={$aGroup.group_id}&type=1'); return false;">
				{phrase var='group.sponsor'}
		</a>
	    </span>

	    <span id="js_unsponsor_{$aGroup.group_id}" class="" style="{if $aGroup.is_sponsor != 1}display:none;{/if}">
		<a href="#" onclick="$('#js_sponsor_{$aGroup.group_id}').show();$('#js_unsponsor_{$aGroup.group_id}').hide();$.ajaxCall('photo.sponsor','group_id={$aGroup.group_id}&type=0'); return false;">
				{phrase var='group.unsponsor'}
		</a>
	    </span>
	</li>
	{elseif Phpfox::getUserParam('group.can_purchase_sponsor')
	&& $aGroup.user_id == Phpfox::getUserId()
	&& $aGroup.is_sponsor != 1}
	<li>
	    <a href="{url link='ad.sponsor' module='group' id=$aGroup.group_id}">
		{phrase var='group.sponsor'}
	    </a>
	</li>
	{/if}
	</ul>
</div>