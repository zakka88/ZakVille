<?php

class Country
{
	private string $name;
	private string $capital;
	private string $isoCode;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct(string $name, string $capital)
	{
		$this->name = $name;
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
