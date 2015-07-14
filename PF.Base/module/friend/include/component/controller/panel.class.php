<?php

class Friend_Component_Controller_Panel extends Phpfox_Component {
	public function process() {
		Phpfox::isUser(true);

		list($iCnt, $aFriends) = Friend_Service_Request_Request::instance()->get(0, 100);
		$this->template()->assign([
			'aFriends' => $aFriends
		]);
	}
}