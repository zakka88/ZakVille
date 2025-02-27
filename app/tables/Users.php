<?php

require_once __DIR__ . "/../database/Database.php";
require_once __DIR__ . "/../entities/User.php";

class Users extends Database
{
	/**
	 * Nom de la table
	 */
	private string $tableName = "users";

	/**
	 * Insère un nouvel utilisateur
	 */
	public function create(User $user): bool
	{
		$cityReq = $this->getPdo()->prepare("
			SELECT id
			FROM cities
			WHERE id = :city_id
		");
		$cityReq->execute(["city_id" => $user->getCityId()]);
		$city = $cityReq->fetch();

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
			return false;
		}
	}

	/**
	 * Récupère tous les utilisateurs sans villes
	 */
	public function findAllWithoutCities(): array
	{
		$cityReq = $this->getPdo()->query("
			SELECT *
			FROM {$this->tableName}
			WHERE city_id IS NULL
		");
		if ($cityReq === false) {
			return [];
		}
		return array_map(function ($item): User {
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
		}, $cityReq->fetchAll());
	}

	/**
	 * Met à jour le champ cit_id de la table villes
	 */
	public function updateCity(int $user_id, string $cityName): bool
	{
		$req = $this->getPdo()->prepare("SELECT id FROM cities WHERE name = :city LIMIT 1");
		$req->execute(["city" => $cityName]);
		$city = $req->fetch();

		$req = $this->getPdo()->prepare("
			UPDATE {$this->tableName} 
			SET city_id = {$city->id}
			WHERE id = :user_id
		");

		try {
			return $req->execute([
				"user_id" => $user_id,
			]);
		} catch (PDOException $_) {
			return false;
		}
	}
}
