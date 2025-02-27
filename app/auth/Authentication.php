<?php

require_once __DIR__ . "/../entities/User.php";
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
	 */
	public function attempt(string $username, string $password): bool
	{
		return false;
	}

	/**
	 * Autorisation d'accès basé sur le rôle de l'utilisateur. Par défaut
	 * l'autorisation est anonyme.
	 */
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
