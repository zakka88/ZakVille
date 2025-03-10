<?php
session_start();

if (isset($_GET["destroy"])) {
	foreach (array_keys($_SESSION) as $key) {
		unset($_SESSION[$key]);
	}

	header("Location: session.php");
	exit();
}

// NOTE: `array_filter` fonctionne de la même façon que le `Array.filter` de
//       JavaScript.
//       https://php.net/manual/en/function.array-filter.php
$sessions = array_filter(
	$_SESSION,
	fn($key) => str_starts_with($key, "tp_zakville."),
	ARRAY_FILTER_USE_KEY
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sessions</title>
	<link rel="stylesheet" href="./assets/styles/main.css">
</head>

<body>
	<main role="main" class="inline-center size-article">
		<h1>Toutes les sessions du projet <code>tp_zakville</code></h1>

		<?php var_dump($sessions) ?>

		<ul>
			<li>
				<a href="?destroy">Supprimer toutes les sessions du projet</a>
			</li>

			<li>
				<a href="./">Aller à la page d'accueil</a>
			</li>

			<li>
				<a href="#" onclick="history.back(); return false;">
					Retourner à la page précédente, si vous avez toujours les droits.
				</a>
			</li>
		</ul>
	</main>
</body>

</html>
