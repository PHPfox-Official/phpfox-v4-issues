<?php

class Admincp_Component_Controller_App_Index extends Phpfox_Component {
	public function process() {
		// $app = Phpfox_Module::instance()->get(($this->request()->get('id')));
		$App = (new Core\App())->get($this->request()->get('id'));
		if (!$App->is_module) {

			if (($val = $this->request()->get('val'))) {
				if (!($error = User_Service_Auth::instance()->loginAdmin($val['email'], $val['password']))) {
					throw new \Exception(implode('', Phpfox_Error::get()));
				}

				$App->delete();
				Phpfox::addMessage('App successfully uninstalled.');
				return [
					'redirect' => $this->url()->makeUrl('admincp/apps')
				];
			}

			if (($settings = $this->request()->get('setting'))) {
				$Setting = new Core\Setting\Service($App);
				$Setting->save($settings);

				return [
					'updated' => true
				];
			}

			if ($this->request()->get('export')) {
				$App->export();
				exit;
			}

			$menus = [];
			if ($App->admincpMenu) {
				foreach ($App->admincpMenu as $key => $value) {
					$menus[$key] = [
						'url' => $this->url()->makeUrl('admincp/' . $value)
					];
				}
			}

			$menus['Uninstall'] = [
				'url' => $this->url()->makeUrl('admincp/app', ['id' => $App->id, 'uninstall' => 'yes'])
			];

			$settings = [];
			foreach ($App->settings as $key => $value) {
				if (!isset($value->type)) {
					$value->type = 'input:text';
				}

				if (!isset($value->value)) {
					$value->value = '';
				}

				if (setting($key) !== null) {
					$value->value = setting($key);
				}

				$settings[$key] = [
					'info' => $value->info,
					'value' => $value->value,
					'type' => $value->type
				];
			}

			$this->template()->assign([
				'sSectionTitle' => $App->name,
				'aSectionAppMenus' => $menus,
				'ActiveApp' => $App,
				'settings' => $settings
			]);

			if (defined('PHPFOX_IS_TECHIE') && PHPFOX_IS_TECHIE) {
				$this->template()->setActionMenu([
					'Export' => [
						'url' => $this->url()->makeUrl('admincp/app', ['id' => $App->id, 'export' => '1']),
						'class' => ''
					]
				]);
			}
		}

		$this->template()
			->setTitle($App->name)
			// ->setSectionTitle($App->name)
			->assign([
				'App' => $App,
				'uninstall' => $this->request()->get('uninstall')
			]);
	}
}