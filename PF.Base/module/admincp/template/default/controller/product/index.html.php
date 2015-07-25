<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: index.html.php 1544 2010-04-07 13:20:17Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!');

?>
{if count($aProducts)}
<form method="post" action="{url link='admincp.product'}">
	<table>
	{foreach from=$aProducts key=iKey item=aProduct}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.product.add' id=$aProduct.product_id}">{phrase var='admincp.edit'}</a></li>
					<li><a href="{url link='admincp.product.file' export=$aProduct.product_id extension='xml'}">{phrase var='admincp.export'}</a></li>
					<li><a href="{url link='admincp.product' delete=$aProduct.product_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='admincp.delete'}</a></li>
				</ul>
			</div>		
		</td>		
		<td>{$aProduct.title} ({$aProduct.version})</td>
		<td class="t_center">
		{if isset($aProduct.upgrade_version)}
			<a href="{url link='admincp.product' upgrade=$aProduct.product_id}" class="action_link">{phrase var='admincp.upgrade_upgrade_version' upgrade_version=$aProduct.upgrade_version}</a>
		{else}
			{phrase var='admincp.n_a'}
		{/if}
		</td>
	</tr>
	{/foreach}
	</table>
</form>

{else}
<div class="extra_info">
	No modules have been installed.
</div>
{/if}