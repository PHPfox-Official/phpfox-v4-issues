<?php

namespace Core\Auth;

class User {
	public function isLoggedIn() {
		return (\Phpfox::isUser() ? true : false);
	}
}