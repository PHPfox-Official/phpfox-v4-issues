<?php

namespace Core;

class View {
	private $_loader;
	private $_env;
	private $_render = [];

	public function __construct() {
		$this->_loader = new \Twig_Loader_Filesystem();
		$this->_loader->addPath(PHPFOX_DIR_PARENT . 'themes/default/html', 'Theme');
		$this->_loader->addPath(PHPFOX_DIR_PARENT . 'views', 'Base');

		$this->_env = new \Twig_Environment($this->_loader, array(
			'cache' => false,
			'autoescape' => false
		));
	}

	public function loader() {
		return $this->_loader;
	}

	public function render($name, array $params = []) {
		$this->_render = [
			'name' => $name,
			'params' => $params
		];

		return $this;
	}

	public function getContent() {
		$Template = \Phpfox_Template::instance();
		if (!$this->_render) {
			$this->_render = [
				'name' => '@Base/layout.html',
				'params' => [
					'content' => new View\Functions('content'),
					'left' => new View\Functions('left'),
					'right' => new View\Functions('right'),
					'top' => new View\Functions('top')
				]
			];
		}

		$params = $this->_render['params'];
		$params['header'] = $Template->getHeader();
		$params['js'] = $Template->getFooter();
		$params['nav'] = new View\Functions('nav');
		$params['notification'] = new View\Functions('notification');

		return $this->_env->render($this->_render['name'], $params);
	}
}