<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: top.html.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aTopBloggers)}
<ul class="action">
{foreach from=$aTopBloggers item=aTopBlogger}
	<li><a href="{$aTopBlogger.link}">{img user=$aTopBlogger suffix='_50' max_width=20 max_height=20 style="vertical-align:middle;" no_link=true} {$aTopBlogger.full_name} {if Phpfox::getParam('blog.display_post_count_in_top_bloggers')} ({$aTopBlogger.top_total}){/if}</a></li>
{/foreach}
</ul>
{/if}