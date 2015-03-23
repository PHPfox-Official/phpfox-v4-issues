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
<div class="profile_header">
	<div id="section_menu">
	{if isset($bIsPagesViewSection)}		
		<ul>
			{foreach from=$aSubPageMenus item=aSubPageMenu}
			<li><a href="{$aSubPageMenu.url}">{$aSubPageMenu.phrase}</a></li>
			{/foreach}
		</ul>			
	{else}
		{if $aPage.is_app || !$aPage.is_admin}
		<ul>
			{if $aPage.is_app}
				<li><a href="{permalink module='apps' id=$aPage.app_id title=$aPage.title}">{phrase var='pages.go_to_app'}</a></li>
			{/if}
			{if !$aPage.is_admin}
				<li><a href="{url link='pages.add'}">{phrase var='pages.create_a_page'}</a></li>		
			{/if}	
		</ul>
		{/if}
	{/if}	
	</div>
	
	<h1><a href="{$aPage.link}" title="{$aPage.title|clean}">{$aPage.title|clean|split:50|shorten:40:'...'}</a>
	
	{template file='pages.block.joinpage'}
	</h1>
	<div class="profile_info">
		{$aPage.category_name|convert}
	</div>
</div>