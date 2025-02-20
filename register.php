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
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>S'inscrire</title>
	<link rel="stylesheet" href="./assets/styles/main.css">
	<link rel="stylesheet" href="./assets/styles/pages/register.css">
</head>

<body>

	<main role="main">
		<h1>S'inscrire</h1>

		<?= displaySessionsMessages() ?>

		<form action="" method="POST" class="form">
			<div class="form-group">
				<label for="firstname">Prénom</label>
				<input
					type="text"
					name="firstname"
					id="firstname"
					placeholder="John"
					minlength="3"
					title="3 caractères minimum"
					value="<?= inputValue("firstname") ?>">
			</div>

			<div class="form-group">
				<label for="username">Pseudo</label>
				<input
					type="text"
					name="username"
					id="username"
					placeholder="JohnDoe"
					minlength="3"
					title="3 caractères minimum"
					value="<?= inputValue("username") ?>">
			</div>

			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input
					type="password"
					name="password"
					id="password"
					minlength="8"
					placeholder="8 caractères minimum"
					title="8 caractères minimum"
					value="<?= inputValue("password") ?>">
			</div>

			<div class="form-group">
				<label for="cities">Ville</label>
				<select id="cities" name="city">
					<?php foreach ($data->villes as $ville): ?>
						<option
							value="<?= $ville->getId() ?>"
							<?php if (isset($_POST["city"]) && $_POST["city"] == $ville->getId()) : ?>
							selected
							<?php endif ?>>
							<?= $ville->getFlag() ?> <?= $ville->getCountry() ?>
						</option>
					<?php endforeach ?>
				</select>
			</div>

			<button type="submit" name="register-user">
				Inscription
			</button>
		</form>
	</main>

</body>

</html>
