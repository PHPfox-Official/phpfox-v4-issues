<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: currency.html.php 1883 2010-10-05 08:43:21Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aCurrencies key=sName item=aCurrency}
<div class="currency">
	<span class="js_hover_title"><span class="js_hover_info">{phrase var=$aCurrency.name}</span>{$aCurrency.symbol}</span>
	<input type="text" name="{$sCurrencyFieldName}[{$sName}]" value="{if isset($aCurrency.value)}{$aCurrency.value|clean}{else}0{/if}" size="10" />
</div>
{/foreach}