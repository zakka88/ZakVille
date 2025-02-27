<?php

require_once __DIR__ . "/../entities/User.php";
require_once __DIR__ . "/Authorization.php";

class Authentication
{
	private string $sessionName = "tp_zakville.user";
	public function check(): bool
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		return isset($_SESSION[$this->sessionName]);
	}

	public function attempt(): bool
	{
		return false;
	}

	public function userAccess(): AuthorizationAccess
	{
		if ($this->check()) {
			switch ($_SESSION[$this->sessionName]->getRole()) {
				case "Admin":
					return AuthorizationAccess::Admin;
				case "User":
					return AuthorizationAccess::User;
			}
		}

		return AuthorizationAccess::Anonymous;
	}
}
