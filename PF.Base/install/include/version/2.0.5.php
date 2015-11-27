<?php

$this->_db()->query('ALTER TABLE ' . Phpfox::getT('ad') . ' CHANGE ad_id ad_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT');
$this->_db()->delete(Phpfox::getT('component'), 'module_id = \'core\' AND component = \'guest\'');

$this->_upgradeDatabase('2.0.5');
	
$bCompleted = true;

?>