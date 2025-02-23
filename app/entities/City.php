<?php

class City
{
	// --------- //
	// Propriété //
	// --------- //

	private ?int $id;

	/**
	 * Nom de la capitale du pays où la ville est située.
	 */
	private string $capital;

	/**
	 * Nom de la ville.
	 */
	private string $city;

	/**
	 * Pays dans lequel est situé la ville.
	 */
	private string $country;

	/**
	 * Le démonyme désigne le nom des habitants d'un lieu, qu'il s'agisse d'une
	 * ville, d'un pays, ou d'une région.
	 */
	private string $demonym = "";

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
		$this->country = $country;
		$this->capital = $capital;
		$this->city = $city;
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function toOptionString()
	{
		return $this->getFlagEmoji() . ' ' . $this->getCity() .	" (" . $this->getFlag() . ")";
	}

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getCapitale(): string
	{
		return $this->capital;
	}

	public function setCapitale(string $capital): void
	{
		$this->capital = $capital;
	}

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

	public function getCountry(): string
	{
		return $this->country;
	}

	public function setCountry(string $country): void
	{
		$this->country = $country;
	}

	public function getDemonym(): string
	{
		return $this->demonym;
	}

	public function setDemonym(string $demonym): void
	{
		$this->demonym = $demonym;
	}

	/**
	 * Retourne l'emoji du pays en fonction du code ISO (flag, BE,FR,JP,...)
	 */
	public function getFlagEmoji(): string
	{
		return implode(
			'',
			array_map(
				fn($letter) => mb_chr(ord($letter) % 32 + 0x1F1E5),
				str_split($this->flag)
			)
		);
	}

	public function getFlag(): string
	{
		return $this->flag;
	}

	public function setFlag(string $iso): void
	{
		$this->flag = $iso;
	}
}
