<?php

require_once __DIR__ . "/../database/Database.php";
require_once __DIR__ . "/../entities/City.php";
require_once __DIR__ . "/../entities/Country.php";

class Cities extends Database
{
	private string $tableName = "cities";

	private string $sessionNameDemonyms = "tp_zakville.demonyms";
	private string $sessionNameFlags    = "tp_zakville.flags";

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

		if (!isset($_SESSION[$this->sessionNameDemonyms])) {
			// Initialise la session des démonymes.
			$_SESSION[$this->sessionNameDemonyms] = [];
		}

		if (!isset($_SESSION[$this->sessionNameFlags])) {
			// Initialise la session des drapeaux
			$_SESSION[$this->sessionNameFlags] = [];
		}
	}

	/**
	 * Récupère toutes les villes (ainsi que leur démonyme)
	 */
	public function all(): array
	{
		$stmt = $this->getPdo()->query("SELECT * FROM {$this->tableName}");

		if ($stmt === false) {
			return [];
		}

		// NOTE: `array_map` fonctionne de la même façon que le `Array.map` de
		//       JavaScript.
		return array_map(
			/** Fonction anonyme */
			function (object $item): City {
				// var_dump($item);

				$city = new City(
					city: $item->name,
					country: $item->country,
					capital: $item->capital
				);

				$city->setId($item->id);
				$city->getCountry()->setDemonym($this->getDemonym($item->country) ?: "");
				$city->getCountry()->setIsoCode($this->getCountryISO($item->country) ?: "");

				return $city;
			},
			$stmt->fetchAll()
		);
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
		if (isset($_SESSION[$this->sessionNameDemonyms][$country])) {
			return $_SESSION[$this->sessionNameDemonyms][$country];
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

			return $_SESSION[$this->sessionNameDemonyms][$country];
		}

		return null;
	}

	/**
	 * Ajoute un démonyme dans la liste des démonymes.
	 */
	public function addDemonym(string $country, string $demonym): void
	{
		$_SESSION[$this->sessionNameDemonyms][$country] = $demonym;
	}

	/**
	 * Récupère un code ISO depuis le nom d'un pays.
	 */
	public function getCountryISO(string $country): string|null
	{
		if (isset($_SESSION[$this->sessionNameFlags][$country])) {
			return $_SESSION[$this->sessionNameFlags][$country];
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

			return $_SESSION[$this->sessionNameFlags][$country];
		}

		return null;
	}

	/**
	 * Ajoute un drapeau dans la liste des flags.
	 */
	public function addDrapeau(string $country, string $drapeau): void
	{
		$_SESSION[$this->sessionNameFlags][$country] = $drapeau;
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
