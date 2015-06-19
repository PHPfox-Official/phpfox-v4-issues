<?php

namespace Core\Route;

class Controller {
	public static $active;
	public static $activeId;
	public static $name;
	public static $isApi = false;

	private $_request;

	public function __construct() {
		$this->_request = new \Core\Request();
	}

	public function get() {
		if ($this->_request->segment(1) == 'api') {
			self::$isApi = true;
		}

		$content = false;
		$routes = \Core\Route::$routes;
		$uri = trim($this->_request->uri(), '/');
		$uriParts = explode('/', $uri);

		// d($routes); exit;

		// d($uriParts); exit;
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
											// return false;
											// continue;
											break 2;
										}
									}

									// $args[$_arg] = $segment;
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
			$routes[$uri] = (array) $routes[$uri];
			$r = $routes[$uri];

			$r['route'] = $uri;
			self::$name = $r;

			try {
				if (isset($r['auth']) && $r['auth'] === true) {
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

					$pass = [$Controller];
					if (isset($r['args'])) {
						$pass = array_merge($pass, $r['args']);
					}
					$content = call_user_func_array($routes[$uri]['run'], $pass);
				}
				else if (isset($r['url'])) {
					$App = (new \Core\App())->get($r['id']);

					$innerHTML = function($xml) {
						$innerXML = '';
						foreach (dom_import_simplexml($xml)->childNodes as $child) {
							if ($child->nodeName == 'api') {
								continue;
							}
							$innerXML .= $child->ownerDocument->saveXML($child);
						}
						return $innerXML;
					};

					$Template = \Phpfox_Template::instance();
					$response = (new \Core\HTTP($r['url']))
						->auth($App->auth->id, $App->auth->key)
						->header('API_ENDPOINT', \Phpfox_Url::instance()->makeUrl('api'))
						->call($_SERVER['REQUEST_METHOD']);

					$doc = new \DOMDocument();
					libxml_use_internal_errors(true);
					$doc->loadHTML($response);
					$xml = $doc->saveXML($doc);


					$xml = @simplexml_load_string($xml);
					if ($xml === false) {
						$xml = new \stdClass();
						$xml->body = $response;
					}
					else {
						if (!isset($xml->body)) {
							$xml = new \stdClass();
							$xml->body = $response;
						}
					}

					if (isset($xml->body->api)) {
						if (isset($xml->body->api->section)) {
							$Template->setBreadCrumb($xml->body->api->section->name, \Phpfox_Url::instance()->makeUrl($xml->body->api->section->url));
						}

						if (isset($xml->body->api->h1)) {
							$Template->setBreadCrumb($xml->body->api->h1->name, \Phpfox_Url::instance()->makeUrl($xml->body->api->h1->url), true);
						}

						if (isset($xml->body->api->menu)) {
							$Template->setSubMenu($innerHTML($xml->body->api->menu));
						}

						// unset($xml->body->api);
					}

					$Controller = new \Core\Controller();
					if (isset($xml->head)) {
						$Controller->title('' . $xml->head->title);

						foreach ((array) $xml->head as $type => $data) {
							switch ($type) {
								case 'style':
									$Template->setHeader('<' . $type . '>' . (string) $data . '</' . $type . '>');
									break;
							}
						}
					}

					$content = $Controller->render('@Base/blank.html', [
						'content' => (is_string($xml->body) ? $xml->body : $innerHTML($xml->body))
					]);
				}
				else if (isset($r['call'])) {
					$parts = explode('@', $r['call']);
					if (!isset($parts[1])) {
						$parts[1] = $this->_request->method();
					}

					$Reflection = new \ReflectionClass($parts[0]);
					$Controller = $Reflection->newInstance((isset($routes[$uri]['path']) ? $routes[$uri]['path'] . 'views' : null));

					$args = (isset($r['args']) ? $r['args'] : []);

					try {
						$content = call_user_func_array([$Controller, $parts[1]], $args);
					} catch (\Exception $e) {
						if (self::$isApi) {
							http_response_code(400);
							$content = [
								'error' => [
									'message' => $e->getMessage()
								]
							];
						}
						else {
							throw new \Exception($e->getMessage(), $e->getCode(), $e);
						}
					}
				}
			} catch (\Exception $e) {
				if ($this->_request->isPost()) {
					$errors = \Core\Exception::getErrors(true);
					if (!$errors) {
						$errors = '<div class="error_message">' . $e->getMessage() . '</div>';
					}
					$content = ['error' => $errors];
				}
				else {
					throw new \Exception($e->getMessage(), $e->getCode(), $e);
				}
			}

			if (is_array($content) || self::$isApi) {
				header('Content-type: application/json');
				echo json_encode($content, JSON_PRETTY_PRINT);
				exit;
			}

			if (empty($content) || $this->_request->isPost()) {
				if (is_object($content) && $content instanceof \Core\jQuery) {
					header('Content-type: application/json');
					echo json_encode([
						'run' => (string) $content
					]);
				}

				exit;
			}
		}

		return $content;
	}
}