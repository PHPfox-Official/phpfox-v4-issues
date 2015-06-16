<?php

class Theme_Component_Controller_Admincp_Delete extends Phpfox_Component {
	public function process() {
		$Theme = (new Core\Theme())->get($this->request()->get('id'));
		if ($this->request()->get('sure')) {
			$Theme->delete();
			Phpfox::addMessage('Successfully deleted the theme.');

			$this->url()->send('admincp.theme');
		}

		$this->template()->setBreadCrumb('Are you sure?', $this->url()->makeUrl('current'), true);
		$this->template()->assign([
			'Theme' => $Theme
		]);
	}
}