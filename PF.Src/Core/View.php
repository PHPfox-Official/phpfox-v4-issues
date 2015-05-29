<?php

namespace Core;

class View {

	public static $template = 'layout';

	private $_loader;
	private $_env;
	private $_render = [];

	public function __construct() {
		$this->_loader = new View\Loader();
		$this->_loader->addPath(PHPFOX_DIR . 'theme/default/html', 'Theme');
		$this->_loader->addPath(PHPFOX_DIR . 'views', 'Base');

		$this->_env = new \Twig_Environment($this->_loader, array(
			'cache' => false,
			'autoescape' => false
		));

		$this->_env->setBaseTemplateClass('Core\View\Base');

		$this->_env->addFunction(new \Twig_SimpleFunction('url', function($url, $params = []) {
			return \Phpfox_Url::instance()->makeUrl($url, $params);
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('phrase', function() {
			return call_user_func_array('phrase', func_get_args());
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('comments', function() {

			\Phpfox::getBlock('feed.comment');

			return '';
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('_p', function() {
			return call_user_func_array('_p', func_get_args());
		}));
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
			/*
			if (PHPFOX_IS_AJAX_PAGE) {
				\Phpfox_Module::instance()->getControllerTemplate();
				$content = ob_get_contents(); ob_clean();
				$content = (string) new View\Functions('content', $content);
				return $content;
			}
			else {
				\Phpfox_Module::instance()->getControllerTemplate();
				$content = ob_get_contents(); ob_clean();

				$this->_render['name'] = '@Base/Layout.html';
				$this->_render['params']['content'] = $content;
			}
			*/
			\Phpfox_Module::instance()->getControllerTemplate();
			$content = ob_get_contents(); ob_clean();

			$this->_render['name'] = '@Base/Layout.html';
			$this->_render['params']['content'] = $content;
		}

		$params = $this->_render['params'];
		$params['content'] = $this->_env->render($this->_render['name'], $params);
		if (PHPFOX_IS_AJAX_PAGE) {
			$content = (string) new View\Functions('content', $params['content']);

			return $content;
		}

		// $params['content'] = '<div class="_block_content">' . $params['content'] . '</div>';
		$params['content'] = new View\Functions('content', $params['content']);
		$params['header'] = $Template->getHeader();
		$params['title'] = $Template->getTitle();
		$params['js'] = $Template->getFooter();
		$params['nav'] = new View\Functions('nav');
		$params['footer'] = new View\Functions('footer');
		$params['top'] = new View\Functions('top');
		$params['left'] = new View\Functions('left');
		$params['right'] = new View\Functions('right');
		$params['h1'] = new View\Functions('h1');
		$params['breadcrumb'] = new View\Functions('breadcrumb');
		$params['notification'] = new View\Functions('notification');
		$params['logo'] = new View\Functions('logo');
		$params['body'] = 'id="page_' . \Phpfox_Module::instance()->getPageId() . '" class="' . \Phpfox_Module::instance()->getPageClass() . '"';

		$locale = \Phpfox_Locale::instance()->getLang();
		$params['html'] = 'xmlns="http://www.w3.org/1999/xhtml" dir="' . $locale['direction'] . '" lang="' . $locale['language_code'] . '"';

		// return $this->_env->render($this->_render['name'], $params);
		return $this->_env->render('@Theme/layout.html', $params);
	}
}