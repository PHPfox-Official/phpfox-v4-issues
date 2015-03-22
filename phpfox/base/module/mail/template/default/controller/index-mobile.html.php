<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: index-mobile.html.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="search_bar">
	<form method="post" action="{if $bIsSentbox}{url link='mail.sent'}{else}{url link='mail'}{/if}">
		<input type="text" name="search" value="" style="width:70%;" /> <input type="submit" value="{phrase var='friend.search'}" class="button" />
	</form>
</div>
{if count($aMessages)}
{foreach from=$aMessages item=aMessage}
<div class="item{if !$bIsSentbox && $aMessage.viewer_is_new} item_active{/if}">
	<div class="item_image">
		{img user=$aMessage suffix='_50_square' max_width=35 max_height=35}
	</div>
	<div class="item_content">
		<a href="{url link='mail.view' id=$aMessage.mail_id}">{$aMessage.subject|clean}</a>
		<div class="extra_info">
		{if $bIsSentbox}{phrase var='mail.to'}:{else}{phrase var='mail.from'}:{/if} {$aMessage|user}
		</div>
	</div>
	<div class="clear"></div>
</div>
{/foreach}
{pager}
{else}
{if $bIsSearch}
{phrase var='mail.unable_to_find_any_messages'}
{else}
{phrase var='mail.no_messages'}
{/if}
{/if}