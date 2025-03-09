<?php

require_once __DIR__ . "/../entities/City.php";

class User
{
	// --------- //
	// Propriété //
	// --------- //

	/**
	 * ID de l'utilisateur.
	 */
	private ?int $id;

	/**
	 * ID de la ville de l'utilisateur. Cette information peut être NULL.
	 */
	private ?int $cityId;
	/**
	 * Ville de l'utilisateur. Cette information peut être NULL.
	 */
	private ?City $city;

	/**
	 * Date de naissance de l'utilisateur.
	 */
	private DateTime $date_of_birth;

	/**
	 * Prénom de l'utilisateur.
	 */
	private string $firstname;

	/**
	 * Pseudo de l'utilisateur.
	 */
	private string $username;

	/**
	 * Mot de passe de l'utilisateur.
	 */
	private string $password;

	/**
	 * Rôle de l'utilisateur.
	 */
	private string $role;

	// ----------- //
	// Constructor //
	// ----------- //

	/**
	 * Construit la classe User avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de User.
	 */
	public function __construct(
		string $username,
		string $password,
		string $firstname,
		DateTime $date_of_birth,
		string $role,
		?string $cityId = null,
		?int $id = null,
	) {
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->firstname = $firstname;
		$this->date_of_birth = $date_of_birth;
		$this->role = $role;
		$this->cityId = $cityId;
	}

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getCityId(): ?int
	{
		return $this->cityId;
	}

	public function setCityId(int $cityId): void
	{
		$this->cityId = $cityId;
	}

	public function getCity(): ?City
	{
		return $this->city;
	}

	public function setCity(City $city): void
	{
		$this->cityId = $city->getId();
		$this->city = $city;
	}

	public function getCountry(): ?Country
	{
		return $this->city->getCountry();
	}

	public function getNationality(): string
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		return $_SESSION["tp_zakville.demonyms"][$this->getCountry()->getName()];
	}

	public function getDateOfBirth(): DateTime
	{
		return $this->date_of_birth;
	}

	public function setDateOfBirth(DateTime $dateOfBirth): void
	{
		$this->date_of_birth = $dateOfBirth;
	}

	public function getFirstname(): string
	{
		return $this->firstname;
	}

	public function setFirstname(string $firstname): void
	{
		$this->firstname = $firstname;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function setUsername(string $username): void
	{
		$this->username = $username;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function getRole(): string
	{
		return $this->role;
	}

	public function setRole(string $role): void
	{
		$this->role = $role;
	}
}
