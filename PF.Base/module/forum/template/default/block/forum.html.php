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
					{if !empty($aForum.description)}
					<h2>{$aForum.description|clean}</h2>
					{/if}
				</header>
			</div>

			<ul class="_forum_info">
				<li><strong>{$aForum.total_thread|number_format}</strong><span>{phrase var='forum.threads'}</span></li>
				<li><strong>{$aForum.total_post|number_format}</strong><span>{phrase var='forum.posts'}</span></li>
			</ul>
		</div>
{/item}