<?php

$this->_db()->update(Phpfox::getT('user_group_setting'), array(
		'is_hidden' => 1
		), 'module_id = ' . "'photo'" . ' AND name = ' . "'can_search_for_photos'");
		
$this->_db()->update(Phpfox::getT('user_group_setting'), array(
		'is_hidden' => 1
		), 'module_id = ' . "'feed'" . ' AND name = ' . "'can_sponsor_feeds'");

$this->_upgradeDatabase('3.7.5');
$bCompleted = true;

?>
