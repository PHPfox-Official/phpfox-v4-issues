<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPromotions)}
<div class="table_header">
	{phrase var='user.promotions'}
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='user.user_group'}</th>
		<th>{phrase var='user.upgraded_user_group'}</th>
		<th class="t_center">{phrase var='user.total_activity'}</th>
		<th class="t_center">{phrase var='user.total_days_registered'}</th>
		<th>Created On</th>
	</tr>
	{foreach from=$aPromotions name=promotions item=aPromotion}
	<tr{if is_int($phpfox.iteration.promotions/2)} class="tr"{/if}>
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='user.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.user.promotion.add' id=$aPromotion.promotion_id}">{phrase var='user.edit'}</a></li>		
					<li><a href="{url link='admincp.user.promotion' delete=$aPromotion.promotion_id}" onclick="return confirm('{phrase var='core.are_you_sure' phpfox_squote=true}');">{phrase var='user.delete'}</a></li>					
				</ul>
			</div>		
		</td>		
		<td>{$aPromotion.user_group_title|convert}</td>
		<td>{$aPromotion.upgrade_user_group_title|convert}</td>
		<td class="t_center">{$aPromotion.total_activity}</td>
		<td class="t_center">{$aPromotion.total_day}</td>
		<td>{$aPromotion.time_stamp|date}</td>
	</tr>
	{/foreach}
</table>
<div class="table_clear"></div>
{else}
<div class="message">
	{phrase var='user.no_promotions_found'}
</div>
{/if}