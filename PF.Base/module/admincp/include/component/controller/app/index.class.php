<?php

class Admincp_Component_Controller_App_Index extends Phpfox_Component {
	public function process() {

		// $app = Phpfox_Module::instance()->get(($this->request()->get('id')));
		$App = (new Core\App())->get($this->request()->get('id'));
		$this->template()
			->setTitle($App->name)
			// ->setSectionTitle($App->name)
			->assign([
				'App' => $App
			]);
	}
}