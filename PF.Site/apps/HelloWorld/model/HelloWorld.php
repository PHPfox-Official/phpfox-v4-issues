<?php

namespace Apps\HelloWorld\Model;

class HelloWorld extends \Core\Model {
	public function test() {


		d($this->active->user_id);
		exit;
	}
}