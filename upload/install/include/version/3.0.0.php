<?php

$this->_db()->update(Phpfox::getT('user_group_setting'), array('is_hidden' => '1'), 'name = \'can_control_comments_on_photos\'');

$this->_upgradeDatabase('3.0.0');

$bCompleted = true;

?>