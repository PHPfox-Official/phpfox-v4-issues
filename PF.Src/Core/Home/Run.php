<?php

namespace Core\Home;

class Run {
	private $_out;

	public function __construct($action, $response = null) {
		call_user_func([$this, $action], $response);
	}

	public function version() {
		$this->_out = [
			'version' => \Phpfox::getVersion()
		];
	}

	public function install($response) {
		$zip = PHPFOX_DIR_FILE . 'static/' . uniqid() . '.zip';
		file_put_contents($zip, file_get_contents($response->download));

		$Theme = new \Core\Theme();
		$Theme->import($zip, [
			'image' => $response->image,
			'id' => $response->internal_id
		]);

		$Url = new \Core\Url();
		$Url->send('admincp/theme', null, 'Theme successfully installed!');
	}

	public function __toString() {
		$out = json_encode($this->_out);

		return $out;
	}
}