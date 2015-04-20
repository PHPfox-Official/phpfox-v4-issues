<?php

class Admincp_Component_Controller_App_Add extends Phpfox_Component {
	public function process() {
		if (isset($_SERVER['HTTP_X_FILE_NAME'])) {
			$App = (new Core\App())->import();

			return [
				'redirect' => $this->url()->makeUrl('admincp.app', ['id' => $App->id])
			];
		}

		if ($token = $this->request()->get('m9token')) {
			(new Core\App())->vendor($token);

			d($token);
			exit;
		}

		if (($val = $this->request()->getArray('val'))) {
			$App = (new Core\App())->make($val['name'], $val['vendor']);

			Phpfox::addMessage('App successfully created.');
			return [
				'redirect' => $this->url()->makeUrl('admincp.app', ['id' => $App->id])
			];
		}

		$this->template()->setBreadCrumb('New App', $this->url()->current(), true);
	}
}