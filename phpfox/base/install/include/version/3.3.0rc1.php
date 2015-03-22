<?php

$this->_upgradeDatabase('3.3.0rc1');

$this->_db()->update(Phpfox::getT('user_group_setting'), array('is_hidden' => '1'), 'name = \'custom_table_name\'');

$bCompleted = true;

?>