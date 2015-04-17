<?php

class Admincp_Component_Controller_App_Index extends Phpfox_Component {
	public function process() {

		// $app = Phpfox_Module::instance()->get(($this->request()->get('id')));
		$App = (new Core\App())->get($this->request()->get('id'));
		if (!$App->is_module) {
			$menus = [];
			if ($App->admincpMenu) {
				foreach ($App->admincpMenu as $key => $value) {
					$menus[$key] = [
						'url' => $this->url()->makeUrl('admincp/' . $value)
					];
				}
			}

			$this->template()->assign([
				'sSectionTitle' => $App->name,
				'aSectionAppMenus' => $menus,
				'ActiveApp' => $App
			]);
		}

		$this->template()
			->setTitle($App->name)
			// ->setSectionTitle($App->name)
			->assign([
				'App' => $App
			]);
	}
}