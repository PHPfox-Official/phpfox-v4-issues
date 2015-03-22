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

			require($App->path . 'start.php');
		}
	}

	public function get() {
		$content = false;
		$routes = \Core\Route::$routes;
		$uri = $this->_request->uri();
		$uriParts = explode('/', $uri);

		// d($uriParts);
		foreach ($routes as $key => $route) {
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

		if (isset($routes[$uri])) {
			$r = $routes[$uri];

			try {
				if (isset($r['auth'])) {
					\Phpfox::isUser(true);
				}

				if (isset($routes[$uri]['run'])) {
					$Controller = new \Core\Controller($routes[$uri]['path'] . 'views');

					$content = call_user_func($routes[$uri]['run'], $Controller);
				}
				else if (isset($r['call'])) {
					$parts = explode('@', $r['call']);

					$Reflection = new \ReflectionClass($parts[0]);
					$Controller = $Reflection->newInstance($routes[$uri]['path'] . 'views');
					$content = call_user_func_array([$Controller, $parts[1]], (isset($r['args']) ? $r['args'] : []));
				}
			} catch (\Exception $e) {
				if ($this->_request->isPost()) {
					$content = ['error' => \Core\Exception::getErrors(true)];
				}
				//echo $e->getMessage();
				// exit;
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