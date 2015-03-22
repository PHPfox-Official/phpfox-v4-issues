<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.group.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.category_id}" /></div>
{/if}
	<div class="table_header">
		{phrase var='group.group_category_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='group.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" size="30" maxlength="100" value="{value type='input' id='name'}" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table">
		<div class="table_left">
			{phrase var='group.parent_category'}:
		</div>
		<div class="table_right">
			<select name="val[parent_id]" style="width:300px;">
				<option value="">{phrase var='group.select'}:</option>
				{$sOptions}
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" value="{phrase var='group.submit'}" class="button" />
	</div>
</form>