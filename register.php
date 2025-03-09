<?php

require_once "./app/utilities/form.php";
require_once "./app/pages/RegisterUserPage.php";

$page = new RegisterUserPage();

if (isset($_POST["register-user"])) {
	$page->save($_POST);
} else {
	$view = $page->data();
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

	<header role="banner">
		<nav role="navigation">
			<div>
				<a href="./">ZakVille</a>
			</div>

			<ul>
				<li><a href="session.php">Sessions</a></li>
			</ul>
		</nav>
	</header>

	<main role="main" id="page-auth-register">

		<section class="auth-account">
			<h1 class="auth-account-title">Créer un compte</h1>

			<p>Entre tes informations personnelles.</p>

			<p class="auth-account-note">
				<strong>NOTE:</strong><br>

				Seuls TOI et les administrateurs du site serez au courant de
				ces informations, hormis le mot de passe qui utilise un
				algorithme de hachage fort et irréversible, autrement dit:
				quelque chose d'<b><u>indéchiffrable</u></b>.
			</p>

			<?= displaySessionsMessages() ?>

			<form action="" method="POST" class="auth-form">
				<div class="input-group">
					<div class="input-container">
						<label for="firstname">
							<?php include "assets/svg/name.svg" ?>
						</label>

						<input 
							aria-label="Prénom" 
							autocomplete="given-name" 
							minlength="3" 
							placeholder="Écris ton prénom" 
							required
							type="text" 
							id="firstname" 
							name="firstname"
							<?= inputValue("firstname") ?>
						>
					</div>
					
					<!--
						NOTE: La fonction `input()` va créer le même élément
						ci-haut (<div class="input-container">...</div>) mais
						avec les valeurs différentes.
					-->

					<?=
					input(
						"username",
						[
							"aria-label" => "Pseudonyme",
							"autocomplete" => "username",
							"placeholder" => "Écris ton pseudonyme",
							"required" => true,
							"type" => "text",
						],
						[
							"icon-left" => "user",
						]
					)
					?>

					<?=
					input(
						"password",
						[
							"aria-label" => "Mot de passe",
							"autocomplete" => "new-password",
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
							"aria-label" => "Confirmation de mot de passe",
							"autocomplete" => "new-password",
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
					input(
						"date_of_birth",
						[
							"aria-label" => "Jour de naissance, minimum 16 ans",
							"autocomplete" => "bday",
							"placeholder" => "Jour de naissance",
							"required" => true,
							"type" => "date",
							"min" => $view->minBdayDate,
							"max" => $view->maxBdayDate,
						],
						[
							"icon-left" => "birth"
						]
					)
					?>

					<?=
					select(
						"city",
						[
							/** Le champ en base de données peut être NULL */
							"placeholder" => "Choisir sa ville (optionnel)",
							"required" => false,
							"title" => "Choisis ta ville",
						],
						[
							"default-group" => true,
							"icon-left" => "city",
							/** Le champ en base de données peut être NULL */
							"icon-right" => "cancel-left",
							"options" => $view->cities,
							"placeholder" => "Choisis ta ville (optionnel)",
						]
					)
					?>
				</div>

				<div class="auth-form-actions">
					<button type="submit" name="register-user">Créer le compte</button>
					<hr text="ou">
					<a href="login.php">J'ai déjà en ma possession un compte</a>
				</div>
			</form>
		</section>

		<section
			aria-label="Prévisualisation des images du pays séléctionné"
			aria-roledescription="carousel"
			aria-orientation="horizontal"
			hidden
		>
			<div class="carousel js-pictures" tabindex="0">
			</div>

			<div class="carousel-controls js-carousel-controls" role="tablist" aria-label="Slides">
			</div>
		</section>

	</main>

	<script type="module">
		import {
			RegisterPage,
		} from "./assets/js/pages/register.js";

		/**
		 * Cela va générer un code similaire avec les données réelles de la base
		 * de donnes.
		 *
		 * @example
		 *
		 *```js
		 * {
		 *     be: 3,
		 *     it: 3,
		 *     us: 3,
		 *     // etc...
		 * }
		 *```
		 */
		let pictures = {
			<?php foreach ($view->isoCodes as $isoCode): ?>
				<?php if ($isoCode): ?>
					<?= $isoCode ?>: 3,
				<?php endif ?>
			<?php endforeach ?>
		};

		let page = new RegisterPage().withPictures(pictures);
		page.start();
	</script>
</body>

</html>
