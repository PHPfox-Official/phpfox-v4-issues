<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Forum
 * @version 		$Id: index.html.php 140 2009-01-30 13:04:09Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $aCallback === null && count($aForums)}

{if isset($bIsSubForum)}
<div class="block">
	<div class="title">
		{$aForumData.name|clean|convert}
	</div>
	<div class="content">
{/if}

{foreach from=$aForums name=forums item=aForum}
{if !isset($bIsSubForum)}
<div class="block">
	{if $aForum.is_category}
	<div class="title">
		<a href="{permalink module='forum' id=$aForum.forum_id title=$aForum.name}"{if !empty($aForum.description)} title="{$aForum.description|parse}" {/if}>{$aForum.name|clean|convert}</a>
	</div>
	<div class="content">
{/if}
	{if count($aForum.sub_forum)}
			{foreach from=$aForum.sub_forum item=aForum}
			{template file='forum.block.forum'}
			{/foreach}
	{/if}
	{else}
		{if !isset($bIsSubForum) && $phpfox.iteration.forums == 1}
		<div class="table_info">
			{phrase var='forum.forums'}
		</div>
		{/if}
		{template file='forum.block.forum'}
	{/if}
{if !isset($bIsSubForum)}

	</div>
</div>
{/if}

{/foreach}

{if isset($bIsSubForum)}
	</div>
</div>
{/if}

{/if}