<?php

namespace Core\Theme;

class Design extends \Core\Model {
	private $_theme;

	public function __construct(\Core\Theme\Object $Theme) {
		parent::__construct();

		$this->_theme = $Theme;
	}
}