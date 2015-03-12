<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: display.html.php 3042 2011-09-08 09:58:34Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aCustomMain item=aCustom}
{if $sTemplate == 'info'}
{if !empty($aCustom.value)}
<div class="info">
	<div class="info_left">
		{phrase var=$aCustom.phrase_var_name}:
	</div>	
	<div class="info_right">
		{module name='custom.entry' data=$aCustom template=$sTemplate edit_user_id=$aUser.user_id}		
	</div>	
</div>		
{/if}
{else}
	{module name='custom.block' data=$aCustom template=$sTemplate edit_user_id=$aUser.user_id}
{/if}
{/foreach}