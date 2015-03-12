<?php

$this->_db()->update(Phpfox::getT('user_group_setting'), array('is_hidden' => '1'), 'name = \'can_spotlight_videos\'');
$this->_db()->update(Phpfox::getT('user_group_setting'), array('is_hidden' => '1'), 'name = \'total_song_on_profile\'');
$this->_db()->update(Phpfox::getT('module'), array('menu' => 'a:1:{s:60:"user.admin_menu_phrase_var_user_anti_spam_security_questions";a:1:{s:3:"url";a:2:{i:0;s:4:"user";i:1;s:4:"spam";}}}'), 'product_id = "phpfox" AND module_id = "user"');
$this->_upgradeDatabase('3.5.0beta2');

$bCompleted = true;

?>