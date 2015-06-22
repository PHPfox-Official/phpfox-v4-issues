<?php

namespace Core\Route;

class Group {
	public function __construct($name, \Closure $callback) {

		\Core\Route::$group = $name;

		call_user_func($callback, new \Core\Controller());

		\Core\Route::$group = null;
	}
}