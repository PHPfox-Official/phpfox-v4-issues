<?php

namespace Core;

class Phrase {
	public static function get() {
		$args = func_get_args();
		$phrase = $args[0];
		unset($args[0]);

		// $key = substr(preg_replace('/[^a-z0-9]+/', '_', strtolower($phrase)), 0, 250);
		if (preg_match('/^([a-z]+)\.([a-zA-Z0-9_]+)$/', $phrase)) {
			return \Phpfox::getPhrase($phrase);
		}

		if (isset($args[1]) && count($args[1])) {
			foreach ($args[1] as $key => $value) {
				$phrase = str_replace('{{ ' . $key . ' }}', $value, $phrase);
			}
		}

		return $phrase;
	}
}