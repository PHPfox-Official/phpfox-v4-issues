<?php

namespace Core\App;

use Core\Url;
use Core\View;

class Map {
	public $title;
	public $link;
	public $content = '';

	public function __construct(Object $app, $objects, $map, $feed) {
		foreach ($map as $key => $value) {
			if (substr($value, 0, 6) == '@view/') {
				$View = new View();
				$View->loader()->addPath($app->path . 'views', $app->id);
				$this->$key = $View->env()->render('@' . $app->id . '/' . str_replace('@view/', '', $value), array_merge((array) $objects, $feed));

				continue;
			}

			if ($key == 'link') {
				$value = str_replace([':id'], [$feed['feed_id']], $value);
				$this->$key = (new Url())->make($value);
				continue;
			}

			if (isset($objects->$value)) {
				$this->$key = $objects->$value;
			}
		}
	}
}