<?php

class Admincp_Component_Controller_Apps_index extends Phpfox_Component {
	public function process() {
		$Apps = new Core\App();

		$this->template()->setSectionTitle('Apps');
		$this->template()->assign([
			'modules' => $Apps->all('__core'),
			'apps' => $Apps->all('__not_core'),
			'aNewProducts' => Admincp_Service_Product_Product::instance()->getNewProductsForInstall(),
			'appsV4' => $Apps->all()
		]);
	}
}