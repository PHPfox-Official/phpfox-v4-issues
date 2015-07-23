<?php

namespace Core\Payment;

class Event {
	public function __construct($name, $callback) {
		Trigger::$events[$name] = $callback;
	}
}