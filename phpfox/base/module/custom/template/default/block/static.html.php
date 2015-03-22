<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: block.html.php 3042 2011-09-08 09:58:34Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table">
	<div class="table_left">
		{phrase var=$aField.phrase_var_name}:
	</div>
	<div class="table_right">
		{if $aField.var_type == 'textarea'}
			<textarea name="static[{$aField.field_id}]"></textarea>
		{/if}
	</div>
</div>
