<?php

/**
 * Énumération.
 *
 * Cette fonction inclue des choses que l'on n'a pas vu :
 *
 * - https://www.php.net/manual/en/language.enumerations.php
 */
enum AuthorizationAccess: int
{
	case Anonymous = 0;
	case User 	   = 10;
	case Admin     = 1000;
};
