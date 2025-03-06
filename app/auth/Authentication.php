<?php

require_once __DIR__ . "/../entities/User.php";
require_once __DIR__ . "/../tables/Users.php";
require_once __DIR__ . "/AuthorizationAccess.php";

class Authentication
{
	/**
	 * Nom de la session utilisateur.
	 */
	private string $sessionName = "tp_zakville.user";

	/**
	 * Vérifie qu'un utilisateur est connect ou non.
	 */
	public function check(): bool
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		return isset($_SESSION[$this->sessionName]);
	}

	/**
	 * Tentative de connexion à partir du pseudo et du mot de passe.
	 *
	 * Cette fonction inclue des choses que l'on n'a pas vu :
	 *
	 * - https://www.php.net/manual/en/function.password-verify.php
	 */
	public function attempt(string $username, string $password): User|bool
	{
		$usersTable = new Users();
		$user = $usersTable->findByUsername($username);
		if ($user && password_verify($password, $user->getPassword())) {
			return $user;
		}
		return false;
	}

	/**
	 * Autorisation d'accès basé sur le rôle de l'utilisateur. Par défaut
	 * l'autorisation est anonyme.
	 *
	 *  Cette fonction inclue des choses que l'on n'a pas vu :
	 *
	 * - https://www.php.net/manual/en/language.enumerations.php
	 */
	public function userAccess(): AuthorizationAccess
	{
		if ($this->check()) {
			switch ($_SESSION[$this->sessionName]->getRole()) {
				case "Admin": return AuthorizationAccess::Admin;
				case "User":  return AuthorizationAccess::User;
			}
		}

		return AuthorizationAccess::Anonymous;
	}
}
