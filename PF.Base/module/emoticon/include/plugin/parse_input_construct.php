<?php
foreach ($this->_aEvilEvents as $sKey => $sValue)
{
	if(preg_match('/' . $sValue . '/i', strtolower(Phpfox::getParam('core.host'))))
	{
		unset($this->_aEvilEvents[$sKey]);
	}
}
?>
