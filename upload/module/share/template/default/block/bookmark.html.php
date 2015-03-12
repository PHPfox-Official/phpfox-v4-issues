<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Share
 * @version 		$Id: bookmark.html.php 4154 2012-05-07 14:32:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div>
	{if count($aPostBookmarks)}
	{foreach from=$aPostBookmarks item=aBookmark name=bookmark}
	<div class="go_left p_4" style="width:45%;">
		<a href="{$aBookmark.url}" target="_blank"><img src="{$sUrlStaticImage}{$aBookmark.icon}" alt="" style="vertical-align:middle;" /></a> <a href="{$aBookmark.url}" target="_blank">{$aBookmark.title}</a>
	</div>
	{if is_int($phpfox.iteration.bookmark/2)}
	<div class="clear"></div>
	{/if}
	{/foreach}
	<div class="clear"></div>	
	{/if}
	{if count($aBookmarks)}
	{foreach from=$aBookmarks item=aBookmark name=bookmark}
	<div class="go_left p_4" style="width:45%;">
		<a href="{$aBookmark.url}" target="_blank"><img src="{$sUrlStaticImage}{$aBookmark.icon}" alt="" style="vertical-align:middle;" /></a> <a href="{$aBookmark.url}" target="_blank">{$aBookmark.title}</a>
	</div>
	{if is_int($phpfox.iteration.bookmark/2)}
	<div class="clear"></div>
	{/if}
	{/foreach}
	<div class="clear"></div>
	{/if}
</div>