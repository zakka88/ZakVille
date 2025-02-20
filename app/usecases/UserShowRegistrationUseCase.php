<?php

require_once __DIR__ . "/../usecases/AuthUseCase.php";
require_once __DIR__ . "/../tables/Cities.php";

class UserShowRegistrationUseCase
{
	private AuthUseCase $authUseCase;
	private Cities $citiesTable;

	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("profile.php");
		$this->authUseCase->anonymousOnly();

		$this->citiesTable = new Cities();
	}

	public function fetchData(): UserShowRegistrationData
	{
		$villes = $this->citiesTable->all();
		$data = new UserShowRegistrationData(villes: $villes);
		return $data;
	}
}

class UserShowRegistrationData
{
	public function __construct(public array $villes) {}
}
