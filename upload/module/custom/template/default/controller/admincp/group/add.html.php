<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1572 2010-05-06 12:37:24Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	{$sGroupCreateJs}
	<form method="post" action="{url link='admincp.custom.group.add'}" id="js_group_field" onsubmit="{$sGroupGetJsForm}">
		{if $bIsEdit}
		<div><input type="hidden" name="id" value="{$aForms.group_id}" /></div>
		{/if}
		{template file='custom.block.group-form'}
		<div class="table_clear">
			<input type="submit" value="{phrase var='custom.submit'}" class="button" />			
		</div>		
	</form>