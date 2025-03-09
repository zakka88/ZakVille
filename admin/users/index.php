<?php

require_once "../../app/pages/admin/ListUsersAdminPage.php";

$view = (new ListUsersAdminPage())->data();
$users = array_filter($view->users, fn($item) => !empty($_GET["role"]) ? $_GET["role"] === $item->getRole() : true);
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
		<h1>Tous les utilisateurs</h1>

		<table>
			<thead>
				<tr>
					<?php foreach ($view->fields as $field): ?>
						<th><?= $field ?></th>
					<?php endforeach ?>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?= $user->getId() ?></td>
						<td><?= $user->getFirstname() ?></td>
						<td>
							<a href="./show.php?id=<?= $user->getId() ?>">
								<?= $user->getUsername() ?>
							</a>
						</td>
						<td>******</td>
						<td><?= $user->getDateOfBirth()->format('Y-m-d') ?></td>
						<td>
							<a href="./?role=<?= $user->getRole() ?>">
								<?= $user->getRole() ?>
							</a>
						</td>
						<td>
							<a href="../cities/show.php?id=<?= $user->getCityId() ?>">
								<?= $user->getCityId() ?>
							</a>
						</td>
					</tr>
				<?php endforeach ?>

			</tbody>
		</table>

		<!-- <?php var_dump($view) ?> -->
	</main>
</body>

</html>
