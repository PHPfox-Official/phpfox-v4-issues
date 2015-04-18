<?php

namespace Core;

class Phrase {
	public static function get() {
		$args = func_get_args();
		$phrase = $args[0];
		unset($args[0]);

		$key = substr(preg_replace('/[^a-z0-9]+/', '_', strtolower($phrase)), 0, 250);

		return $phrase;
	}
}