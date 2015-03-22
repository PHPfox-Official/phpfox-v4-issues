<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-menusub.html.php 2817 2011-08-08 16:59:43Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($aFilterMenus) && is_array($aFilterMenus) && count($aFilterMenus)}
<div class="header_display">
	<a href="#">
		<i class="fa fa-list-ul"></i>
		<span>Display</span>
	</a>

	<ul>
		{foreach from=$aFilterMenus name=filtermenu item=aFilterMenu}
		{if !isset($aFilterMenu.name)}
		<li class="menu_line"></li>
		{else}
		<li class="{if $aFilterMenu.active}active{/if}"><a href="{$aFilterMenu.link}">{$aFilterMenu.name}</a></li>
		{/if}
		{/foreach}
	</ul>
</div>
{/if}
							