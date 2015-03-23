<?php

$this->_upgradeDatabase('3.0.0rc1');

$this->_db()->update(Phpfox::getT('module'), array('is_core' => '1', 'is_active' => '1'), 'module_id ="friend"');

$bCompleted = true;

?>