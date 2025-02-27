<?php

enum AuthorizationAccess: int
{
	case Anonymous = 0;
	case User 	   = 10;
	case Admin     = 1000;
};
