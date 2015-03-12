<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: breadcrumb.html.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aBreadCrumbs)}
<div id="breadcrumb_holder"{if !$bIsUsersProfilePage && count($aSubMenus)} class="has_section_menu"{/if} itemscope itemtype="http://schema.org/WebPage">
	<div id="breadcrumb_content" itemprop="breadcrumb">
		{if empty($aBreadCrumbTitle)}
		{foreach from=$aBreadCrumbs key=sLink item=sCrumb name=link}
		{if $phpfox.iteration.link == 1}
		{if count($aBreadCrumbTitle)}<div class="h1">{else}<h1>{/if}{if !empty($sLink)}<a href="{$sLink}" class="ajax_link">{/if}{$sCrumb|clean}{if !empty($sLink)}</a>{/if}{if count($aBreadCrumbTitle)}</div>{else}</h1>{/if}
		{/if}
		{/foreach}			
		{/if}
		{breadcrumb_list}
	</div>	
	 {breadcrumb_menu}	
</div>
{/if}