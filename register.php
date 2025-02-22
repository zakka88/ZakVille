<?php

require_once "./app/utilities/form.php";
require_once "./app/utilities/session.php";

if (isset($_POST["register-user"])) {
	require_once "./app/usecases/UserCreateUseCase.php";
	$useCase = new UserCreateUseCase();
	$useCase->store($_POST);
} else {
	require_once "./app/usecases/UserViewRegistrationUseCase.php";
	$useCase = new UserViewRegistrationUseCase();
	$data = $useCase->fetchData();

	// Voir https://www.php.net/manual/en/function.array-reduce.php
	$cities = array_reduce($data->cities, function ($acc, $city) {
		$acc[$city->getId()] = $city->getFlag() . " " . $city->getCountry();
		return $acc;
	}, []);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Créer un compte</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="./assets/styles/main.css">
	<link rel="stylesheet" href="./assets/styles/pages/register.css">
</head>

<body>

	<main role="main" id="page-auth-register">

		<section class="auth-account">
			<h1 class="auth-account-title">Créer un compte</h1>

			<p>Entre tes informations personnelles.</p>

			<p class="auth-account-note">
				<strong>NOTE:</strong><br>


				Seuls TOI et le centre de formation auquel tu es attaché serez
				au courant de ces informations, hormis le mot de passe qui
				utilise un algorithme de hachage fort et irréversible, autrement
				dit: <b><u>indéchiffrable</u></b>.
			</p>

			<?= displaySessionsMessages() ?>

			<form action="" method="POST" class="auth-form" autocomplete="off">
				<div class="input-group">
					<?=
					input(
						"firstname",
						[
							"minlength" => "3",
							"placeholder" => "Écris ton prénom",
							"required" => true,
						],
						[
							"icon-left" => "user",
						]
					)
					?>

					<?=
					input(
						"email",
						[
							"placeholder" => "Écris ton adresse e-mail",
							"required" => true,
							"type" => "email",
						],
						[
							"icon-left" => "email",
						]
					)
					?>

					<?=
					input(
						"password",
						[
							"minlength" => "8",
							"placeholder" => "Écris ton mot de passe (retiens-le, note-le !!)",
							"required" => true,
							"type" => "password",
						],
						[
							"icon-left" => "password",
						]
					)
					?>

					<?=
					input(
						"password_confirmation",
						[
							"placeholder" => "Confirme ton mot de passe",
							"required" => true,
							"type" => "password",
						],
						[
							"icon-left" => "password",
						]
					)
					?>

					<?=
					select(
						"city",
						[
							"required" => true,
						],
						[
							"icon-left" => "city",
							"default-group" => true,
							"options" => $cities,
							"placeholder" => "Choisi ta ville",
						]
					)
					?>
				</div>

				<div class="auth-form-actions">
					<button type="submit">Créer le compte</button>
					<hr text="ou">
					<a href="login.php">J'ai déjà en ma possession un compte</a>
				</div>
			</form>
		</section>

		<section role="presentation" hidden>
			<div class="container">
				:)
			</div>
		</section>

	</main>

</body>

</html>
