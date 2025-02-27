<?php

require_once __DIR__ . "/../../tables/Users.php";
require_once __DIR__ . "/../../usecases/AuthUseCase.php";
require_once __DIR__ . "/../../usecases/CityCreateUseCase.php";

class AddCityAdminPage
{
	// --------- //
	// Propriété //
	// --------- //

	private AuthUseCase $authUseCase;
	private CityCreateUseCase $cityCreateUseCase;
	private Users $usersTable;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();

		$this->authUseCase->setRedirectTo("../../error404.php");

		/* Exemple */
		/*
		session_start();

		require_once __DIR__ . "/../../entities/User.php";

		$user = new User(
			username: "Mike",
			password: password_hash("12345678", PASSWORD_DEFAULT),
			firstname: "Mike",
			date_of_birth: new DateTime(),
			role: "Admin",
			cityId: 10,
		);

		$_SESSION["tp_zakville.user"] = $user;
		*/

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
	public function __construct(public array $users) {}
}
