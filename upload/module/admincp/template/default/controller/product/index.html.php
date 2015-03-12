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
<div class="table_header">
	{phrase var='admincp.products'}
</div>
<form method="post" action="{url link='admincp.product'}">
	<table>
	<tr>
		<th style="width:20px;"></th>
		<th>{phrase var='admincp.name'}</th>
		<th class="t_center">{phrase var='admincp.latest'}</th>
		<th class="t_center">{phrase var='admincp.version'}</th>
		<th class="t_center">{phrase var='admincp.upgrade'}</th>
		<th style="width:60px;">{phrase var='admincp.active'}</th>
	</tr>
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
		<td>{$aProduct.title}</td>
		<td class="t_center">{if $aProduct.latest_version > 0}{if !empty($aProduct.url)}<a href="{$aProduct.url}" target="_blank">{/if}{$aProduct.latest_version}</a>{else}{$aProduct.version}{/if}</td>
		<td class="t_center">{$aProduct.version}</td>
		<td class="t_center">
		{if isset($aProduct.upgrade_version)}
			<a href="{url link='admincp.product' upgrade=$aProduct.product_id}" class="action_link">{phrase var='admincp.upgrade_upgrade_version' upgrade_version=$aProduct.upgrade_version}</a>
		{else}
			{phrase var='admincp.n_a'}
		{/if}
		</td>
		<td class="t_center">
			<div><input type="hidden" name="val[{$aProduct.product_id}][id]" value="1" /></div>
			<div><input type="checkbox" name="val[{$aProduct.product_id}][is_active]" value="1" {if $aProduct.is_active}checked="checked" {/if}/></div>
		</td>	
	</tr>
	{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" value="{phrase var='admincp.update'}" class="button" />
	</div>
</form>

<script type="text/javascript">
	setTimeout('$.ajaxCall(\'admincp.checkProductVersions\');', 2000);
</script>

{else}
{phrase var='admincp.no_products_have_been_added'}
<ul class="action">
	<li><a href="{url link='admincp.product.add'}">{phrase var='admincp.create_a_new_product'}</a></li>
	<li><a href="{url link='admincp.product.file'}">{phrase var='admincp.import_a_product'}</a></li>
</ul>
{/if}