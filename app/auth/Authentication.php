<?php

require_once __DIR__ . "/Authorization.php";

class Authentication
{
	public function check(): bool
	{
		$sessionAuthName = "tp_zakville.users";
		return isset($_SESSION[$sessionAuthName]);
	}

	public function attempt(): bool
	{
		return false;
	}

	public function userAccess(): AuthorizationAccess
	{
		return AuthorizationAccess::User;
	}
}
