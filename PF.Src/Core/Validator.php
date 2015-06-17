<?php

namespace Core;

use Gump;

class Validator {

	/**
	 * @return Validator\Rules
	 */
	public function rule($name) {
		return new Validator\Rules($name, $this);
	}

	public function make() {
		$Request = new Request();
		if (!$Request->isPost()) {
			return false;
		}

		$return = \Phpfox_Request::instance()->get('val');
		if (!$return) {
			return false;
		}

		$gump = new Gump();
		$gump->validation_rules(Validator\Rules::get());
		if (!$gump->run($return)) {
			throw Error($gump->get_errors_array());
		}

		return true;
	}
}