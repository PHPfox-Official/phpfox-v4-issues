<?php

class Admincp_Component_Controller_App_Index extends Phpfox_Component {
	public function process() {
		$app = Phpfox_Module::instance()->get($this->request()->get('id'));

		$this->template()
			->setTitle($app['product_id'])
			->setTitle($app['module_id'])
			->assign([
				'app' => $app
			]);
	}
}