<?php
require_once "./app/tables/Cities.php";

$citiesTable = new Cities();
$countries = $citiesTable->findAllCountries();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Accueil</title>
	<link rel="stylesheet" href="./assets/styles/main.css">
	<link rel="stylesheet" href="./assets/styles/pages/home.css">
</head>

<body>
	<header role="banner">
		<nav role="navigation">
			<div>
				<a href="./">ZakVille</a>
			</div>

			<ul>
				<li><a href="./" aria-current="page">Accueil</a></li>

				<?php if (true): ?>
					<li><a href="login.php">Se connecter</a></li>
				<?php else: ?>
					<li><a href="profile.php">Accéder à mon profil</a></li>
					<li><a href="logout.php">Se déconnecter</a></li>
				<?php endif ?>
			</ul>
		</nav>
	</header>

	<main role="main">
		<div class="hero js-hero size-full" style="background-image: url('https://i.ytimg.com/vi/eLPVDaaQybY/maxresdefault.jpg');">
			<h1>Des endroits à visiter</h1>

			<button type="button" class="launch-video-btn js-launch-video-btn">
				<svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M40 30L90 60L40 90V30Z" fill="currentColor" fill-opacity="0.3" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</button>
		</div>

		<div class="size-full mask1" hidden>
			<div class="size-full mask2">
				<iframe
					src="https://www.youtube-nocookie.com/embed/eLPVDaaQybY?si=-ESp9qEe0mP1tgFh&amp;controls=0&rel=0&enablejsapi=1"
					title="YouTube video player"
					frameborder="0"
					allow="autoplay; encrypted-media;"
					referrerpolicy="strict-origin-when-cross-origin"
					allowfullscreen
					class="size-full js-yt-player"
				></iframe>
			</div>
		</div>

		<h1 style="text-align: center;">Nous recommandons ces pays...</h1>

		<div class="table-wrap">
			<div class="table">
				<div class="table-head">
					<div class="country-flag">Drapeau</div>
					<div class="country-name">Pays</div>
					<div class="country-capital">Capitale</div>
					<div class="visits">Visites</div>
				</div>

				<?php foreach ($countries as $country): ?>
					<div class="table-row">
						<div class="country-flag">
							<?= $country->getFlag() ?>
						</div>
						<div class="country-name">
							<?= $country->getName() ?>
						</div>
						<div class="country-capital">
							<?= $country->getCapital() ?>
						</div>
						<div class="visits">
							<?= rand(5e5, 1e8) ?>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</main>

	<script type="module">
		import {
			HomePage,
		} from "./assets/js/pages/home.js";

		let page = new HomePage();
		page.start();
	</script>
</body>

</html>
