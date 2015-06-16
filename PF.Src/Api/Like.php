<?php

namespace Api;

class Like extends \Core\Api {
	public function post($feedId) {
		$this->auth();

		return \Like_Service_Process::instance()->add('app', $feedId);
	}

	public function delete($feedId) {
		$this->auth();

		return \Like_Service_Process::instance()->delete('app', $feedId);
	}
}