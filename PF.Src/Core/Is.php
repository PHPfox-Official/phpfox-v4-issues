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

	public static function param($param) {
		return Phpfox::getParam($param);
	}
}