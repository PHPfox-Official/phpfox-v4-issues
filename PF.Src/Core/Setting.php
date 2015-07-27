<?php

namespace Core;

class Setting extends \Core\Model {
	private static $_settings = null;

	public function __construct() {
		if (self::$_settings === null) {
			parent::__construct();

			self::$_settings = $this->cache->get('app_settings');
			if (is_bool(self::$_settings)) {
				$App = new \Core\App(true);
				foreach ($App->all() as $_app) {
					if ($_app->settings) {
						foreach ($_app->settings as $key => $value) {
							$thisValue = (isset($value->value) ? $value->value : null);
							$value = $this->db->select('*')->from(':setting')->where(['var_name' => $key])->get();
							if (isset($value['value_actual'])) {
								$thisValue = $value['value_actual'];
							}
							self::$_settings[$key] = $thisValue;
						}
					}
				}

				$this->cache->set('app_settings', self::$_settings);
				self::$_settings = $this->cache->get('app_settings');
			}
		}
	}

	public function get($key, $default = null) {
		return (isset(self::$_settings[$key]) ? self::$_settings[$key] : $default);
	}
}