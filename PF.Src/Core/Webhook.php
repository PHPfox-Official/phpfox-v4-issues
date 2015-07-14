<?php

namespace Core;

class Webhook {
	public function __construct($hook, $url) {
		$webhook = new \Core\HTTP($url);

		Event::trigger('webhook', $webhook);

		$webhook->using((new \Core\Request())->all())
			->header('WEBHOOK', $hook)
			->call($_SERVER['REQUEST_METHOD']);

	}
}