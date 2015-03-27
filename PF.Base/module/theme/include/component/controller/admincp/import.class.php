<?php

class Theme_Component_Controller_Admincp_Import extends Phpfox_Component {
	public function process() {
		$Theme = new Core\Theme();
		$id = $Theme->import();

		return [
			'redirect' => $this->url()->makeUrl('admincp.theme.manage', ['id' => $id])
		];
	}
}