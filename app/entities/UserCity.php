<?php

class UserCity
{
	// --------- //
	// Propriété //
	// --------- //

	/**
	 * Champs se trouvant dans la table `users`. Correspond à l'ID de la ville
	 * faisant reference au champs `id` de la table `villes`.
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
