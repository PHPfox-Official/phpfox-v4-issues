<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: manage.html.php 4073 2012-03-28 13:25:57Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="page_section_menu page_section_menu_header">
	<ul>
		<li{if empty($sView)} class="active"{/if}><a href="{url link='ad.manage'}">{phrase var='ad.approved'}</a></li>
		<li{if $sView == 'pending'} class="active"{/if}><a href="{url link='ad.manage' view='pending'}">{phrase var='ad.pending_approval'}</a></li>
		<li{if $sView == 'payment'} class="active"{/if}><a href="{url link='ad.manage' view='payment'}">{phrase var='ad.pending_payment'}</a></li>
		<li class="last{if $sView == 'denied'} active{/if}"><a href="{url link='ad.manage' view='denied'}">{phrase var='ad.denied'}</a></li>
	</ul>
	<div class="clear"></div>
</div>

{if $bNewPurchase}
<div class="message">
	{phrase var='ad.thank_you_for_your_purchase_your_ad_is_currently_pending_approval'}
</div>
{/if}

<table class="default_table" cellpadding="0" cellspacing="0">
	<tr>
		<th>{phrase var='ad.campaign'}</th>
		<th>{phrase var='ad.status'}</th>
		<th>{phrase var='ad.impressions'}</th>
		<th>{phrase var='ad.clicks'}</th>		
		<th style="width:50px;">{phrase var='ad.active'}</th>
	</tr>
{foreach from=$aAllAds name=ads item=aAd}
	<tr{if is_int($phpfox.iteration.ads/2)} class="on"{/if}>
		<td><a href="{if $aAd.is_custom == '1'}{url link='ad.add.completed' id=$aAd.ad_id}{else}{url link='ad.add' id=$aAd.ad_id}{/if}">{$aAd.name|clean}</a></td>
		<td class="t_center">{$aAd.status}</td>
		<td class="t_center">{$aAd.count_view}</td>
		<td class="t_center">{$aAd.count_click}</td>	
		<td class="t_center">	
			{if empty($sView)}
			<div class="js_item_is_active"{if !$aAd.is_active} style="display:none;"{/if}>
				<a href="#?call=ad.updateAdActivityUser&amp;id={$aAd.ad_id}&amp;active=0" class="js_item_active_link" title="{phrase var='ad.pause_this_campaign'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aAd.is_active} style="display:none;"{/if}>
				<a href="#?call=ad.updateAdActivityUser&amp;id={$aAd.ad_id}&amp;active=1" class="js_item_active_link" title="{phrase var='ad.continue_this_campaign'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>
			{else}
			{phrase var='ad.n_a'}
			{/if}
		</td>			
	</tr>
{foreachelse}	
	<tr>
		<td colspan="5">
			<div class="extra_info">
				{phrase var='ad.no_ads_found'}		
			</div>
		</td>
	</tr>
{/foreach}
</table>