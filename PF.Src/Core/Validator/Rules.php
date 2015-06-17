<?php

namespace Core\Validator;

/**
 * Class Rules
 * @package SocialCore\Extend\Validator
 *
 * @method \Core\Validator\Rules required()
 * @method \Core\Validator\Rules numeric()
 * @method \Core\Validator\Rules alphaNumeric()
 * @method \Core\Validator\Rules alpha()
 * @method \Core\Validator\Rules email()
 * @method \Core\Validator\Rules min($length)
 * @method \Core\Validator\Rules max($length)
 */
class Rules {
	private static $_cache = [];
	private static $_rules = [];
	private $_validator;
	private $_name = '';
	private $_map = [
		'email' => 'valid_email',
		'min' => 'min_len,%s',
		'max' => 'max_len,%s',
		'alphaNumeric' => 'alpha_numeric',
		'alpha' => 'alpha'
	];

	public function __construct($name, \Core\Validator $Validator) {
		$this->_name = $name;
		$this->_validator = $Validator;
	}

	public function contains(array $keys) {
		self::$_rules[] = 'contains,' . implode(' ', $keys);

		return $this;
	}

	public function rule($name) {
		return new self($name, $this->_validator);
	}

	public function make() {
		return $this->_validator->make();
	}

	public static function get() {
		$rules = [];
		foreach (self::$_rules as $key => $rule) {
			$rules[$key] = implode('|', $rule);
		}

		return $rules;
	}

	public function __call($method, $args) {
		if (isset($this->_map[$method])) {
			$method = $this->_map[$method];
		}

		self::$_rules[$this->_name][] = vsprintf($method, $args);

		return $this;
	}
}