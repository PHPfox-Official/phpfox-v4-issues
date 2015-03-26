<?php

namespace Core\Theme;

class Service {
	private $_theme;

	public function __construct(\Core\Theme\Object $Theme) {
		$this->_theme = $Theme;
	}

	public function html() {
		return new HTML($this->_theme);
	}

	public function css() {
		return new CSS($this->_theme);
	}

	public function js() {
		return new JS($this->_theme);
	}

	public function design() {
		return new Design($this->_theme);
	}

	public function flavor() {
		return new Flavor($this->_theme);
	}
}