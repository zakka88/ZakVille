<?php

require_once __DIR__ . "/../database/Database.php";
require_once __DIR__ . "/../entities/City.php";
require_once __DIR__ . "/../entities/Country.php";

class Cities extends Database
{
	// --------- //
	// Propriété //
	// --------- //

	/**
	 * Nom de la table
	 */
	protected string $tableName = "cities";

	/** Nom des sessions */

	private string $sessionNameDemonyms = "tp_zakville.demonyms";
	private string $sessionNameFlags    = "tp_zakville.flags";

	// ----------- //
	// Constructor //
	// ----------- //

	/**
	 * Construit la classe Cities avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de Cities.
	 *
	 * Initialise les sessions si elles ne sont pas déjà initialisées.
	 */
	public function __construct()
	{
		// Appel du constructeur parent.
		parent::__construct();

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if ( ! isset($_SESSION[$this->sessionNameDemonyms])) {
			// Initialise la session des démonymes.
			$_SESSION[$this->sessionNameDemonyms] = [];
		}

		if ( ! isset($_SESSION[$this->sessionNameFlags])) {
			// Initialise la session des drapeaux
			$_SESSION[$this->sessionNameFlags] = [];
		}
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	/**
	 * Récupère toutes les villes (ainsi que leur démonyme)
	 */
	public function all(): array
	{
		$stmt = $this->getPdo()->query("SELECT * FROM {$this->tableName}");

		// NOTE: `array_map` fonctionne de la même façon que le `Array.map` de
		//       JavaScript.
		//       https://php.net/manual/en/function.array-map.php
		return array_map(
			// Fonction anonyme
			function (object $item): City {
				// var_dump($item);

				$city = new City(
					city:    $item->name,
					country: $item->country,
					capital: $item->capital
				);

				$city->setId($item->id);
				$city->getCountry()->setDemonym(
					$this->getDemonym($item->country) ?: ""
				);
				$city->getCountry()->setIsoCode(
					$this->getCountryISO($item->country) ?: ""
				);

				return $city;
			},
			$stmt->fetchAll()
		);
	}

	/**
	 * Insère une nouvelle ville
	 */
	public function create(City $city): bool
	{
		try {
			$stmt = $this->getPdo()->prepare("
				INSERT INTO {$this->tableName} (name,country,capital) VALUES (
					:city_name,
					:country,
					:capital
				)
			");

			return $stmt->execute([
				"city_name" => $city->getCity(),
				"country"   => $city->getCountry()->getName(),
				"capital"   => $city->getCountry()->getCapital(),
			]);
		} catch (PDOException $_) {
			// L'ajout d'une ville dans la base de données peut échouer dans le
			// cas où le nom d'une ville existe déjà.
			//
			// name = unique
			return false;
		}
	}

	/**
	 * Récupère tous les pays de la base de données.
	 */
	public function findAllCountries(): array
	{
		$stmt = $this->getPdo()->query("
			SELECT DISTINCT country,capital FROM {$this->tableName}
		");

		// NOTE: `array_map` fonctionne de la même façon que le `Array.map` de
		//       JavaScript.
		//       https://php.net/manual/en/function.array-map.php
		return array_map(
			// Fonction anonyme
			function ($item) {
				$country = new Country(
					country: $item->country,
					capital: $item->capital
				);
				$country->setIsoCode($this->getCountryISO($item->country));
				return $country;
			},
			$stmt->fetchAll()
		);
	}

	// ------- //
	// Méthode // -> Privée
	// ------- //

	/**
	 * Récupère un démonyme depuis un nom de country.
	 */
	private function getDemonym(string $country): string|null
	{
		if (isset($_SESSION[$this->sessionNameDemonyms][$country])) {
			return $_SESSION[$this->sessionNameDemonyms][$country];
		}

		$req = $this->getPdo()->prepare("CALL GetCountryDemonym(:country, @demonym)");

		if (!$req->execute(["country" => $country])) {
			return null;
		}

		$req = $this->getPdo()->query("SELECT @demonym AS demonym");
		if ($req === false) {
			return null;
		}

		$res = $req->fetch();
		if ($res === false || $res->demonym === null) {
			return null;
		}

		$this->addDemonym($country, $res->demonym);

		return $_SESSION[$this->sessionNameDemonyms][$country];
	}

	/**
	 * Ajoute un démonyme dans la liste des démonymes.
	 */
	private function addDemonym(string $country, string $demonym): void
	{
		$_SESSION[$this->sessionNameDemonyms][$country] = $demonym;
	}

	/**
	 * Récupère un code ISO depuis le nom d'un pays.
	 */
	private function getCountryISO(string $country): string|null
	{
		if (isset($_SESSION[$this->sessionNameFlags][$country])) {
			return $_SESSION[$this->sessionNameFlags][$country];
		}

		$req = $this->getPdo()->prepare("CALL GetCountryISO(:country, @output)");

		if (!$req->execute(["country" => $country])) {
			return null;
		}

		$req = $this->getPdo()->query("SELECT @output AS iso");
		if (!$req) {
			return null;
		}

		$output = $req->fetch();
		if (!$output || $output->iso === null) {
			return null;
		}

		$this->addFlag($country, $output->iso);

		return $_SESSION[$this->sessionNameFlags][$country];
	}

	/**
	 * Ajoute un drapeau dans la liste des flags.
	 */
	private function addFlag(string $country, string $flag): void
	{
		$_SESSION[$this->sessionNameFlags][$country] = $flag;
	}
}
