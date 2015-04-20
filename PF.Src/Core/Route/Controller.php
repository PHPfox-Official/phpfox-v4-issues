<?php

namespace Core\Route;

class Controller {
	public static $active;

	private $_request;

	public function __construct() {
		$this->_request = new \Core\Request();

		$Apps = new \Core\App();
		foreach ($Apps->all() as $App) {
			self::$active = $App->path;

			$vendor = $App->path . 'vendor/autoload.php';
			if (file_exists($vendor)) {
				require($vendor);
			}

			if (file_exists($App->path . 'start.php')) {
				require($App->path . 'start.php');
			}
		}
	}

	public function get() {
		if ($this->_request->segment(1) == 'api') {
			$api = 'Api\\' . $this->_request->segment(2);
			if (class_exists($api)) {
				try {
					$Reflect = (new \ReflectionClass($api))->newInstance();
					if (!method_exists($Reflect, $this->_request->method())) {
						throw error('Method not found.');
					}
					$data = call_user_func([$Reflect, $this->_request->method()]);
				} catch (\Exception $e) {
					$data = [
						'error' => $e->getMessage()
					];
				}

				header('Content-type: application/json');
				echo json_encode($data);
				exit;
			}
		}

		$content = false;
		$routes = \Core\Route::$routes;
		$uri = trim($this->_request->uri(), '/');
		$uriParts = explode('/', $uri);

		// d($uriParts);
		foreach ($routes as $key => $route) {
			$key = trim($key, '/');

			if (strpos($key, ':')) {
				$parts = explode('/', $key);
				if (count($uriParts) === count($parts)) {
					foreach ($parts as $partKey => $arg) {

						if (substr($arg, 0, 1) == ':') {

							$args = [];
							$iteration = 0;
							foreach ($parts as $_arg) {
								if (empty($_arg)) {
									continue;
								}

								$iteration++;
								if (substr($_arg, 0, 1) == ':') {
									$segment = $this->_request->segment($iteration);
									if (isset($route['where']) && isset($route['where'][$_arg])) {
										if (!preg_match('/' . $route['where'][$_arg] . '/i', $segment)) {
											return false;
										}
									}

									$args[$_arg] = $segment;
								}
							}

							$route['args'] = $args;
							$routes[$uri] = $route;

							break 2;
						}

						if ($arg != $uriParts[$partKey]) {
							break;
						}
					}
				}
			}
		}

		if ($this->_request->segment(1) == 'admincp') {
			// \Phpfox::getComponent('admincp.index', ['bNoTemplate' => true, 'isRoute' => true], 'controller');
		}

		if (isset($routes[$uri])) {
			$r = $routes[$uri];

			try {
				if (isset($r['auth'])) {
					\Phpfox::isUser(true);
				}

				if (isset($r['accept'])) {
					if (!is_array($r['accept'])) {
						$r['accept'] = [$r['accept']];
					}

					if (!in_array($this->_request->method(), $r['accept'])) {
						throw error('Method not support.');
					}
				}

				if (isset($routes[$uri]['run'])) {
					$Controller = new \Core\Controller($routes[$uri]['path'] . 'views');

					$content = call_user_func($routes[$uri]['run'], $Controller);
				}
				else if (isset($r['call'])) {
					$parts = explode('@', $r['call']);

					$Reflection = new \ReflectionClass($parts[0]);
					$Controller = $Reflection->newInstance((isset($routes[$uri]['path']) ? $routes[$uri]['path'] . 'views' : null));

					$content = call_user_func_array([$Controller, $parts[1]], (isset($r['args']) ? $r['args'] : []));
				}
				else if (isset($r['url'])) {
					$response = (new \Core\HTTP($r['url']))
						->auth('foo', 'bar')
						->call($this->_request->method());

					$Controller = new \Core\Controller();
					return $Controller->render('@Base/layout.html', [
						'content' => 'test...'
					]);
				}
			} catch (\Exception $e) {
				if ($this->_request->isPost()) {
					$content = ['error' => \Core\Exception::getErrors(true)];
				}
				else {
					throw new \Exception($e->getMessage(), 0, $e);
				}
			}

			if (isset($_SERVER['CONTENT_TYPE'])
				&& $_SERVER['CONTENT_TYPE'] == 'application/json'
				&& $content instanceof \Core\View
			) {
				header('Content-type: application/json');
				echo json_encode([
					'content' => $content->getContent()
				]);
				exit;
			}

			if (is_array($content)) {
				header('Content-type: application/json');
				echo json_encode($content);
				exit;
			}

			if (empty($content) || $this->_request->isPost()) {

				exit;
			}
		}

		return $content;
	}
}