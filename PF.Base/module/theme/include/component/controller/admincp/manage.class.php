<?php

class Theme_Component_Controller_Admincp_Manage extends Phpfox_Component {
	public function process() {

		$Session = new Core\Session();
		$key = 'admincp_flavor_' . $this->request()->get('id');
		if (($flavor = $this->request()->get('flavor'))) {
			$Session->set($key, $flavor);
		}

		$Theme = $this->template()->theme()->get($this->request()->get('id'));
		if (($flavor = $Session->get($key))) {
			$Theme->setFlavor($flavor);
		}

		if (($default = $this->request()->get('default'))) {
			return $Theme->setDefault();
		}
		else if ($flavorId = $this->request()->get('flavor-delete')) {
			$Session->remove($key);
			$Theme->deleteFlavor($flavorId);
			$this->url()->send('admincp.theme.manage', ['id' => $this->request()->get('id')], 'Flavor successfully deleted.');
		}
		else if ($this->request()->get('export')) {
			$Theme->export();
		}
		else if ($this->request()->get('merge')) {
			$Theme->merge();

			$this->url()->send('admincp.theme.manage', ['id' => $this->request()->get('id')], 'Successfully merged the theme.');
		}
		else if ($this->request()->get('rebuild')) {
			$Theme->rebuild();

			$this->url()->send('admincp.theme.manage', ['id' => $this->request()->get('id')], 'Successfully merged the theme.');
		}

		$Service = new Core\Theme\Service($Theme);

		if (($design = $this->request()->get('design'))) {
			$Service->design()->set($design);

			return [
				'posted' => true
			];
		}

		$Request = $this->request();
		if ($Request->getHeader('X-File-Name')) {
			$dir = PHPFOX_DIR_FILE . 'logos/';
			if (!is_dir($dir)) {
				mkdir($dir);
			}

			$file = uniqid() . '.' . \Phpfox_File::instance()->extension($Request->getHeader('X-File-Name'));
			if (isset($_FILES['ajax_upload'])) {
				$_FILES['image'] = $_FILES['ajax_upload'];
				file_put_contents($dir . $file, file_get_contents($_FILES['image']['tmp_name']));
			}
			else {
				file_put_contents($dir . $file, file_get_contents('php://input'));
			}

			$url = str_replace(['/index.php', 'http://'], ['', '//'], \Phpfox::getParam('core.path')) . 'PF.Base/file/logos/' . $file;

			return [
				'run' => "\$('input[name=\"design[logoUrl]\"]').val(\"'{$url}'\").trigger('change');"
			];
		}


		if (($load = $this->request()->get('load'))) {
			if ($this->request()->isPost()) {
				$content = $this->request()->get('content');
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
			}

			return [
				'ace' => $data,
				'run' => "\$AceEditor.mode('{$load}'); " . (string) j('.ace_editor')->data('ace-mode', $load)->data('ace-save', $this->url()->makeUrl('admincp.theme.manage', ['id' => $this->request()->get('id'), 'load' => $load]))
			];
		}
		else {
			$this->template()->assign('design', $Service->design()->get());
		}

		$this->template()->setTitle('Theme Manager');
		$this->template()->setTemplate('blank');
		$this->template()->setHeader([
			'colorpicker.css' => 'style_css',
			'colorpicker/js/colpick.js' => 'static_script'
		]);
		$this->template()->assign([
			'theme' => $Theme,
			'flavors' => $Theme->flavors()
		]);
	}
}