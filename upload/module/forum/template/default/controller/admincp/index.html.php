<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: index.html.php 2197 2010-11-22 15:26:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !$sForumList}
<div class="extra_info">
	{phrase var='forum.no_forums_created_yet'}
	<ul class="action">
		<li><a href="{url link='admincp.forum.add'}">{phrase var='forum.create_a_new_forum'}</a></li>
	</ul>
</div>
{else}
<div id="js_menu_drop_down" style="display:none;">
	<div class="link_menu dropContent" style="display:block;">
		<ul>
		{if Phpfox::getUserParam('forum.can_edit_forum')}
			<li><a href="#" onclick="return $Core.forum.action(this, 'edit');">{phrase var='forum.edit_forum'}</a></li>
		{/if}
			<li><a href="#" onclick="return $Core.forum.action(this, 'view');">{phrase var='forum.view_forum'}</a></li>
		{if Phpfox::getUserParam('forum.can_add_new_forum')}
			<li><a href="#" onclick="return $Core.forum.action(this, 'add');">{phrase var='forum.add_child_forum'}</a></li>
		{/if}
		{if Phpfox::getUserParam('forum.can_manage_forum_moderators')}
			<li><a href="#" onclick="return $Core.forum.action(this, 'moderator');">{phrase var='forum.manage_moderators'}</a></li>
		{/if}
		{if Phpfox::getUserParam('forum.can_manage_forum_permissions')}
			<li><a href="#" onclick="return $Core.forum.action(this, 'permission');">{phrase var='forum.manage_permissions'}</a></li>
		{/if}
		{if Phpfox::getUserParam('forum.can_delete_forum')}
			<li><a href="#" onclick="return $Core.forum.action(this, 'delete');">{phrase var='forum.delete_forum'}</a></li>
		{/if}
		</ul>
	</div>
</div>

<div id="js_forum_edit_content"></div>
<div id="js_form_actual_content">
	<form method="post" action="{url link='admincp.forum'}">
		<div class="table_header">
			{phrase var='forum.forums'}
		</div>
		<div class="table">
			<div class="sortable">
				{$sForumList}
			</div>
		</div>
		<div class="table_clear">
			<span id="js_update_order"></span><input type="submit" value="{phrase var='forum.update_order'}" class="button" />
		</div>
	</form>
</div>
{/if}