<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Group
 * @version 		$Id: index.html.php 2628 2011-05-25 13:06:52Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
{if count($aGroups)}
{foreach from=$aGroups name=groups item=aGroup}
<div id="js_group_{$aGroup.group_id}" class="js_group_inline {if is_int($phpfox.iteration.groups/2)}row1{else}row2{/if}{if $phpfox.iteration.groups == 1} row_first{/if}{if $aGroup.is_sponsor} row_sponsored {elseif $aGroup.is_featured} row_featured{/if}{if $aGroup.is_public == '1'} row_moderate{/if}">
	<span class="row_featured_link"{if !$aGroup.is_featured} style="display:none;"{/if}>
		{phrase var='group.featured'}
	</span>	
	<div style="width:130px; position:absolute; text-align:center; left:10px;">
		<a href="{url link='group.'$aGroup.title_url'}">{img server_id=$aGroup.server_id title=$aGroup.title path='group.url_image' file=$aGroup.image_path suffix='_120' max_width='120' max_height='120'}</a>
	</div>
	<div style="margin-left:135px; height:120px;">
		<a href="{url link='group.'$aGroup.title_url'}">{$aGroup.title|clean}</a>
		{if !empty($aGroup.short_description)}
		<div class="extra_info">
			{$aGroup.short_description|clean}
		</div>
		{/if}
		<div class="extra_info" style="padding-top:0px;">
			{if count($aGroup.breadcrumb)}
			<div class="p_4">
				{foreach from=$aGroup.breadcrumb name=breadcrumbs item=aBredcrumb}
				{if $phpfox.iteration.breadcrumbs != 1}&raquo; {/if}<a href="{$aBredcrumb.1}">{$aBredcrumb.0}</a>
				{/foreach}
				</div>
			{/if}		
		</div>
		<div class="extra_info" style="padding-top:0px; padding-bottom:0px;">
		{if !$aGroup.total_member}
			{phrase var='group.founded_on_time_stamp_with_span_id_js_group_member_count_group_id_no_span_members' time_stamp=$aGroup.time_stamp|date:'group.group_view_time_stamp' group_id=$aGroup.group_id}
		{elseif $aGroup.total_member == 1}
			{phrase var='group.founded_on_time_stamp_with_link_1_members' time_stamp=$aGroup.time_stamp|date:'group.group_view_time_stamp' link=$aGroup.group_url group_id=$aGroup.group_id}
		{else}
			{phrase var='group.founded_on_time_stamp_with_a_href_link_span_id_js_group_member_count_group_id_total_mem' time_stamp=$aGroup.time_stamp|date:'group.group_view_time_stamp' link=$aGroup.group_url group_id=$aGroup.group_id total_member=$aGroup.total_member}
		{/if}
		</div>	
	</div>
	<div class="t_right">
		<ul class="item_menu" style="margin:0px;">
			{if $aGroup.is_public == '1' && Phpfox::getUserParam('group.can_approve_groups')}
			<li><a href="#" onclick="$.ajaxCall('group.approve', 'group_id={$aGroup.group_id}'); $(this).parent().remove(); $('#js_group_{$aGroup.group_id}').removeClass('row_moderate'); return false;">{phrase var='group.approve'}</a></li>
			{/if}
			{if Phpfox::getUserParam('group.can_sponsor_group')}
			<li id="js_sponsor_{$aGroup.group_id}">
			    {if $aGroup.is_sponsor}
			    <a href="#" onclick="$.ajaxCall('group.sponsor', 'group_id={$aGroup.group_id}&amp;type=0'); return false;">
				{phrase var='group.unsponsor'}
			    </a>
			    {else}
			    <a href="#" onclick="$.ajaxCall('group.sponsor', 'group_id={$aGroup.group_id}&amp;type=1'); return false;">
				{phrase var='group.sponsor'}
			    </a>
			    {/if}
			</li>
			{/if}
			{if isset($sGroupView) && $sGroupView == 'invite'}
			<li id="js_group_join_{$aGroup.group_id}"><a href="#" onclick="$.ajaxCall('group.joinGroup', 'id={$aGroup.group_id}&amp;parent=true&amp;is_invite=true'); return false;">{phrase var='group.accept_request'}</a></li>	
			<li id="js_group_leave_{$aGroup.group_id}"><a href="#" onclick="$.ajaxCall('group.leaveGroup', 'id={$aGroup.group_id}&amp;parent=true&amp;is_invite=true'); return false;" >{phrase var='group.deny_request'}</a></li>				
			{else}
			<li id="js_group_leave_{$aGroup.group_id}"{if !$aGroup.member_id} style="display:none;"{/if}><a href="#" onclick="$.ajaxCall('group.leaveGroup', 'id={$aGroup.group_id}&amp;parent=true'); return false;" >{phrase var='group.leave_group'}</a></li>		
			<li id="js_group_join_{$aGroup.group_id}"{if $aGroup.member_id} style="display:none;"{/if}><a href="#" onclick="$.ajaxCall('group.joinGroup', 'id={$aGroup.group_id}&amp;parent=true'); return false;">{phrase var='group.join_group'}</a></li>	
			{/if}		
			{if Phpfox::getUserParam('group.can_feature_groups') && !$aGroup.is_sponsor}
				<li class="js_group_is_not_featured"{if $aGroup.is_featured} style="display:none;"{/if}><a href="#" onclick="$(this).parents('.js_group_inline:first').find('.row_featured_link:first').show(); $(this).parents('.js_group_inline:first').addClass('row_featured'); $(this).parents('.item_menu:first').find('.js_group_is_not_featured:first').hide(); $(this).parents('.item_menu:first').find('.js_group_is_featured:first').show(); $.ajaxCall('group.feature', 'id={$aGroup.group_id}&amp;type=1'); return false;">{phrase var='group.feature'}</a></li>
				<li class="js_group_is_featured"{if !$aGroup.is_featured} style="display:none;"{/if}><a href="#" onclick="$(this).parents('.js_group_inline:first').find('.row_featured_link:first').hide(); $(this).parents('.js_group_inline:first').removeClass('row_featured'); $(this).parents('.item_menu:first').find('.js_group_is_not_featured:first').show(); $(this).parents('.item_menu:first').find('.js_group_is_featured:first').hide(); $.ajaxCall('group.feature', 'id={$aGroup.group_id}&amp;type=0'); return false;">{phrase var='group.unfeature'}</a></li>
			{/if}				
			{if ($aGroup.user_id == Phpfox::getUserId() && Phpfox::getUserParam('group.can_delete_own_group')) || Phpfox::getUserParam('group.can_delete_other_group')}
				<li><a href="#" onclick="if (confirm('{phrase var='group.are_you_sure' phpfox_squote=true}')) {literal}{{/literal} $.ajaxCall('group.delete', 'id={$aGroup.group_id}'); {literal}}{/literal} return false;">{phrase var='group.delete'}</a></li>
			{/if}
			<li><!-- --></li>
		</ul>	
	</div>	
</div>
{/foreach}
{pager}
{else}
<div class="extra_info">
	No groups found.
</div>
{/if}