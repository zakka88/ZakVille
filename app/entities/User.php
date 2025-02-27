<?php

require_once __DIR__ . "/../entities/City.php";

class User
{
	// --------- //
	// Propriété //
	// --------- //

	private int $id;
	private ?int $cityId;
	private DateTime $date_of_birth;
	private ?City $city;
	private string $firstname;
	private string $username;
	private string $password;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct(
		string $username,
		string $password,
		string $firstname,
		DateTime $date_of_birth,
		?string $cityId,
	) {
		$this->username = $username;
		$this->password = $password;
		$this->firstname = $firstname;
		$this->date_of_birth = $date_of_birth;
		$this->cityId = $cityId;
	}

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getId(): int
	{
		return $this->id;
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
		$this->city = $city;
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
}
