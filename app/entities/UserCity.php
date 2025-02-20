<?php

class UserCity
{
	// --------- //
	// Propriété //
	// --------- //

	/**
	 * ID de la ville faisant reference au champs `id` de la table `ville`.
	 */
	private int $cityId;

	// --------------- //
	// Getter | Setter //
	// --------------- //

	public function getCityId(): int
	{
		return $this->cityId;
	}

	public function setCityId(int $cityId): void
	{
		$this->cityId = $cityId;
	}
}
