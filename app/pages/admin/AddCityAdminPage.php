<?php

require_once __DIR__ . "/../../tables/Users.php";
require_once __DIR__ . "/../../usecases/AuthUseCase.php";
require_once __DIR__ . "/../../usecases/CityCreateUseCase.php";

class AddCityAdminPage
{
	// --------- //
	// Propriété //
	// --------- //

	private AuthUseCase       $authUseCase;
	private CityCreateUseCase $cityCreateUseCase;

	private Users $usersTable;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("../../error404.php");
		$this->authUseCase->adminOnly();

		$this->cityCreateUseCase = new CityCreateUseCase();

		$this->usersTable = new Users();
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function save(): void
	{
		$this->cityCreateUseCase->store($_POST);
	}

	public function handle(): AddCityAdminView
	{
		$users = $this->usersTable->findAllWithoutCities();
		return new AddCityAdminView(users: $users);
	}
}

/**
 * @property array<int,User> $users Utilisateurs
 */
class AddCityAdminView
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
	public function __construct(public array $users) {}
}
