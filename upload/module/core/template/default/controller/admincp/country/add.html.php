<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: add.html.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.core.country.add'}">
{if $bIsEdit}
	<div><input type="hidden" name="id" value="{$aForms.country_iso}" /></div>
{/if}
	<div class="table_header">
		{phrase var='admincp.country_details'}
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.iso'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[country_iso]" value="{value id='country_iso' type='input'}" size="4" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{required}{phrase var='admincp.name'}:
		</div>
		<div class="table_right">
			<input type="text" name="val[name]" value="{value id='name' type='input'}" size="40" />
		</div>
		<div class="clear"></div>
	</div>	
	<div class="table_clear">
		<input type="submit" value="{if $bIsEdit}{phrase var='admincp.update'}{else}{phrase var='admincp.submit'}{/if}" class="button" />
	</div>
</form>