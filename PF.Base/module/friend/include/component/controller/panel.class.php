<?php

class Friend_Component_Controller_Panel extends Phpfox_Component {
	public function process() {
		Phpfox::isUser(true);

		list($iCnt, $aFriends) = Phpfox::getService('friend.request')->get();
		$this->template()->assign([
			'aFriends' => $aFriends
		]);
	}
}