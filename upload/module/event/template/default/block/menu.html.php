<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: menu.html.php 3737 2011-12-09 07:50:12Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')}
		<li><a href="{url link='event.add' id=$aEvent.event_id}">{phrase var='event.edit_event'}</a></li>	
	{/if}
	{if $aEvent.view_id == 0 && ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')}
		<li><a href="{url link='event.add.invite' id=$aEvent.event_id}">{phrase var='event.invite_people_to_come'}</a></li>	
		<li><a href="{url link='event.add.email' id=$aEvent.event_id}">{phrase var='event.mass_email_guests'}</a></li>	
	{/if}		
	{if ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')}
		<li><a href="{url link='event.add.manage' id=$aEvent.event_id}">{phrase var='event.manage_guest_list'}</a></li>	
	{/if}
	
	{if $aEvent.view_id == 0 && Phpfox::getUserParam('event.can_feature_events')}
		<li id="js_feature_{$aEvent.event_id}"{if $aEvent.is_featured} style="display:none;"{/if}><a href="#" title="{phrase var='event.feature_this_event'}" onclick="$(this).parent().hide(); $('#js_unfeature_{$aEvent.event_id}').show(); $(this).parents('.js_event_parent:first').addClass('row_featured').find('.js_featured_event').show(); $.ajaxCall('event.feature', 'event_id={$aEvent.event_id}&amp;type=1'); return false;">{phrase var='event.feature'}</a></li>				
		<li id="js_unfeature_{$aEvent.event_id}"{if !$aEvent.is_featured} style="display:none;"{/if}><a href="#" title="{phrase var='event.un_feature_this_event'}" onclick="$(this).parent().hide(); $('#js_feature_{$aEvent.event_id}').show(); $(this).parents('.js_event_parent:first').removeClass('row_featured').find('.js_featured_event').hide(); $.ajaxCall('event.feature', 'event_id={$aEvent.event_id}&amp;type=0'); return false;">{phrase var='event.unfeature'}</a></li>				
	{/if}	
	
	{if Phpfox::getUserParam('event.can_sponsor_event')}
		<li id="js_event_sponsor_{$aEvent.event_id}" {if $aEvent.is_sponsor}style="display:none;"{/if}><a href="#" onclick="$.ajaxCall('event.sponsor', 'event_id={$aEvent.event_id}&type=1', 'GET'); return false;">{phrase var='event.sponsor_this_event'}</a></li>
		<li id="js_event_unsponsor_{$aEvent.event_id}" {if !$aEvent.is_sponsor}style="display:none;"{/if}><a href="#" onclick="$.ajaxCall('event.sponsor', 'event_id={$aEvent.event_id}&type=0', 'GET'); return false;">{phrase var='event.unsponsor_this_event'}</a></li>				
	{elseif Phpfox::getUserParam('event.can_purchase_sponsor') && !defined('PHPFOX_IS_GROUP_VIEW') 
		&& $aEvent.user_id == Phpfox::getUserId()
		&& $aEvent.is_sponsor != 1}
		<li> 
			<a href="{permalink module='ad.sponsor' id=$aEvent.event_id title=$aEvent.title section=event}"> 
				{phrase var='event.sponsor_this_event'}
			</a>
		</li>
	{/if}
	
	{if (($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_delete_own_event')) || Phpfox::getUserParam('event.can_delete_other_event'))
		|| (defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getService('pages')->isAdmin('' . $aPage.page_id . ''))
	}
		<li class="item_delete"><a href="{url link='event' delete=$aEvent.event_id}" class="sJsConfirm">{phrase var='event.delete_event'}</a></li>
	{/if}	