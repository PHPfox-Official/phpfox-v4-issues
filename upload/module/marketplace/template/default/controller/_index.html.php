<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 7254 2014-04-07 15:30:10Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aListings)}
<div class="extra_info">
	{phrase var='marketplace.no_marketplace_listings_found'}
</div>
{else}

{foreach from=$aListings name=listings item=aListing}
<div id="js_mp_item_holder_{$aListing.listing_id}" class="js_listing_parent {if $aListing.is_sponsor}row_sponsored {/if}{if $aListing.is_featured}row_featured {/if}{if $aListing.view_id == 1 && !isset($bIsInPendingMode)}row_moderate {/if}{if is_int($phpfox.iteration.listings)}row1{else}row2{/if}{if $phpfox.iteration.listings == 1} row_first{/if}">
	{item name='Product'}	
		{if $aListing.view_id == '1' && !isset($bIsInPendingMode)}
		<div class="row_moderate_info">
			{phrase var='marketplace.pending_approval'}
		</div>
		{/if}		
					
	{if !Phpfox::isMobile()}
				<div class="row_title_image_header">
					
					{if isset($aListing.is_expired)}
						<div class="row_featured_link">
							{phrase var='marketplace.expired'}
						</div>
					{else}
						{if isset($sView) && $sView == 'featured'}
						{else}
							<div id="js_featured_phrase_{$aListing.listing_id}" class="row_featured_link"{if !$aListing.is_featured} style="display:none;"{/if}>
								{phrase var='marketplace.featured'}
							</div>					
						{/if}	
						<div id="js_sponsor_phrase_{$aListing.listing_id}" class="js_sponsor_event row_sponsored_link"{if !$aListing.is_sponsor} style="display:none;"{/if}>
							{phrase var='marketplace.sponsored'}
						</div>					
					{/if}
					
					<a href="{$aListing.url}">
						{img server_id=$aListing.server_id title=$aListing.title path='marketplace.url_image' file=$aListing.image_path suffix='_120' max_width='120' max_height='120' itemprop='image'}
					</a>
				</div>				
					
					<div class="row_title_image_header_body">				
{/if}
				<div class="row_title">				
			
				
						<div class="row_title_image">
							{img user=$aListing suffix='_50_square' max_width='50' max_height='50'}
							
					{if ($aListing.user_id == Phpfox::getUserId() && Phpfox::getUserParam('marketplace.can_edit_own_listing')) || Phpfox::getUserParam('marketplace.can_edit_other_listing')
						|| ($aListing.user_id == Phpfox::getUserId() && Phpfox::getUserParam('marketplace.can_delete_own_listing')) || Phpfox::getUserParam('marketplace.can_delete_other_listings')
						|| (Phpfox::getUserParam('marketplace.can_feature_listings'))
					}
					<div class="row_edit_bar_parent">
						<div class="row_edit_bar_holder">
							<ul>
								{template file='marketplace.block.menu'}
							</ul>			
						</div>
						<div class="row_edit_bar">				
								<a href="#" class="row_edit_bar_action"><span>{phrase var='marketplace.actions'}</span></a>							
						</div>
					</div>		
					{/if}						
							
							{if Phpfox::isModule('event') && (Phpfox::getUserParam('event.can_approve_events') || Phpfox::getUserParam('event.can_delete_other_event'))}<a href="#{$aListing.listing_id}" class="moderate_link" rel="marketplace">Moderate</a>{/if}
						</div>
						<div class="row_title_info">		
							
								<header><h1 itemprop="name"><a href="{$aListing.url}" class="link" title="{$aListing.title|clean}" itemprop="url">{$aListing.title|clean|shorten:100:'...'|split:25}</a>{if $aListing.view_id == '2'}<span class="marketplace_item_sold">({phrase var='marketplace.sold'})</span>{/if}</h1></header>
							
	<div class="marketplace_price_tag" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<span itemprop="price">
		    {if $aListing.price == '0.00'}
			    {phrase var='marketplace.free'}
		    {else}
			    {$aListing.currency_id|currency_symbol}{$aListing.price|number_format:2}
		    {/if}
		    </span>
		    </div>																
							
							<div class="extra_info">
								<ul class="extra_info_middot"><li itemprop="releaseDate">{$aListing.time_stamp|convert_time}</li><li><span>&middot;</span></li><li>{$aListing|user:'':'':30}</li><li>&middot;</li><li><a class="js_hover_title" href="{url link='marketplace' location=$aListing.country_iso}">{$aListing.country_iso|location}<span class="js_hover_info">{if !empty($aListing.city)} {$aListing.city|clean} &raquo; {/if}{if !empty($aListing.country_child_id)} {$aListing.country_child_id|location_child} &raquo; {/if} {$aListing.country_iso|location}</span></a></li></ul>
							</div>
							
						
							{if Phpfox::isMobile()}
							<a href="{$aListing.url}">{img server_id=$aListing.server_id title=$aListing.title path='marketplace.url_image' file=$aListing.image_path suffix='_120' max_width='120' max_height='120'}</a>
							{/if}
							
							<div class="item_content" itemprop="description">
								{$aListing.mini_description|clean|split:25|shorten:255}
							</div>							
	
							{module name='feed.comment' aFeed=$aListing.aFeed}				
							
						</div>			

					
				</div>	
				{if !Phpfox::isMobile()}
					</div>
					{/if}
					<div class="clear"></div>		
	{/item}
</div>
{/foreach}

{if Phpfox::getUserParam('marketplace.can_delete_other_listings') || Phpfox::getUserParam('marketplace.can_feature_listings') || Phpfox::getUserParam('marketplace.can_approve_listings')}
{moderation}
{/if}

{pager}
{/if}
