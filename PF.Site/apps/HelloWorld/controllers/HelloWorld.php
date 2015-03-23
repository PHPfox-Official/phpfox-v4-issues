<?php

namespace Apps\HelloWorld\Controllers;

class HelloWorld extends \Core\Controller {
	public function sample($type) {

		return $this->render('sample.html', [
			'foo' => 'bar'
		]);
	}

	public function arrayRoute() {
		if ($this->request->isPost()) {
			throw Error('Failed...');
		}

		return $this->render('array.html');
	}
}