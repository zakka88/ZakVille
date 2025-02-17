<?php

class BaseDeDonnees
{
	// --------- //
	// Propriété //
	// --------- //

	private PDO $pdo;

	/** Configurations de connexion à la base de données */
	private string $nom = "tp_zakville";
	private string $utilisateur = "root";
	private string $motDePasse = "";

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->pdo = new PDO(
			"mysql:dbname={$this->nom};host=localhost",
			$this->utilisateur,
			$this->motDePasse
		);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getPdo(): PDO
	{
		return $this->pdo;
	}

	public function getNom(): string
	{
		return $this->nom;
	}

	public function setNom(string $nom): void
	{
		$this->nom = $nom;
	}

	public function setUtilisateur(string $utilisateur): void
	{
		$this->utilisateur = $utilisateur;
	}

	public function setMotDePasse(string $mdp): void
	{
		$this->motDePasse = $mdp;
	}
}
