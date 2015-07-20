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
		$Request = new \Core\Request();
		$Url = new \Core\Url();

		$zip = PHPFOX_DIR_FILE . 'static/' . uniqid() . '.zip';
		file_put_contents($zip, file_get_contents($response->download));

		switch ($Request->get('type')) {
			case 'isAppInstalled':
				echo "OK";
				break;
			case 'language':
				$file = PHPFOX_DIR_FILE . 'static/' . uniqid() . '/';
				mkdir($file);

				$Zip = new \ZipArchive();
				$Zip->open($zip);
				$Zip->extractTo($file);
				$Zip->close();

				// $xml = \Phpfox::getLib('xml.parser')->parse($file . 'phpfox-language-import.xml');
				$name = false;
				$fullPath = $file . 'upload/include/';
				foreach (scandir($fullPath . 'xml/language/') as $dir) {
					if (file_exists($fullPath . 'xml/language/' . $dir . '/phpfox-language-import.xml')) {
						$name = $dir;
					}
				}

				if (!$name) {
					throw new \Exception('Not a valid language package to install.');
				}

				\Language_Service_Process::instance()->installPackFromFolder($name, $fullPath . 'xml/language/' . $name . '/');

				$Url->send('admincp/language/import', ['dir' => base64_encode($fullPath . 'xml/language/' . $name . '/')]);
				break;
			default:
				$Theme = new \Core\Theme();
				$Theme->import($zip, [
					'image' => $response->image,
					'id' => $response->internal_id,
					'version' => $response->internal_version
				]);

				$Url->send('admincp/theme', null, 'Theme successfully installed!');
				break;
		}

		exit;
	}

	public function __toString() {
		$out = json_encode($this->_out);

		return $out;
	}
}