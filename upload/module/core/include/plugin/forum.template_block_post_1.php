<?php

if ((Phpfox_Module::instance()->getFullControllerName() == 'forum.thread' || (PHPFOX_IS_AJAX && isset($_POST['core']) && $_POST['core']['call'] == 'forum.addReply')) && Phpfox::isUser())
{
	$aPost = $this->getVar('aPost');
	$aThread = (array) $this->getVar('aThread');

	echo '<a class="forum_post_count" href="' . Phpfox::permalink('forum.thread', $aPost['thread_id'], $aThread['title'], false, null, array('view' => $aPost['post_id'])) . '">#' . $aPost['count'] . '</a>';
}