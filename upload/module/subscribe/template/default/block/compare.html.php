<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 
	[feature-id][title]
	[feature-id][package][package-id] = array
	[feature-id][package][package-id][radio] = [0|1|2]
	[feature-id][package][package-id][text] = text
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aPackages.features) && $bIsDisplay}
<div class="message">{phrase var='subscribe.there_is_nothing_to_compare_at_this_time'}</div>
{/if}
<div id="div_compare_wrapper"{if !$bIsDisplay} class="compare_admincp"{/if}>
		<table id="tbl_compare" cellpadding="0" cellspacing="0">
			{if !count($aPackages.features) && $bIsDisplay}
			
			{else}
			<tr id="trHeader">
				<th class="th_title"></th>
				{foreach name=iteTitle from=$aPackages.packages item=aPackage}
					<th class="th_package_title {if is_int($phpfox.iteration.iteTitle/2)}thTitleEven{else}thTitleOdd{/if}"{if $bIsDisplay && !empty($aPackage.background_color)} style="background-color:{$aPackage.background_color}"{/if}>{$aPackage.title|convert}</th>
				{/foreach}
			</tr>
			{if $bIsDisplay}
			<tr class="trDescription">
				<td class="tdTitle">{phrase var='subscribe.package_info'}</td>
				{foreach name=iteDescription from=$aPackages.packages item=aPackage}
					<td class="tdPackageDescription {if is_int($phpfox.iteration.iteDescription/2)}tdDescriptionEven{else}tdDescriptionOdd{/if}"{if $bIsDisplay && !empty($aPackage.background_color)} style="background-color:{$aPackage.background_color}"{/if}>{$aPackage.description|convert}</td>
				{/foreach}
			</tr>
			
			<tr id="tr_pricing_1">
				<td class="tdFee"> {phrase var='subscribe.fee'} </td>
				{foreach name=iteFee from=$aPackages.packages item=aPackage}
					<td class="{if is_int($phpfox.iteration.iteFee/2)}tdFeeEven{else}tdFeeOdd{/if}"{if $bIsDisplay && !empty($aPackage.background_color)} style="background-color:{$aPackage.background_color}"{/if}>
						{$aPackage.price_phrase}	 					
					</td>
				{/foreach}
			</tr>
			{/if}
			{/if}
			{if $bIsDisplay}
				{if count($aPackages.features)}
				<tr class="tr_purchase_1">
					<td class="tdEmpty"></td>
					{foreach name=tdPurchase from=$aPackages.packages key=iPackageId item=aPackage}
						<td class="td_purchase_1 {if is_int($phpfox.iteration.tdPurchase/2)}tdPurchaseEven{else}tdPurchaseOdd{/if}" {if $bIsDisplay && !empty($aPackage.background_color)} style="background-color:{$aPackage.background_color}"{/if}>
							<a href="#" onclick="tb_show('Select Payment', $.ajaxBox('subscribe.upgrade', 'height=400&width=400&id={$iPackageId}')); return false;">
								{phrase var='subscribe.purchase'}
							</a>							
						</td>
					{/foreach}
				</tr>
				<tr class="tr_feature_head">
					<td class="td_feature_head" colspan="{if ($sColspan = (count($aPackages.packages)) + 1)}{/if}{$sColspan}">{phrase var='subscribe.membership_package_comparison'}</td>				</tr>
				{foreach name=iteTrFeature from=$aPackages.features key=sFeatureTitle item=aFeature}
					<tr class="tr_feature {if is_int($phpfox.iteration.iteTrFeature/2)}trFeatureEven{else}trFeatureOdd{/if}{if $phpfox.iteration.iteTrFeature==1} tr_first_feature{/if}">
						<td class="td_comparison_title">
							{if strpos($sFeatureTitle, 'no-feature-title') === false} {$sFeatureTitle|convert} {/if}
						</td>
						{foreach from=$aFeature item=aFeatureValue name=iteTdFeature}
							<td class="td_feature {if is_int($phpfox.iteration.iteTdFeature/2)}tdFeatureEven{else}tdFeatureOdd{/if}"{if $bIsDisplay && !empty($aFeatureValue.background_color)} style="background-color:{$aFeatureValue.background_color}"{/if}>
								{if $aFeatureValue.feature_value == 'img_accept.png'} {img theme='misc/accept.png'} {/if}
								{if $aFeatureValue.feature_value == 'img_cross.png'} {img theme='misc/cross.png'} {/if}
								{if $aFeatureValue.feature_value != 'img_cross.png' && $aFeatureValue.feature_value != 'img_accept.png'} {$aFeatureValue.feature_value|convert} {/if}
							</td>
						{/foreach}
					</tr>
				{/foreach}		
				{/if}
				<tr class="tr_purchase_2">
					<td class="td_empty"></td>
					{foreach name=tdPurchase from=$aPackages.packages key=iPackageId item=aPackage}
						<td class="td_purchase_1 {if is_int($phpfox.iteration.tdPurchase/2)}tdPurchaseEven{else}tdPurchaseOdd{/if}" {if $bIsDisplay && !empty($aPackage.background_color)} style="background-color:{$aPackage.background_color}"{/if}>
							<a href="#" onclick="tb_show('Select Payment', $.ajaxBox('subscribe.upgrade', 'height=400&width=400&id={$iPackageId}')); return false;">
								{phrase var='subscribe.purchase'}
							</a>							
						</td>
					{/foreach}
				</tr>
			{else}
				<tr id="tr_features_template" class="tr_feature" style="display:none;">
					<td class="td_comparison_title">
						<input type="text" class="txt_title" value="" name="compare[99999999][title]" />						
					</td>
					{foreach from=$aPackages.packages key=iPackageId item=aPackage}
						<td class="td_feature" id="td_feature_{$iPackageId}"{if $bIsDisplay && !empty($aPackage.background_color)} style="background-color:{$aPackage.background_color}"{/if}>					
							<div>
								<span class="switch_type js_hover_title" onclick="$Core.subscribe.switchType(this);">{img theme='misc/arrow_switch.png'}<span class="js_hover_info">Toggle Comparison Value (Yes, No or Text Field)</span></span>								
								<span class="div_text">
									<input type="text" class="txt_package_feature" id="txt_package_feature_{$aPackage.package_id}" name="compare[99999999][package][{$aPackage.package_id}][text]" style="width:60px;" />
								</span>
								
								<span class="div_radio js_hover_title" style="display: none;">
									<input type="hidden" class="hid_input" id="hid_input_{$aPackage.package_id}" name="compare[99999999][package][{$aPackage.package_id}][radio]" value="0">
									<img src="" class="img_accept" style="" onclick="$Core.subscribe.toggleAccept(this);">						
									<img src="" class="img_reject" style="display:none;" onclick="$Core.subscribe.toggleAccept(this);">
									<span class="js_hover_info">Toggle Yes or No</span>
								</span>							
							</div>
						</td>
					{/foreach}
				</tr>
				<tr id="tr_last" {if isset($bIsDisplay) && $bIsDisplay == true}style="display: none;"{/if}>
					<td colspan={$iTotalColumns} class="td_center" onclick="$Core.subscribe.addRow();">
						{phrase var='subscribe.add_new_feature'}
					</td>
				</tr>
			{/if}
		</table>
	</div>
