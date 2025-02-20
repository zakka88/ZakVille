<?php

require_once __DIR__ . "/../utilities/session.php";
require_once __DIR__ . "/../utilities/form.php";
require_once __DIR__ . "/../tables/Cities.php";
require_once __DIR__ . "/AuthUseCase.php";

class CityCreateViewUseCase
{
	private AuthUseCase $authUseCase;


	public function __construct()
	{
		$this->authUseCase = new AuthUseCase();
		$this->authUseCase->setRedirectTo("../../error404.php");
		$this->authUseCase->adminOnly();
	}

	public function handle(): void {}
}
