<?php

$nav = "login";
$title = "login";
require "./app/entities/User.php";
require "./app/utilities/session.php";
require "header.php";
require "baseDeDonnees.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];

	// Controllo utente nel database
	$stmt = $pdo->prepare("SELECT u.*, c.name AS city_name, c.name, c.country, c.capital
    FROM users u
    LEFT JOIN cities c ON u.city_id = c.id
    WHERE u.username = :username
    ");
	$stmt->execute(["username" => $username]);
	$user = $stmt->fetch();

	// Mike ha deciso di hash la password nel database, dobbiamo controllare con
	// la funzione nativa di PHP: password_verify
	if ($user && password_verify($password, $user["password"])) {
		// perche Mike vuole che costruiamo un oggetto User nella sessione
		$entity = new User(
			$user["username"],
			$user["password"],
			$user["firstname"],
			new DateTime($user["date_of_birth"]),
			$user["role"],
			$user["city_id"],
			$user["id"],
		);
		$city = new City($user["country"], $user["capital"], $user["city_name"], $user["city_id"]);
		$entity->setCity($city);
		$_SESSION["tp_zakville.user"] = $entity;

		header("Location: profile.php");
		exit();
	} else {
		echo '<span style="background:#e36940ba;color: white; text-shadow: 2px 2px 2px black; margin-left: 20px; font-size: 30px;">Nome utente o password errati!</span>' . "<br>";
	}
}
?>

<style>
	body {
		background-image: url(./assets/img/cn_3.jpg);
		background-size: cover;
		background-position: center;
		width: 100%;
	}

	form {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		background-color: coral;

		height: 30vh;
		border: solid;
		border-color: white;
		border-radius: 10px;
		opacity: 0.8;
		text-align: center;
		margin: 35px;
	}

	input {
		margin: 20px;
		border-radius: 10px;
		font-size: 25px;
		width: 100%;
	}

	button {
		border-radius: 10px;
	}
</style>

<?= displaySessionsMessages() ?>

<form method="POST">
	<input type="text" name="username" placeholder="Nome utente" required>
	<input type="password" name="password" placeholder="Password" required>
	<button type="submit">Accedi</button>
</form>

<?php require "footer.php" ?>
