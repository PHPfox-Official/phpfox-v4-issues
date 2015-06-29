<?php

class Admincp_Component_Controller_Store_index extends Phpfox_Component {
	public function process() {
		// $Apps = new Core\App();
		$Home = new Core\Home(PHPFOX_LICENSE_ID, PHPFOX_LICENSE_KEY);
		$response = $Home->admincp(['return' => $this->url()->makeUrl('admincp.app.add')]);
		if (!isset($response->token)) {
			var_dump($response);
			exit;
		}

		$load = $this->request()->get('load');
		$token = $response->token;
		if (($open = $this->request()->get('open'))) {
			$token .= '&search=' . $open;
		}
		$this->template()->setSectionTitle('<a href="' . $this->url()->current() . '">Store</a>');
		$this->template()->assign([
			'token' => $token,
			'load' => $load
		]);
	}
}