<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: header.html.php 414 2009-04-17 23:31:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="profile_header">
	<a href="{url link='group.'$aGroup.title_url''}">{$aGroup.title|clean}</a>
</div>

<div id="profile_menu">
	<ul>
	{foreach from=$aGroupMenus key=sName item=aValue}
		<li{if $sGroupMenuActive == $aValue.active} class="active"{/if}><a href="{$aValue.url}">{$sName}</a></li>
	{/foreach}
	</ul>
</div>
	