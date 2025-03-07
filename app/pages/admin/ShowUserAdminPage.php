<?php

require_once __DIR__ . "/../../tables/Users.php";
require_once __DIR__ . "/../../usecases/AuthUseCase.php";

class ShowUserAdminPage
{
	// --------- //
	// Propriété //
	// --------- //

	private AuthUseCase $authUseCase;

	private Users $usersTable;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct(private int $userId)
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("../../error404.php");
		$this->authUseCase->adminOnly();

		$this->usersTable = new Users();
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function data(): ShowUserAdminView
	{
		$fields = $this->usersTable->getFields();
		$user = $this->usersTable->findById($this->userId);
		return new ShowUserAdminView(fields: $fields, user: $user);
	}
}

/**
 * @property array<int,string> $fields Les champs de la table
 * @property ?User $user Utilisateur
 */
class ShowUserAdminView
{
	/**
	 * La syntaxe qui suit est une syntaxe alternative et plus rapide de
	 *
	 * ```php
	 * public type $prop;
	 *
	 * public function __construct(type $prop) {
	 * 		$this->prop = $prop;
	 * }
	 * ```
	 */
	public function __construct(
		public array $fields,
		public ?User $user
	) {}
}
