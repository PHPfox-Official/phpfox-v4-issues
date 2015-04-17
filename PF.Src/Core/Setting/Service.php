<?php

namespace Core\Setting;

class Service extends \Core\Model {
	private $_app;

	public function __construct(\Core\App\Object $App) {
		parent::__construct();

		$this->_app = $App;
	}

	public function save($settings) {
		foreach ($settings as $key => $value) {
			$this->db->delete(':setting', ['product_id' => $this->_app->id, 'var_name' => $key]);
			$this->db->insert(':setting', [
				'module_id' => 'app_' . $this->_app->id,
				'product_id' => $this->_app->id,
				'is_hidden' => 1,
				'type_id' => 'string',
				'var_name' => $key,
				'phrase_var_name' => $key,
				'value_actual' => $value,
				'value_default' => $value
			]);
		}

		$this->cache->del('app_settings');

		return true;
	}
}