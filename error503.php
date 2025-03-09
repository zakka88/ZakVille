<?php http_response_code(503) ?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erreur 503</title>
	<style>
		strong:empty:after {
			content: "[vide]";
			font-style: italic;
			font-weight: normal;
			color: #AAA;
		}
	</style>
</head>

<body>
	<h1>Service indisponible</h1>

	<?php if (isset($_GET["cause"]) && $_GET["cause"] === "db"): ?>
		<h2>Erreur liée à la base de données</h2>

		<?php if (isset($_GET["type"]) && $_GET["type"] === "access_denied"): ?>
			<p>
				D'après nos informations, les identifiants de connexion n'ont pas accès
				à la base de données <strong><?= $_GET["dbname"] ?></strong>.
			</p>

			<p>Vos identifiants :</p>

			<ul>
				<li>Utilisateur: <strong><?= $_GET["dbuser"] ?></strong></li>
				<li>Mot de passe: <strong><?= $_GET["dbpass"] ?></strong></li>
			</ul>
		<?php endif ?>

		<?php if (isset($_GET["type"]) && $_GET["type"] === "unknown_database"): ?>
			<p>D'après nos informations, la base de données <strong><?= $_GET["dbname"] ?></strong> n'existe pas.</p>
			<p>Néanmoins</p>
		<?php endif ?>

		<?php if (isset($_GET["type"]) && $_GET["type"] === "unknown_table"): ?>
			<p>D'après nos informations, la table <strong><?= $_GET["dbtable"] ?></strong>
			dans la base de données <strong><?= $_GET["dbname"] ?></strong> n'existe pas.</p>
			<p>Néanmoins</p>
		<?php endif ?>

		<?php if (isset($_GET["type"]) && $_GET["type"] === "unavailable"): ?>
			<p>D'après nos informations, <strong>MySQL</strong> n'est pas démarré.</p>
			<p>Néanmoins</p>
		<?php endif ?>


		<p>Veuillez vérifier les points suivants :</p>

		<ol>
			<li>
				Est-ce que le service <strong>MySQL</strong> est bien démarré
				sur le port <strong><?= $_GET["dbport"] ?></strong> ?
			</li>

			<li>
				L'utilisateur <strong><?= $_GET["dbuser"] ?></strong> est-il le bon ?
			</li>

			<li>
				Est-ce que les fichiers <strong>.sql</strong> liés au projet ont bien été importés ? <br>
				Ces fichiers se trouvent dans le dossier <strong>database/</strong> du projet.
			</li>

			<li>
				Est-ce que tout semble correct dans le fichier <strong>app/database/Database.php</strong> ?
			</li>
		</ol>
	<?php endif ?>
</body>

</html>
