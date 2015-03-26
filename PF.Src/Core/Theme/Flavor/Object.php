<?php

namespace Core\Theme\Flavor;

class Object extends \Core\Objectify {
	public $style_id;
	public $name;
	public $folder;
	public $is_selected = false;

	public function __toArray() {

	}
}