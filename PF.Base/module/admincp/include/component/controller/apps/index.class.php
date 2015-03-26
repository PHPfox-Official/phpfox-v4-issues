<?php

class Admincp_Component_Controller_Apps_index extends Phpfox_Component {
	public function process() {
		$Apps = new Core\App();

		$this->template()->setSectionTitle('Apps');
		$this->template()->assign([
			'apps' => $Apps->all(true)
		]);
	}
}