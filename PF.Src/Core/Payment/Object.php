<?php

namespace Core\Payment;

class Object extends \Core\Objectify {
	public $gateway;
	public $ref;
	public $status;
	public $item_number;
	public $total_paid;

	public function log($log) {
		\Phpfox::log($log);
	}

	public function success() {
		return ($this->status == 'completed' ? true : false);
	}
}