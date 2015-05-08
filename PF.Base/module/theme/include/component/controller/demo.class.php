<?php

class Theme_Component_Controller_Demo extends Phpfox_Component {
	public function process() {
		if (!defined('PHPFOX_ALLOW_MODE')) {
			exit;
		}

		$demoId = 0;
		if (($demoId = $this->request()->get('id'))) {
			Phpfox::setCookie('theme_id', $demoId);

			$this->url()->send('');
		}

		Core\View::$template = 'blank';
		$Themes = new Core\Theme();

		$this->template()->assign([
			'themes' => $Themes->all(),
			'demoId' => $demoId
		]);
	}
}