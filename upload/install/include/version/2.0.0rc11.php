<?php

$aLanguages = $this->_db()->select('language_id, site')
	->from(Phpfox::getT('language'))
	->execute('getRows');

foreach ($aLanguages as $aLanguage)
{
	if (substr($aLanguage['site'], 0, 7) != 'http://')
	{
		$this->_db()->update(Phpfox::getT('language'), array('site' => 'http://' . $aLanguage['site']), 'language_id = \'' . $aLanguage['language_id'] . '\'');
	}
}

$this->_db()->delete(Phpfox::getT('menu'), 'var_name = \'menu_friends\'');

$this->_upgradeDatabase('2.0.0rc11');

$bCompleted = true;

?>