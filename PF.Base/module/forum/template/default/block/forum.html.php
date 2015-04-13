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
		<div class="row1">
			<div class="_forum_title">
				<header>
					<h1 itemprop="name"><a href="{permalink module='forum' id=$aForum.forum_id title=$aForum.name}"{if !empty($aForum.description)} title="{$aForum.description|parse}" {/if} class="forum_title_link" itemprop="url">{$aForum.name|clean|convert}</a></h1>
				</header>
			</div>

			{if $aForum.thread_title}
			<div class="_form_last_post">
				<ul>
					<li>
						<a href="{if $aForum.post_id}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}post_{$aForum.post_id}/{else}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}{/if}" title="{$aForum.thread_title|clean}">
							{$aForum.thread_title|clean|shorten:50:'...'}
						</a><span>{$aForum.thread_time_stamp|convert_time} by {$aForum|user}</span>
					</li>
				</ul>
			</div>
			{/if}

			<ul class="_forum_info">
				<li><strong>{$aForum.total_thread|number_format}</strong><span>{phrase var='forum.threads'}</span></li>
				<li><strong>{$aForum.total_post|number_format}</strong><span>{phrase var='forum.posts'}</span></li>
			</ul>
		</div>
{/item}

{*
<div class="_forum_last_post">
	<a href="{if $aForum.post_id}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}post_{$aForum.post_id}/{else}{permalink module='forum.thread' id=$aForum.thread_id title=$aForum.thread_title_url}{/if}" title="{$aForum.thread_title|clean}">{$aForum.thread_title|clean|shorten:50:'...'}
	</a>
	<div class="extra_info">
		{phrase var='forum.by_full_name_on_time' full_name=$aForum|user:'':'':30 time=$aForum.thread_time_stamp|convert_time}
	</div>
</div>
*}