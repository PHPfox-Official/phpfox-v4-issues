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

		$menu = [];
		if (defined('PHPFOX_IS_TECHIE') && PHPFOX_IS_TECHIE) {
			$menu['New App'] = [
				'url' => $this->url()->makeUrl('admincp/app/add'),
				'class' => 'popup light'
			];
		}

		$menu['Find More Apps'] = [
			'url' => $this->url()->makeUrl('admincp.store', ['load' => 'apps']),
			'class' => ''
		];
		$this->template()->setActionMenu($menu);

		$allApps = $Apps->all('__remove_core');
		$Home = new Core\Home(PHPFOX_LICENSE_ID, PHPFOX_LICENSE_KEY);
		$products = $Home->downloads(['type' => 0]);
		$newInstalls = [];
		if (is_object($products)) {
			foreach ($products as $product) {
				foreach ($allApps as $app) {
					if (isset($app->internal_id) && isset($product->id) && $app->internal_id == $product->id) {
						continue 2;
					}
				}

				$newInstalls[] = (array) $product;
			}
		}

		$this->template()->setSectionTitle('Apps');
		$this->template()->assign([
			// 'modules' => $Apps->all('__core'),
			'apps' => $allApps,
			'newInstalls' => $newInstalls
			// 'aNewProducts' => Admincp_Service_Product_Product::instance()->getNewProductsForInstall(),
			// 'appsV4' => $Apps->all()
		]);
	}
}