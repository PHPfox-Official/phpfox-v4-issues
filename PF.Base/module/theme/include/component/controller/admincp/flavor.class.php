<?php

class Theme_Component_Controller_Admincp_Flavor extends Phpfox_Component {
	public function process() {
		$Theme = (new Core\Theme())->get($this->request()->get('theme'));
		$Service = new Core\Theme\Service($Theme);
		if ($this->request()->isPost()) {
			$val = $this->request()->getArray('val');

			return $Service->flavor()->make($val);
		}

		$this->template()->setBreadcrumb('New Flavor', $this->url()->makeUrl('current'), true);
		$this->template()->assign([
			'Theme' => $Theme,
			'flavors' => $Theme->flavors()
		]);
	}
}