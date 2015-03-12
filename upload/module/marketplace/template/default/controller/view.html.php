<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: view.html.php 5032 2012-11-19 13:58:57Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{if (Phpfox::getParam('marketplace.days_to_expire_listing') > 0) && ( $aListing.time_stamp < (PHPFOX_TIME - (Phpfox::getParam('marketplace.days_to_expire_listing') * 86400)) )}
	<div class="error_message">
		{phrase var='marketplace.listing_expired_and_not_available_main_section'}
	</div>
{/if}
{if $aListing.view_id == '1'}
<div class="message js_moderation_off">
	{phrase var='marketplace.listing_is_pending_approval'}
</div>
{/if}
{if ($aListing.user_id == Phpfox::getUserId() && Phpfox::getUserParam('marketplace.can_edit_own_listing')) || Phpfox::getUserParam('marketplace.can_edit_other_listing')
	|| ($aListing.user_id == Phpfox::getUserId() && Phpfox::getUserParam('marketplace.can_delete_own_listing')) || Phpfox::getUserParam('marketplace.can_delete_other_listings')
	|| (Phpfox::getUserParam('marketplace.can_feature_listings'))
}
<div class="item_bar">
	<div class="item_bar_action_holder">
	{if (Phpfox::getUserParam('marketplace.can_approve_listings') && $aListing.view_id == '1')}
		<a href="#" class="item_bar_approve item_bar_approve_image" onclick="return false;" style="display:none;" id="js_item_bar_approve_image">{img theme='ajax/add.gif'}</a>			
		<a href="#" class="item_bar_approve" onclick="$(this).hide(); $('#js_item_bar_approve_image').show(); $.ajaxCall('marketplace.approve', 'inline=true&amp;listing_id={$aListing.listing_id}'); return false;">{phrase var='marketplace.approve'}</a>
	{/if}
		<a href="#" class="item_bar_action"><span>{phrase var='marketplace.actions'}</span></a>	
		<ul>
			{template file='marketplace.block.menu'}
		</ul>			
	</div>
</div>
{/if}

<div class="item_view">
	{module name='marketplace.info'}

	{plugin call='marketplace.template_default_controller_view_extra_info'}

	<div {if $aListing.view_id != 0}style="display:none;" class="js_moderation_on"{/if}>
		{module name='feed.comment'}
	</div>
</div>