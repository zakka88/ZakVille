<?php

require_once __DIR__ . "/../entities/Country.php";

class City
{
	// --------- //
	// Propriété //
	// --------- //

	private ?int $id;

	/**
	 * Nom de la ville.
	 */
	private string $city;

	/**
	 * Pays dans lequel est situé la ville.
	 */
	private Country $country;

	/**
	 * Drapeau ISO
	 */
	private string $flag = "";

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct(
		string $country = "",
		string $capital = "",
		string $city = "",
	) {
		$this->country = new Country($country, $capital);
		$this->city = $city;
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function toOptionString()
	{
		return $this->getCountry()->getFlag() .
			' ' . $this->getCity() .
			" (" . $this->getCountry()->getIsoCode() . ")";
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

	public function getCity(): string
	{
		return $this->city;
	}

	public function setCity(string $city): void
	{
		$this->city = $city;
	}

	public function getCountry(): Country
	{
		return $this->country;
	}

	public function setCountry(string $country, string $capital): void
	{
		$this->country = new Country($country, $capital);
	}
}
