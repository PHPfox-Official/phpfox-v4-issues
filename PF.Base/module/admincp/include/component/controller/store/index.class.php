<?php

class Admincp_Component_Controller_Store_index extends Phpfox_Component {
	public function process() {
		// $Apps = new Core\App();
		$Home = new Core\Home(PHPFOX_LICENSE_ID, PHPFOX_LICENSE_KEY);
		$response = $Home->admincp(['return' => $this->url()->makeUrl('admincp.app.add')]);
		if (!isset($response->token)) {
			// throw error($response->error);
			// return Phpfox_Error::set($response->error);
			exit($response->error);
		}

		$load = $this->request()->get('load');
		$token = $response->token;
		if (($open = $this->request()->get('open'))) {
			$token .= '&search=' . $open;
		}
		if (($upgrade = $this->request()->get('upgrade'))) {
			header('Location: ' . Core\Home::store() . 'product/' . $upgrade . '/install.json/installing?iframe-mode=' . $token . '&is-upgrade=true');
			exit;
		}
		if (($upgrade = $this->request()->get('install'))) {
			header('Location: ' . Core\Home::store() . 'product/' . $upgrade . '/install.json/installing?iframe-mode=' . $token);
			exit;
		}
		$this->template()->setSectionTitle('<a href="' . $this->url()->current() . '">Store</a>');
		$this->template()->assign([
			'token' => $token,
			'load' => $load,
			'storeUrl' => Core\Home::store()
		]);
	}
}