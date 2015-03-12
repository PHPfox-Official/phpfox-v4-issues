<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Forum
 * @version 		$Id: index.html.php 4074 2012-03-28 14:02:40Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="p_bottom_10">
	<ul class="sub_menu_bar">
		{if Phpfox::isUser()}
		<li><a href="#" class="sJsDropMenu drop_down_link">{phrase var='forum.quick_links'}</a>
			<div class="link_menu dropContent">
				<ul>
					<li><a href="{url link='forum.read'}">{phrase var='forum.mark_forums_read'}</a></li>
					<li><a href="{url link='forum.search' view='new'}">{phrase var='forum.new_posts'}</a></li>
					<li><a href="{url link='forum.search' view='my-thread'}">{phrase var='forum.my_threads'}</a></li>
					<li><a href="{url link='forum.search' view='subscribed'}">{phrase var='forum.subscribed_threads'}</a></li>					
				</ul>
			</div>		
		</li>	
		{/if}
		<li><a href="#" class="sJsDropMenu drop_down_link">{phrase var='forum.search'}</a>
			<div class="link_menu dropContent">
				<form method="post" action="{url link='forum.search'}">
					<div class="div_menu">
						<input type="text" name="search[keyword]" value="" class="v_middle" /> <input name="search[submit]" type="submit" value="{phrase var='forum.go'}" class="button v_middle" />
					</div>
					<div class="div_menu">
						<label><input type="radio" name="search[result]" value="0" class="v_middle checkbox" checked="checked" /> {phrase var='forum.show_threads'}</label>
						<label><input type="radio" name="search[result]" value="1" class="v_middle checkbox" /> {phrase var='forum.show_posts'}</label>
					</div>
				</form>
				<ul>
					<li><a href="{url link='forum.search'}">{phrase var='forum.advanced_search'}</a></li>
				</ul>
			</div>
		</li>		
	</ul>
	<div class="clear"></div>
</div>

{if !count($aForums)}
<div class="extra_info">
	{phrase var='forum.no_forums_have_been_created'}
	{if Phpfox::getUserParam('forum.can_add_new_forum')}
	<ul class="action">
		<li><a href="{url link='admincp.forum.add'}">{phrase var='forum.create_a_new_forum'}</a></li>
	</ul>
	{/if}
</div>
{else}
{template file='forum.block.entry'}
{/if}