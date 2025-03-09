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

	protected string $tableName;
	protected array $fields = [];

	// ----------- //
	// Constructor //
	// ----------- //

	/**
	 * Construit la classe Database avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de Database.
	 *
	 * Cette fonction inclue des choses que l'on n'a pas vu :
	 *
	 * - https://www.php.net/manual/en/function.array-map.php
	 * - https://www.php.net/manual/en/function.str-contains.php
	 * - https://www.php.net/manual/en/function.http-build-query.php
	 */
	public function __construct()
	{
		try {
			$this->pdo = new PDO(
				"mysql:dbname={$this->name};host=localhost",
				$this->user,
				$this->pass
			);

			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

			$req = $this->pdo->query("DESCRIBE {$this->tableName}");
			$this->fields = array_map(fn ($item) => $item->Field, $req->fetchAll());
		} catch (PDOException $e) {
			$dbinfo = [
				"cause" => "db",
				"dbhost" => "localhost",
				"dbport" => 3306,
				"dbname" => $this->name,
				"dbuser" => $this->user,
			];

			if (str_contains($e->getMessage(), "No such file or directory")) {
				$dbinfo["type"] = "unavailable";
			} else if (str_contains($e->getMessage(), "Access denied for user")) {
				$dbinfo["dbpass"] = $this->pass;
				$dbinfo["type"] = "access_denied";
			} else if (str_contains($e->getMessage(), "Unknown database")) {
				$dbinfo["type"] = "unknown_database";
			} else if (str_contains($e->getMessage(), "Base table or view not found")) {
				$dbinfo["dbtable"] = $this->tableName;
				$dbinfo["type"] = "unknown_table";
			}

			// Transforme notre tableau $dbinfo en chaîne de caractères sous le
			// format des paramètres d'URL, exemple :
			//
			// @in :  ["nom" => "Doe", "prenom" => "John"]
			// @out:  "nom=Doe&prenom=John"
			$qs = http_build_query($dbinfo);
			header("Location: error503.php?$qs");
			exit();
		}
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

	public function getFields(): array
	{
		return $this->fields;
	}
}
