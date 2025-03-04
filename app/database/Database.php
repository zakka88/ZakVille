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

	// ----------- //
	// Constructor //
	// ----------- //

	/**
	 * Construit la classe Database avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de Database.
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

			$this->pdo->query("DESCRIBE {$this->tableName}");
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
}
