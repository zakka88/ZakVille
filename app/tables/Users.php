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

		if ($city === false) {
			return false;
		}

		$req = $this->getPdo()->prepare("
			INSERT INTO {$this->tableName} (
				firstname,
				username,
				password,
				city_id
			) VALUES (
				:firstname,
				:username,
				:password,
				:city_id
			)
		");

		try {
			return $req->execute([
				"firstname" => $user->getFirstname(),
				"username" => $user->getUsername(),
				"password" => password_hash($user->getPassword(), PASSWORD_DEFAULT),
				"city_id" => $city->id,
			]);
		} catch (PDOException $_) {
			return false;
		}
	}
}
