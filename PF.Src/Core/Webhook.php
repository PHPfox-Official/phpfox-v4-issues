<?php

namespace Core;

class Webhook {
	public $response;

	public function __construct($hook, $url) {
		$webhook = new \Core\HTTP($url);

		Event::trigger('webhook', $webhook);

		$this->response = $webhook->using((new \Core\Request())->all())
			->header('WEBHOOK', $hook)
			->call($_SERVER['REQUEST_METHOD']);

	}
}