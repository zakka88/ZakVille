<?php

enum AuthorizationAccess: int
{
	case Anonymous = 0;
	case User = 10;
	case Admin = 1000;
};

class Authorization
{
	public function isAnonymous(AuthorizationAccess $access): bool
	{
		return $access->value >= AuthorizationAccess::Anonymous->value &&
			   $access->value < AuthorizationAccess::User->value;
	}

	public function isUser(AuthorizationAccess $access): bool
	{
		return $access->value >= AuthorizationAccess::User->value &&
			   $access->value < AuthorizationAccess::Admin->value;
	}

	public function isAdmin(AuthorizationAccess $access): bool
	{
		return $access->value >= AuthorizationAccess::Admin->value;
	}
}
