<?php

class MODULE_Component_Controller_Index extends Phpfox_Component {
	public function process() {
		$this->template()->setTitle('Hello World!')
			->setBreadCrumb('Welcome to my Controller!')
			->assign([
				'foo' => 'bar'
			]);
	}
}