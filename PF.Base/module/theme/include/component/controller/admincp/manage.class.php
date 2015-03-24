<?php

class Theme_Component_Controller_Admincp_Manage extends Phpfox_Component {
	public function process() {

		$Theme = $this->template()->theme()->get($this->request()->get('id'));
		$Service = new Core\Theme\Service($Theme);

		if (($load = $this->request()->get('load'))) {
			if (($content = $this->request()->get('content'))) {
				switch ($load) {
					case 'html':
						$Service->html()->set($content);
						break;
					case 'css':
						$Service->css()->set($content);
						break;
					case 'javascript':
						$Service->js()->set($content);
						break;
				}

				return [
					'posting' => true
				];
			}

			$data = '';
			switch ($load) {
				case 'html':
					$data = $Service->html()->get();
					break;
				case 'css':
					$data = $Service->css()->get();
					break;
				case 'javascript':
					$data = $Service->js()->get();
					break;
				default:

					break;
			}

			return [
				'ace' => $data,
				'run' => "\$AceEditor.mode('{$load}'); " . (string) j('.ace_editor')->data('ace-mode', $load)->data('ace-save', $this->url()->makeUrl('admincp.theme.manage', ['id' => $this->request()->get('id'), 'load' => $load]))
			];
		}

		$this->template()->setTitle('Theme Manager');
		$this->template()->setTemplate('blank');
		$this->template()->assign([
			'theme' => $Theme
		]);
	}
}