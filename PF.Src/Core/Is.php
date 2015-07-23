<?php

namespace Core;

use Phpfox;

class Is {
	public static function user() {
		return Phpfox::isUser();
	}

	public static function module($module) {
		return Phpfox::isModule($module);
	}

	public static function app($app) {
		try {
			(new App())->get($app);

			return true;
		} catch (\Exception $e) {
			return false;
		}
	}

	public static function param($param) {
		return Phpfox::getParam($param);
	}
}