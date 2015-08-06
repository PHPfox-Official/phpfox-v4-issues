<?php

namespace Core\Auth;

class User {
	public function isLoggedIn() {
		return (\Phpfox::isUser() ? true : false);
	}

	public function membersOnly() {
		\Phpfox::isUser(true);
	}

	public function isAdmin() {
		return \Phpfox::isAdmin();
	}
}