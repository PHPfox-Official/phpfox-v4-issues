<?php

class Admincp_Component_Controller_Apps_index extends Phpfox_Component {
	public function process() {
		$Apps = new Core\App();

		if (($token = $this->request()->get('m9token'))) {
			$response = (new Core\Home(PHPFOX_LICENSE_ID, PHPFOX_LICENSE_KEY))->token(['token' => $token]);
			if ($response->token) {
				$file = PHPFOX_DIR_SETTINGS . 'license.sett.php';
				$content = file_get_contents($file);
				$content = preg_replace('!define\(\'PHPFOX_LICENSE_ID\', \'(.*?)\'\);!s', 'define(\'PHPFOX_LICENSE_ID\', \'techie_' . $this->request()->get('m9id') . '\');', $content);
				$content = preg_replace('!define\(\'PHPFOX_LICENSE_KEY\', \'(.*?)\'\);!s', 'define(\'PHPFOX_LICENSE_KEY\', \'techie_' . $this->request()->get('m9key') . '\');', $content);

				file_put_contents($file, $content);

				$this->template()->assign('vendorCreated', true);
			}
		}

		if (defined('PHPFOX_IS_TECHIE') && PHPFOX_IS_TECHIE) {
			$this->template()->setActionMenu([
				'New App' => [
					'url' => $this->url()->makeUrl('admincp/app/add'),
					'class' => 'popup'
				]
			]);
		}

		$this->template()->setSectionTitle('Apps');
		$this->template()->assign([
			// 'modules' => $Apps->all('__core'),
			'apps' => $Apps->all('__remove_core'),
			'aNewProducts' => Admincp_Service_Product_Product::instance()->getNewProductsForInstall(),
			// 'appsV4' => $Apps->all()
		]);
	}
}