<?php

require_once "../../app/utilities/form.php";
require_once "../../app/utilities/session.php";

if (isset($_POST["create-city"])) {
	require_once "../../app/usecases/CityCreateUseCase.php";
	$uc = new CityCreateUseCase();
	$uc->store($_POST);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin: Ajouter une ville</title>
	<link rel="stylesheet" href="../../assets/styles/main.css">
	<link rel="stylesheet" href="../../assets/styles/city.css">
</head>

<body>

	<main role="main">
		<h1>Ajouter une ville</h1>

		<?= displaySessionsMessages() ?>

		<form action="" method="POST" class="form">
			<div class="form-group">
				<label for="country">Nom du pays</label>
				<input type="text" name="country" id="country" placeholder="Turquie" value="<?= inputValue('country') ?>">
			</div>

			<div class="form-group">
				<label for="capital">Capital</label>
				<input type="text" name="capital" id="capital" placeholder="Ankara" value="<?= inputValue('capital') ?>">
			</div>

			<div class="form-group">
				<label for="city">Nom de la ville</label>
				<input type="text" name="city" id="city" placeholder="Istanbul" value="<?= inputValue('city') ?>">
			</div>

			<button type="submit" name="create-city">Créer la ville</button>
		</form>
	</main>

</body>

</html>
