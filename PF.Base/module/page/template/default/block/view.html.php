<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="label_flow" style="height:300px;">
	{if $aPage.parse_php}{$aPage.text_parsed|eval}{else}{$aPage.text_parsed}{/if}
</div>