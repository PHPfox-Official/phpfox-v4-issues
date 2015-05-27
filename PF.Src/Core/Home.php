<?php

namespace Core;

/**
 * Class Home
 * @package Core
 *
 * @method Home token()
 * @method Home verify()
 * @method Home install()
 * @method Home vendor($name)
 * @method Home admincp()
 */
class Home {
	private $_id;
	private $_key;

	public function __construct($id = null, $key = null) {
		$this->_id = $id;
		$this->_key = $key;
	}

	public function checkAppInstalled($params) {
		$App = new \Core\App();
		$_App = $App->get($params['id']);
		d($_App); exit;
	}

	public function run($action, $response = null) {
		header('Content-type: application/json');
		echo (new Home\Run($action, $response));
		exit;
	}

	public function __call($method, $args) {
		$url = (defined('PHPFOX_API_URL') ? PHPFOX_API_URL : 'http://store.phpfox.us/') . $method;
		$Http = new HTTP($url);
		$Http->auth($this->_id, $this->_key);
		if (\Phpfox::isTrial()) {
			$Http->header('PHPFOX_IS_TRIAL', '1');
		}

		$Http->using(['domain' => \Phpfox::getParam('core.path')]);
		$Http->using(['version' => \Phpfox::VERSION]);
		foreach ($args as $key => $value) {
			if (is_string($value)) {
				// $value = [$key => $value];
			}
			$Http->using($value);
		}

		return $Http->post();
	}
}