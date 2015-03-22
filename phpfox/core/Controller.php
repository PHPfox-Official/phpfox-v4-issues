<?php

namespace Core;

class Controller {
	public $request;
	public $url;

	private $_view;

	public function __construct($path) {
		$this->request = new Request();
		$this->_view = new View();
		$this->_view->loader()->addPath($path);
	}

	/*
	public function view() {
		return $this->_view;
	}
	*/

	public function render($name, array $params = []) {
		return $this->_view->render($name, $params);
	}
}