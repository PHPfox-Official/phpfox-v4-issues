<?php

if ((Phpfox_Module::instance()->getFullControllerName() == 'forum.thread' || (PHPFOX_IS_AJAX && isset($_POST['core']) && $_POST['core']['call'] == 'forum.addReply')) && Phpfox::isUser())
{
	$aPost = $this->getVar('aPost');
	$aThread = (array) $this->getVar('aThread');
	$iTotalPosts = (int) $this->getVar('iTotalPosts');

	if ((Phpfox::getUserParam('forum.can_reply_to_own_thread')
			&& $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_reply_on_other_threads')
		|| Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'can_reply')
	)
	{
		echo '<div class="forum_quote"><a href="#" onclick="$Core.box(\'forum.reply\', 800, \'id=' . $aPost['thread_id'] . '&amp;quote=' . $aPost['post_id'] . '&amp;total_post=' . $iTotalPosts . '\'); return false;">' . Phpfox::getPhrase('core.quote') . '</a></div>';

	}
}