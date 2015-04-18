<?php

class Admincp_Component_Controller_Apps_index extends Phpfox_Component {
	public function process() {
		$Apps = new Core\App();

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
			'modules' => $Apps->all('__core'),
			'apps' => $Apps->all('__not_core'),
			'aNewProducts' => Admincp_Service_Product_Product::instance()->getNewProductsForInstall(),
			'appsV4' => $Apps->all()
		]);
	}
}