<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: entry.html.php 2232 2010-12-03 21:04:43Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
					{if (Phpfox::getUserParam('blog.edit_own_blog') && Phpfox::getUserId() == $aItem.user_id) || Phpfox::getUserParam('blog.edit_user_blog')}
						<li><a href="{url link="blog.add" id=""$aItem.blog_id""}">{phrase var='core.edit'}</a></li>
					{/if}
					{if (Phpfox::getUserParam('blog.delete_own_blog') && Phpfox::getUserId() == $aItem.user_id) || Phpfox::getUserParam('blog.delete_user_blog')}
						<li class="item_delete"><a href="{url link="blog.delete" id=""$aItem.blog_id""}" class="no_ajax_link" onclick="return confirm('{phrase var='blog.are_you_sure_you_want_to_delete_this_blog' phpfox_squote=true}');" title="{phrase var='blog.delete_blog'}">{phrase var='core.delete'}</a></li>
					{/if}
					{plugin call='blog.template_block_entry_links_main'}