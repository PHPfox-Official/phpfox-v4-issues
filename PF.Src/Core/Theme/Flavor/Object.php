<?php

namespace Core\Theme\Flavor;

class Object extends \Core\Objectify {
	public $style_id;
	public $name;
	public $folder;
	public $is_selected = false;

	private $_theme;
	private $_db;

	public function __construct(\Core\Theme\Object $Theme, $keys) {
		parent::__construct($keys);
		$this->_theme = $Theme;
		$this->_db = new \Core\Db();
	}

	public function delete() {
		$file = $this->_theme->getPath() . 'flavor/';
		@unlink($file . $this->folder . '.less');
		@unlink($file . $this->folder . '.css');
		$this->_db->delete(':theme_style', ['style_id' => $this->style_id]);
	}

	public function __toArray() {

	}
}