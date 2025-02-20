<?php

require_once __DIR__ . "/../utilities/session.php";
require_once __DIR__ . "/../utilities/form.php";
require_once __DIR__ . "/../tables/Cities.php";
require_once __DIR__ . "/AuthUseCase.php";

class CityCreateUseCase
{
	private AuthUseCase $authUseCase;
	private Cities $citiesTable;

	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("error404.php");
		$this->authUseCase->adminOnly();

		$this->citiesTable = new Cities();
	}

	public function store(array $form)
	{
		if (isEmptyForm(array_keys($form), ["create-city"])) {
			notifyMessage(
				"errors",
				"Vous ne pouvez pas envoyer de formulaire avec des champs vides"
			);
		}

		$city = new City(
			country: $form["country"],
			capital: $form["capital"],
			city: $form["city"],
		);

		$success = $this->citiesTable->create($city);

		if ($success) {
			notifyMessage("success", "La ville a bien été ajouté.");
		} else {
			notifyMessage(
				"error",
				"Impossible d'ajouter la ville " . htmlspecialchars($form["city"]) .
				", veuillez recommencer..."
			);
		}
	}
}
