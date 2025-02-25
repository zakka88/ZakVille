<?php

require_once __DIR__ . "/../database/Database.php";
require_once __DIR__ . "/../entities/City.php";
require_once __DIR__ . "/../entities/Country.php";

class Cities extends Database
{
	private string $tableName = "cities";

	/**
	 * Construit la classe Villes avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de Villes.
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

		if (!isset($_SESSION[$this->getName() . ".demonyms"])) {
			// Initialise la session des démonymes.
			//
			// Un démonyme désigne le nom des habitants d'un lieu, qu'il
			// s'agisse d'une ville, d'un country, ou d'une région.
			//
			$_SESSION[$this->getName() . ".demonyms"] = [];
		}

		if (!isset($_SESSION[$this->getName() . ".flags"])) {
			// Initialise la session des drapeaux
			$_SESSION[$this->getName() . ".flags"] = [];
		}
	}

	/**
	 * Récupère toutes les villes (ainsi que leur démonyme)
	 */
	public function findAll(): array
	{
		$stmt = $this->getPdo()->query("SELECT * FROM {$this->tableName}");

		if ($stmt === false) {
			return [];
		}

		// NOTE: `array_map` est comme le `Array.map` de JavaScript.
		return array_map(function ($data) {
			$city = new City(
				city: $data->name,
				country: $data->country,
				capital: $data->capital
			);

			$city->setId($data->id);
			$city->getCountry()->setDemonym($this->getDemonym($data->country) ?: "");
			$city->getCountry()->setIsoCode($this->getCountryISO($data->country) ?: "");

			return $city;
		}, $stmt->fetchAll());
	}

	/**
	 * Récupère tous les pays de la base de données.
	 */
	public function findAllCountries(): array
	{
		try {
			$stmt = $this->getPdo()->query("
				SELECT DISTINCT country,capital FROM {$this->tableName}
			");

			if ($stmt === false) {
				return [];
			}

			return array_map(function ($data) {
				$country = new Country($data->country, $data->capital);
				$country->setIsoCode($this->getCountryISO($data->country));
				return $country;
			}, $stmt->fetchAll());
		} catch (PDOException $e) {
			return [];
		}
	}

	/**
	 * Récupère un démonyme depuis un nom de country.
	 */
	public function getDemonym(string $country): string|null
	{
		if (isset($_SESSION[$this->getName() . ".demonyms"][$country])) {
			return $_SESSION[$this->getName() . ".demonyms"][$country];
		}

		$req = $this->getPdo()->prepare("CALL GetCountryDemonym(:country, @demonym)");

		if ($req->execute(["country" => $country])) {
			$req = $this->getPdo()->query("SELECT @demonym AS demonym");
			if ($req === false) {
				return null;
			}

			$res = $req->fetch();
			if ($res === false || $res->demonym === null) {
				return null;
			}

			$this->addDemonym($country, $res->demonym);

			return $_SESSION[$this->getName() . ".demonyms"][$country];
		}

		return null;
	}

	/**
	 * Ajoute un démonyme dans la liste des démonymes.
	 */
	public function addDemonym(string $country, string $demonym): void
	{
		$_SESSION[$this->getName() . ".demonyms"][$country] = $demonym;
	}

	/**
	 * Récupère un code ISO depuis le nom d'un pays.
	 */
	public function getCountryISO(string $country): string|null
	{
		if (isset($_SESSION[$this->getName() . ".flags"][$country])) {
			return $_SESSION[$this->getName() . ".flags"][$country];
		}

		$req = $this->getPdo()->prepare("CALL GetCountryISO(:country, @output)");

		if ($req->execute(["country" => $country])) {
			$req = $this->getPdo()->query("SELECT @output AS iso");
			if (!$req) {
				return null;
			}

			$output = $req->fetch();
			if (!$output || $output->iso === null) {
				return null;
			}

			$this->addDrapeau($country, $output->iso);

			return $_SESSION[$this->getName() . ".flags"][$country];
		}

		return null;
	}

	/**
	 * Ajoute un drapeau dans la liste des flags.
	 */
	public function addDrapeau(string $country, string $drapeau): void
	{
		$_SESSION[$this->getName() . ".flags"][$country] = $drapeau;
	}

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
				"country" => $city->getCountry()->getName(),
				"capital" => $city->getCountry()->getCapital(),
			]);
		} catch (PDOException $_) {
			return false;
		}
	}
}
