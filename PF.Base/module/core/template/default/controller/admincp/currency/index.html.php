<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1558 2010-05-04 12:51:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='core.currencies'}
</div>
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
	<tr>
		<th></th>
		<th style="width:20px;"></th>
		<th style="width:40px;" class="t_center">{phrase var='admincp.id'}</th>		
		<th style="width:60px;" class="t_center">{phrase var='admincp.symbol'}</th>
		<th>{phrase var='admincp.currency'}</th>
		<th class="t_center" style="width:80px;">{phrase var='admincp.default'}</th>
		<th class="t_center" style="width:60px;">{phrase var='admincp.active'}</th>		
	</tr>
{foreach from=$aCurrencies name=currencies item=aCurrency}
	<tr class="checkRow{if is_int($phpfox.iteration.currencies/2)} tr{else}{/if}">
		<td class="drag_handle"><input type="hidden" name="val[ordering][{$aCurrency.currency_id}]" value="{$aCurrency.ordering}" /></td>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='admincp.manage'}">{img theme='misc/bullet_arrow_down.png'}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.core.currency.add' id={$aCurrency.currency_id}">{phrase var='admincp.edit'}</a></li>
					<li><a href="{url link='admincp.core.currency' delete={$aCurrency.currency_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>
				</ul>
			</div>
		</td>
		<td class="t_center">{$aCurrency.currency_id}</td>
		<td class="t_center">{$aCurrency.symbol}</td>
		<td>{phrase var=$aCurrency.phrase_var}</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aCurrency.is_default} style="display:none;"{/if}>
				{img theme='misc/bullet_green.png' alt=''}
			</div>
			<div class="js_item_is_not_active"{if $aCurrency.is_default} style="display:none;"{/if}>
				<a href="#?call=core.updateCurrencyDefault&amp;id={$aCurrency.currency_id}&amp;active=1" class="js_item_active_link js_remove_default" title="{phrase var='admincp.set_as_default'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>
		<td class="t_center">
			<div class="js_item_is_active"{if !$aCurrency.is_active} style="display:none;"{/if}>
				<a href="#?call=core.updateCurrencyActivity&amp;id={$aCurrency.currency_id}&amp;active=0" class="js_item_active_link" title="{phrase var='admincp.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
			</div>
			<div class="js_item_is_not_active"{if $aCurrency.is_active} style="display:none;"{/if}>
				<a href="#?call=core.updateCurrencyActivity&amp;id={$aCurrency.currency_id}&amp;active=1" class="js_item_active_link" title="{phrase var='admincp.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
			</div>		
		</td>		
	</tr>
{/foreach}
</table>
<div class="table_clear"></div>