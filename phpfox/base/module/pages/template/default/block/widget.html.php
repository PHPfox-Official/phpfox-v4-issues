<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aWidgetBlocks item=aWidgetBlock}
<div class="block">
	<div class="title">{$aWidgetBlock.title|clean}</div>
	<div class="content">
		{$aWidgetBlock.text|parse}
	</div>	
</div>
{/foreach}