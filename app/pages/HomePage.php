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

	public function handle(): HomeView
	{
		return new HomeView(
			countries: $this->citiesTable->findAllCountries(),
			isConnected: $this->authentication->check(),
		);
	}
}

/**
 * @property array<int,Country> $countries Tous les pays de la base de données.
 * @property bool $isConnected Est-ce que l'utilisateur est connecté ou non.
 */
class HomeView
{
	public function __construct(
		public array $countries,
		public bool $isConnected,
	) {}
}
