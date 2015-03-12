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
<div class="table_info">
	<b>{phrase var='forum.sub_forum'}:</b> {$aForumData.name|clean|convert}	
</div>
{/if}

{foreach from=$aForums name=forums item=aForum}
{if $aForum.is_category}
<div class="table_info">
	<a href="{permalink module='forum' id=$aForum.forum_id title=$aForum.name}"{if !empty($aForum.description)} title="{$aForum.description|parse}" {/if}>{$aForum.name|clean|convert}</a>	
</div>
{if count($aForum.sub_forum)}
		{foreach from=$aForum.sub_forum item=aForum}
		{template file='forum.block.forum'}
		{/foreach}
		<br />
{/if}
{else}
	{if !isset($bIsSubForum) && $phpfox.iteration.forums == 1}
	<div class="table_info">
		{phrase var='forum.forums'}
	</div>
	{/if}
	{template file='forum.block.forum'}
{/if}
{/foreach}

{if isset($bIsSubForum)}
<br />
{/if}

{/if}