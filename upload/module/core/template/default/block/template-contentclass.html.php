<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-contentclass.html.php 6620 2013-09-11 12:10:20Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !$bUseFullSite}class="content_column {if count($aBlocks3) || count($aBlocks1) || count($aAdBlocks3) || count($aAdBlocks1)} content_float{/if} {if (count($aBlocks1) || count($aAdBlocks1)) && (count($aBlocks3) || count($aAdBlocks3))} content3{/if} {if count($aBlocks1) || count($aBlocks3) || count($aAdBlocks3)} {if isset($aFilterMenus) && (count($aBlocks3) || count($aAdBlocks3)) && !count($aBlocks1)}content3{else}content2{/if}{/if}"{/if}