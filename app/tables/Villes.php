<?php

require_once "./app/database/BaseDeDonnees.php";
require_once "./app/entities/Ville.php";

class Villes extends BaseDeDonnees
{
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

		if (!isset($_SESSION[$this->getNom() . ".demonymes"])) {
			// Tous les démonymes.
			//
			// Un démonyme désigne le nom des habitants d'un lieu, qu'il s'agisse d'une
			// ville, d'un pays, ou d'une région.
			//
			$_SESSION[$this->getNom() . ".demonymes"] = [];
		}

		if (!isset($_SESSION[$this->getNom() . ".drapeaux"])) {
			// Tous les drapeaux
			$_SESSION[$this->getNom() . ".drapeaux"] = [];
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
			$ville = new Ville();

			$ville->setId($data->id);
			$ville->setNom($data->nom);
			$ville->setPays($data->pays);
			$ville->setCapitale($data->capitale);
			$ville->setDemonyme($this->getDemonyme($ville->getPays()) ?: "");
			$ville->setDrapeau($this->getDrapeau($ville->getPays()) ?: "");

			return $ville;
		}, $stmt->fetchAll());
	}

	/**
	 * Récupère un démonyme depuis un nom de pays.
	 */
	public function getDemonyme(string $pays): string|null
	{
		if (isset($_SESSION[$this->getNom() . ".demonymes"][$pays])) {
			return $_SESSION[$this->getNom() . ".demonymes"][$pays];
		}

		$req = $this->getPdo()->prepare("CALL GetDemonymeDuPays(:pays, @demonyme)");

		if ($req->execute(["pays" => $pays])) {

			$req = $this->getPdo()->query("SELECT @demonyme AS demonyme");
			if ($req === false) {
				return null;
			}

			$res = $req->fetch();
			if ($res === false || $res->demonyme === null) {
				return null;
			}

			$this->addDemonyme($pays, $res->demonyme);

			return $_SESSION[$this->getNom() . ".demonymes"][$pays];
		}

		return null;
	}

	/**
	 * Ajoute un démonyme dans la liste des démonymes.
	 */
	public function addDemonyme(string $pays, string $demonyme): void
	{
		$_SESSION[$this->getNom() . ".demonymes"][$pays] = $demonyme;
	}

	/**
	 * Récupère un code ISO depuis le nom d'un pays.
	 */
	public function getDrapeau(string $pays): string|null
	{
		if (isset($_SESSION[$this->getNom() . ".drapeaux"][$pays])) {
			return $_SESSION[$this->getNom() . ".drapeaux"][$pays];
		}

		$req = $this->getPdo()->prepare("CALL GetISOPays(:pays, @drapeau)");

		if ($req->execute(["pays" => $pays])) {
			$req = $this->getPdo()->query("SELECT @drapeau AS drapeau");
			if (!$req) {
				return null;
			}

			$drapeau = $req->fetch();
			if (!$drapeau || $drapeau->drapeau === null) {
				return null;
			}

			$this->addDrapeau($pays, $drapeau->drapeau);

			return $_SESSION[$this->getNom() . ".drapeaux"][$pays];
		}

		return null;
	}

	/**
	 * Ajoute un drapeau dans la liste des drapeaux.
	 */
	public function addDrapeau(string $pays, string $drapeau): void
	{
		$_SESSION[$this->getNom() . ".drapeaux"][$pays] = $drapeau;
	}
}
