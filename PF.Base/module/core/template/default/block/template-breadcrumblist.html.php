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
		{if count($aBreadCrumbs) > 1 || !empty($aBreadCrumbTitle)}
		{if $iBreadTotal = count($aBreadCrumbs)}{/if}
		<div id="breadcrumb_list">
			<ul>
			{foreach from=$aBreadCrumbs key=sLink item=sCrumb name=link}
				<li>{if !empty($sLink)}<a href="{$sLink}" class="ajax_link{if $phpfox.iteration.link == '1'} first{/if}">{/if}<span title="{$sCrumb|clean}">{$sCrumb|clean|shorten:40:'...'}</span>{if !empty($sLink)}</a>{/if}</li>
			{/foreach}
			</ul>
		</div>
		{/if}