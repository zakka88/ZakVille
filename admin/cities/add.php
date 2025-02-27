<?php

require_once "../../app/pages/admin/AddCityAdminPage.php";

$page = new AddCityAdminPage();

if (isset($_POST["create-city"])) {
	$page->save();
} else {
	$view = $page->handle();
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

	<main role="main" class="inline-center size-article">
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

			<?php if (!empty($view->users)): ?>
			<div class="form-group">
				<label for="users">Associer cette ville aux utilisateurs :</label>
				<select name="users[]" id="users" multiple>
					<optgroup label="Utilisateurs sans ville associée">
						<?php foreach ($view->users as $user): ?>
							<option value="<?= $user->getId() ?>">
								<?= $user->getUsername(); ?>
							</option>
						<?php endforeach ?>
					</optgroup>
				</select>
			</div>
			<?php endif; ?>

			<button type="submit" name="create-city">Créer la ville</button>
		</form>
	</main>

</body>

</html>
