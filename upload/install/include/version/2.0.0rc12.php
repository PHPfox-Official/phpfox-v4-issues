<?php

if ($this->_db()->isField(Phpfox::getT('user_field'), 'dst_check'))
{
	$this->_db()->dropField(Phpfox::getT('user_field'), 'dst_check');
}

$this->_upgradeDatabase('2.0.0rc12');

$bCompleted = true;

?>