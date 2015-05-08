<?php

class Admincp_Component_Controller_App_Add extends Phpfox_Component {
	public function process() {
		if (isset($_SERVER['HTTP_X_FILE_NAME']) || $this->request()->get('download')) {
			$App = (new Core\App())->import($this->request()->get('download'), ($this->request()->get('download') ? true : false));

			if ($this->request()->get('download')) {
				$this->url()->send('admincp.app', ['id' => $App->id]);
			}

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