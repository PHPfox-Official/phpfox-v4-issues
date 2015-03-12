<?php

/** Add an index to the event_category */
$this->_db()->addIndex(Phpfox::getT('event_category'), 'name_url');

$aRow = array(
				'name' => 'Nebula',
				'folder' => 'nebula',
				'created' => '1212226813',
				'is_active' => '1',
				'is_default' => '0',
				'total_column' => '3'
		);

$iInsertId = $this->_db()->insert(Phpfox::getT('theme'), $aRow);

$aRow = 
		array(
				'theme_id' => $iInsertId,
				'name' => 'Nebula',
				'folder' => 'nebula',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
		);

$this->_db()->insert(Phpfox::getT('theme_style'), $aRow);

$this->_upgradeDatabase('3.5.0rc1');
$bCompleted = true;


/* Check if the user_spam menu exists */
$aRow = $this->_db()->select('is_active, is_menu, menu')
        ->from(Phpfox::getT('module'))
        ->where('module_id = "user"')
        ->execute('getSlaveRow');
if ($aRow['is_menu'] != 1 || $aRow['is_active'] != 1 || $aRow['menu'] != 'a:1:{s:60:"user.admin_menu_phrase_var_user_anti_spam_security_questions";a:1:{s:3:"url";a:2:{i:0;s:4:"user";i:1;s:4:"spam";}}}')
{
    $this->_db()->update(Phpfox::getT('module'), array(
        'is_active' => '1',
        'is_menu' => '1',
        'menu' => 'a:1:{s:60:"user.admin_menu_phrase_var_user_anti_spam_security_questions";a:1:{s:3:"url";a:2:{i:0;s:4:"user";i:1;s:4:"spam";}}}'), 'product_id = "phpfox" AND module_id = "user"');
}

?>