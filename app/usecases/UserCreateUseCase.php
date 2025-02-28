<?php

require_once __DIR__ . "/../utilities/session.php";
require_once __DIR__ . "/../usecases/AuthUseCase.php";
require_once __DIR__ . "/../tables/Users.php";
require_once __DIR__ . "/../entities/User.php";

class UserCreateUseCase
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
		$this->authUseCase->setRedirectTo("profile.php");
		$this->authUseCase->anonymousOnly();

		$this->usersTable = new Users();
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function store(array $form): bool
	{
		if (isEmptyForm(array_keys($form), ["register-user"])) {
			notifyMessage(
				"errors",
				"Vous ne pouvez pas envoyer de formulaire avec des champs vides"
			);
		}

		if ($form["password"] !== $form["password_confirmation"]) {
			notifyMessage(
				"errors",
				"Les deux mots de passes ne sont pas identiques."
			);
		}

		$cityId = is_numeric($form["city"]) ? (int) $form["city"] : null;

		$user = new User(
			username: $form["username"],
			password: $form["password"],
			firstname: $form["firstname"],
			date_of_birth: new DateTime($form["date_of_birth"]),
			role: "User",
			cityId: $cityId,
		);

		$success = $this->usersTable->create($user);

		if ($success) {
			notifyMessage(
				"success",
					"Un mail de confirmation vous a été envoyé à votre adresse e-mail. " .
					"Mais comme on fait semblant et qu'il n'existe pas d'adresse mail, " .
					"bah vous pouvez directement vous connecter.",
				"login.php"
			);
		} else {
			notifyMessage(
				"errors",
					"Vous ne pouvez pas choisir le pseudo " .
					"<strong>" . htmlspecialchars($form["username"]) . "</strong>" .
					" car il a été banni de nos services pour une durée déterminée"
			);
		}

		return $success;
	}
}
