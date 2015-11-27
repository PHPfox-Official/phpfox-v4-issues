<?php

class Admincp_Component_Controller_Setting_Url extends Phpfox_Component {
	public function process() {
		$htaccess = PHPFOX_DIR . '../.htaccess';
		$hasRewrite = false;
		$hasHtaccess = false;

		if (Phpfox::getParam('core.url_rewrite') == '1') {
			$hasRewrite = true;
		}

		if (file_exists($htaccess) && $hasRewrite) {
			$hasHtaccess = true;
			$content = file_get_contents($htaccess);
			if (strpos($content, 'PHPfox')) {
				$hasRewrite = true;
			}
		}

		if ($this->request()->isPost()) {
			$url = str_replace('/index.php/', '/', $this->url()->makeUrl('contact'));
			$headers = get_headers($url);
			if (strpos($headers[0], 'Not Found')) {
				throw new \Exception('The /.htaccess file seems to be missing our Rewrite rules or this server does not support Mod_Rewrite.');
			}

			$file = PHPFOX_DIR_SETTINGS . 'server.sett.php';
			$setting = file_get_contents($file);
			$setting = preg_replace('/\$_CONF\[\'core\.url_rewrite\'] = \'(.*?)\';/is', '$_CONF[\'core.url_rewrite\'] = \'1\';', $setting);
			file_put_contents($file, $setting);

			file_put_contents(PHPFOX_DIR_SETTINGS . 'rewrite.sett.php', "<?php\n");

			$url = str_replace('/index.php/', '/', $this->url()->makeUrl('admincp.setting.url'));
			return [
				'redirect' => $url
			];
		}

		$this->template()->setTitle('Short URL')
			->setSectionTitle('Short URL')
			->assign([
				'hasRewrite' => $hasRewrite,
				'hasHtaccess' => $hasHtaccess
			]);
	}
}