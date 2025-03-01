<?php

require_once __DIR__ . "/../utilities/session.php";
require_once __DIR__ . "/../utilities/form.php";
require_once __DIR__ . "/../tables/Cities.php";
require_once __DIR__ . "/../tables/Users.php";
require_once __DIR__ . "/AuthUseCase.php";

class CityCreateUseCase
{
	// --------- //
	// Propriété //
	// --------- //

	private AuthUseCase $authUseCase;
	private Cities      $citiesTable;
	private Users       $usersTable;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("error404.php");
		$this->authUseCase->adminOnly();

		$this->citiesTable = new Cities();
		$this->usersTable  = new Users();
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function store(array $form): void
	{
		if (isEmptyForm(array_keys($form), ["create-city"])) {
			notifyMessage(
				"errors",
				"Vous ne pouvez pas envoyer de formulaire avec des champs vides"
			);
		}

		$success = $this->citiesTable->create(new City(
			country: $form["country"],
			capital: $form["capital"],
			city:    $form["city"],
		));

		if (!$success) {
			notifyMessage(
				"error",
				"Impossible d'ajouter la ville " . htmlspecialchars($form["city"]) .
				", veuillez recommencer..."
			);
		}

		if (!isset($form["users"]) || count($form["users"]) === 0) {
			notifyMessage("success", "La ville a bien été ajouté.");
		}

		$this->usersTable->updateCityFor(
			users_id: array_map(fn ($userId) => (int) $userId, $form["users"]),
			cityName: $form["city"],
		);

		notifyMessage(
			"success",
			"La ville « " . htmlspecialchars($form["city"]) .
			" » a bien été ajouté et les utilisateurs sélectionnés se sont bien" .
			" vu recevoir cette ville"
		);
	}
}
