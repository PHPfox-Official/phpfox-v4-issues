<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: file.html.php 1149 2009-10-07 10:14:46Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
	<div class="table_header">
		Manual Install
	</div>
	{if count($aNewProducts)}
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>Product</th>
			<th>Version</th>
			<th style="width:100px;">Action</th>
		</tr>
		{foreach from=$aNewProducts key=iKey item=aProduct}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
			<td>
			{if !empty($aProduct.url)}<a href="{$aProduct.url}" target="_blank">{/if}{$aProduct.title|clean}{if !empty($aProduct.url)}</a>{/if}
				{if !empty($aProduct.description)}
				<div class="extra_info">
					{$aProduct.description|clean}
				</div>
				{/if}
			</td>
			<td class="t_center">{if empty($aProduct.version)}N/A{else}{$aProduct.version}{/if}</td>			
			<td class="t_center">
				<a href="{url link='admincp.product.file' install=$aProduct.product_id}" title="Click to install this product.">Install</a>
			</td>
		</tr>
		{/foreach}
	</table>
	{else}
	<div class="table">
		<div class="message">
			Nothing new to install.
		</div>	
	</div>	
	{/if}	
	<div class="table_clear"></div>
	<br />
{*
<form method="post" action="{url link='admincp.product.file'}" enctype="multipart/form-data">
	<div class="table_header">
		{phrase var='admincp.import'}
	</div>
	{if Phpfox::getParam('core.ftp_enabled')}
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.select_file'}:
		</div>
		<div class="table_right">
			<input type="file" name="import" />
			<div class="p_4">
				{phrase var='admincp.valid_file_extensions'}: {$sSupported}
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.overwrite'}:
		</div>
		<div class="table_right">
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="overwrite" value="1" /> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="overwrite" value="0" checked="checked" /> {phrase var='admincp.no'}</span>
			</div>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.upload'}" class="button" />
	</div>
	{else}
	<div class="table">
		<div class="message">
			{phrase var='admincp.ftp_support_must_be_enabled_in_order_to_import_products'}
		</div>
		<div class="extra_info">
			{phrase var='admincp.click_a_href_url_link_admincp_setting_edit_group_id_ftp_here_a_to_enable_ftp_support' link=$sFtpEditLink}
		</div>
	</div>
	<div class="table_clear"></div>
	{/if}	
</form>
*}