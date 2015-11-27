<?php

return function(Phpfox_Installer $Installer) {
	$Installer->db->delete(':menu', 'menu_id > 0');
	$Installer->db->delete(':block', 'block_id > 0');
	$Installer->db->delete(':block_source', 'block_id > 0');
	$Installer->db->delete(':theme', 'theme_id > 0');
	$Installer->db->delete(':theme_style', 'style_id > 0');
	$Installer->db->delete(':product', 'product_id > 0');

	if (!$Installer->db->select('COUNT(*)')->from(':product')->where(['product_id' => 'phpfox'])->execute('getField')) {
		$Installer->db->insert(':product', [
			'product_id' => 'phpfox',
			'is_core' => 1,
			'title' => 'Core',
			'is_active' => 1
		]);
	}

	if (!$Installer->db->select('COUNT(*)')->from(':language')->where(['language_id' => 'en'])->execute('getField')) {
		$Installer->db->insert(':language', [
			'language_id' => 'en',
			'title' => 'English',
			'direction' => 'ltr',
			'charset' => 'UTF-8',
			'time_stamp' => PHPFOX_TIME,
			'is_default' => 1,
			'is_master' => 1
		]);
	}

	$modules = $Installer->db->select('*')->from(':module')->all();
	foreach ($modules as $module) {
		$dir = PHPFOX_DIR_MODULE . $module['module_id'] . '/';
		if (!is_dir($dir)) {
			$Installer->db->delete(':module', ['module_id' => $module['module_id']]);
		}
	}

	$themeId = $Installer->db->insert(Phpfox::getT('theme'), [
		'name' => 'Default',
		'folder' => 'default',
		'created' => PHPFOX_TIME,
		'is_active' => 1,
		'is_default' => 0
	]);

	$Installer->db->insert(Phpfox::getT('theme_style'), [
		'theme_id' => $themeId,
		'is_active' => 1,
		'is_default' => 1,
		'name' => 'Default',
		'folder' => 'default',
		'created' => PHPFOX_TIME
	]);

	$Theme = new Core\Theme();
	$newTheme = $Theme->make([
		'name' => 'Neutron'
	]);
	$Installer->db->update(Phpfox::getT('theme'), ['is_default' => 1], ['theme_id' => $newTheme->theme_id]);

	if (!$Installer->db->select('COUNT(*)')->from(':country')->execute('getField')) {
		Core_Service_Country_Process::instance()->importForInstall(Phpfox::getLib('xml.parser')->parse(PHPFOX_DIR_XML . 'country' . PHPFOX_XML_SUFFIX));
	}

	return [
		'reset' => true
	];
};
