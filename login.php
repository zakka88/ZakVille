<?php

require_once "./app/utilities/session.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Page de connexion</title>
	<link rel="stylesheet" href="./assets/styles/main.css">
</head>

<body>

	<?php
	/*
	Mike: Tu peux déplacer cette partie où tu veux dans ton code HTML.

          Cette fonction va afficher un élément <div class="alert" /> avec un
          message de succès ou d'erreur si un message existe dans la session.

          Par exemple:

          Un message va s'afficher lorsqu'un utilisateur a été bien été inscrit
          depuis le formulaire de la page d'inscription.

          Les messages sont définies grâce à la fonction `notifyMessage` dans
          le fichier `./app/utilities/session.php`:

          Exemple d'utilisation:

              notifyMessage("errors", "Mon message d'erreur", "page_de_redirection.php");
              notifyMessage("success", "Mon message de succès", "page_de_redirection.php");

          La fonction ci-dessous va capturer ces messages.
	*/
	echo displaySessionsMessages();
	?>

</body>

</html>
