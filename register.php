<?php

require_once "./app/tables/Villes.php";

try {
	$villesTable = new Villes();
} catch (PDOException $e) {
	die("Erreur avec la base de données: " . $e->getMessage());
}

var_dump($_SESSION);

if (isset($_POST["register-user"])) {
} else {
	try {
		$villes = $villesTable->all();
	} catch (PDOException $e) {
		die("Erreur avec la base de données: " . $e->getMessage());
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>S'inscrire</title>
	<link rel="stylesheet" href="./assets/styles/main.css">
</head>

<body>

	<section>
		<h1>S'inscrire</h1>

		<form action="" method="post">
			<div class="form-group">
				<label for="firstname">Prénom</label>
				<input type="text" name="firstname" id="firstname">
			</div>

			<div class="form-group">
				<label for="username">Pseudo</label>
				<input type="text" name="username" id="username">
			</div>

			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input type="text" name="password" id="password">
			</div>

			<div class="form-group">
				<label for="cities">Ville</label>
				<select id="cities" name="city">
					<?php foreach ($villes as $ville): ?>
						<option value="<?= $ville->getId() ?>">
							<?= $ville->getDrapeau() ?> <?= $ville->getNom() ?>
						</option>
					<?php endforeach ?>
				</select>
			</div>

			<button type="submit" name="register-user">
				Inscription
			</button>
		</form>
	</section>

</body>

</html>
