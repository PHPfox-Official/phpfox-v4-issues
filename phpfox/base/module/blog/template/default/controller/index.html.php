<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: index.html.php 7290 2014-04-30 19:14:20Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($bSpecialMenu) && $bSpecialMenu == true}
    {template file='blog.block.specialmenu'}
{/if}
{if !count($aItems)}
<div class="extra_info">
	{phrase var='blog.no_blogs_found'}
</div>
{else}
{foreach from=$aItems name=blog item=aItem}
	{item name='BlogPosting'}
		{template file='blog.block.entry'}
	{/item}
{/foreach}
{if Phpfox::getUserParam('blog.can_approve_blogs') || Phpfox::getUserParam('blog.delete_user_blog')}
{moderation}
{/if}
{unset var=$aItems}
{pager}
{/if}
