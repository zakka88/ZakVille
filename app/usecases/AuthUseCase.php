<?php

require_once __DIR__ . "/../auth/Authentication.php";
require_once __DIR__ . "/../auth/Authorization.php";

class AuthUseCase
{
	// --------- //
	// Propriété //
	// --------- //

	private Authentication $authentication;
	private Authorization $authorization;
	private string $redirectTo = "login.php";

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->authentication = new Authentication();
		$this->authorization = new Authorization();
	}

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function isConnected(): bool
	{
		return $this->authentication->check();
	}

	public function setRedirectTo(string $redirectTo): void
	{
		$this->redirectTo = $redirectTo;
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	/**
	 * Page accessible uniquement pour les utilisateurs anonymes. (non connectés)
	 */
	public function anonymousOnly(): void
	{
		if ($this->authentication->check()) {
			header("Location: {$this->redirectTo}");
			exit();
		}
	}

	/**
	 * Page accessible uniquement pour les utilisateurs connectés.
	 */
	public function connectedOnly(): void
	{
		if (!$this->authentication->check()) {
			header("Location: {$this->redirectTo}");
			exit();
		}
	}

	/**
	 * Page accessible uniquement pour les administrateurs.
	 */
	public function adminOnly(): void
	{
		if (
			!(
				$this->authentication->check() &&
				$this->authorization->isAdmin($this->authentication->userAccess())
			)
		) {
			header("Location: {$this->redirectTo}");
			exit();
		}
	}
}
