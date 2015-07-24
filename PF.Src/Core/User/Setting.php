<?php

namespace Core\User;

class Setting extends \Core\Model {
	private $_app;
	private static $_settings = null;

	public function __construct() {
		parent::__construct();

		self::$_settings = $this->cache->get('app_user_group_settings');
		if (!is_array(self::$_settings)) {
			$settings = [];
			$rows = $this->db->select('*')->from(':user_group_custom')->all();
			foreach ($rows as $row) {
				if (!\Phpfox::isModule($row['module_id'])) {
					$settings[$row['user_group_id']][$row['name']] = $row['default_value'];
				}
			}

			$this->cache->set('app_user_group_settings', $settings);
			self::$_settings = $this->cache->get('app_user_group_settings');
		}
	}

	public function get($key, $default = null, $userGroupId = null) {
		$userGroupId = ($userGroupId === null ? $this->active->group->id : $userGroupId);
		if (isset(self::$_settings[$userGroupId]) && isset(self::$_settings[$userGroupId][$key])) {
			return self::$_settings[$userGroupId][$key];
		}

		return $default;
	}

	public function save(\Core\App\Object $App, $settings) {
		$this->_app = $App;

		foreach ($settings as $group_id => $values) {
			foreach ($values as $key => $value) {
				$this->db->delete(':user_group_custom', ['user_group_id' => $group_id, 'module_id' => 'app_' . $this->_app->id, 'name' => $key]);
				$this->db->insert(':user_group_custom', [
					'user_group_id' => $group_id,
					'module_id' => 'app_' . $this->_app->id,
					'name' => $key,
					'default_value' => $value
				]);
			}
		}

		$this->cache->del('app_user_group_settings');

		return true;
	}
}