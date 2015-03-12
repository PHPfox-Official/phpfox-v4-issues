<?php

$this->_upgradeDatabase('3.0.0beta4');

$this->_db()->update(Phpfox::getT('user_group_setting'), array('is_hidden' => '1'), 'name IN(\'can_thank_on_forum_posts\', \'can_delete_thanks_by_other_users\')');
	
$bCompleted = true;

?>