<?php

session_start();

require_once "../app/auth/Authentication.php";

$authentication = new Authentication();

if (isset($_GET["username"])) {
	switch ($_GET["username"]) {
		case "PhiSyX":
		case "Zak":
		{
			$user = $authentication->attempt($_GET["username"], "12345678");
			if ($user) {
				$_SESSION["tp_zakville.user"] = $user;
			}
		} break;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>

<body>

	<ul>
		<li>
			<a href="./">Retour à la page d'admin</a>
		</li>
	</ul>

	<?php
	if ($authentication->check()) {
		echo "<h1>Connecté en tant que</h1>";
		var_dump($_SESSION["tp_zakville.user"]);
	}
	?>

	<h1>Changer d'utilisateur</h1>

	<ul>
		<li>
			<a href="?username=PhiSyX">
				Se connecter en tant que
				<strong>PhiSyX</strong>
				<em>(Role: Admin)</em>
			</a>
		</li>

		<li>
			<a href="?username=Zak">
				Se connecter en tant que
				<strong>Zak</strong>
				<em>(Role: User)</em>
			</a>
		</li>
	</ul>

</body>

</html>
