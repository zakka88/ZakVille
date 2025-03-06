<?php

require_once __DIR__ . "/AuthorizationAccess.php";

class Authorization
{
	/**
	 * Est-ce que l'autorisation d'accès passé en paramètre a un accès
	 * d'autorisation anonyme ?
	 *
	 * Cette fonction inclue des choses que l'on n'a pas vu :
	 *
	 * - https://www.php.net/manual/en/language.enumerations.php
	 */
	public function isAnonymous(AuthorizationAccess $access): bool
	{
		return $access->value >= AuthorizationAccess::Anonymous->value &&
			   $access->value <  AuthorizationAccess::User->value;
	}

	/**
	 * Est-ce que l'autorisation d'accès passé en paramètre a un accès
	 * d'autorisation d'utilisateur ?
	 *
	 * Cette fonction inclue des choses que l'on n'a pas vu :
	 *
	 * - https://www.php.net/manual/en/language.enumerations.php
	 */
	public function isUser(AuthorizationAccess $access): bool
	{
		return $access->value >= AuthorizationAccess::User->value &&
			   $access->value <  AuthorizationAccess::Admin->value;
	}

	/**
	 * Est-ce que l'autorisation d'accès passé en paramètre a un accès
	 * d'autorisation d'admin ?
	 *
	 * Cette fonction inclue des choses que l'on n'a pas vu :
	 *
	 * - https://www.php.net/manual/en/language.enumerations.php
	 */
	public function isAdmin(AuthorizationAccess $access): bool
	{
		return $access->value >= AuthorizationAccess::Admin->value;
	}
}
