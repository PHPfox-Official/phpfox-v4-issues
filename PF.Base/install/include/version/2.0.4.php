<?php

$this->_db()->delete(Phpfox::getT('menu'), 'module_id = \'core\' AND var_name = \'menu_core_friends\'');

$this->_upgradeDatabase('2.0.4');

$bCompleted = true;

?>