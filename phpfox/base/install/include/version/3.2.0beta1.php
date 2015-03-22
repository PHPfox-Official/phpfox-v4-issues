<?php

$this->_upgradeDatabase('3.2.0beta1');
$this->_db()->update(Phpfox::getT('setting'), array('value_actual' => date('j/n/Y', PHPFOX_TIME)), 'var_name = \'official_launch_of_site\'');

$bCompleted = true;

?>