<?php

class Ville
{
	// --------- //
	// Propriété //
	// --------- //

	private ?int $id;

	/**
	 * Nom de la capitale du pays où la ville est située.
	 */
	private string $capitale;

	/**
	 * Nom de la ville.
	 */
	private string $nom;

	/**
	 * Pays dans lequel est situé la ville.
	 */
	private string $pays;

	/**
	 * Le démonyme désigne le nom des habitants d'un lieu, qu'il s'agisse d'une
	 * ville, d'un pays, ou d'une région.
	 */
	private string $demonyme = "";

	/**
	 * Drapeau ISO
	 */
	private string $drapeau = "";

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getCapitale(): string
	{
		return $this->capitale;
	}

	public function setCapitale(string $capitale): void
	{
		$this->capitale = $capitale;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getNom(): string
	{
		return $this->nom;
	}

	public function setNom(string $nom): void
	{
		$this->nom = $nom;
	}

	public function getPays(): string
	{
		return $this->pays;
	}

	public function setPays(string $pays): void
	{
		$this->pays = $pays;
	}

	public function getDemonyme(): string
	{
		return $this->demonyme;
	}

	public function setDemonyme(string $demonyme): void
	{
		$this->demonyme = $demonyme;
	}

	public function setDrapeau(string $iso): void
	{
		$this->drapeau = $iso;
	}

	/**
	 * Retourne le l'emoji du pays en fonction du code ISO (drapeau)
	 */
	public function getDrapeau(): string
	{
		return implode(
			'',
			array_map(
				fn($letter) => mb_chr(ord($letter) % 32 + 0x1F1E5),
				str_split($this->drapeau)
			)
		);
	}
}
