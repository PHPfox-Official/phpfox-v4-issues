<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: menu.html.php 3346 2011-10-24 15:20:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{if ($aListing.user_id == Phpfox::getUserId() && Phpfox::getUserParam('marketplace.can_edit_own_listing')) || Phpfox::getUserParam('marketplace.can_edit_other_listing')}
		<li><a href="{url link='marketplace.add' id=$aListing.listing_id}">{phrase var='marketplace.edit_listing'}</a></li>	
		<li><a href="{url link='marketplace.add.customize' id=$aListing.listing_id}">{phrase var='marketplace.manage_photos'}</a></li>	
		<li><a href="{url link='marketplace.add.invite' id=$aListing.listing_id}">{phrase var='marketplace.send_invitations'}</a></li>	
		<li><a href="{url link='marketplace.add.manage' id=$aListing.listing_id}">{phrase var='marketplace.manage_invites'}</a></li>	
	{/if}
	{if Phpfox::getUserParam('marketplace.can_feature_listings')}
		<li class="js_marketplace_is_feature" {if $aListing.is_featured} style="display:none;"{/if}><a href="#" onclick="$('#js_featured_phrase_{$aListing.listing_id}').show(); $.ajaxCall('marketplace.feature', 'listing_id={$aListing.listing_id}&amp;type=1', 'GET'); $(this).parent().hide(); $(this).parents('ul:first').find('.js_marketplace_is_un_feature').show(); return false;">{phrase var='marketplace.feature'}</a></li>
		<li class="js_marketplace_is_un_feature" {if !$aListing.is_featured} style="display:none;"{/if}><a href="#" onclick="$('#js_featured_phrase_{$aListing.listing_id}').hide(); $.ajaxCall('marketplace.feature', 'listing_id={$aListing.listing_id}&amp;type=0', 'GET'); $(this).parent().hide(); $(this).parents('ul:first').find('.js_marketplace_is_feature').show(); return false;">{phrase var='marketplace.un_feature'}</a></li>
	{/if}
	{if Phpfox::getUserParam('marketplace.can_sponsor_marketplace')}
	<li>
	    <span id="js_sponsor_{$aListing.listing_id}">
			    {if $aListing.is_sponsor}
		<a href="#" onclick="$('#js_sponsor_phrase_{$aListing.listing_id}').hide(); $.ajaxCall('marketplace.sponsor','listing_id={$aListing.listing_id}&type=0', 'GET'); return false;">
			    {phrase var='marketplace.unsponsor_this_listing'}
		</a>
			    {else}
		<a href="#" onclick="$('#js_sponsor_phrase_{$aListing.listing_id}').show(); $.ajaxCall('marketplace.sponsor','listing_id={$aListing.listing_id}&type=1', 'GET'); return false;">
				    {phrase var='marketplace.sponsor_this_listing'}
		</a>
			    {/if}
	    </span>
	</li>
	{elseif Phpfox::getUserParam('marketplace.can_purchase_sponsor') 
	&& $aListing.user_id == Phpfox::getUserId()
	&& $aListing.is_sponsor != 1}
	<li>
	    <a href="{permalink module='ad.sponsor' id=$aListing.listing_id}section_marketplace/">
			    {phrase var='marketplace.sponsor_this_listing'}
	    </a>
	</li>
	{/if}
	{if ($aListing.user_id == Phpfox::getUserId() && Phpfox::getUserParam('marketplace.can_delete_own_listing')) || Phpfox::getUserParam('marketplace.can_delete_other_listings')}
		<li class="item_delete"><a href="{url link='marketplace' delete=$aListing.listing_id}" class="sJsConfirm">{phrase var='marketplace.delete_listing'}</a></li>
	{/if}	