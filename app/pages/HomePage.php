<?php

require_once __DIR__ . "/../auth/Authentication.php";
require_once __DIR__ . "/../tables/Cities.php";

class HomePage
{
	// --------- //
	// Propriété //
	// --------- //

	private Authentication $authentication;

	private Cities $citiesTable;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->authentication = new Authentication();

		$this->citiesTable = new Cities();
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function data(): HomeView
	{
		$youtubeVideoIDs = ["4piwwTCgpPA", "eLPVDaaQybY", "bHDmvm5nunk", "2vqvBzb0xJY", "mtCK_tHQ6U4"];
		$youtubeVideoID = $youtubeVideoIDs[array_rand($youtubeVideoIDs)];

		return new HomeView(
			youtubeVideoID: $youtubeVideoID,
			countries:      $this->citiesTable->findAllCountries(),
			isConnected:    $this->authentication->check(),
		);
	}
}

/**
 * @property array<int,Country> $countries Tous les pays de la base de données.
 * @property bool $isConnected Est-ce que l'utilisateur est connecté ou non.
 */
class HomeView
{
	/**
	 * La syntaxe qui suit est une syntaxe alternative et plus rapide de
	 *
	 * ```php
	 * public type $prop;
	 *
	 * public function __construct(type $prop) {
	 * 		$this->prop = $prop;
	 * }
	 * ```
	 */
	public function __construct(
		public array $countries,
		public bool $isConnected,
		public string $youtubeVideoID,
	) {}
}
