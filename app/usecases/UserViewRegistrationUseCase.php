<?php

require_once __DIR__ . "/../usecases/AuthUseCase.php";
require_once __DIR__ . "/../tables/Cities.php";

class UserViewRegistrationUseCase
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
		$cities = $this->citiesTable->all();
		$data = new UserShowRegistrationData(cities: $cities);
		return $data;
	}
}

class UserShowRegistrationData
{
	public function __construct(public array $cities) {}
}
