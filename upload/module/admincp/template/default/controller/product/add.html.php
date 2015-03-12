<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: add.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<form method="post" action="{url link="admincp.product.add"}" id="js_form" onsubmit="{$sGetJsForm}">
	{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.product_id}" /></div>
	{/if}
	<div class="table_header">
		{phrase var='admincp.product_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.product_id'}:
		</div>
		<div class="table_right">
			{if $bIsEdit}
			<input type="hidden" name="val[product_id]" value="{value type='input' id='product_id'}" size="40" id="product_id" maxlength="25" />	
			{$aForms.product_id}
			{else}
			<input type="text" name="val[product_id]" value="{value type='input' id='product_id'}" size="40" id="product_id" maxlength="25" />	
			{/if}
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.title'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[title]" value="{value type='input' id='title'}" size="40" id="title" maxlength="50" />	
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.description'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[description]" value="{value type='input' id='description'}" size="40" id="description" maxlength="250" />	
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.version'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[version]" value="{value type='input' id='version'}" size="10" id="version" maxlength="25" />	
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.product_url'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[url]" value="{value type='input' id='url'}" size="40" id="url" maxlength="250" />	
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.version_check_url'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[url_version_check]" value="{value type='input' id='url_version_check'}" size="40" id="url_version_check" maxlength="250" />	
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.active'}:
		</div>
		<div class="table_right">
			<div class="item_is_active_holder">		
				<span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='admincp.yes'}</span>
				<span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active' default='0'}/> {phrase var='admincp.no'}</span>
			</div>			
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.submit'}" class="button" />
	</div>
</form>

{if $bIsEdit}
<form method="post" action="{url link="admincp.product.add"}" id="js_form" onsubmit="{$sGetJsForm}">
	<div><input type="hidden" name="val[dependency][product_id]" value="{$aForms.product_id}" /></div>
	<h2>{phrase var='admincp.dependencies'}</h2>
	{if isset($aDependencies) && count($aDependencies)}	
	<div class="table_header">
		{phrase var='admincp.existing_product_dependencies'}
	</div>	
	<table>
	<tr>
		<th>{phrase var='admincp.dependency_type'}</th>
		<th style="width:20%;">{phrase var='admincp.compatibility_starts'}</th>
		<th style="width:20%;">{phrase var='admincp.incompatible_with'}</th>
		<th style="width:5%;">{phrase var='admincp.delete'}</th>
	</tr>		
	{foreach from=$aDependencies key=iKey item=aDependency}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td>
			{if $aDependency.type_id == 'php'}
			PHP
			{elseif $aDependency.type_id == 'product'}
			Product - {$aDependency.check_id}
			{else}
			phpFox
			{/if}		
		</td>
		<td style="text-align:center;"><input type="text" name="val[dependency][update][{$aDependency.dependency_id}][dependency_start]" value="{$aDependency.dependency_start}" maxlength="25" size="15" /></td>
		<td style="text-align:center;"><input type="text" name="val[dependency][update][{$aDependency.dependency_id}][dependency_end]" value="{$aDependency.dependency_end}" maxlength="25" size="15" /></td>
		<td style="text-align:center;"><input type="checkbox" name="val[dependency][delete][]" class="checkbox" value="{$aDependency.dependency_id}" id="js_id_row{$aDependency.dependency_id}" /></td>
	</tr>	
	{/foreach}
	</table>
	{/if}
	<div class="table_header">
		{phrase var='admincp.add_new_product_dependency'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.type'}:
		</div>
		<div class="table_right">
			<label><input type="radio" name="val[dependency][type_id]" value="php" /> {phrase var='admincp.php'}</label>
			<div style="padding-top:5px;">
				<label><input type="radio" name="val[dependency][type_id]" value="phpfox" /> {phrase var='admincp.phpfox_version'}</label> 
			</div>
			<div style="padding-top:5px;">
				<label><input type="radio" name="val[dependency][type_id]" value="product" /> {phrase var='admincp.product_id'}</label> <input type="text" name="val[dependency][check_id]" value="" /> 
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.compatibility_starts_with_version'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[dependency][dependency_start]" value="" maxlength="25" size="15" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.compatibility_end_with_version'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[dependency][dependency_end]" value="" maxlength="25" size="15" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.save'}" class="button" />
	</div>	
</form>

<form method="post" action="{url link="admincp.product.add"}" id="js_form" onsubmit="{$sGetJsForm}">
	<div><input type="hidden" name="val[install][product_id]" value="{$aForms.product_id}" /></div>
	<h2>{phrase var='admincp.install_uninstall'}</h2>
	{if isset($aInstalls) && count($aInstalls)}	
	<div class="table_header">
		{phrase var='admincp.existing_install_uninstall_code'}
	</div>	
	<table>
	<tr>
		<th style="width:20%;">{phrase var='admincp.version'}</th>
		<th>{phrase var='admincp.install_code'}</th>
		<th>{phrase var='admincp.uninstall_code'}</th>
		<th style="width:5%;">{phrase var='admincp.delete'}</th>
	</tr>		
	{foreach from=$aInstalls key=iKey item=aInstall}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td>
			<input type="text" name="val[install][update][{$aInstall.install_id}][version]" value="{$aInstall.version}" maxlength="25" size="15" />
		</td>
		<td><textarea cols="50" rows="8" name="val[install][update][{$aInstall.install_id}][install_code]" style="width:95%;">{$aInstall.install_code|htmlspecialchars}</textarea></td>
		<td><textarea cols="50" rows="8" name="val[install][update][{$aInstall.install_id}][uninstall_code]" style="width:95%;">{$aInstall.uninstall_code|htmlspecialchars}</textarea></td>
		<td style="text-align:center;"><input type="checkbox" name="val[install][delete][]" class="checkbox" value="{$aInstall.install_id}" id="js_id_row{$aInstall.install_id}" /></td>
	</tr>	
	{/foreach}
	</table>
	{/if}	
	<div class="table_header">
		{phrase var='admincp.add_new_install_uninstall_code'}
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.version'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[install][version]" value="" maxlength="25" size="15" />
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.install'}:
		</div>
		<div class="table_right">
			<textarea cols="50" rows="8" name="val[install][install_code]" style="width:95%;"></textarea>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table">
		<div class="table_left">
			{phrase var='admincp.uninstall'}:
		</div>
		<div class="table_right">
			<textarea cols="50" rows="8" name="val[install][uninstall_code]" style="width:95%;"></textarea>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="table_clear">
		<input type="submit" value="{phrase var='admincp.save'}" class="button" />
	</div>		
</form>
	
{/if}