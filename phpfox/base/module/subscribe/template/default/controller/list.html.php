<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 5382 2013-02-18 09:48:39Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{plugin call='subscribe.template_controller_list__1'}
{if count($aPurchases)}
    {plugin call='subscribe.template_controller_list__2'}
    {foreach from=$aPurchases item=aPurchase name=purchases}
        {plugin call='subscribe.template_controller_list__3'}
        <div class="{if is_int($phpfox.iteration.purchases/2)}row1{else}row2{/if}{if $phpfox.iteration.purchases == 1} row_first{/if}">
            {template file='subscribe.block.entry'}
        </div>
        {plugin call='subscribe.template_controller_list__4'}
    {/foreach}
{else}
    {plugin call='subscribe.template_controller_list__5'}
    <div class="extra_info">
        {phrase var='subscribe.no_subscriptions_found'}
    </div>
    {plugin call='subscribe.template_controller_list__6'}
{/if}
{plugin call='subscribe.template_controller_list__7'}