<?php

class Admincp_Component_Controller_Store_index extends Phpfox_Component {
	public function process() {
		// $Apps = new Core\App();
		$Home = new Core\Home(PHPFOX_LICENSE_ID, PHPFOX_LICENSE_KEY);
		$response = $Home->admincp(['return' => $this->url()->makeUrl('admincp.app.add')]);

		$this->template()->setSectionTitle('Store');
		$this->template()->assign([
			'token' => $response->token,
			'load' => $this->request()->get('load')
		]);
	}
}