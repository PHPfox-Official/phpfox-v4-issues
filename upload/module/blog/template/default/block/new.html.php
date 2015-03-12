<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aBlogs)}
<div class="extra_info">
	{phrase var='blog.no_blogs_have_been_added_yet'}
	<ul class="action">
		<li><a href="{url link='blog.add'}">{phrase var='blog.be_the_first_to_add_a_blog'}</a></li>
	</ul>
</div>
{else}
{foreach from=$aBlogs name=blogs item=aBlog}
<div class="{if is_int($phpfox.iteration.blogs/2)}row1{else}row2{/if}{if $phpfox.iteration.blogs == 1} row_first{/if}"{if $phpfox.iteration.blogs == 1} style="padding-top:0px;"{/if}>
	<div class="go_left" style="width:52px;">
		{img user=$aBlog max_width=50 max_height=50 suffix='_50' class='v_middle'}
	</div>
	<div style="margin-left:54px;">
		<a href="{url link=''$aBlog.user_name'.blog.'$aBlog.title_url''}">{$aBlog.title|clean}</a>
		<div class="extra_info">
			{$aBlog.posted_on}
		</div>
	</div>
	<div class="clear"></div>
</div>
{/foreach}
{/if}