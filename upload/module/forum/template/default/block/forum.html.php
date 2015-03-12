<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Forum
 * @version 		$Id: forum.html.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{item name='Thing'}
		<div class="table_row">
			<div class="forum_image">
				<div class="forum_large_{if $aForum.is_closed}closed{else}{if $aForum.is_seen}old{else}new{/if}{/if}" title="{if $aForum.is_closed}{phrase var='forum.forum_is_closed_for_posting'}{else}{if $aForum.is_seen}{phrase var='forum.forum_contains_no_new_posts'}{else}{phrase var='forum.forum_contains_new_posts'}{/if}{/if}">{$aForum.is_seen}</div>
			</div>			
			<div class="forum_title">
				<header>
					<h1 itemprop="name"><a href="{permalink module='forum' id=$aForum.forum_id title=$aForum.name}"{if !empty($aForum.description)} title="{$aForum.description|parse}" {/if} class="forum_title_link" itemprop="url">{$aForum.name|clean|convert}</a></h1>
				</header>					
					<div class="extra_info">
						<ul class="extra_info_middot">						
							<li>{phrase var='forum.threads'}: {$aForum.total_thread|number_format}</li>
							<li>&middot;</li>
							<li>{phrase var='forum.posts'}: {$aForum.total_post|number_format}</li>
						</ul>
					</div>
					{if Phpfox::isMobile() && !empty($aForum.thread_title)}
					<div class="forum_last_post">
						<a href="{if $aForum.post_id}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}post_{$aForum.post_id}/{else}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}{/if}" title="{$aForum.thread_title|clean}">{$aForum.thread_title|clean|split:20|shorten:50:'...'}
						</a>
						<div class="extra_info">
							{phrase var='forum.by_full_name_on_time' full_name=$aForum|user time=$aForum.thread_time_stamp|convert_time}
						</div>					
					</div>						
					{/if}
					{if isset($aForum.moderators)}
						{phrase var='forum.moderated_by'}: {foreach from=$aForum.moderators name=moderators item=aModerator}{if $phpfox.iteration.moderators != 1}, {/if}{$aModerator|user}{/foreach}
					{/if}
			</div>
			{if !Phpfox::isMobile() && !empty($aForum.thread_title)}
			<div class="forum_last_post">
				<a href="{if $aForum.post_id}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}post_{$aForum.post_id}/{else}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}{/if}" title="{$aForum.thread_title|clean}">{$aForum.thread_title|clean|shorten:50:'...'}
				</a>
				<div class="extra_info">
					{phrase var='forum.by_full_name_on_time' full_name=$aForum|user:'':'':30 time=$aForum.thread_time_stamp|convert_time}
				</div>					
			</div>	
			{/if}
		</div>
{/item}