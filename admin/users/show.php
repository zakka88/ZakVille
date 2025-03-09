<?php

require_once "../../app/pages/admin/ShowUserAdminPage.php";

$userId = (int) $_GET["id"];
$view = (new ShowUserAdminPage($userId))->data();
$user = $view->user;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin: liste des utilisateurs</title>
	<link rel="stylesheet" href="../../assets/styles/main.css">
	<link rel="stylesheet" href="../../assets/styles/admin.css">
</head>

<body>
	<main role="main" class="inline-center size-article">
		<p><a href="./">Retour à la liste de tous les utilisateurs</a></p>

		<h1>Visualiser les informations de <?= $view->user->getFirstname() ?></h1>

		<table>
			<thead>
				<tr>
					<?php foreach ($view->fields as $field): ?>
						<th><?= $field ?></th>
					<?php endforeach ?>

					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?= $user->getId() ?></td>
					<td><?= $user->getFirstname() ?></td>
					<td><?= $user->getUsername() ?></td>
					<td>******</td>
					<td><?= $user->getDateOfBirth()->format('Y-m-d') ?></td>
					<td><?= $user->getRole() ?></td>
					<td>
						<a href="../cities/show.php?id=<?= $user->getCityId() ?>">
							<?= $user->getCityId() ?>
						</a>
					</td>
					<td>
						<a href="./edit.php?id=<?= $user->getCityId() ?>">Éditer</a>
						<br>
						<a href="./remove.php?id=<?= $user->getCityId() ?>">Supprimer</a>
					</td>
				</tr>
			</tbody>
		</table>
	</main>
</body>

</html>
