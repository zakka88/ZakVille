<?php

class VilleUtilisateur
{
	// --------- //
	// Propriété //
	// --------- //

	/**
	 * ID de la ville faisant reference au champs `id` de la table `ville`.
	 */
	private int $villeId;

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getVilleId(): int
	{
		return $this->villeId;
	}

	public function setVilleId(int $villeId): void
	{
		$this->villeId = $villeId;
	}
}
