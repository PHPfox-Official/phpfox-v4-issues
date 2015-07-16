<?php

class Theme_Component_Controller_Demo extends Phpfox_Component {
	public function process() {

		if (!defined('PHPFOX_ALLOW_MODE')) {
			exit;
		}

		$demoId = 0;
		if (($demoId = $this->request()->get('id'))) {
			$Themes = new Core\Theme($demoId);

			Phpfox::setCookie('flavor_id', $demoId);

			$this->url()->send('');
		}
		/*
		else {
			$this->url()->send('');
		}
		*/

		Core\View::$template = 'blank';
		$Themes = new Core\Theme();

		$flavors = [];
		foreach ($Themes->all() as $Theme) {
			foreach ($Theme->flavors() as $Flavor) {
				$flavors[] = $Flavor;
			}
		}

		$this->template()->assign([
			// 'themes' => $Themes->all(),
			'flavors' => $flavors,
			'demoId' => $demoId
		]);
	}
}