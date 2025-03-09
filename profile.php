<?php
require "./app/entities/User.php";
session_start();
$nav = "profile";
$title = "profile";
require "header.php";

if (!isset($_SESSION["tp_zakville.user"])) {
	header("Location: login.php");
	exit();
}
$session = $_SESSION["tp_zakville.user"];
?>
<style>
	body {
		<?php
			$iso = strtolower($session->getCountry()->getIsoCode());
			$rnd = rand(1, 3);
		?>
		background-image: url(./assets/img/<?= $iso ?>_<?= $rnd ?>.jpg);
		background-size: cover;
		background-position: center;
	}

	img {
		width: 570px;
		margin-bottom: 20px;
	}

	h1 {
		color: white;
		font-size: 55px;
		text-align: center;
		text-shadow: 2px 2px 1px black;
	}

	p {
		color: white;
		font-size: 55px;
		text-align: center;
		text-shadow: 2px 2px 1px black;
	}

	.profilo {
		display: flex;
		flex-direction: column;
		justify-content: center;
		padding: 1px;
		height: 30vh;
		margin-left: 100px;
	}

	a {
		text-shadow: 2px 2px 1px black;
	}

	img {
		width: 200px;
		margin-left: auto;
		margin-right: 150px;
		border-radius: 60px;
	}
</style>

<div class="profilo">
	<img src="./assets/img/profilo.jpg" alt="">
	<?php

	echo "<h1>Benvenuto : " . $session->getUsername() . " " . $session->getFirstname() . " !</h1>";
	echo "<h1>City : " . $session->getCity()->getCityName() . " <br> Nationalité : " . $session->getNationality() .  " </h1>";
	?>
</div>
<?php require "footer.php" ?>
