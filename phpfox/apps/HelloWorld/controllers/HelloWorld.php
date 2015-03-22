<?php

namespace Apps\HelloWorld\Controllers;

class HelloWorld extends \Core\Controller {
	public function sample($type) {

		return $this->render('sample.html', [
			'foo' => 'bar'
		]);
	}
}