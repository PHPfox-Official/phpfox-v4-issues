<?php

class Admincp_Component_Controller_App_Add extends Phpfox_Component {
	public function process() {
		$Theme = new Core\Theme();
		$file = null;
		if ($this->request()->get('type') == 'theme') {
			$dir = PHPFOX_DIR_FILE . 'static/' . uniqid() . '/';
			mkdir($dir);
			$file = $dir . 'import.zip';
			file_put_contents($file, file_get_contents($this->request()->get('download')));
			register_shutdown_function(function() use($dir) {
				Phpfox_File::instance()->delete_directory($dir);
			});

			Phpfox::addMessage('Theme successfully installed.');
			$id = $Theme->import($file);
			// $this->url()->send('admincp.theme');
			echo '<script>window.top.location.href = \'' . $this->url()->makeUrl('admincp.theme') . '\';</script>';
			exit;
		}

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