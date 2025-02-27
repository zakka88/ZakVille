<?php

class Country
{
	/**
	 * Nom du pays.
	 */
	private string $name;

	/**
	 * Nom de la capitale du pays.
	 */
	private string $capital;

	/**
	 * Le démonyme désigne le nom des habitants d'un lieu, qu'il s'agisse d'une
	 * ville, d'un pays, ou d'une région.
	 */
	private string $demonym = "";

	/**
	 * Code ISO du pays.
	 */
	private string $isoCode;

	// ----------- //
	// Constructor //
	// ----------- //

	/**
	 * Construit la classe Country avec le mot-clé `new` ce qui crée un Objet
	 * ou autrement dit une instance de Country.
	 */
	public function __construct(string $country, string $capital)
	{
		$this->name = $country;
		$this->capital = $capital;
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	/**
	 * Retourne l'emoji du pays en fonction du code ISO (flag, BE,FR,JP,...)
	 */
	public function getFlag(): string
	{
		return implode(
			'',
			array_map(
				fn($letter) => mb_chr(ord($letter) % 32 + 0x1F1E5),
				str_split($this->isoCode)
			)
		);
	}

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getCapital(): string
	{
		return $this->capital;
	}

	public function setCapital(string $capital): void
	{
		$this->capital = $capital;
	}

	public function getDemonym(): string
	{
		return $this->demonym;
	}

	public function setDemonym(string $demonym): void
	{
		$this->demonym = $demonym;
	}

	public function getIsoCode(): string
	{
		return $this->isoCode;
	}

	public function setIsoCode(string $isoCode): void
	{
		$this->isoCode = $isoCode;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}
}
