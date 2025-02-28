<?php

require_once __DIR__ . "/../database/Database.php";
require_once __DIR__ . "/../entities/User.php";

class Users extends Database
{
	// --------- //
	// Propriété //
	// --------- //

	/**
	 * Nom de la table
	 */
	private string $tableName = "users";

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	/**
	 * Insère un nouvel utilisateur
	 */
	public function create(User $user): bool
	{
		// Vérifie que la ville donnée à l'utilisateur existe
		$req = $this->getPdo()->prepare("
			SELECT id
			FROM cities
			WHERE id = :city_id
		");
		$req->execute(["city_id" => $user->getCityId()]);
		$city = $req->fetch();

		// Insertion de l'utilisateur
		$req = $this->getPdo()->prepare("
			INSERT INTO {$this->tableName} (
				firstname,
				username,
				password,
				date_of_birth,
				city_id
			) VALUES (
				:firstname,
				:username,
				:password,
				:date_of_birth,
				:city_id
			)
		");

		try {
			return $req->execute([
				"firstname" => $user->getFirstname(),
				"username" => $user->getUsername(),
				"password" => password_hash($user->getPassword(), PASSWORD_DEFAULT),
				"date_of_birth" => $user->getDateOfBirth()->format("Y-m-d"),
				"city_id" => $city?->id ?: null,
			]);
		} catch (PDOException $_) {
			// L'insertion peut échouer dans la cas où le nom d'utilisateur
			// existe déjà
			return false;
		}
	}

	/**
	 * Récupère tous les utilisateurs sans villes
	 */
	public function findAllWithoutCities(): array
	{
		$req = $this->getPdo()->query("
			SELECT *
			FROM {$this->tableName}
			WHERE city_id IS NULL
		");

		// NOTE: `array_map` fonctionne de la même façon que le `Array.map` de
		//       JavaScript.
		//       https://php.net/manual/en/function.array-map.php
		return array_map(
			// Fonction anonyme
			function ($item): User {
				$user = new User(
					username: $item->username,
					password: $item->password,
					firstname: $item->firstname,
					date_of_birth: new DateTime($item->date_of_birth),
					role: $item->role,
					cityId: $item->city_id,
				);
				$user->setId($item->id);
				return $user;
			},
			$req->fetchAll()
		);
	}

	/**
	 * Met à jour le champ city_id de la table villes pour chaque utilisateur
	 * @param array<int,int> $users_id
	 */
	public function updateCityFor(array $users_id, string $cityName): bool
	{
		$req = $this->getPdo()->prepare("
			SELECT id FROM cities WHERE name = :city_name LIMIT 1
		");

		$req->execute(["city_name" => $cityName]);
		$city = $req->fetch();

		// Remplace chaque élément du tableau $users_id par un placeholder (il
		// s'agit du caractère `?`).
		// La fonction join va transformer le tableau en chaîne de caractère et
		// les séparer par des virgules.
		//
		// @example:
		// @in:  join(",", ["?", "?", "?"]);
		// @out: ?,?,?
		$usersSqlPlaceholders = join(
			',',
			array_map(fn ($_) => '?', $users_id)
		);

		$req = $this->getPdo()->prepare("
			UPDATE {$this->tableName}
			SET city_id = {$city->id}
			WHERE id IN ($usersSqlPlaceholders)
		");

		return $req->execute(
			// Les placeholders `?` seront remplacés par les valeurs des
			// éléments du tableau $users_id. Il est important de faire ces
			// étapes pour éviter les failles SQL.
			$users_id
		);
	}
}
