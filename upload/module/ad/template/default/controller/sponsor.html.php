<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package 		Phpfox
 * @version 		$Id: sponsor.html.php 7088 2014-02-04 15:37:30Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !isset($iInvoice) && !isset($bWithoutPay)}

<form action="{permalink module='ad.sponsor' id=$iId}section_{if isset($sFormerModule)}{$sFormerModule}{else}{$sModule}{/if}/{if isset($aForms.where)}where_{$aForms.where}/{/if}{if isset($aForms.item_id)}item_{$aForms.item_id}/{/if}" name="js_form" method="post">
	
    <div id="js_ad_continue_next_step">
	<h2>{phrase var='ad.1_confirm_your_item'}</h2>
	<div class="main_break"></div>
	<div class="t_center">
	    <a href="{$aForms.link}">
		{$aForms.title}
		{if isset($aForms.image) && isset($aForms.image_dir) && isset($aForms.server_id)}<br />
		    {img server_id=$aForms.server_id path=$aForms.image_dir file=$aForms.image suffix='_500' max_width=500 max_height=500 title=$aForms.title}
		{/if}
		{if isset($aForms.extra)}
		<div class="extra_info">
		    {$aForms.extra}
		</div>
		{/if}
	    </a>
	</div>
	<div class="main_break"></div>

	<h2>{phrase var='ad.2_targeting'}</h2>

	<div class="main_break"></div>

	<div class="table">
	    <div class="table_left">
				    {phrase var='ad.location'}:
	    </div>
	    <div class="table_right">
		    {select_location value_title='phrase var=core.any' name='country_iso_custom'}
	    </div>
	    <div class="clear"></div>
	</div>
	<div class="table">
	    <div class="table_left">
				    {phrase var='ad.gender'}:
	    </div>
	    <div class="table_right">
				    {select_gender value_title='phrase var=core.any' name='gender'}
	    </div>
	    <div class="clear"></div>
	</div>
	<div class="table">
	    <div class="table_left">
				    {phrase var='ad.age_group_between'}:
	    </div>
	    <div class="table_right">
		<select name="val[age_from]" id="age_from">
		    <option value="">{phrase var='ad.any'}</option>
				    {foreach from=$aAge item=iAge}
		    <option value="{$iAge}"{value type='select' id='age_from' name='age_from' default=$iAge}>{$iAge}</option>
				    {/foreach}
		</select>
		<span id="js_age_to">
					    and
		    <select name="val[age_to]" id="age_to">
			<option value="">{phrase var='ad.any'}</option>
			    {foreach from=$aAge item=iAge}
			<option value="{$iAge}"{value type='select' id='age_to' name='age_to' default=$iAge}>{$iAge}</option>
			    {/foreach}
		    </select>
		</span>
	    </div>
	    <div class="clear"></div>
	</div>

	<div class="main_break"></div>

	<h2>{phrase var='ad.3_campaigns_and_pricing'}</h2>

	<div class="main_break"></div>

	<div class="table">
	    <div class="table_left">
				    {phrase var='ad.campaign_name'}:
	    </div>
	    <div class="table_right">
		<input type="text" name="val[name]" value="{value type='input' id='name'}" size="25" id="name" />
	    </div>
	    <div class="clear"></div>
	</div>

	<div class="table">
	    <div class="table_left">
				    {phrase var='ad.impressions'}:
	    </div>
	    <div class="table_right">
		<div><input type="hidden" name="val[ad_cost]" value="{value type='input' id='ad_cost'}" size="15" id="js_total_ad_cost" /></div>
		<input type="text" name="val[total_view]" onkeyup="$('#js_ad_cost').hide();$('#js_recalculate').show();" value="{value type='input' name='impressions' id='impressions' default='1000'}" size="15" id="total_view" />
		<span id="js_ad_cost" style="font-weight:bold;"></span>
		<span id="js_recalculate" style="display:none;" onclick="$Core.Ad.calcCost();">
		    <a href="#" onclick="return false;">
			{phrase var='ad.recalculate_costs'}
		    </a>
		</span>
	    </div>
	    <div class="clear"></div>
	</div>

	<div class="table">
	    <div class="table_left">
				    {phrase var='ad.start_date'}:
	    </div>
	    <div class="table_right">
				    {select_date prefix='start_' start_year='current_year' end_year='+10' field_separator=' / ' field_order='MDY' default_all=true add_time=true time_separator='core.time_separator'}
		<div class="extra_info">
					    {phrase var='ad.note_the_time_is_set_to_your_registered_time_zone'}
		</div>
	    </div>
	    <div class="clear"></div>
	</div>

	<div class="table_clear">
	   {if !isset($isView) || $isView != true}
	    <input type="submit" value="{phrase var='ad.submit'}" class="button" />
	   {/if}
	</div>
    </div>
</form>
{elseif $sStatus == ''}
<h3>{phrase var='ad.payment_methods'}</h3>
{module name='api.gateway.form'}
{else}
{phrase var='ad.your_order_has_been_processed'}
{/if}
