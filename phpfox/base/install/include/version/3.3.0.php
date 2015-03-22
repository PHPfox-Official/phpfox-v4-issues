<?php

$this->_upgradeDatabase('3.3.0');

$aTotalPagesIndex = $this->_db()->select('*')
	->from(Phpfox::getT('component'))
	->where('m_connection = \'pages.index\'')
	->execute('getSlaveRows');
if (count($aTotalPagesIndex) > 1 && isset($aTotalPagesIndex[0]) && isset($aTotalPagesIndex[0]['component_id']))
{
	$this->_db()->delete(Phpfox::getT('component'), 'm_connection = ' . (int) $aTotalPagesIndex[0]['component_id']);
}

$bCompleted = true;

?>