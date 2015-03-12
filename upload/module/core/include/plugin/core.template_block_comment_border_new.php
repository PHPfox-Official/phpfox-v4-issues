<?php
if ((Phpfox::getLib('module')->getFullControllerName() == 'forum.thread' || (PHPFOX_IS_AJAX && isset($_POST['core']) && $_POST['core']['call'] == 'forum.addReply')) && Phpfox::isUser())
{
	echo '<div class="feed_comment_extra">
		<ul style="margin:0px; padding:0px;">
	';
	$aPost = $this->getVar('aPost');
	$aThread = (array) $this->getVar('aThread');	
	$iTotalPosts = (int) $this->getVar('iTotalPosts');	

	if ((Phpfox::getUserParam('forum.can_edit_own_post') && $aPost['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_edit_other_posts') || Phpfox::getService('forum.moderate')->hasAccess($aPost['forum_id'], 'edit_post'))
	{
		echo '<li><a href="#" onclick="$Core.box(\'forum.reply\', 800, \'id=' . $aPost['thread_id'] . '&amp;edit=' . $aPost['post_id'] . '\'); return false;">' . Phpfox::getPhrase('forum.edit') . '</a></li>';
		echo '<li>&middot;</li>';
	}	

	if ((Phpfox::getUserParam('forum.can_reply_to_own_thread') 
		&& $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_reply_on_other_threads') 
		|| Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'can_reply')
		)
	{
		echo '<li><a href="#" onclick="$Core.box(\'forum.reply\', 800, \'id=' . $aPost['thread_id'] . '&amp;quote=' . $aPost['post_id'] . '&amp;total_post=' . $iTotalPosts . '\'); return false;">' . Phpfox::getPhrase('core.quote') . '</a></li>';
		echo '<li>&middot;</li>';
	}

	if ((Phpfox::getUserParam('forum.can_delete_own_post') && $aPost['user_id'] == Phpfox::getUserId()) 
		|| Phpfox::getUserParam('forum.can_delete_other_posts') 
		|| Phpfox::getService('forum.moderate')->hasAccess($aPost['forum_id'], 'delete_post') 
		|| (!empty($aThread['group_id']) && Phpfox::getService('pages')->isAdmin($aThread['group_id']))
		)
	{
		echo '<li><a href="#" onclick="return $Core.forum.deletePost(\'' . $aPost['post_id'] . '\');" title="' . Phpfox::getPhrase('forum.delete_this_post') . '">' . Phpfox::getPhrase('forum.delete') . '</a></li>';
		echo '<li>&middot;</li>';
	}

	echo '<li class="feed_entry_time_stamp"><a href="' . Phpfox::permalink('forum.thread', $aPost['thread_id'], $aThread['title'], false, null, array('view' => $aPost['post_id'])) . '">#' . $aPost['count'] . '</a></li>';
	
	echo '
		</ul>
	</div>';
}
?>