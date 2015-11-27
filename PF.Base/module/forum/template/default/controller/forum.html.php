<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Forum
 * @version 		$Id: $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if !PHPFOX_IS_AJAX && $aCallback === null && !$bIsSearch}
	{template file='forum.block.entry'}
{/if}

{if !PHPFOX_IS_AJAX && !$bIsSearch && count($aAnnouncements)}
	{foreach from=$aAnnouncements item=aThread}
		{template file='forum.block.thread-entry'}
	{/foreach}
{/if}

{if count($aThreads)}

	{if isset($bResult) && $bResult}
		{foreach from=$aThreads item=aPost}
			{template file='forum.block.post'}
		{/foreach}
	{else}
		{foreach from=$aThreads item=aThread}
			{template file='forum.block.thread-entry'}
		{/foreach}
	{/if}

	{pager}
{/if}

{if !isset($bIsPostSearch) && (Phpfox::getUserParam('forum.can_approve_forum_thread') || Phpfox::getUserParam('forum.can_delete_other_posts'))}
	{moderation}
{/if}
