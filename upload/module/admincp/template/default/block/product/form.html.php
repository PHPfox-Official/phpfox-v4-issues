<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: form.html.php 977 2009-09-12 15:29:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table">
	<div class="table_left">
	{if $bProductIsRequired}{required}{/if}{phrase var='admincp.product'}:
	</div>
	<div class="table_right">
		<select name="val[product_id]" {if $bUseClass}class{else}id{/if}="product_id">
		{foreach from=$aProducts item=aProduct}
			<option value="{$aProduct.product_id}"{value type='select' id='product_id' default=$aProduct.product_id}>{$aProduct.title}</option>
		{/foreach}
		</select>
	</div>
</div>