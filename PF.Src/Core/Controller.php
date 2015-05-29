<?php

namespace Core;

class Controller {
	public $request;
	public $url;
	public $active;

	private $_view;
	private $_template;

	public function __construct($path = null) {
		$this->request = new Request();
		$this->url = new Url();
		$this->active = (new \Api\User())->get(\Phpfox::getUserId());

		$this->_template = \Phpfox_Template::instance();
		$this->_view = new View();
		if ($path !== null && is_dir($path)) {
			$this->_view->loader()->addPath($path);
		}
	}

	public function h1($name, $url) {
		$this->_template->setBreadcrumb($name, $this->url->make($url), true);

		return $this;
	}

	public function section($name, $url) {
		$this->_template->setBreadcrumb($name, $this->url->make($url));

		return $this;
	}

	public function asset($asset) {
		new Asset($asset);

		return $this;
	}

	public function title($title) {
		$this->_template->setTitle($title);

		return $this;
	}

	public function render($name, array $params = []) {
		return $this->_view->render($name, $params);
	}
}