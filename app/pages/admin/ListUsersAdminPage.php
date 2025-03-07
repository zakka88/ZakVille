<?php

require_once __DIR__ . "/../../tables/Users.php";
require_once __DIR__ . "/../../usecases/AuthUseCase.php";

class ListUsersAdminPage
{
	// --------- //
	// Propriété //
	// --------- //

	private AuthUseCase $authUseCase;

	private Users $usersTable;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("../../error404.php");
		$this->authUseCase->adminOnly();

		$this->usersTable = new Users();
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function data(): ListUsersAdminView
	{
		$fields = $this->usersTable->getFields();
		$users = $this->usersTable->findAll();
		return new ListUsersAdminView(fields: $fields, users: $users);
	}
}

/**
 * @property array<int,string> $fields Les champs de la table
 * @property array<int,User> $users Utilisateurs
 */
class ListUsersAdminView
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
		public array $users
	) {}
}
