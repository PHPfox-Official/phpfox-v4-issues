<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Event
 * @version 		$Id: index.html.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aEvents)}
<div class="extra_info">
	{phrase var='event.no_events_found'}
</div>
{else}

{foreach from=$aEvents key=sDate item=aGroups}
<div class="block">
	<div class="title">{$sDate}</div>	
	<div class="border">
		<div class="content">
			{foreach from=$aGroups name=events item=aEvent}
			{item name='Event'}
				<div id="js_event_item_holder_{$aEvent.event_id}" class="js_event_parent {if $aEvent.is_sponsor && !defined('PHPFOX_IS_GROUP_VIEW')}row_sponsored {elseif $aEvent.is_featured && $sView != 'featured'}row_featured {/if}{if is_int($phpfox.iteration.events)}row1{else}row2{/if}{if $phpfox.iteration.events == 1} row_first{/if}">
					{if !Phpfox::isMobile()}
					<div class="row_title_image_header">
						
						{if isset($sView) && $sView == 'featured'}
						{else}
						<div class="js_featured_event row_featured_link"{if !$aEvent.is_featured} style="display:none;"{/if}>
							{phrase var='event.featured'}
						</div>					
						{/if}	
						<div id="js_sponsor_phrase_{$aEvent.event_id}" class="js_sponsor_event row_sponsored_link"{if !$aEvent.is_sponsor} style="display:none;"{/if}>
							{phrase var='event.sponsored'}
						</div>					
						
						<a href="{$aEvent.url}">{img server_id=$aEvent.server_id title=$aEvent.title path='event.url_image' file=$aEvent.image_path suffix='_120' max_width='120' max_height='120' itemprop='image'}</a>
					</div>				
					<div class="row_title_image_header_body">	
					{/if}
						<div class="row_title">	
	
							<div class="row_title_image">		
								<a href="{$aEvent.url}">{img user=$aEvent suffix='_50_square' max_width='50' max_height='50'}</a>
								{if ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')
									|| ($aEvent.view_id == 0 && ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event'))
									|| ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_edit_own_event')) || Phpfox::getUserParam('event.can_edit_other_event')
									|| ($aEvent.user_id == Phpfox::getUserId() && Phpfox::getUserParam('event.can_delete_own_event')) || Phpfox::getUserParam('event.can_delete_other_event')
									|| (defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getService('pages')->isAdmin('' . $aPage.page_id . ''))
								}
								<div class="row_edit_bar_parent">
									<div class="row_edit_bar_holder">
										<ul>
											{template file='event.block.menu'}
										</ul>			
									</div>
									<div class="row_edit_bar">				
											<a href="#" class="row_edit_bar_action"><span>{phrase var='event.actions'}</span></a>							
									</div>
								</div>		
								{/if}							
								{if Phpfox::getUserParam('event.can_approve_events') || Phpfox::getUserParam('event.can_delete_other_event')}<a href="#{$aEvent.event_id}" class="moderate_link" rel="event">{phrase var='event.moderate'}</a>{/if}
							</div>
							<div class="row_title_info">		
								<header>
									<h1 itemprop="name"><a href="{$aEvent.url}" class="link" itemprop="url">{$aEvent.title|clean|split:25}</a></h1>
								</header>
								<div class="extra_info">
									<ul class="extra_info_middot">{if isset($aEvent.start_time_micro)}<li itemprop="startDate" style="display:none;">{$aEvent.start_time_micro}<li>{/if}{$aEvent.start_time_phrase} {phrase var='event.at'} {$aEvent.start_time_phrase_stamp}</li><li><span>&middot;</span></li><li>{$aEvent|user}</li></ul>
								</div>
								
								{if Phpfox::isMobile()}
								<a href="{$aEvent.url}">{img server_id=$aEvent.server_id title=$aEvent.title path='event.url_image' file=$aEvent.image_path suffix='_120' max_width='120' max_height='120'}</a>
								{/if}
		
								{module name='feed.comment' aFeed=$aEvent.aFeed}				
								
							</div>			
							
						</div>	
					{if !Phpfox::isMobile()}
					</div>
					{/if}
				</div>
			{/item}
			{/foreach}
		</div>
	</div>
</div>
{/foreach}

{if Phpfox::getUserParam('event.can_approve_events') || Phpfox::getUserParam('event.can_delete_other_event')}
{moderation}
{/if}

{pager}
{/if}