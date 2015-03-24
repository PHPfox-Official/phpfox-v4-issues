<?php

namespace Core\Theme;

class Object extends \Core\Objectify {
	public $theme_id;
	public $name;
	public $folder;
	public $flavor_folder;
	public $is_active;
	public $is_default;

	public function getPath() {
		return PHPFOX_DIR_SITE . 'themes/' . $this->folder . '/';
	}

	public function __toArray() {

	}
}