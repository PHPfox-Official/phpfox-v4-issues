<?php

namespace Core;

/**
 * Class jQuery
 * @package SocialCore\Extend\Helper
 *
 * @method jQuery html($html)
 * @method jQuery prepend($html)
 * @method jQuery append($html)
 * @method jQuery find($find)
 * @method jQuery removeClass($class)
 * @method jQuery addClass($class)
 * @method jQuery remove()
 * @method jQuery parent()
 * @method jQuery show()
 * @method jQuery hide()
 * @method jQuery val($value)
 */
class jQuery {
	private $_html = '';
	private $_element;

	public function __construct($element) {
		$this->_element = $element;

		$this->_html = "$('" . $element . "')";

		return $this;
	}

	public function fillForm($elements) {
		$this->_html = '';
		foreach ($elements as $key => $value) {
			$this->_html .= "$('{$this->_element}').find('#__form_{$key}').val('{$value}');";
		}

		return $this;
	}

	public function attr($attr, $value) {
		$this->_html .= ".attr('{$attr}', '{$value}')";

		return $this;
	}

	public function data($attr, $value) {
		$this->_html .= ".data('{$attr}', '{$value}')";

		return $this;
	}

	public function __toString() {
		return $this->_html . ";";
	}

	public function __call($method, $args) {
		$params = "'" . implode('', $args) . "'";
		if (!count($args)) {
			$params = '';
		}

		if (in_array($method, ['prepend', 'html'])) {
			$params = json_encode(trim($params, "'"));
		}

		$this->_html .= "." . $method . "(" . $params . ")";

		return $this;
	}
}