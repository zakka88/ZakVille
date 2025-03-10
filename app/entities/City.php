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
	private string $cityName;

	/**
	 * Pays dans lequel est situé la ville.
	 */
	private Country $country;

	// ----------- //
	// Constructor //
	// ----------- //

	/**
	 * Construit la classe City avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de City.
	 */
	public function __construct(
		string $country,
		string $capital,
		string $city,
		?int $id = null
	) {
		$this->country = new Country($country, $capital);
		$this->cityName = $city;
		$this->id = $id;
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	/**
	 * Retourne le texte qu'on doit mettre dans la balise <option>{text}</option>.
	 */
	public function toOptionText(): string
	{
		$str = $this->getCountry()->getFlag() . ' ' . $this->getCityName();

		if ($this->getCountry()->getIsoCode()) {
			$str .= " (" . $this->getCountry()->getIsoCode() . ")";
		}

		return $str;
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

	public function getCityName(): string
	{
		return $this->cityName;
	}

	public function setCityName(string $city): void
	{
		$this->cityName = $city;
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
