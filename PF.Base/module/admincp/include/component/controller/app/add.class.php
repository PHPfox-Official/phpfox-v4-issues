<?php

class Admincp_Component_Controller_App_Add extends Phpfox_Component {
	public function process() {
		if (isset($_SERVER['HTTP_X_FILE_NAME'])) {
			$App = (new Core\App())->import();

			return [
				'redirect' => $this->url()->makeUrl('admincp.app', ['id' => $App->id])
			];
		}

		$this->template()->setBreadCrumb('New App', $this->url()->current(), true);
	}
}