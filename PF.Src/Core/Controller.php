<?php

namespace Core;

class Controller {
	protected $request;
	protected $url;
	protected $active;

	private $_view;

	public function __construct($path = null) {
		$this->request = new Request();
		$this->url = new Url();
		$this->active = (new \Api\User())->get(\Phpfox::getUserId());

		$this->_view = new View();
		if ($path !== null && is_dir($path)) {
			$this->_view->loader()->addPath($path);
		}
	}

	public function render($name, array $params = []) {
		return $this->_view->render($name, $params);
	}
}