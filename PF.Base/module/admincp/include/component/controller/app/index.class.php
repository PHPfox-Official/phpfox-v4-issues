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

			if (($settings = $this->request()->get('user_group_setting'))) {
				$UserGroupSetting = new Core\User\Setting();
				$UserGroupSetting->save($App, $settings);

				return [
					'updated' => true
				];
			}

			if ($this->request()->get('export')) {
				$App->export();
				exit;
			}

			$menus = [];
			if ($App->admincp_menu) {
				foreach ($App->admincp_menu as $key => $value) {
					$menus[$key] = [
						'url' => $this->url()->makeUrl('admincp/' . trim($value, '/'))
					];
				}
			}

			/*
			$menus['Uninstall'] = [
				'url' => $this->url()->makeUrl('admincp/app', ['id' => $App->id, 'uninstall' => 'yes'])
			];
			*/

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

			$userGroups = User_Service_Group_Group::instance()->get();
			$userGroupSettings = [];
			if ($App->user_group_settings) {
				foreach ($userGroups as $group) {

					$userGroupSettings[$group['user_group_id']] = [
						'id' => $group['user_group_id'],
						'name' => $group['title'],
						'settings' => []
					];

					foreach ($App->user_group_settings as $key => $value) {
						if (!isset($value->type)) {
							$value->type = 'input:text';
						}

						if (!isset($value->value)) {
							$value->value = '';
						}

						if (user($key) !== null) {
							$value->value = user($key, null, $group['user_group_id']);
						}

						$userGroupSettings[$group['user_group_id']]['settings'][$key] = [
							'info' => $value->info,
							'value' => $value->value,
							'type' => $value->type
						];
					}
				}
			}

			$this->template()->assign([
				'sSectionTitle' => $App->name,
				'aSectionAppMenus' => $menus,
				'ActiveApp' => $App,
				'settings' => $settings,
				'userGroupSettings' => $userGroupSettings
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

		$customContent = $App->admincp_route;

		$this->template()
			->setTitle($App->name)
			->assign([
				'App' => $App,
				'uninstall' => $this->request()->get('uninstall'),
				'uninstallUrl' => $this->url()->makeUrl('admincp/app', ['id' => $App->id, 'uninstall' => 'yes']),
				'disableUrl' => $this->url()->makeUrl('admincp/app', ['id' => $App->id, 'disable' => 'yes']),
				'enableUrl' => $this->url()->makeUrl('admincp/app', ['id' => $App->id, 'enable' => 'yes']),
				'customContent' => $customContent
			]);
	}
}