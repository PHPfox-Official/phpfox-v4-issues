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
{foreach from=$aInputs item=aInput}
	<div class="info">
		<div class="info_left">
			{phrase var=$aInput.phrase_var}:
		</div>	
		<div class="info_right">
			{$aInput.value}
		</div>	
	</div>		
{/foreach}