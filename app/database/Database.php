<?php

class Database
{
	// --------- //
	// Propriété //
	// --------- //

	/**
	 * Connexion à la base de données avec PDO.
	 */
	private PDO $pdo;

	/** Configurations de connexion à la base de données */
	private string $name = "tp_zakville";
	private string $user = "root";
	private string $pass = "";

	// ----------- //
	// Constructor //
	// ----------- //

	/**
	 * Construit la classe Database avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de Database.
	 */
	public function __construct()
	{
		$this->pdo = new PDO(
			"mysql:dbname={$this->name};host=localhost",
			$this->user,
			$this->pass
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

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function setUser(string $user): void
	{
		$this->user = $user;
	}

	public function setPassword(string $pass): void
	{
		$this->pass = $pass;
	}
}
