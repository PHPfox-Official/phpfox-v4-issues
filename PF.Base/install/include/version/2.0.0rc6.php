<?php

$this->_upgradeDatabase('2.0.0rc6');

$this->_db()->update(Phpfox::getT('module'), array(
		'is_menu' => '1',
		'menu' => 'a:2:{s:34:"attachment.admin_menu_manage_types";a:1:{s:3:"url";a:1:{i:0;s:10:"attachment";}}s:34:"attachment.admin_menu_add_new_type";a:1:{s:3:"url";a:2:{i:0;s:10:"attachment";i:1;s:3:"add";}}}'
	), 'module_id = \'attachment\''
);

$bCompleted = true;

?>