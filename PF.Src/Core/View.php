<?php

namespace Core;

class View {

	public static $template = 'layout';

	private $_loader;
	private $_env;
	private $_render = [];

	public function __construct() {
		$Template = \Phpfox_Template::instance();

		$this->_loader = new View\Loader();

		$dir = $Template->theme()->get()->getPath() . 'html';
		if (is_dir($dir)) {
			$this->_loader->addPath($dir, 'Theme');
		}
		$this->_loader->addPath(PHPFOX_DIR . 'theme/default/html', 'Theme');

		$this->_loader->addPath(PHPFOX_DIR . 'views', 'Base');

		$this->_env = new View\Environment($this->_loader, array(
			'cache' => (((defined('PHPFOX_IS_TECHIE') && PHPFOX_IS_TECHIE) || defined('PHPFOX_NO_TEMPLATE_CACHE')) ? false : PHPFOX_DIR_FILE . 'cache/twig/'),
			'autoescape' => false
		));

		$this->_env->setBaseTemplateClass('Core\View\Base');

		$this->_env->addFunction(new \Twig_SimpleFunction('url', function($url, $params = []) {
			return \Phpfox_Url::instance()->makeUrl($url, $params);
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('is_user',function(){
			return \Phpfox::isUser();
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('is_admin',function(){
			return \Phpfox::isAdmin();
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('setting', function() {
			return call_user_func_array('setting', func_get_args());
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('user', function() {
			return call_user_func_array('user', func_get_args());
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('phrase', function() {
			return call_user_func_array('phrase', func_get_args());
		}));


		$this->_env->addFunction(new \Twig_SimpleFunction('comments', function() {

			\Phpfox::getBlock('feed.comment');

			return '';
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('payment', function($params) {
			$params = new \Core\Object($params);

			\Phpfox::getBlock('api.gateway.form', ['gateway_data' => [
				'item_number' => '@App/' . $params->callback . '|' . $params->id,
				'currency_code' => 'USD',
				'amount' => $params->amount,
				'item_name' => $params->name,
				'return' => $params->return,
				'recurring' => '',
				'recurring_cost' => '',
				'alternative_cost' => '',
				'alternative_recurring_cost' => ''
			]]);

			return '';
		}));

		$this->_env->addFunction(new \Twig_SimpleFunction('pager', function() {
			$u = \Phpfox_Url::instance();
			if (!isset($_GET['page'])) {
				$_GET['page'] = 1;
			}
			$_GET['page']++;
			$u->setParam('page', $_GET['page']);
			$url = $u->current();

			$html = '
				<div class="js_pager_view_more_link">
					<a href="' . $url . '" class="next_page">
						<i class="fa fa-spin fa-circle-o-notch"></i>
						<span>View More</span>
					</a>
				</div>
			';

			return $html;
		}));



		$this->_env->addFunction(new \Twig_SimpleFunction('_p', function() {
			return call_user_func_array('_p', func_get_args());
		}));
	}

	public function env() {
		return $this->_env;
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

			$this->_render['name'] = '@Base/' . self::$template . '.html';
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
		$params['sticky_bar'] = new View\Functions('sticky_bar');
		$params['menu_sub'] = new View\Functions('menu_sub');
		$params['breadcrumb_menu'] = new View\Functions('breadcrumb_menu');

		$params['site_logo'] =  \Phpfox::getParam('core.site_title');


		$params['menu'] = new View\Functions('menu');
		$params['share'] = new View\Functions('share');
		$params['notify'] = new View\Functions('notify');
		$params['search'] = new View\Functions('search');

		$params['footer'] = new View\Functions('footer');
		$params['errors'] = new View\Functions('errors');
		$params['top'] = new View\Functions('top');
		$params['location_1'] = new View\Functions('location_1');
		$params['location_2'] = new View\Functions('location_2');
		$params['location_3'] = new View\Functions('location_3');
		$params['location_4'] = new View\Functions('location_4');
		$params['location_5'] = new View\Functions('location_5');
		$params['location_6'] = new View\Functions('location_6');
		$params['location_7'] = new View\Functions('location_7');
		$params['location_8'] = new View\Functions('location_8');
		$params['location_9'] = new View\Functions('location_9');
		$params['location_10'] = new View\Functions('location_10');
		$params['location_11'] = new View\Functions('location_11');
		$params['location_12'] = new View\Functions('location_12');
		$params['main_top'] = new View\Functions('main_top');
		$params['left'] = new View\Functions('left');
		$params['right'] = new View\Functions('right');
		$params['h1'] = new View\Functions('h1');
		$params['breadcrumb'] = new View\Functions('breadcrumb');
		$params['notification'] = new View\Functions('notification');
		$params['logo'] = new View\Functions('logo');
		$params['body'] = 'id="page_' . \Phpfox_Module::instance()->getPageId() . '" class="' . \Phpfox_Module::instance()->getPageClass() . '"';

		// d($params['active']); exit;

		$locale = \Phpfox_Locale::instance()->getLang();
		$params['html'] = 'xmlns="http://www.w3.org/1999/xhtml" dir="' . $locale['direction'] . '" lang="' . $locale['language_code'] . '"';

		// return $this->_env->render($this->_render['name'], $params);
		return $this->_env->render('@Theme/' . self::$template . '.html', $params);
	}
}