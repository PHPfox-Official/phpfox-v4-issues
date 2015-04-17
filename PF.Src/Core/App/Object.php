<?php

namespace Core\App;

class Object extends \Core\Objectify {
	public $id;
	public $name;
	public $path;
	public $is_module = false;
	public $icon;
	public $version;
	public $currentVersion;
	public $unityId;
	public $admincpMenu;
	public $settings = [];

	public function __construct($keys) {
		parent::__construct($keys);

		$name = $this->name[0];
		// $first = $name;
		$parts = explode(' ', $this->name);
		if (isset($parts[1])) {
			$name .= trim($parts[1])[0];
		}
		else {
			$name .= $this->name[1];
		}
		$this->icon = '<b class="app_icons"><i class="app_icon _' . strtolower($name) . '">' . $name . '</i></b>';
	}

	public function __toArray() {

	}
}