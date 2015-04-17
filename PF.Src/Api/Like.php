<?php

namespace Api;

class Like extends \Core\Api {
	public function post($appId, $itemId) {
		return \Like_Service_Process::instance()->add($appId, $itemId);
	}
}