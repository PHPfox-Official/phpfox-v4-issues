<?php

class Theme_Component_Controller_Admincp_Import extends Phpfox_Component {
	public function process() {
		$Theme = new Core\Theme();
		$Theme->import();

		exit('asd');
	}
}