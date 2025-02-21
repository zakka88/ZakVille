<?php

require_once __DIR__ . "/../database/Database.php";
require_once __DIR__ . "/../entities/City.php";

class Cities extends Database
{
	private string $tableName = "villes";

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
			$_SESSION[$this->getName() . ".demonyms"] = [
				"France" => "Français"
			];
		}

		if (!isset($_SESSION[$this->getName() . ".flags"])) {
			// Initialise la session des drapeaux
			$_SESSION[$this->getName() . ".flags"] = [
				"France" => "FR"
			];
		}
	}

	/**
	 * Récupère toutes les villes (ainsi que leur démonyme)
	 */
	public function all(): array
	{
		$stmt = $this->getPdo()->query("SELECT * FROM villes");

		if ($stmt === false) {
			return [];
		}

		// NOTE: `array_map` est comme le `Array.map` de JavaScript.
		return array_map(function ($data) {
			$ville = new City();

			$ville->setId($data->id);
			$ville->setCity($data->nom);
			$ville->setCountry($data->pays);
			$ville->setCapitale($data->capitale);
			$ville->setDemonym($this->getDemonym($ville->getCountry()) ?: "");
			$ville->setFlag($this->getDrapeau($ville->getCountry()) ?: "");

			return $ville;
		}, $stmt->fetchAll());
	}

	/**
	 * Récupère un démonyme depuis un nom de country.
	 */
	public function getDemonym(string $country): string|null
	{
		if (isset($_SESSION[$this->getName() . ".demonyms"][$country])) {
			return $_SESSION[$this->getName() . ".demonyms"][$country];
		}

		$req = $this->getPdo()->prepare("CALL GetDemonymeDuPays(:country, @demonym)");

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
	public function getDrapeau(string $country): string|null
	{
		if (isset($_SESSION[$this->getName() . ".flags"][$country])) {
			return $_SESSION[$this->getName() . ".flags"][$country];
		}

		$req = $this->getPdo()->prepare("CALL GetISOPays(:country, @drapeau)");

		if ($req->execute(["country" => $country])) {
			$req = $this->getPdo()->query("SELECT @drapeau AS drapeau");
			if (!$req) {
				return null;
			}

			$drapeau = $req->fetch();
			if (!$drapeau || $drapeau->drapeau === null) {
				return null;
			}

			$this->addDrapeau($country, $drapeau->drapeau);

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
				INSERT INTO {$this->tableName} (nom,pays,capitale) VALUES (
					:city_name,
					:country,
					:capitale
				)
			");

			return $stmt->execute([
				"city_name" => $city->getCity(),
				"country" => $city->getCountry(),
				"capitale" => $city->getCapitale(),
			]);
		} catch (PDOException $_) {
			return false;
		}
	}
}
