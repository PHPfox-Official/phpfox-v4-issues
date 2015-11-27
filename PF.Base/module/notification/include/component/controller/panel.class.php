<?php

class Notification_Component_Controller_Panel extends Phpfox_Component {
	public function process() {
		Phpfox::isUser(true);

		$this->template()->assign([
			'aNotifications' => Notification_Service_Notification::instance()->get()
		]);
	}
}