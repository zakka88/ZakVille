<?php

require_once __DIR__ . "/../utilities/form.php";
require_once __DIR__ . "/../utilities/session.php";
require_once __DIR__ . "/../usecases/AuthUseCase.php";
require_once __DIR__ . "/../usecases/UserCreateUseCase.php";
require_once __DIR__ . "/../tables/Cities.php";

class RegisterUserPage
{
	// --------- //
	// Propriété //
	// --------- //

	private AuthUseCase $authUseCase;
	private UserCreateUseCase $userCreateUseCase;
	private Cities $citiesTable;

	// ----------- //
	// Constructor //
	// ----------- //

	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("profile.php");
		$this->authUseCase->anonymousOnly();

		$this->userCreateUseCase = new UserCreateUseCase();

		$this->citiesTable = new Cities();
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	public function save(): void
	{
		$this->userCreateUseCase->store($_POST);
	}

	public function handle(): RegisterUserView
	{
		$cities = $this->citiesTable->all();

		// Voir https://www.php.net/manual/en/function.array-reduce.php
		//
		// Le résultat final serait d'avoir un tableau du style :
		//
		// [
		//    ID => "EMOJI Pays (Code ISO)",
		// ];
		$citiesOptions = array_reduce(
			$cities,
			function ($acc, $city) {
				$acc[$city->getId()] = $city->toOptionText();
				return $acc;
			},
			[]
		);

		// Voir https://www.php.net/manual/en/function.array-map.php
		//
		// Je veux récupérer que les codes ISO des pays des différentes villes récupérées.
		// EX: ["be", "it", "us", ...];
		$isoCodes = array_map(
			fn ($item) => $item->getCountry()->getIsoCode(),
			$cities,
		);

		// Je veux que chaque utilisateur qui s'inscrit sur le site ait au moins
		// 16 ans.
		$minAge = "16 years";
		$dateInterval = DateInterval::createFromDateString($minAge);
		$maxBdayDate = (new DateTime())->sub($dateInterval)->format("Y-m-d");

		return new RegisterUserView(
			cities: $citiesOptions,
			isoCodes: $isoCodes,
			maxBdayDate: $maxBdayDate,
		);
	}
}

/**
 * @property array<int,City> $cities Les villes de la table `cities`.
 * @property array<int,string> $isoCodes les codes ISO des différents pays
 */
class RegisterUserView
{
	/**
	 * Syntaxe alternative et plus rapide de
	 *
	 * ```php
	 * public array $cities;
	 *
	 * public function __construct(array $cities) {
	 * 		$this->cities = $cities;
	 * }
	 * ```
	 */
	public function __construct(
		public array $cities,
		public array $isoCodes,
		public string $maxBdayDate,
	) {}
}
